<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectVehicle;
use App\Models\TimeSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TimeSheetController extends Controller
{
    protected $project;
    protected $timeSheet;

    protected $projectVehicle;

    public function __construct()
    {
        $this->timeSheet = new TimeSheet();
        $this->project = new Project();
        $this->projectVehicle = new ProjectVehicle();
    }

    public function index($projectId)
    {

        $project = $this->project->find($projectId);

        return Inertia::render("Project/views/timesheet", [
            'title' => $project->name,
            'project' => $project,
            'today' => date('Y-m-d H:i:s'),
            'todayJs' => date('Y-m-d', strtotime('+1 day')),
        ]);
    }

    //get items por fecha 
    public function getItemsByDate(Request $request)
    {
        $items = $this->timeSheet->getItemsByDate($request->date);
        return response()->json($items);
    }



    //register time sheet
    public function store(Request $request)
    {
        $data = $request->all();
        foreach ($data as $item) {
            $this->timeSheet->register($item);
        }
        return response()->json([
            'message' => 'Registro guardado correctamente',
        ]);
    }

    public function timeSheetByDay($projectId, $day)
    {
        $items = $this->projectVehicle->distinct()
            ->select(
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
                'time_sheets.type as type',
            )
            ->join('vehicles', 'project_vehicles.vehicle_id', '=', 'vehicles.id')
            ->join('suppliers', 'vehicles.supplier_id', '=', 'suppliers.id')
            ->leftJoin('vehicles_operators', 'vehicles.id', '=', 'vehicles_operators.vehicle_id')
            ->leftJoin('operators', 'vehicles_operators.operator_id', '=', 'operators.id')
            ->leftJoin('time_sheets', function ($join) use ($day) {
                $join->on('project_vehicles.vehicle_id', '=', 'time_sheets.vehicle_id')
                    ->where(function ($query) {
                        $query->whereColumn('vehicles_operators.operator_id', '=', 'time_sheets.operator_id')
                            ->orWhereNull('time_sheets.operator_id');
                    })
                    ->whereDate('time_sheets.register_at', $day);
            })
            ->whereRaw('vehicles_operators.is_enabled = 1 or vehicles_operators.is_enabled is null')
            ->where('project_vehicles.project_id', $projectId)
            ->get();

        return response()->json($items);
    }



    //timeSheetByMonth

    public function timeSheetByMonth($projectId, $month)
    {
        $items = $this->projectVehicle->distinct()
            ->select(
                'project_vehicles.project_id',
                'project_vehicles.vehicle_id',
                'vehicles.name as vehicle_name',
                'suppliers.name as supplier_name',
                'operators.id as operator_id',
                DB::Raw('CONCAT_WS(" ", operators.name, operators.paternal_surname, operators.maternal_surname) as operator_name'),
            )
            ->join('vehicles', 'project_vehicles.vehicle_id', '=', 'vehicles.id')
            ->join('suppliers', 'vehicles.supplier_id', '=', 'suppliers.id')
            ->leftJoin('vehicles_operators', 'vehicles.id', '=', 'vehicles_operators.vehicle_id')
            ->leftJoin('operators', 'vehicles_operators.operator_id', '=', 'operators.id')
            ->where('project_vehicles.project_id', $projectId)
            ->get();

        //listar losias del mes $month 2024-08 = [2024-08-01,.., 2024-08-31]
        $days = [];
        $date = new \DateTime($month . '-01');
        $lastDay = $date->format('t');
        for ($i = 1; $i <= $lastDay; $i++) {
            $days[] = $date->format('Y-m-d');
            $date->modify('+1 day');
        }

        $items = $items->map(function ($item) use ($days) {

            $types = [];
            foreach ($days as $day) {
                $type = $this->timeSheet->where('vehicle_id', $item->vehicle_id)
                    ->where('operator_id', $item->operator_id)
                    ->where('project_id', $item->project_id)
                    ->whereDate('register_at', $day)
                    ->value('type');

                array_push($types, $type);
            }

            $item->types = $types;
            return $item;
        });

        return response()->json($items);
    }
}
