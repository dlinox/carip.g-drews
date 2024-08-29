<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function indexOperators()
    {
        return Inertia::render("Payment/views/operators", [
            'title' => "Pagos a Operadores",
        ]);
    }

    //indexSuppliers

    public function indexSuppliers()
    {
        return Inertia::render("Payment/views/suppliers", [
            'title' => "Pagos a Proveedores",
        ]);
    }
}
