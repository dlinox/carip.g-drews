<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\Permission\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{

    public function index()
    {
        return Inertia::render('Security/user/views/index',
        [
            'title' => 'Usuarios',
            'roles' => Role::select('id', 'name')->get(),
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
            $query->where('username', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->orWhere('name', 'like', '%' . $request->search . '%');
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
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'is_enabled' => $request->isEnabled,
            ]
        );

        $user->assignRole($request->role);

        return redirect()->back()->with('success', 'Usuario creado correctamente');
    }
}
