<?php

namespace App\Http\Requests\Permission;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        
        //conderar si es edit
        $id = $this->route('id');
        return [
            'name' => 'required|max:100|unique:roles,name,' . $id,
            'isEnabled' => 'required|boolean',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Nombre requerido',
            'name.max' => 'El nombre no puede exceder 100 caracteres',
            'name.unique' => 'El nombre ya existe',
            'isEnabled.required' => 'El campo "Activo" es requerido',
            'isEnabled.boolean' => 'El campo "Activo" debe ser un booleano',
        ];
    }
}
