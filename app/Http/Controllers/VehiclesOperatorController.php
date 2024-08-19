<?php

namespace App\Http\Controllers;

use App\Models\VehiclesOperator;
use Illuminate\Http\Request;

class VehiclesOperatorController extends Controller
{
    protected $vehiclesOperator;

    public function __construct()
    {
        $this->vehiclesOperator = new VehiclesOperator();
    }


    public function assignOperator(Request $request)
    {

        try {
            $this->vehiclesOperator->assignOperator(
                $request->vehicle_id,
                $request->operator_id,
                $request->project_id,
                $request->start_date,
                $request->operator_salary
            );

            return response()->json([
                'message' => 'Operador asignado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
