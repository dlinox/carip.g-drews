<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VehicleController extends Controller
{

    protected $title;
    protected $vehicle;
    public function __construct()
    {
        $this->title = "Vehiculos";
        $this->vehicle = new Vehicle();
    }
    public function index($supplierId)
    {
        $supplier = Supplier::find($supplierId);
        return Inertia::render("Configuration/vehicle/views/index", [
            'title' => $this->title,
            'supplier' => $supplier
        ]);
    }

    public function getItems(Request $request, $supplierId)
    {
        $perPage = $request->itemsPerPage ?? 10;

        $query = $this->vehicle::query();
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

        $query->where('supplier_id', $supplierId);


        $items = $query->paginate($perPage);

        $headers = $this->vehicle->headers();

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
            $this->vehicle::create($request->all());

            return response()->json([
                'message' => 'Vihiculo creado correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->vehicle->where('id', $id)->update($request->except('supplier','supplier_id', 'processing', 'supplier_name'));
            return response()->json([
                'message' => 'Vihiculo actualizado correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
