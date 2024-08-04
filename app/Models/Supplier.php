<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'document_number',
        'name',
        'address',
        'phone',
        'email',
        'location',
        'is_enabled',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    protected function location(): Attribute
    {

        return Attribute::make(
            get: function ($value) {
                $location = Location::where('code', $this->attributes['location'])->first();

                if ($location) {
                    $name = $location->department . ', ' . $location->province . ', ' . $location->district;
                }

                return  [
                    'code' => $this->attributes['location'],
                    'location' => $name,
                ];
            },
            // set: function ($value) {
            //     return $value['code'];
            // }

        );
    }


    public static function headers(): array
    {
        return [
            ['title' => "Ruc", 'key' => 'document_number', 'align' => 'center'],
            ['title' => "Nombre", 'key' => 'name', 'align' => 'center'],
            ['title' => "Dirección", 'key' => 'address', 'align' => 'center'],
            ['title' => "Teléfono", 'key' => 'phone', 'align' => 'center'],
            // ['title' => "Email", 'key' => 'email', 'align' => 'center'],
            ['title' => "Ubicación", 'key' => 'location', 'align' => 'center'],
            ['title' => "Estado", 'key' => 'is_enabled', 'align' => 'center'],
            ['title' => "Acciones", 'key' => 'actions', 'align' => 'end', 'sortable' => false]
        ];
    }
}
