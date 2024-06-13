<?php
/*
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

*/

return [
    "menuItems" => [
        [
            "title" => "Dashboard",
            "value" => "dashboard",
            "icon" => "mdi-view-dashboard-outline",
            "to" => "/dashboard",
            "permission" => "100",
        ],

        [
            "title" => "Proyectos",
            "value" => "projects",
            "icon" => "mdi-boom-gate-up-outline",
            "to" => "/projects",
            "permission" => "302",
        ],
        [
            "title" => "Configuraciones",
            "value" => "config",
            "icon" => "mdi-cog-outline",
            "children" => [
                [
                    "title" => "Sedes",
                    "value" => "branches",
                    "icon" => "mdi-minus",
                    "to" => "/branches",
                    "permission" => "303",
                ],
                [
                    "title" => "Empresas",
                    "value" => "companies",
                    "icon" => "mdi-minus",
                    "to" => "/companies",
                    "permission" => "304",
                ],
                [
                    "title" => "Proveedores",
                    "value" => "suppliers",
                    "icon" => "mdi-minus",
                    "to" => "/suppliers",
                    "permission" => "305",
                ],
                [
                    "title" => "Operadores",
                    "value" => "operators",
                    "icon" => "mdi-minus",
                    "to" => "/operators",
                    "permission" => "306",
                ],
            ],
        ],
        [
            "title"=> "Seguridad",
            "value"=> "security",
            "icon"=> "mdi-security",
            "children"=> [
                [
                    "title"=> "Usuarios",
                    "value"=> "users",
                    "icon"=> "mdi-minus",
                    "to"=> "/users",
                    "permission"=> "307",
                ],
                [
                    "title"=> "Roles",
                    "value"=> "roles",
                    "icon"=> "mdi-minus",
                    "to"=> "/roles",
                    "permission"=> "308",
                ],
            ]
        ]
    ]
];
