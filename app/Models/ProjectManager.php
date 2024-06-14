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


    public function assignProjectManager($projectId, $workerId)
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

    public function getProjectManager($projectId)
    {
        return $this->select('workers.name as worker_name', 'areas.name as area_name', 'companies.name as company_name')
            ->join('workers', 'workers.id', '=', 'project_managers.worker_id')
            ->join('areas', 'areas.id', '=', 'project_managers.project_id')
            ->join('companies', 'companies.id', '=', 'project_managers.project_id')
            ->where('project_managers.project_id', $projectId)
            ->where('project_managers.is_enabled', true)
            ->first();
    }
}
