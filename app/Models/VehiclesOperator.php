<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehiclesOperator extends Model
{
    use HasFactory;


    protected $table = 'vehicles_operators';

    protected $fillable = [
        'vehicle_id',
        'operator_id',
        'project_id',
        'is_enabled'
    ];

    protected $casts = [
        'is_enabled' => 'boolean'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];





}
