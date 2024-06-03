<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{

    public function index()
    {

        return Inertia::render("Project/views/index", [
            'title' => 'Proyectos'
        ]);
    }

    public function show($id)
    {
        return Inertia::render('Project/views/show', [
            'title' => 'Proyecto'
        ]);
    }
}
