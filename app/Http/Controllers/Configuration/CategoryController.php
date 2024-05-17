<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{

    public function index()
    {

        $modelTypes = Category::modelType();

        return Inertia::render('Configuration/views/category/index', [
            'modelTypes' => $modelTypes
        ]);
    }

    public function loadItems (Request $request)
    {
        $perPage = $request->itemsPerPage ?? 10;

        $query = Category::query();
        $sortBy = [];

        if ($request->has('sortBy') && count($request->sortBy) > 0) {
            $sortBy = $request->sortBy;
            foreach ($sortBy as $sort) {
                $query->orderBy($sort['key'], $sort['order']);
            }
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $items = $query->paginate($perPage);

        $headers = Category::headers();
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
        $request['model_type'] = $request->modelType;

        Category::create($request->all());

        return response()->json(['message' => 'Categoría creada correctamente']);
    }
}
