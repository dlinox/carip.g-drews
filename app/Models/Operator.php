<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'document',
        'phone',
        'email',
        'is_enabled',
        'branch_id',
    ];


    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public static function headers(): array
    {
        return [
            ["title" => "Nombre", "key" => "name", "align" => "center"],
            ["title" => "Documento", "key" => "document", "align" => "center"],
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
            ->whereRaw('projects.is_enabled = false or projects.is_enabled is null')
            ->whereRaw('vehicles_operators.is_enabled = false or vehicles_operators.is_enabled is null')
            ->where('operators.is_enabled', true)
            ->get() ;

        return $operators->toArray();
    }
}
