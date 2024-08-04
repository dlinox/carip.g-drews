<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Supervisor extends Model
{
    use HasFactory;
    /*

            $table->char('email', 60)->nullable();
            $table->enum('gender', ['M', 'F'])->default('M');
            $table->string('birth_place', 60)->nullable();
            $table->string('residence_place', 60)->nullable();
            $table->date('birthdate ')->nullable();
*/
    protected $fillable = [
        'name',
        'paternal_surname',
        'maternal_surname',
        'document_type',
        'document_number',
        'phone',
        'email',
        'gender',
        'birth_place',
        'residence_place',
        'birthdate',
        'is_enabled',

    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'birthdate' => 'date:Y-m-d',
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
        );
    }

    public static function headers(): array
    {
        return [
            ["title" => "Nombre", "key" => "name", "align" => "center"],
            ["title" => "Apellido Paterno", "key" => "paternal_surname", "align" => "center"],
            ["title" => "Apellido Materno", "key" => "maternal_surname", "align" => "center"],
            ["title" => "Número de Documento", "key" => "document_number", "align" => "center"],
            ["title" => "Teléfono", "key" => "phone", "align" => "center"],
            ["title" => "Correo Electrónico", "key" => "email", "align" => "center"],
            ["title" => "Género", "key" => "gender", "align" => "center"],
            ["title" => "Lugar de Nacimiento", "key" => "birth_place", "align" => "center"],
            ["title" => "Lugar de Residencia", "key" => "residence_place", "align" => "center"],
            ["title" => "Fecha de Nacimiento", "key" => "birthdate", "align" => "center"],
            ["title" => "Estado", "key" => "is_enabled", "align" => "center"],
            ["title" => "Acciones", "key" => "actions", "align" => "end", "sortable" => false]
        ];
    }

    public static function getFreeSupervisors()
    {
        return Supervisor::select('id', DB::raw('CONCAT(name, " ", paternal_surname, " ", maternal_surname) as name'))
            ->where('is_enabled', true)
            ->whereNotIn(
                'id',
                ProjectSupervisor::join('projects', 'projects.id', '=', 'project_supervisors.project_id')
                    ->where('projects.is_enabled', true)
                    ->select('supervisor_id')
            )
            ->get();
    }
}
