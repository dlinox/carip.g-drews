<?php

namespace App\Http\Controllers;

use App\Models\Supervisor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupervisorController extends Controller
{
    protected $title;
    protected $supervisor;

    public function __construct()
    {
        $this->title = 'Supervisores';
        $this->supervisor = new Supervisor();
    }

    public function index()
    {

        return Inertia::render("Configuration/supervisor/views/index", [
            'title' => $this->title,
            'typeDocuments' => $this->typeDocuments,

        ]);
    }

    public function getItems(Request $request)
    {

        $perPage = $request->itemsPerPage ?? 10;

        $query = $this->supervisor::query();
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
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('paternal_surname', 'like', '%' . $request->search . '%')
                ->orWhere('maternal_surname', 'like', '%' . $request->search . '%')
                ->orWhere('document_number', 'like', '%' . $request->search . '%');
        }


        $items = $query->paginate($perPage);

        $headers = $this->supervisor->headers();

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
            $request['birth_place'] = $request->birth_place['code'];
            $request['residence_place'] = $request->residence_place['code'];
            Supervisor::create($request->all());
            return response()->json([
                'message' => 'Administrador creado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el administrador',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request['birth_place'] = $request->birth_place['code'];
            $request['residence_place'] = $request->residence_place['code'];
            $supervisor = Supervisor::find($id);
            $supervisor->update($request->all());
            return response()->json([
                'message' => 'Administrador actualizado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el administrador',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
