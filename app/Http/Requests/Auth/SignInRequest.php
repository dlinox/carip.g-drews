<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SignInRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            "email" => "required|email",
            "password" => "required",
        ];
    }

    public function messages(): array
    {
        return [
            "email.required" => "El correo es requerido",
            "email.email" => "El correo no es valido",
            "password.required" => "La contraseña es requerida",
        ];
    }
}
