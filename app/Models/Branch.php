<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
        "is_protected",
    ];

    protected $casts = [
        "is_enabled" => "boolean",
        "is_protected" => "boolean",
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
    ];

    protected $appends = [
        "location",
    ];

    protected function location(): Attribute
    {

        return Attribute::make(
            get: function ($value) {
                $location = Location::where('code', $this->attributes['geo_code'])->first();

                if ($location) {
                    $name = $location->department . ', ' . $location->province . ', ' . $location->district;
                }

                return  [
                    'code' => $this->attributes['geo_code'],
                    'location' => $name,
                ];
            },
            set: function ($value) {
                return $value['code'];
            }

        );
    }

    public static function headers(): array
    {
        return [
            ['title' => "Nombre", 'key' => 'name', 'align' => 'start'],
            ['title' => "Ubicación", 'key' => 'geo_name', 'align' => 'start', 'sortable' => false],
            ['title' => "Estado", 'key' => 'is_enabled', 'align' => 'center'],
            ['title' => "Acciones", 'key' => 'actions', 'align' => 'end', 'sortable' => false]
        ];
    }
}
