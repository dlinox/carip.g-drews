<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Worker extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "document",
        "email",
        "phone",
        "is_enabled",
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


    public static function headers(): array
    {
        return [
            ["title" => "Nombre", "key" => "name", "align" => "center"],
            ["title" => "Documento", "key" => "document", "align" => "center"],
            ["title" => "Email", "key" => "email", "align" => "center"],
            ["title" => "Teléfono", "key" => "phone", "align" => "center"],
            ["title" => "Estado", "key" => "is_enabled", "align" => "center"],
            ["title" => "Acciones", "key" => "actions", "align" => "end", "sortable" => false],

        ];
    }

    public function getResponsibleByCompany($idCompany)
    {
        $companies = $this->select('workers.id', DB::raw('concat(  areas.name, " - " ,  workers.name, " [", workers.document , "]") as name'))
            ->join('areas', 'areas.id', '=', 'workers.area_id')
            ->join('companies', 'companies.id', '=', 'workers.company_id')
            ->where('companies.id', $idCompany)
            ->get();

        return $companies->toArray();
    }
}
