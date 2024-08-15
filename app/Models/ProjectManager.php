<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProjectManager extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'worker_id',
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

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }


    public function getCompanyManagers($companyId)
    {
        return Worker::select('id', DB::raw('CONCAT(name, " ", paternal_surname, " ", maternal_surname) as name'))
            ->where('company_id', $companyId)
            ->where('is_enabled', true)
            ->whereNotIn(
                'id',
                ProjectManager::join('projects', 'projects.id', '=', 'project_managers.project_id')
                    ->where('projects.is_enabled', true)
                    ->select('worker_id')
            )
            ->get();
    }
    //getProjectManagers
    public function getManagers($projectId)
    {
        return Worker::select('workers.id', 'workers.area_id', DB::raw('CONCAT(workers.name, " ", workers.paternal_surname, " ", workers.maternal_surname) as name'))
            ->join('project_managers', 'project_managers.worker_id', '=', 'workers.id')
            ->where('project_managers.project_id', $projectId)
            ->where('project_managers.is_enabled', true)
            ->get();
    }

    public function assignManager($projectId, $workerId)
    {
        $projectManager = $this->where('project_id', $projectId)->where('worker_id', $workerId)->first();

        if ($projectManager) {
            return $projectManager;
        }
        $projectManager = new ProjectManager();
        $projectManager->project_id = $projectId;
        $projectManager->worker_id = $workerId;
        $projectManager->is_enabled = true;
        $projectManager->save();
        return $projectManager;
    }
}
