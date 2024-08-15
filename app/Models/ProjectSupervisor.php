<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProjectSupervisor extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'supervisor_id',
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

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }

    public static function getSupervisors()
    {
        return Supervisor::select('id', DB::raw('CONCAT(name, " ", paternal_surname, " ", maternal_surname) as name'))
            ->where('is_enabled', true)
            ->whereNotIn(
                'id',
                ProjectSupervisor::join('projects', 'projects.id', '=', 'project_supervisors.project_id')
                    ->where('projects.is_enabled', true)
                    ->select('supervisor_id')
            )
            ->get();
    }


    public function assignProjectSupervisor($projectId, $supervisorId)
    {
        $projectSupervisor = $this->where('project_id', $projectId)->where('supervisor_id', $supervisorId)->first();

        if ($projectSupervisor) {
            return $projectSupervisor;
        }
        $projectSupervisor = new ProjectSupervisor();
        $projectSupervisor->project_id = $projectId;
        $projectSupervisor->supervisor_id = $supervisorId;
        $projectSupervisor->is_enabled = true;
        $projectSupervisor->save();
        return $projectSupervisor;
    }

    public function getProjectSupervisor($projectId)
    {
        $supervisor =  $this->select('supervisors.id', 'supervisors.name')
            ->join('supervisors', 'supervisors.id', '=', 'project_supervisors.supervisor_id')
            ->where('project_supervisors.project_id', $projectId)
            ->where('project_supervisors.is_enabled', true)
            ->first();
        return $supervisor;
    }
}
