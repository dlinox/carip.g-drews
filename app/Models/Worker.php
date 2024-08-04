<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Worker extends Model
{
    use HasFactory;
    /*
        $table->id();
            $table->string('name', 60);
            $table->string('paternal_surname', 60)->nullable();
            $table->string('maternal_surname', 60)->nullable();
            $table->char('document_type', 8)->default('DNI');
            $table->char('document_number', 8)->nullable();
            $table->char('phone', 15)->nullable();
            $table->char('email', 60)->nullable();
            $table->enum('gender', ['M', 'F'])->default('M');
            $table->char('birth_place', 6)->nullable();
            $table->char('residence_place', 6)->nullable();
            $table->date('birthdate')->nullable();
    */

    protected $fillable = [
        "name",
        "paternal_surname",
        "maternal_surname",
        "document_type",
        "document_number",
        "phone",
        "email",
        "gender",
        "birth_place",
        "residence_place",
        "birthdate",
        'is_enabled',
        "area_id",
        "company_id",
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    protected $appends = [
        // 'full_name',
        'area_name',
    ];

    // protected function getFullNameAttribute()
    // {
    //     return $this->attributes['name'] . ' ' . $this->attributes['paternal_surname'] . ' ' . $this->attributes['maternal_surname'];
    // }

    protected function getAreaNameAttribute()
    {
        return isset($this->attributes['area_id']) ? Area::find($this->attributes['area_id'])->name : '';
    }

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
            ["title" => "Área", "key" => "area_name", "align" => "center"],

            ["title" => "Género", "key" => "gender", "align" => "center"],
            ["title" => "Fecha de Nacimiento", "key" => "birthdate", "align" => "center"],
            ["title" => "Lugar de Nacimiento", "key" => "birth_place", "align" => "center"],
            ["title" => "Lugar de Residencia", "key" => "residence_place", "align" => "center"],

            ["title" => "Documento", "key" => "document_number", "align" => "center"],
            ["title" => "Email", "key" => "email", "align" => "center"],
            ["title" => "Teléfono", "key" => "phone", "align" => "center"],
            ["title" => "Estado", "key" => "is_enabled", "align" => "center"],
            ["title" => "Acciones", "key" => "actions", "align" => "end", "sortable" => false],

        ];
    }

    public static function getFreeWorkers($idCompany)
    {
        $companies = Worker::select(
            'workers.id',
            DB::raw('concat(  areas.name, " - " ,  workers.name, " ", workers.paternal_surname, " ", workers.maternal_surname) as name')
        )
            ->join('areas', 'areas.id', '=', 'workers.area_id')
            ->join('companies', 'companies.id', '=', 'workers.company_id')
            ->where('companies.id', $idCompany)
            ->whereNotIn(
                'workers.id',
                ProjectManager::join('projects', 'projects.id', '=', 'project_managers.project_id')
                    ->where('projects.company_id', $idCompany)
                    ->where('projects.is_enabled', true)
                    ->select('worker_id')
            )
            ->get();

        return $companies;
    }
}
