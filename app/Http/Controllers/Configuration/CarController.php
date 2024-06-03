<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CarController extends Controller
{

    public function index()
    {
        return Inertia::render("Configuration/car/views/index", [
            'title' => 'Carros'
        ]);
    }
}
