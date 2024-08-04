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
            return response()->json($locations ?? [], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
            // return response()->json(['message' => 'El servicio de localización no esta disponible'], 500);
        }
    }

    public function searchReniec($dni)
    {
        if (!is_numeric($dni) || strlen($dni) != 8) {
            return response()->json([
                'status' => 404,
                'message' => 'El DNI debe tener 8 dígitos',
                'data' => null
            ]);
        }

        try {
            $url = "https://api.factiliza.com/pe/v1/dni/info/" . $dni;
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('API_TOKEN_RENIEC_SUNAT')
                ]
            ]);
            $data = json_decode($response->getBody());
            return $data;
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error al consultar el servicio de RENIEC',
                'data' => null
            ]);
        }
    }

    public function searchSunat($ruc)
    {
        if (!is_numeric($ruc) || strlen($ruc) != 11) {
            return response()->json([
                'status' => 404,
                'message' => 'El RUC debe tener 11 dígitos',
                'data' => null
            ]);
        }

        try {
            $url = "https://api.factiliza.com/pe/v1/ruc/info/" . $ruc;
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('API_TOKEN_RENIEC_SUNAT')
                ]
            ]);
            $data = json_decode($response->getBody());
            return $data;
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Error al consultar el servicio de SUNAT',
                'data' => null
            ]);
        }
    }
}
