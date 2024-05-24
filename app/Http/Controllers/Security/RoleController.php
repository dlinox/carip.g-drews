<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\RoleRequest;
use App\Models\Permission\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;


class RoleController extends Controller
{

    protected $role;
    protected $title;


    //define constructor
    public function __construct()
    {
        $this->role = new Role();
        $this->title = 'Roles';
    }

    public function index()
    {
        return Inertia::render('Security/role/views/index', [
            'title' => $this->title
        ]);
    }

    public function getItems(Request $request)
    {
        $perPage = $request->itemsPerPage ?? 10;

        $query = $this->role::query();
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
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $items = $query->paginate($perPage);

        $headers = $this->role->headers();
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



    public function store(RoleRequest $request)
    {
        try {
            $data = $this->role->prepareRequest($request->all());
            $this->role->create($data);

            return redirect()->back()->with('success', 'Role creado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
