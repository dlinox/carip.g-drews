<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BranchController extends Controller
{

    protected $title;
    protected $branch;

    public function __construct()
    {
        $this->title = "Sedes";
        $this->branch = new Branch();
    }

    public function index()
    {
        return Inertia::render("Configuration/branch/views/index", [
            'title' =>  $this->title
        ]);
    }

    public function getItems(Request $request)
    {

        $perPage = $request->itemsPerPage ?? 10;

        $query = $this->branch::query();
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
            'geo_code',
            'is_enabled'
        ]);

        $items = $query->paginate($perPage);

        $headers = $this->branch->headers();
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
            $this->branch::create([
                'name' => $request->name,
                'geo_code' => $request->location['code'],
                'is_enabled' => $request->is_enabled,
            ]);

            return response()->json([
                'message' => 'Sede creada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->branch->where('id', $id)->update([
                'name' => $request->name,
                'geo_code' => $request->location['code'],
                'is_enabled' => $request->is_enabled,
            ]);

            return response()->json([
                'message' => 'Sede actualizada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
