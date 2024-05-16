<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PermissionController extends Controller
{
    
    public function index()
    {
        return Inertia::render('Security/views/permission/index');
    }
}
