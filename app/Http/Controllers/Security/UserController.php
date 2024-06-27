<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\Permission\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    protected $title;
    protected $user;
    public function __construct()
    {
        $this->title = 'Usuarios';
        $this->user = new User();
    }

    public function index()
    {

        return Inertia::render(
            'Security/user/views/index',
            [
                'title' => $this->title,
                'roles' => Role::select('id', 'name')->get(),
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

    public function getProfilesByType($type)
    {
        try {
            $profiles = $this->user->getProfilesByType($type);
            return response()->json($profiles);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
