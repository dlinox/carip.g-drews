<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'paternal_surname',
        'maternal_surname',
        'document_type',
        'document_number',
        'phone',
        'email',
        'birthdate',
        'birth_place',
        'residence_place',
        'gender',
        'license_number',
        'license_category',
        'license_expiration_date',
        'is_enabled',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'birthdate' => 'date:Y-m-d',
        'license_expiration_date' => 'date:Y-m-d',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected function birthPlace(): Attribute
    {

        return Attribute::make(
            get: function ($value) {
                $location = Location::where('code', $this->attributes['birth_place'])->first();

                if ($location) {
                    $name = $location->department . ', ' . $location->province . ', ' . $location->district;
                }

                return  [
                    'code' => $this->attributes['birth_place'],
                    'location' => $name,
                ];
            },
            // set: function ($value) {
            //     return $value['code'];
            // }

        );
    }

    protected function residencePlace(): Attribute
    {

        return Attribute::make(
            get: function ($value) {
                $location = Location::where('code', $this->attributes['residence_place'])->first();

                if ($location) {
                    $name = $location->department . ', ' . $location->province . ', ' . $location->district;
                }

                return  [
                    'code' => $this->attributes['residence_place'],
                    'location' => $name,
                ];
            },
            // set: function ($value) {
            //     return $value['code'];
            // }

        );
    }

    public static function headers(): array
    {
        return [
            ["title" => "Nombre", "key" => "name", "align" => "center"],
            ["title" => "Apellido Paterno", "key" => "paternal_surname", "align" => "center"],
            ["title" => "Apellido Materno", "key" => "maternal_surname", "align" => "center"],

            ["title" => "Documento", "key" => "document_number", "align" => "center"],
            ["title" => "Fecha de Nacimiento", "key" => "birthdate", "align" => "center"],
            ["title" => "Lugar de Nacimiento", "key" => "birth_place", "align" => "center"],
            ["title" => "Lugar de Residencia", "key" => "residence_place", "align" => "center"],
            ["title" => "Género", "key" => "gender", "align" => "center"],
            ["title" => "Número de Licencia", "key" => "license_number", "align" => "center"],
            ["title" => "Categoría de Licencia", "key" => "license_category", "align" => "center"],
            ["title" => "Fecha de Vencimiento de Licencia", "key" => "license_expiration_date", "align" => "center"],


            ["title" => "Teléfono", "key" => "phone", "align" => "center"],
            ["title" => "Email", "key" => "email", "align" => "center"],
            ["title" => "Estado", "key" => "is_enabled", "align" => "center"],
            ["title" => "Acciones", "key" => "actions", "align" => "end", "sortable" => false]
        ];
    }

    public  function getFreeOperators(): array
    {
        $operators =  $this->select('operators.id', 'operators.name')
            ->leftJoin('vehicles_operators', 'vehicles_operators.operator_id', '=', 'operators.id')
            ->leftJoin('projects', 'projects.id', '=', 'vehicles_operators.project_id')
            ->whereRaw('vehicles_operators.is_enabled = false or vehicles_operators.id is null')
            ->whereRaw('projects.is_enabled is null or projects.is_enabled = false')
            ->where('operators.is_enabled', true)
            ->get();

        return $operators->toArray();
    }

    public function getSupervisoryOperators(): array
    {
        $supervisoryOperators = $this->select('operators.id', 'operators.name')
            // ->leftJoin('project_supervisors', 'project_supervisors.operator_id', '!=', 'operators.id')
            // ->where('project_supervisors.is_enabled', true)
            ->get();

        return $supervisoryOperators->toArray();
    }
}
