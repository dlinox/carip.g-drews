<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vehicle extends Model
{
    /*
           $table->string('name');        //marca - modelo - placa

            $table->string('plate')->unique();

            $table->string('brand');

            $table->string('model');

            $table->string('color');
 
            $table->string('category');
 
            $table->string('state');

            $table->string('soat');

            $table->date('soat_expiration_date');

            $table->string('type');
  
            $table->string('fuel_type');

            $table->string('capacity');

            $table->string('mileage');
    */
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

    public function getFreeVehicles(): array
    {
        $vehicles = $this->select('vehicles.id', DB::raw('concat(vehicles.name, " (", suppliers.name, ")") as name'))
            ->leftJoin('suppliers', 'suppliers.id', '=', 'vehicles.supplier_id')
            ->leftJoin('vehicles_operators', 'vehicles_operators.vehicle_id', '=', 'vehicles.id')
            ->leftJoin('projects', 'projects.id', '=', 'vehicles_operators.project_id')
            ->whereRaw('projects.is_enabled = false or projects.is_enabled is null')
            ->whereRaw('vehicles_operators.is_enabled = false or vehicles_operators.is_enabled is null')
            ->where('vehicles.is_enabled', true)
            ->get();

        return $vehicles->toArray();
    }
}
