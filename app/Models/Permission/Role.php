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
        'isEnabled' => 'boolean',
    ];


    public static function get($column, $value = null)
    {
        $query = parent::get($column, $value);
        $query->select([
            'id',
            'name',
            'route_redirect as routeRedirect',
            'is_enabled as isEnabled'
        ]);
        return $query;
    }

    
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }


    public static function headers(): array
    {
        return [
            ['title' => "Nombre", 'key' => 'name', 'align' => 'center'],
            ['title' => "Ruta base", 'key' => 'routeRedirect', 'align' => 'center'],
            ['title' => "Estado", 'key' => 'isEnabled', 'align' => 'center'],
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
