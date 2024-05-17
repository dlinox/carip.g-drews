<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;
    /*
    Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->string('detail', 100);
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->double('amount')->default(00.0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    */

    protected $fillable = [
        'detail',
        'model_type',
        'model_id',
        'amount',
        'status'
    ];


    //morphTo
    public function model()
    {
        return $this->morphTo();
    }


    protected $casts = [
        'amount' => 'double',
        'status' => 'boolean'
    ];

    public static function headers(): array
    {
        return [
            ['title' => "Detalle", 'key' => 'detail', 'align' => 'center'],
            ['title' => "Tipo de modelo", 'key' => 'model_type', 'align' => 'center'],
            ['title' => "ID de modelo", 'key' => 'model_id', 'align' => 'center'],
            ['title' => "Monto", 'key' => 'amount', 'align' => 'center'],
            ['title' => "Estado", 'key' => 'status', 'align' => 'center'],
            ['title' => "Acciones", 'key' => 'actions', 'align' => 'end', 'sortable' => false]
        ];
    }
}
