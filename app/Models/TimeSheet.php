<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSheet extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id',
        'vehicle_id',
        'operator_id',
        'user_id',
        'register_at',
        'type'
    ];

    protected $casts = [
        'register_at' => 'datetime:Y-m-d H:i:s',
    ];

    //type atributos
    /*
        TYPES
        Dias trabajados           T
        Dias no trabajados        N 			
        faltas injustificadas	  I 		
        Permisos			      P 
        Mantenimiento		      M     	
        Casos de emergencia		  E     	
    */

    public function getTypeNameAttribute()
    {
        $types = [
            'T' => 'Dias trabajados',
            'N' => 'Dias no trabajados',
            'I' => 'Faltas injustificadas',
            'P' => 'Permisos',
            'M' => 'Mantenimiento',
            'E' => 'Casos de emergencia',
        ];
        
        return $this->type ? $types[$this->type] : null;
    }

    public function scopeByDate($query, $date)
    {
        return $query->whereDate('register_at', $date);
    }

    public function scopeByProject($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    public function register($data)
    {
        $data['user_id'] = auth()->user()->id;
        $this->create($data);
    }
}
