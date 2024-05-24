<?php

use Illuminate\Support\Facades\Route;

return [
    'dashboard' => [

        'key' => 'dashboard',
        'title' => 'Dashboard',
        'icon' => 'mdi-view-dashboard-outline',
        'can' => 'auth',
        'widgets' => [],

    ],

    'security' => [
        'key' => 'security',
        'title' => 'Seguridad',
        'icon' => 'mdi-security',
        'can' => 'users.index,roles.index',
        'children' => [
            [
                'key' => 'users.index',
                'title' => 'Usuarios',
                'icon' => 'mdi-account',
                'can' => 'users.index',
                'actions' => [
                    ['store', 'user.create'],
                    ['update', 'user.update'],
                    ['update-password', 'user.updatePassword'],
                    ['update-status', 'user.updateStatus'],
                ],
            ],
            [
                'key' => 'roles.index',
                'title' => 'roles',
                'icon' => 'mdi-account-multiple',
                'can' => 'roles.index',
                'actions' => [
                    ['store', 'role.create'],
                    ['update', 'role.update'],
                    ['destroy', 'role.destroy'],
                    ['update-status', 'role.updateStatus'],
                    ['update-modules', 'role.updateModules'],
                    ['update-permissions', 'role.updatePermissions'],
                ],
            ]
        ],
    ],
];
