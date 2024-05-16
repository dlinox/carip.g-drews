<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FloorController extends Controller
{
    
    public function index()
    {
        return Inertia::render('Configuration/views/floor/index');
    }
}
