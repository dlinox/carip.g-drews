<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use App\Models\ProjectVehicle;
use App\Models\Vehicle;
use App\Models\VehiclesOperator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectVehicleController extends Controller
{
    protected $projectVehicle;

    protected $vehicle;

    protected $vehiclesOperator;


    public function __construct()
    {
        $this->projectVehicle = new ProjectVehicle();
        $this->vehicle = new Vehicle();
        $this->vehiclesOperator = new VehiclesOperator();
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
            ], 400);
        }
    }

    public function unassignVehicle(Request $request)
    {
        try {

            DB::beginTransaction();

            $this->projectVehicle->where('project_id', $request->project_id)
                ->where('vehicle_id', $request->vehicle_id)
                ->update(['is_enabled' => 0, 'end_date' => now()]);

            //desasignar operadores que esten asignados a este vehiculo con un estado activo
            $this->vehiclesOperator->where('vehicle_id', $request->vehicle_id)
                ->where('project_id', $request->project_id)
                ->where('is_enabled', 1)
                ->update(['is_enabled' => 0, 'end_date' => now()]);

            DB::commit();
            return response()->json([
                'message' => 'Vehiculo desasignado correctamente',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al desasignar vehiculo',
                'error' => $e->getMessage(),
            ]);
        }
    }

    //vehicles for time sheet
    public function vehiclesForTimeSheet($projectId)
    {
        $items = $this->projectVehicle->select(
            'project_vehicles.project_id',
            'project_vehicles.vehicle_id',
            'project_vehicles.start_date as vehicle_start_date',
            'project_vehicles.end_date as vehicle_end_date',
            'vehicles.name as vehicle_name',
            'suppliers.name as supplier_name',
            'operators.id as operator_id',
            DB::Raw('CONCAT_WS(" ", operators.name, operators.paternal_surname, operators.maternal_surname) as operator_name'),
            'vehicles_operators.start_date as operator_start_date',
            'vehicles_operators.end_date as operator_end_date',

        )
            ->join('vehicles', 'project_vehicles.vehicle_id', '=', 'vehicles.id')
            ->join('suppliers', 'vehicles.supplier_id', '=', 'suppliers.id')
            ->leftJoin('vehicles_operators', 'vehicles.id', '=', 'vehicles_operators.vehicle_id')
            ->leftJoin('operators', 'vehicles_operators.operator_id', '=', 'operators.id')
            ->whereRaw('project_vehicles.is_enabled = 1 or project_vehicles.is_enabled is null')
            ->where('project_vehicles.project_id', $projectId)
            ->get();

        return response()->json($items);
    }
}
