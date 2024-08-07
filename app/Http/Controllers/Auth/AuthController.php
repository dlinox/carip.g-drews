<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignInRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return inertia('Auth/views/login');
    }

    public function signIn(SignInRequest $request)
    {

        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Credenciales inválidas',
            ]);
        }

        //añadir los permisos a la sesión
        auth()->user()->p = 'hola';

        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully logged in',
        ]);
    }

    public function signOut()
    {
        auth()->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully logged out',
        ]);
    }
}
