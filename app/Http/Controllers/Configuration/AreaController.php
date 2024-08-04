<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Company;
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

    public function index($id)
    {
        $company = Company::find($id);
        return Inertia::render('Configuration/area/views/index', [
            'title' =>  $company->name . ' - ' . $this->title,
            'company' => $company
        ]);
    }

    public function getItems(Request $request, $companyId)
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
            $query->orderBy('areas.created_at', 'desc');
        }

        if ($request->has('search')) {
            $query->where('areas.name', 'like', '%' . $request->search . '%');
        }

        $query->where('company_id', $companyId);

        $query->select([
            'areas.id',
            'areas.name',
            'areas.is_enabled',
            'companies.name as company'
        ])->join('companies', 'areas.company_id', '=', 'companies.id');



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
            $this->area::create($request->all());

            return response()->json([
                'message' => 'Area creada correctamente',
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
            $this->area->where('id', $id)->update([
                'name' => $request->name,
                'is_enabled' => $request->is_enabled,
            ]);
            return response()->json([
                'message' => 'Area actualizada correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
