<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBranch extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'branch_id',
        'is_enabled',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    public function assignBranchToUser($branch, $user)
    {
        $this->user_id = $user;
        $this->branch_id = $branch;
        $this->save();
    }

    public function disableBranchToUser($branch, $user)
    {
        $this->where('user_id', $user)
            ->where('branch_id', $branch)
            ->update(['is_enabled' => false]);
    }

    public function enableBranchToUser($branch, $user)
    {
        $this->where('user_id', $user)
            ->where('branch_id', $branch)
            ->update(['is_enabled' => true]);
    }

    public function getBranchesByUser($user)
    {
        return $this->where('user_id', $user->id)
            ->where('is_enabled', true)
            ->pluck('branch_id')
            ->toArray();
    }
}
