<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AreaController extends Controller
{

    protected $area;
    protected $title;

    //define constructor
    public function __construct()
    {
        $this->area = new Area();
        $this->title = 'Areas';
    }

    public function index()
    {
        return Inertia::render('Configuration/area/views/index', [
            'title' => $this->title
        ]);
    }

    public function getItems(Request $request)
    {
        $perPage = $request->itemsPerPage ?? 10;

        $query = $this->area::query();
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

        $headers = $this->area::headers();
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
            $area = $this->area::create([
                'name' => $request->name,
                'description' => $request->description,
                'is_enabled' => $request->isEnabled,
            ]);

            return redirect()->back()->with('success', 'Area creado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->area->where('id', $id)->update([
                'name' => $request->name,
                'description' => $request->description,
                'is_enabled' => $request->isEnabled,
            ]);

            return redirect()->back()->with('success', 'Area actualizado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
