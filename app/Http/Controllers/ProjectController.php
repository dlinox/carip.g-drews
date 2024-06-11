<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use App\Models\Project;
use App\Models\Vehicle;
use App\Models\VehiclesOperator;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{

    protected $title;
    protected $project;
    public function __construct()
    {
        $this->title = "Proyectos";
        $this->project = new Project();
    }

    public function index()
    {

        return Inertia::render("Project/views/index", [
            'title' => 'Proyectos'
        ]);
    }

    public function getItems(Request $request)
    {

        $perPage = $request->itemsPerPage ?? 10;

        $query = $this->project::query();
        $sortBy = [];

        if ($request->has('sortBy') && count($request->sortBy) > 0) {
            $sortBy = $request->sortBy;
            foreach ($sortBy as $sort) {
                $query->orderBy($sort['key'], $sort['order']);
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $items = $query->paginate($perPage);

        $headers = $this->project->headers();
        return response()->json([
            'items' => $items,
            'headers' => $headers,
            'filters' => [
                'perPage' => $perPage,
                'sortBy' => $sortBy,
                'search' => $request->search
            ]
        ]);
    }

    public function store(Request $request)
    {

        try {
            $project = $this->project::create($request->all());
            return response()->json([
                'message' => 'Proyecto creado correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $project = $this->project::where('id', $id)->first();
            $project->update($request->except('processing'));
            return response()->json([
                'message' => 'Proyecto actualizado correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }


    public function show($id)
    {
        $project = $this->project::find($id);
        return Inertia::render('Project/views/show', [
            'title' => 'Proyecto',
            'project' => $project
        ]);
    }



    //getTtemsVehiclesToProject
    public function getItemsAssignedVehicles($idProject)
    {
        $vehiclesOperator = new VehiclesOperator();
        $items = $vehiclesOperator->getVehiclesForProject($idProject);
        return response()->json($items);
    }

    public function assignVehicle(Request $request)
    {

        try {
            VehiclesOperator::create($request->all());

            return response()->json([
                'message' => 'Vehicle asigned correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    //optener los operadores libres
    public function getOperators()
    {
        $operator = new Operator();
        $operators = $operator->getFreeOperators();
        return response()->json($operators);
    }

    public function getVehicles()
    {
        $vehicle = new Vehicle();
        $vehicles = $vehicle->getFreeVehicles();
        return response()->json($vehicles);
    }
}
