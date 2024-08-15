<?php

namespace App\Http\Controllers;

use App\Models\ProjectVehicle;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ProjectVehicleController extends Controller
{
    protected $projectVehicle;

    protected $vehicle;

    public function __construct()
    {
        $this->projectVehicle = new ProjectVehicle();
        $this->vehicle = new Vehicle();
    }

    public function items($projectId)
    {
        $items = $this->projectVehicle->select('project_vehicles.*', 'vehicles.name as vehicle_name', 'vehicles.plate', 'vehicles.brand', 'vehicles.model',    'suppliers.name as supplier_name')
            ->join('vehicles', 'project_vehicles.vehicle_id', '=', 'vehicles.id')
            ->join('suppliers', 'vehicles.supplier_id', '=', 'suppliers.id')
            ->get();
        return response()->json($items);
    }

    //getVehiclesBySupplier

    public function getVehiclesBySupplier($supplier_id)
    {
        $vehicle = $this->vehicle->forSelect()->free()->enabled()->bySupplier($supplier_id)->get();
        return response()->json($vehicle);
    }

    public function assignVehicle(Request $request)
    {
        try {
            $this->projectVehicle->create($request->all());
            return response()->json([
                'message' => 'Vehiculo asignado correctamente',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al asignar vehiculo',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
