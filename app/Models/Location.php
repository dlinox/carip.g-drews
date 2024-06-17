<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    /*
     Schema::create('locations', function (Blueprint $table) {
            $table->char('code', 6)->unique()->primary();
            $table->string('deparment', 120);
            $table->string('province', 120);
            $table->string('district', 120);
            $table->index(['code', 'deparment', 'province', 'district']);
            $table->timestamps();
        });
    }
    */

    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'code',
        'deparment',
        'province',
        'district',
    ];

    public function search($search)
    {
        return $this->selectRaw('code, CONCAT_WS(", ", deparment, province, district) as location')
            ->whereRaw('CONCAT_WS(", ", deparment, province, district) like ?', "%$search%")
            ->limit(10)
            ->get();
    }
}
