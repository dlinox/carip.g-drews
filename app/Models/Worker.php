<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;

    /*
     $table->bigIncrements("id");
            $table->unsignedBigInteger("company_id");
            $table->string("name");
            $table->string("document");
            $table->string("email");
            $table->string("phone");
            $table->boolean("is_enabled");
   */

    protected $fillable = [
        "name",
        "document",
        "email",
        "phone",
        "is_enabled",
        "company_id",
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'isEnabled' => 'boolean',
    ];

    public static function get($column, $value = null)
    {
        $query = parent::get($column, $value);
        $query->select([
            'id',
            'name',
            'description',
            'is_enabled as isEnabled'
        ]);
        return $query;
    }

    public static function headers(): array
    {
        return [
            ["title" => "Nombre", "key" => "name", "align" => "center"],
            ["title" => "Documento", "key" => "document", "align" => "center"],
            ["title" => "Email", "key" => "email", "align" => "center"],
            ["title" => "Teléfono", "key" => "phone", "align" => "center"],
            ["title" => "Estado", "key" => "isEnabled", "align" => "center"],
            ["title" => "Acciones", "key" => "actions", "align" => "end", "sortable" => false],

        ];
    }
}
