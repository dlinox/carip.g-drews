<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    protected $project;
    protected $title;

    //define constructor
    public function __construct()
    {
        $this->project = new Project();
        $this->title = 'Projects';
    }

    public function index()
    {
        return Inertia::render('Configuration/project/views/index');
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


        $query->select([
            'id',
            'name',
            'description',
            'is_enabled as isEnabled'
        ]);

        $items = $query->paginate($perPage);

        $headers = $this->project::headers();
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
        $project = $this->project::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_enabled' => $request->isEnabled,
        ]);

        return redirect()->back()->with('success', 'Project creado correctamente');
    }

    public function update(Request $request, $id)
    {
        try {

            $this->project->where('id', $id)->update([
                'name' => $request->name,
                'description' => $request->description,
                'is_enabled' => $request->isEnabled,
            ]);

            return redirect()->back()->with('success', 'Project actualizado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->project->destroy($id);

            return redirect()->back()->with('success', 'Project eliminado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
