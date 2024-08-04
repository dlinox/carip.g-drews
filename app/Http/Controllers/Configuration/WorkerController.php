<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Company;
use App\Models\Worker;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WorkerController extends Controller
{

    protected $title;
    protected $worker;

    public function __construct()
    {
        $this->title = "Trabajadores";
        $this->worker = new Worker();
    }

    public function index($companyId)
    {

        $company = Company::find($companyId);

        $areas = Area::where("company_id", $companyId)->where('is_enabled', true)->get();

        return Inertia::render('Configuration/worker/views/index', [
            'title' =>  $company->name . ' - ' . $this->title,
            'company' => $company,
            'areas' => $areas,
            'typeDocuments' => $this->typeDocuments,
        ]);
    }

    public function getItems(Request $request, $companyId)
    {
        $perPage = $request->itemsPerPage ?? 10;

        $query = $this->worker::query();
        $sortBy = [];

        if ($request->has('sortBy') && count($request->sortBy) > 0) {
            $sortBy = $request->sortBy;
            foreach ($sortBy as $sort) {
                $query->orderBy($sort['key'], $sort['order']);
            }
        } else {
            $query->orderBy('workers.created_at', 'desc');
        }

        if ($request->has('search')) {
            $query->where('workers.name', 'like', '%' . $request->search . '%');
        }

        $query->where('company_id', $companyId);

        $items = $query->paginate($perPage);

        $headers = $this->worker->headers();
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
            $this->worker->create($request->all());

            return response()->json([
                'message' => 'Worker creada correctamente',
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

            $request['birth_place'] = $request->birth_place['code'];
            $request['residence_place'] = $request->residence_place['code'];

            $this->worker->where('id', $id)->update($request->except('company', 'processing', 'full_name', 'area_name'));

            return response()->json([
                'message' => 'Worker actualizada correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }
}
