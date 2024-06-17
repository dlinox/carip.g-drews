<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocatioinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //en la ruta tengo database\data\locations.sql tengo los insert para el Location
        $path = base_path('database/data/locations.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);
        
    }
}
