<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public $typeDocuments = [
        [
            'id' => '001',
            'name' => 'DNI'
        ],
        [
            'id' => '002',
            'name' => 'Carnet de Extranjería'
        ],
        [
            'id' => '003',
            'name' => 'Pasaporte'
        ],
        [
            'id' => '004',
            'name' => 'RUC'
        ]
    ];
}
