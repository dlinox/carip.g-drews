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
        'operator_salary',
        'start_date',
        'end_date',
        'is_enabled'
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
        'operator_salary' => 'decimal:2'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'

    ];

    public function assignOperator($vehicleId, $operatorId, $projectId, $startDate, $operatorSalary)
    {
        $this->vehicle_id = $vehicleId;
        $this->operator_id = $operatorId;
        $this->project_id = $projectId;
        $this->start_date = $startDate;
        $this->operator_salary = $operatorSalary;
        $this->save();
    }


    public function unassignOperator($vehicleId, $operatorId, $projectId)
    {
        $this->where('vehicle_id', $vehicleId)
            ->where('operator_id', $operatorId)
            ->where('project_id', $projectId)
            ->update([
                'end_date' => now(),
                'is_enabled' => false
            ]);
    }
}
