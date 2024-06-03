<?php

namespace Database\Seeders;

use App\Models\Permission\Permission;
use App\Models\Permission\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SecuritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //crear usuarios
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'password',
        ]);

        User::create([
            'name' => 'Operador',
            'username' => 'operador',
            'email' => 'operador@gmail.com',
            'password' => 'password',
        ]);

        //crear roles
        $roles = [
            ['name' => 'Admin', 'route_redirect' => '/', 'guard_name' => 'web'],
            ['name' => 'User', 'route_redirect' => '/', 'guard_name' => 'web'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        //crear permisos
        $permissions = [
            [
                'module' => 'Dashboard',
                'action' => [
                    'dashboard',
                ]
            ],
            [
                'module' => 'Roles',
                'action' => [
                    'gestionar-roles',
                    'agregar-rol',
                    'editar-rol',
                    'eliminar-rol',
                    'asignar-permisos',
                ]
            ],
            [
                'module' => 'Usuarios',
                'action' => [
                    'gestionar-usuarios',
                    'agregar-usuario',
                    'editar-usuario',
                    'eliminar-usuario',
                ]
            ],
        ];

        Permission::create(['guard_name' => 'web', 'group_name' => 'dashboard', 'name' => 'dashboard']);
        Permission::create(['guard_name' => 'web', 'group_name' => 'Roles', 'name' => 'gestionar-roles']);
        Permission::create(['guard_name' => 'web', 'group_name' => 'Roles', 'name' => 'agregar-rol']);
        Permission::create(['guard_name' => 'web', 'group_name' => 'Roles', 'name' => 'editar-rol']);
        Permission::create(['guard_name' => 'web', 'group_name' => 'Roles', 'name' => 'eliminar-rol']);
        Permission::create(['guard_name' => 'web', 'group_name' => 'Roles', 'name' => 'asignar-permisos']);
        Permission::create(['guard_name' => 'web', 'group_name' => 'Usuarios', 'name' => 'gestionar-usuarios']);
        Permission::create(['guard_name' => 'web', 'group_name' => 'Usuarios', 'name' => 'agregar-usuario']);
        Permission::create(['guard_name' => 'web', 'group_name' => 'Usuarios', 'name' => 'editar-usuario']);
        Permission::create(['guard_name' => 'web', 'group_name' => 'Usuarios', 'name' => 'eliminar-usuario']);
    }
}
