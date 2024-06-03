<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\RoleRequest;
use App\Models\Permission\Permission;
use App\Models\Permission\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role as SpatieRole;

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
            'permissions' => Permission::getGroupedData(),
            'title' => $this->title
        ]);
    }

    public function getItems(Request $request)
    {
        $perPage = $request->itemsPerPage ?? 10;

        $query = SpatieRole::query();
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

        //alias a las columnas para el select
        $query->select([
            'id',
            'name',
            'route_redirect as routeRedirect',
            'is_enabled as isEnabled'
        ])
            ->with('permissions:id,name');
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

    public function update(RoleRequest $request, $id)
    {
        try {
            $data = $this->role->prepareRequest($request->all());

            $this->role->where('id', $id)->update([...$data]);

            return redirect()->back()->with('success', 'Role actualizado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->role->destroy($id);

            return redirect()->back()->with('success', 'Role eliminado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateStatus(RoleRequest $request, $id)
    {
        try {
            $data = $this->role->prepareRequest($request->all());
            $this->role->updateStatus($id, $data);

            return redirect()->back()->with('success', 'Role actualizado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function assignPermissions(Request $request){
        try {

            $role =  SpatieRole::find($request->roleId);
            $role->syncPermissions($request->permissions);
    
            return redirect()->back()->with('success', 'Role actualizado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
