<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'code',
        'department',
        'province',
        'district',
    ];

    public function search($search)
    {
        return $this->selectRaw('code, CONCAT_WS(", ", department, province, district) as location')
            ->whereRaw('CONCAT_WS(", ", department, province, district) like ?', "%$search%")
            ->limit(10)
            ->get();
    }
}
