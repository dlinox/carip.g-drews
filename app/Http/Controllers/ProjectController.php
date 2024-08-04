<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Operator;
use App\Models\Project;
use App\Models\ProjectManager;
use App\Models\ProjectSupervisor;
use App\Models\Supervisor;
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

    protected $worker;
    public function __construct()
    {
        $this->title = "Proyectos";
        $this->project = new Project();
        $this->supervisor = new Supervisor();
        $this->worker = new Worker();
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
            'supervisors' => $this->supervisor->getFreeSupervisors(),
            'workers' => $this->worker->getFreeWorkers($id),
        ]);
    }

    //getSupervisors
    public function getSupervisors()
    {
        $supervisors = $this->supervisor->getFreeSupervisors();
        return response()->json($supervisors);
    }

    //assignResponsibleCompany
    public function assignResponsibleCompany(Request $request)
    {

        try {
            $projectManager =  new ProjectManager();
            $projectManager->assignProjectManager($request->project_id, $request->worker_id);

            return response()->json([
                'message' => 'Compañía asignada correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    //getProjectManager
    public function getProjectManager($projectId)
    {
        $projectManager = new ProjectManager();
        $projectManager = $projectManager->getProjectManager($projectId);
        return response()->json($projectManager);
    }

    //getTtemsVehiclesToProject
    public function getItemsAssignedVehicles($projectId)
    {
        $vehiclesOperator = new VehiclesOperator();
        $items = $vehiclesOperator->getVehiclesForProject($projectId);
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

    public function assignProjectSupervisor(Request $request)
    {

        try {
            $projectSupervisor = new ProjectSupervisor();
            $projectSupervisor->assignProjectSupervisor($request->project_id, $request->supervisor_id);

            return response()->json([
                'message' => 'Supervisor asigned correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getProjectSupervisor($projectId)
    {
        $projectSupervisor = new ProjectSupervisor();
        $projectSupervisor = $projectSupervisor->getProjectSupervisor($projectId);
        return response()->json($projectSupervisor);
    }

    //getSupervisoryOperators
    public function getSupervisoryOperators()
    {
        $supervisoryOperators = new Operator();
        $supervisoryOperators = $supervisoryOperators->getSupervisoryOperators();
        return response()->json($supervisoryOperators);
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

    public function getCompanies()
    {
        $company = new Company();
        $companies = $company->getCompanies();
        return response()->json($companies);
    }

    public function getResponsibleByCompany($companyId)
    {
        $worker = new Worker();
        $workers = $worker->getResponsibleByCompany($companyId);
        return response()->json($workers);
    }
}
