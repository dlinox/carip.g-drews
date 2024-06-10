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

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignOperatorToVehicle($vehicle, $operator, $project)
    {
        $this->vehicle_id = $vehicle->id;
        $this->operator_id = $operator->id;
        $this->project_id = $project->id;
        $this->save();
    }

    public function removeOperatorFromVehicle($vehicle, $operator, $project)
    {
        $this->vehicle_id = $vehicle->id;
        $this->operator_id = $operator->id;
        $this->project_id = $project->id;
        $this->is_enabled = false;
        $this->save();
    }

    public function getOperatorsForVehicleByProject($vehicle, $project)
    {
        return $this->where('vehicle_id', $vehicle->id)->where('project_id', $project->id)->where('is_enabled', true)->get();
    }

    public function getVehiclesForOperatorByProject($operator, $project)
    {
        return $this->where('operator_id', $operator->id)->where('project_id', $project->id)->where('is_enabled', true)->get();
    }

    public  function getVehiclesForProject($project)
    {
        return $this
            ->select('vehicles_operators.vehicle_id', 'vehicles_operators.operator_id', 'vehicles.name as vehicle', 'operators.name as operator', 'vehicles_operators.project_id')
            ->join('vehicles', 'vehicles.id', '=', 'vehicles_operators.vehicle_id')
            ->join('operators', 'operators.id', '=', 'vehicles_operators.operator_id')
            ->where('vehicles_operators.project_id', $project->id)
            ->where('vehicles_operators.is_enabled', true)
            ->get();
    }
}
