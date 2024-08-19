<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'description',
        'location',
        'start_date',
        'finish_date',
        'company_id',
        'is_finished',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_finished' => 'boolean',
        'start_date' => 'date:Y-m-d',
        'finish_date' => 'date:Y-m-d',
    ];

    protected $appends = [
        'company_name',
    ];

    //company_name
    protected function companyName(): Attribute
    {

        return Attribute::make(
            get: function ($value) {
                $company = Company::where('id', $this->attributes['company_id'])->first();

                if ($company) {
                    return $company->name;
                }

                return null;
            },

        );
    }
    protected function location(): Attribute
    {

        return Attribute::make(
            get: function ($value) {
                $location = Location::where('code', $this->attributes['location'])->first();

                if ($location) {
                    $name = $location->department . ', ' . $location->province . ', ' . $location->district;
                }

                return  [
                    'code' => $this->attributes['location'],
                    'location' => $name,
                ];
            },

        );
    }

    //finalizar proyecto
    public function finish()
    {
        $this->is_finished = true;
        $this->finish_date = now();
        $this->save();
    }

    public static function headers(): array
    {
        return [

            ['title' => "Empresa", 'key' => 'company_name', 'align' => 'center'],
            ['title' => "Nombre", 'key' => 'name', 'align' => 'center'],
            ['title' => "Descripción", 'key' => 'description', 'align' => 'center'],
            ['title' => "Ubicación", 'key' => 'location', 'align' => 'center'],
            ['title' => "Fecha de Inicio", 'key' => 'start_date', 'align' => 'center'],
            ['title' => "Estado", 'key' => 'is_finished', 'align' => 'center'],
            ['title' => "Acciones", 'key' => 'actions', 'align' => 'end', 'sortable' => false]
        ];
    }
}
