<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Branch extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "address",
        "geo_code",
        "country",
        "is_enabled",
    ];

    protected $casts = [
        "is_enabled" => "boolean",
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
    ];

    protected $appends = [
        "geo_name",
    ];

    public function location()
    {
        return $this->belongsTo(Location::class, 'geo_code', 'code');
    }

    public function getGeoNameAttribute()
    {
        $location = $this->location;

        if ($location) {
            return $location->department . ', ' . $location->province . ', ' . $location->district;
        }

        return 'Location not found';
    }

    public static function headers(): array
    {
        return [
            ['title' => "Nombre", 'key' => 'name', 'align' => 'center'],
            ['title' => "Ubicación", 'key' => 'geo_name', 'align' => 'center'],
            ['title' => "Estado", 'key' => 'is_enabled', 'align' => 'center'],
            ['title' => "Acciones", 'key' => 'actions', 'align' => 'end', 'sortable' => false]
        ];
    }
}
