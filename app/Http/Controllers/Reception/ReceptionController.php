<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReceptionController extends Controller
{
    public function index()
    {

        return Inertia::render('Reception/views/index');
    }

    public function checkIn()
    {
        return inertia('Reception/views/checkIn');
    }

    public function checkOut()
    {
        return inertia('Reception/views/checkOut');
    }
}
