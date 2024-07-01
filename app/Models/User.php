<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasPermissions;
    protected $fillable = [
        'profile_type',
        'profile_id',
        'email',
        'password',
        'is_enabled',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public  static $profileTypes = [
        [
            'id' => '001',
            'name' => 'Administrador'
        ],
        [
            'id' => '002',
            'name' => 'Supervisor'
        ],
        [
            'id' => '003',
            'name' => 'Operador'
        ]
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_enabled' => 'boolean',
        ];
    }

    protected $appends = [
        "branches",
    ];


    //userBranches
    public function branches(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $branches = UserBranch::where('user_id', $this->id)
                    ->where('is_enabled', true)
                    ->pluck('branch_id')
                    ->toArray();

                return $branches;
            },
        );
    }


    public static function headers(): array
    {
        return [
            ['title' => "Correo", 'key' => 'email', 'align' => 'center'],
            ['title' => "Estado", 'key' => 'is_enabled', 'align' => 'center'],
            ['title' => "Acciones", 'key' => 'actions', 'align' => 'end', 'sortable' => false]
        ];
    }



    public function getProfilesByType($type)
    {
        switch ($type) {
            case '001':
                return Administrator::select('id', DB::raw('CONCAT(name, " ", paternal_surname, " ", maternal_surname) as name'))
                    ->where('is_enabled', true)
                    ->get();

            case '002':
                return Supervisor::select('id', DB::raw('CONCAT(name, " ", paternal_surname, " ", maternal_surname) as name'))
                    ->where('is_enabled', true)
                    ->get();

            case '003':
                return Operator::select('id', 'name')
                    ->where('is_enabled', true)
                    ->get();

            default:
                return 'No definido';
        }
    }
}
