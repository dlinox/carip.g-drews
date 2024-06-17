<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    public function searchLocation($search)
    {
        try {
            $location = new Location();
            $locations = $location->search($search);
            return response()->json($locations, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
            // return response()->json(['message' => 'El servicio de localización no esta disponible'], 500);
        }
    }
}
