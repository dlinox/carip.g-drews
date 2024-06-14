<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectSupervisor extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'operator_id',
        'is_enabled',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    public function assignProjectSupervisor($projectId, $operatorId)
    {
        $projectSupervisor = $this->where('project_id', $projectId)->where('operator_id', $operatorId)->first();

        if ($projectSupervisor) {
            return $projectSupervisor;
        }
        $projectSupervisor = new ProjectSupervisor();
        $projectSupervisor->project_id = $projectId;
        $projectSupervisor->operator_id = $operatorId;
        $projectSupervisor->is_enabled = true;
        $projectSupervisor->save();
        return $projectSupervisor;
    }

    public function getProjectSupervisor($projectId)
    {
        return $this->select('operators.name')
            ->join('operators', 'operators.id', '=', 'project_supervisors.operator_id')
            ->where('project_supervisors.project_id', $projectId)
            ->where('project_supervisors.is_enabled', true)
            ->first();
    }
}
