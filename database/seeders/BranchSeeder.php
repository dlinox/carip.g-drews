<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            [
                'name' => 'Sede Principal',
                'address' => 'Calle Mariano Melgar # 107, Cerro Colorado, Arequipa',
                'geo_code' => '040101',
                'country' => 'PER',
                'is_enabled' => true,
                'is_protected' => true,
            ],
            [
                'name' => 'Sede Juliaca',
                'address' => 'Jr. Mariano Nuñez # 231, Juliaca , Puno',
                'geo_code' => '200901',
                'country' => 'PER',
                'is_enabled' => true,
                'is_protected' => true,
            ],
            [
                'name' => 'Sede Cusco',
                'address' => '',
                'geo_code' => '070101',
                'country' => 'PER',
                'is_enabled' => true,
                'is_protected' => false,
            ],
            //tacna
            [
                'name' => 'Sede Tacna',
                'address' => '',
                'geo_code' => '220101',
                'country' => 'PER',
                'is_enabled' => true,
                'is_protected' => false,
            ],

            //moquegua
            [
                'name' => 'Sede Moquegua',
                'address' => '',
                'geo_code' => '170101',
                'country' => 'PER',
                'is_enabled' => true,
                'is_protected' => false,
            ],
            //ica
            [
                'name' => 'Sede Ica',
                'address' => '',
                'geo_code' => '100101',
                'country' => 'PER',
                'is_enabled' => true,
                'is_protected' => false,
            ],
            //eventual
            [
                'name' => 'Sede Eventual',
                'address' => '',
                'geo_code' => '000000',
                'country' => 'PER',
                'is_enabled' => true,
                'is_protected' => false,
            ],
        ];

        foreach ($branches as $branch) {
            \App\Models\Branch::create($branch);
        }
    }
}
