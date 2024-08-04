<?php


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
            "title" => "company",
            "value" => "company",
            "icon" => "mdi-domain",
            "to" => "/company",
            "permission" => "302",
        ],

        [
            "title" => "Proyectoss",
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
            "title" => "Seguridad",
            "value" => "security",
            "icon" => "mdi-security",
            "children" => [
                [
                    "title" => "Usuarios",
                    "value" => "users",
                    "icon" => "mdi-minus",
                    "to" => "/users",
                    "permission" => "307",
                ],
                [
                    "title" => "Roles",
                    "value" => "roles",
                    "icon" => "mdi-minus",
                    "to" => "/roles",
                    "permission" => "308",
                ],
            ]
        ]
    ]
];
