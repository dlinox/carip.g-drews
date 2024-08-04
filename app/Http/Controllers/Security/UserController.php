<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Project;
use App\Models\User;
use App\Models\UserBranch;
use App\Models\UserProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    protected $title;
    protected $user;
    protected $userBranch;

    protected $userProject;
    public function __construct()
    {
        $this->title = 'Gestion de usuarios';
        $this->user = new User();
        $this->userBranch = new UserBranch();
        $this->userProject = new UserProject();
    }

    public function index()
    {

        return Inertia::render(
            'Security/user/views/index',
            [
                'title' => $this->title,
                'roles' => Role::select('id', 'name')->get(),
                'branches' => Branch::select('id', 'name', 'geo_code')->get(),
                'profileTypes' => $this->user::$profileTypes,

            ]
        );
    }

    public function getItems(Request $request)
    {

        $perPage = $request->itemsPerPage ?? 10;

        $query = User::query();
        $sortBy = [];

        if ($request->has('sortBy') && count($request->sortBy) > 0) {
            $sortBy = $request->sortBy;
            foreach ($sortBy as $sort) {
                $query->orderBy($sort['key'], $sort['order']);
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        if ($request->has('search')) {
            $query->where('email', 'like', '%' . $request->search . '%');
        }

        $items = $query->paginate($perPage);

        $headers = User::headers();
        return response()->json([

            'items' => $items,
            'headers' => $headers,
            'filters' => [
                'perPage' => $perPage,
                'sortBy' => $sortBy,
                'search' => $request->search
            ]
        ]);
    }

    public function store(Request $request)
    {
        $user = User::create(
            [
                'profile_type' => $request->profile_type,
                'profile_id' => $request->profile_id,
                'email' => $request->email,
                'password' => $request->password,
                'is_enabled' => $request->is_enabled,
            ]
        );

        $user->assignRole($request->role);

        return response()->json(['message' => 'Usuario creado correctamente']);
    }

    public function assignBranch(Request $request)
    {
        try {
            $userBranch = $this->userBranch->where('user_id', $request->user_id)
                ->where('branch_id', $request->branch_id)
                ->first();
            if ($userBranch) {
                $this->userBranch->enableBranchToUser($request->branch_id, $request->user_id,);
            } else {
                $this->userBranch->assignBranchToUser($request->branch_id, $request->user_id,);
            }

            return response()->json(['message' => 'Sucursal asignada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function disableBranch(Request $request)
    {
        try {
            $this->userBranch->disableBranchToUser($request->branch_id, $request->user_id);
            return response()->json(['message' => 'Sucursal deshabilitada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getProfilesByType($type)
    {
        try {
            $profiles = $this->user->getProfilesByType($type);
            return response()->json($profiles);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function searchProject($search, $id)
    {
        try {
            $projects = Project::select('projects.id', 'projects.name')
                ->where('projects.name', 'like', '%' . $search . '%')
                ->limit(20)->get();
            return response()->json($projects);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    //assignProject
    public function assignProject(Request $request)
    {
        try {
            $userProject = $this->userProject->where('user_id', $request->user_id)
                ->where('project_id', $request->project_id)
                ->first();

            if ($userProject) {
                $this->userProject->enableProjectToUser($request->project_id, $request->user_id);
            } else {
                $this->userProject->assignProjectToUser($request->project_id, $request->user_id);
            }


            return response()->json(['message' => 'Proyecto asignado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function disableProject(Request $request)
    {
        try {
            $this->userProject->disableProjectToUser($request->project_id, $request->user_id);
            return response()->json(['message' => 'Proyecto deshabilitado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
