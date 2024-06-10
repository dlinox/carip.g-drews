<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyController extends Controller
{

    protected $company;
    protected $title;

    //define constructor
    public function __construct()
    {
        $this->company = new Company();
        $this->title = 'Empresas';
    }

    public function index()
    {
        return Inertia::render('Configuration/company/views/index', [
            'title' => $this->title
        ]);
    }

    public function getItems(Request $request)
    {
        $perPage = $request->itemsPerPage ?? 10;

        $query = $this->company::query();
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

        //alias a las columnas para el select
        $query->select([
            'id',
            'ruc',
            'name',
            'social',
            'address',
            'phone',
            'email',
            'ubication',
            'is_enabled'

        ]);

        $items = $query->paginate($perPage);

        $headers = $this->company->headers();
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

            $this->company->create($request->all());

            return response()->json([
                'message' => 'Empresa creada correctamente',
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
            $this->company->where('id', $id)->update(
                [
                    'ruc' => $request->ruc,
                    'name' => $request->name,
                    'social' => $request->social,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'ubication' => $request->ubication,
                    'is_enabled' => $request->is_enabled,
                ]
            );

            return response()->json([
                'message' => 'Empresa actualizada correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $this->company->destroy($id);

            return redirect()->back()->with('success', 'Empresa eliminada correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
