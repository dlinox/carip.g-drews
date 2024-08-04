<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupplierController extends Controller
{
    protected $title;
    protected $supplier;

    public function __construct()
    {
        $this->title = "Proveedores";
        $this->supplier = new Supplier();
    }
    public function index()
    {

        return Inertia::render("Configuration/supplier/views/index", [
            'title' => $this->title
        ]);
    }

    public function getItems(Request $request)
    {
        $perPage = $request->itemsPerPage ?? 10;

        $query = $this->supplier::query();
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

        $headers = $this->supplier->headers();
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
            $this->supplier->create($request->all());
            return response()->json([
                'message' => 'Proveedor creado correctamente',
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
            $this->supplier->where('id', $id)->update($request->except('processing'));
            return response()->json([
                'message' => 'Proveedor actualizado correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }
}
