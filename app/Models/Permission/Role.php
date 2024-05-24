<?php

namespace App\Models\Permission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'guard_name',
        'route_redirect',
        'is_enabled',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];


    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public static function headers(): array
    {
        return [
            ['title' => "Nombre", 'key' => 'name', 'align' => 'center'],
            ['title' => "Ruta base", 'key' => 'route_redirect', 'align' => 'center'],
            ['title' => "Estado", 'key' => 'is_enabled', 'align' => 'center'],
            ['title' => "Acciones", 'key' => 'actions', 'align' => 'center'],
        ];
    }

    public static function prepareRequest(array $request): array
    {
        return [
            'name' => $request['name'],
            'guard_name' => 'web',
            'route_redirect' => $request['routeRedirect'],
            'is_enabled' => $request['isEnabled'],
        ];
    }
}
