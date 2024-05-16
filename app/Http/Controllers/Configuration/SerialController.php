<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SerialController extends Controller
{
    
    public function index()
    {
        return Inertia::render('Configuration/views/serial/index');
    }
}
