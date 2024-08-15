<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vehicle extends Model
{

    use HasFactory;
    protected $fillable = [
        "name",
        "plate",
        "brand",
        "model",
        "color",
        "category",
        "state",
        "soat",
        "soat_expiration_date",
        "type",
        "fuel_type",
        "capacity",
        "mileage",
        "is_enabled",
        "supplier_id",
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',

    ];

    protected $appends = [
        'supplier_name',
    ];

    //set name  = brand - model - plate
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $this->brand . ' - ' . $this->model . ' - ' . $this->plate;
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function getSupplierNameAttribute()
    {
        return $this->supplier ? $this->supplier->name : null;
    }

    public static function headers(): array
    {
        return [
            ["title" => "Nombre", "key" => "name", "align" => "center"],
            ["title" => "Placa", "key" => "plate", "align" => "center"],
            ["title" => "Marca", "key" => "brand", "align" => "center"],
            ["title" => "Modelo", "key" => "model", "align" => "center"],
            ["title" => "Color", "key" => "color", "align" => "center"],
            ["title" => "Tipo", "key" => "type", "align" => "center"],
            ["title" => "Proveedor", "key" => "supplier_name", "align" => "center"],
            ["title" => "Estado", "key" => "is_enabled", "align" => "center"],
            ["title" => "Acciones", "key" => "actions", "align" => "end", "sortable" => false]
        ];
    }

    public function scopeEnabled($query)
    {
        return $query->where('is_enabled', true);
    }

    public function scopeForSelect($query)
    {
        return $query->select('id', DB::raw('concat(name, " (", plate, ")") as name'));
    }

    public function scopeBySupplier($query, $supplier_id)
    {
        return $query->where('supplier_id', $supplier_id);
    }
    public function scopeFree($query)
    {
        //

        /*$vehicles = $this->whereNotIn('id', function ($query) {
            $query->select('vehicle_id')
                ->from('project_vehicles')
                ->where('project_vehicles.is_enabled', true);
        })->get();

        return $vehicles->toArray();*/

        return $query->whereNotIn('id', function ($query) {
            $query->select('vehicle_id')
                ->from('project_vehicles')
                ->where('project_vehicles.is_enabled', true);
        });
    }
}
