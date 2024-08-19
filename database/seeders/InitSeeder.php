<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $this->call(BranchSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(OperatorSeeder::class);
        $this->call(SupervisorSeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(VehicleSeeder::class);

    }
}
