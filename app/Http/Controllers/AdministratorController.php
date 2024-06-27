<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdministratorController extends Controller
{
    protected $title;
    protected $administrator;

    public function __construct()
    {
        $this->title = 'Administradores';
        $this->administrator = new Administrator();
    }

    public function index()
    {

        return Inertia::render("Configuration/administrator/views/index", [
            'title' => $this->title,
            'typeDocuments' => $this->typeDocuments,
        ]);
    }

    public function getItems(Request $request)
    {

        $perPage = $request->itemsPerPage ?? 10;

        $query = $this->administrator::query();
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

        $headers = $this->administrator->headers();

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
        try{
            Administrator::create($request->all());

            return response()->json([
                'message' => 'Administrador creado correctamente'
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'Error al crear el administrador',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
