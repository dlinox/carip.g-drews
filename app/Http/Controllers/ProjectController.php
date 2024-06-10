<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{

    protected $title;
    protected $project;
    public function __construct(){
        $this->title = "Proyectos";
        $this->project = new Project();
    }

    public function index()
    {

        return Inertia::render("Project/views/index", [
            'title' => 'Proyectos'
        ]);
    }

    public function getItems(Request $request){

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

    public function store(Request $request){

        try {
            $project = $this->project::create($request->all());
            return response()->json([
                'message' => 'Proyecto creado correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message'=> $e->getMessage(),
                ]);
        }
    }

    public function update(Request $request, $id){
        try {
            $project = $this->project::where('id', $id)->first();
            $project->update($request->except('processing'));
            return response()->json([
                'message' => 'Proyecto actualizado correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message'=> $e->getMessage(),
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
}
