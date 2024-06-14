<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    /*
        $table->string('name');
            $table->string('plate');
            // marca
            $table->string('brand');
            // modelo
            $table->string('model');
            // color
            $table->string('color');
            // tipo
            $table->string('type');
    */
    protected $fillable = [
        "name",
        "plate",
        "brand",
        "model",
        "color",
        "type",
        "supplier_id",
        "is_enabled",
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



    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function getSupplierNameAttribute()
    {
        return $this->supplier->name;
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

    public function getFreeVehicles(): array
    {
        $vehicles = $this->select('vehicles.id', 'vehicles.name')
            ->leftJoin('vehicles_operators', 'vehicles_operators.vehicle_id', '=', 'vehicles.id')
            ->leftJoin('projects', 'projects.id', '=', 'vehicles_operators.project_id')
            ->whereRaw('projects.is_enabled = false or projects.is_enabled is null')
            ->whereRaw('vehicles_operators.is_enabled = false or vehicles_operators.is_enabled is null')
            ->where('vehicles.is_enabled', true)
            ->get();

        return $vehicles->toArray();
    }
}