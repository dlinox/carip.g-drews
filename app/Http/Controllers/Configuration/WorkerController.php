<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WorkerController extends Controller
{
   
    public function index(){
        return Inertia::render('Configuration/worker/views/index', [
            'title' => 'Trabajadores'
        ]);
    }
}
