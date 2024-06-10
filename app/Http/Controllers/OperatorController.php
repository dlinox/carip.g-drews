<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Operator;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OperatorController extends Controller
{
    protected $operator;

    protected $title;

    public function __construct()
    {
        $this->operator = new Operator();
        $this->title = 'Operatores';
    }


    public function index()
    {


        $branches = Branch::where('is_enabled', true)->get();

        return Inertia::render("Configuration/operator/views/index", [
            'title' => $this->title,
            'branches' => $branches
        ]);
    }

    public function getItems(Request $request)
    {
        $perPage = $request->itemsPerPage ?? 10;

        $query = $this->operator::query();
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

        $headers = $this->operator->headers();

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
            $this->operator::create($request->all());

            return response()->json([
                'message' => 'Operador creado correctamente',
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
            $this->operator->where('id', $id)->update($request->except('processing'));
            return response()->json([
                'message' => 'Operador actualizado correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
