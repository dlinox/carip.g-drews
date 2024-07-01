<?php

namespace Database\Seeders;

use App\Models\Administrator;
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
        $administrator = Administrator::create([
            'name' => 'Denis',
            'document_type' => '001',
            'document_number' => '71822317',
            'paternal_surname' => 'Puma',
            'maternal_surname' => 'Ticona',
            'phone' => '951208106',
        ]);

        //crear usuarios
        $admin = User::create([
            'profile_type' => '001',
            'profile_id' => $administrator->id,
            'email' => 'nearlino20@gmail.com',
            'password' => 'password',
            'is_enabled' => true,
            'is_protected' => true,
        ]);


        //crear roles
        $roles = [
            ['name' => 'Admin', 'route_redirect' => '/', 'guard_name' => 'web'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

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
