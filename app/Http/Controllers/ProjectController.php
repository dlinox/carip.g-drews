<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Operator;
use App\Models\Project;
use App\Models\ProjectManager;
use App\Models\ProjectSupervisor;
use App\Models\Supervisor;
use App\Models\Supplier;
use App\Models\Vehicle;
use App\Models\VehiclesOperator;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProjectController extends Controller
{

    protected $title;
    protected $project;
    protected $supervisor;

    protected $supplier;

    protected $worker;
    public function __construct()
    {
        $this->title = "Proyectos";
        $this->project = new Project();
        $this->supervisor = new Supervisor();
        $this->worker = new Worker();

        $this->supplier = new Supplier();
    }

    public function index()
    {
        return Inertia::render("Project/views/index", [
            'title' => 'Gestion de Proyectos',
            'companies' => Company::select('id', DB::raw('CONCAT(document_number, " - ", name) as name'))->get()
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

            $request['location'] = $request->location['code'];
            $this->project::create($request->all());
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
            $request['location'] = $request->location['code'];
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
            'title' => 'Gestion del Proyecto',
            'project' => $project,
            'suppliers' => $this->supplier::enabled()->forSelect()->get(),
        ]);
    }
}
