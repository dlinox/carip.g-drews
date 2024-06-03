<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'ruc',
        'name',
        'social',
        'address',
        'phone',
        'email',
        'ubication',
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

    public static function get($column, $value = null)
    {
        $query = parent::get($column, $value);
        $query->select([
            'id',
            'name',
            'ruc',
            'social',
            'address',
            'phone',
            'email',
            'ubication',
            'is_enabled as isEnabled'
        ]);
        return $query;
    }

    public static function headers(): array
    {
        return [
            ['title' => "Ruc", 'key' => 'ruc', 'align' => 'center'],
            ['title' => "Nombre", 'key' => 'name', 'align' => 'center'],
            ['title' => "Social", 'key' => 'social', 'align' => 'center'],
            ['title' => "Dirección", 'key' => 'address', 'align' => 'center'],
            ['title' => "Teléfono", 'key' => 'phone', 'align' => 'center'],
            ['title' => "Email", 'key' => 'email', 'align' => 'center'],
            ['title' => "Ubicación", 'key' => 'ubication', 'align' => 'center'],
            ['title' => "Estado", 'key' => 'isEnabled', 'align' => 'center'],
            ['title' => "Acciones", 'key' => 'actions', 'align' => 'end', 'sortable' => false]
        ];
    }


}
