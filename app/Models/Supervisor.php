<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'paternal_surname',
        'maternal_surname',
        'document_type',
        'document_number',
        'phone',
        'is_enabled',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public static function headers(): array
    {
        return [
            ["title" => "Nombre", "key" => "name", "align" => "center"],
            ["title" => "Apellido Paterno", "key" => "paternal_surname", "align" => "center"],
            ["title" => "Apellido Materno", "key" => "maternal_surname", "align" => "center"],
            ["title" => "Tipo de Documento", "key" => "document_type", "align" => "center"],
            ["title" => "Número de Documento", "key" => "document_number", "align" => "center"],
            ["title" => "Teléfono", "key" => "phone", "align" => "center"],
            ["title" => "Estado", "key" => "is_enabled", "align" => "center"],
            ["title" => "Acciones", "key" => "actions", "align" => "end", "sortable" => false]
        ];
    }
}
