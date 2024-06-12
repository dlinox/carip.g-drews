<?php

namespace Database\Seeders;

use App\Models\Permission\Permission;
use App\Models\Permission\Role;
use App\Models\User;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission as ModelsPermission;
use Spatie\Permission\Models\Role as ModelsRole;

class SecuritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //crear usuarios
        $admin = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'password',
        ]);

        $operador = User::create([
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
                    [
                        'name' => 'dashboard',
                        'code' => '100',
                    ]
                ]
            ],
            [
                'module' => 'Roles',
                'action' => [
                    [
                        'name' => 'gestionar-roles',
                        'code' => '200',
                    ],
                    [
                        'name' => 'agregar-rol',
                        'code' => '201',
                    ],
                    [
                        'name' => 'editar-rol',
                        'code' => '202',
                    ],
                    [
                        'name' => 'eliminar-rol',
                        'code' => '203',
                    ],
                    [
                        'name' => 'asignar-permisos',
                        'code' => '204',
                    ],
                ]
            ],
            [
                'module' => 'Usuarios',
                'action' => [
                    [
                        'name' => 'gestionar-usuarios',
                        'code' => '300',
                    ],
                    [
                        'name' => 'agregar-usuario',
                        'code' => '301',
                    ],
                    [
                        'name' => 'editar-usuario',
                        'code' => '302',
                    ],
                    [
                        'name' => 'eliminar-usuario',
                        'code' => '303',
                    ],
                ]
            ],
        ];

        Permission::create(['guard_name' => 'web', 'group_name' => 'dashboard', 'name' => 'dashboard', 'code' => '100']);
        Permission::create(['guard_name' => 'web', 'group_name' => 'Roles', 'name' => 'gestionar-roles', 'code' => '200']);
        Permission::create(['guard_name' => 'web', 'group_name' => 'Roles', 'name' => 'agregar-rol', 'code' => '201']);
        Permission::create(['guard_name' => 'web', 'group_name' => 'Roles', 'name' => 'editar-rol', 'code' => '202']);
        Permission::create(['guard_name' => 'web', 'group_name' => 'Roles', 'name' => 'eliminar-rol', 'code' => '203']);
        Permission::create(['guard_name' => 'web', 'group_name' => 'Roles', 'name' => 'asignar-permisos', 'code' => '204']);
        Permission::create(['guard_name' => 'web', 'group_name' => 'Usuarios', 'name' => 'gestionar-usuarios', 'code' => '300']);
        Permission::create(['guard_name' => 'web', 'group_name' => 'Usuarios', 'name' => 'agregar-usuario', 'code' => '301']);
        Permission::create(['guard_name' => 'web', 'group_name' => 'Usuarios', 'name' => 'editar-usuario', 'code' => '302']);
        Permission::create(['guard_name' => 'web', 'group_name' => 'Usuarios', 'name' => 'eliminar-usuario', 'code' => '303']);

        //asignar al rol admin todos los permisos
        ModelsRole::findByName('Admin')->givePermissionTo(ModelsPermission::all());

        //asignar al usuario admin a la rol admin
        $admin->assignRole(ModelsRole::findByName('Admin'));
    }
}
