<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use App\Models\ProjectVehicle;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            ->where('project_id', $projectId)
            ->get();


        foreach ($items as $item) {
            $item['operators'] = Operator::select('operators.id', DB::raw('CONCAT_WS(" ", operators.name,  operators.paternal_surname, operators.maternal_surname) as name'), 'vehicles_operators.start_date', 'vehicles_operators.operator_salary', 'vehicles_operators.end_date', 'vehicles_operators.is_enabled')
                ->join('vehicles_operators', 'operators.id', '=', 'vehicles_operators.operator_id')
                ->where('vehicles_operators.vehicle_id', $item->vehicle_id)
                ->get();
        }
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
