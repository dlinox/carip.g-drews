<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_enabled',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'isEnabled' => 'boolean',
    ];

    public static function get($column, $value = null){

        $query = parent::get($column, $value);
        $query->select([
            'id',
            'name',
            'description',
            'is_enabled as isEnabled'
        ]);

        return $query;

    }

    public static function headers(): array
    {
        return [
            ['title' => "Nombre", 'key' => 'name', 'align' => 'center'],
            ['title' => "Descripción", 'key' => 'description', 'align' => 'center'],
            ['title' => "Estado", 'key' => 'isEnabled', 'align' => 'center'],
            ['title' => "Acciones", 'key' => 'actions', 'align' => 'end', 'sortable' => false]
        ];
    }
}
