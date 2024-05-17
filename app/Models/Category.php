<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'model_type',
        'status'
    ];


    protected $casts = [
        'status' => 'boolean'
    ];

    public static function modelType(): array
    {
        return  [
            ['value' => 'App\Models\Product', 'title' => 'Producto'],
            ['value' => 'App\Models\Room', 'title' => 'Habitación']
        ];
    }

    public static function headers(): array
    {
        return [
            ['title' => "Nombre", 'key' => 'name', 'align' => 'center'],
            ['title' => "Descripción", 'key' => 'description', 'align' => 'center'],
            ['title' => "Estado", 'key' => 'status', 'align' => 'center'],
            ['title' => "Acciones", 'key' => 'actions', 'align' => 'end', 'sortable' => false]
        ];
    }
}
