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
    ];

    //areas
    public function areas()
    {
        return $this->belongsToMany(Area::class);
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
            ['title' => "Estado", 'key' => 'is_enabled', 'align' => 'center'],
            ['title' => "Acciones", 'key' => 'actions', 'align' => 'end', 'sortable' => false]
        ];
    }
}
