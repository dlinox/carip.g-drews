<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectVehicle extends Model
{
    use HasFactory;

    protected $primaryKey = ['project_id', 'vehicle_id'];
    public $incrementing = false;

    protected $fillable = [
        'project_id',
        'vehicle_id',
        'vehicle_price',
        'start_date',
        'end_date',
        'is_enabled'
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function scopeEnabled($query)
    {
        return $query->where('is_enabled', true);
    }


    public function scopeDisabled($query)
    {
        return $query->where('is_enabled', false);
    }

    public function scopeByProject($query, $project_id)
    {
        return $query->where('project_id', $project_id);
    }
}
