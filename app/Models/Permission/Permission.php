<?php

namespace App\Models\Permission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'group_name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public static function getGroupedData()
    {
        $data =  Permission::select('id', 'name', 'group_name')
        ->get();
        $groupedData = [];
        foreach ($data as $item) {
            $groupName = $item['group_name'];

            if (!isset($groupedData[$groupName])) {
                $groupedData[$groupName] = [];
            }
            $groupedData[$groupName][] = $item;
        }
        return $groupedData;
    }
}
