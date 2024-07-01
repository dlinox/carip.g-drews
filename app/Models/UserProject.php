<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'is_enabled',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    public function assignProjectToUser($project, $user)
    {
        $this->user_id = $user->id;
        $this->project_id = $project->id;
        $this->save();
    }

    public function disableProjectToUser($project, $user)
    {
        $this->where('user_id', $user->id)
            ->where('project_id', $project->id)
            ->update(['is_enabled' => false]);
    }

    public function enableProjectToUser($project, $user)
    {
        $this->where('user_id', $user->id)
            ->where('project_id', $project->id)
            ->update(['is_enabled' => true]);
    }

    public function getProjectsByUser($user)
    {
        return $this->where('user_id', $user->id)
            ->where('is_enabled', true)
            ->pluck('project_id')
            ->toArray();
    }
}
