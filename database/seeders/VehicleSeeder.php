<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        INSERT INTO `vehicles` (`id`, `name`, `plate`, `brand`, `model`, `color`, `category`, `state`, `soat`, `soat_expiration_date`, `type`, `fuel_type`, `capacity`, `mileage`, `is_enabled`, `supplier_id`, `created_at`, `updated_at`) 
        VALUES
             (1, 'Chevrolet - 54 - 654-SFS', '654-SFS', 'Chevrolet', '54', '', 'Automóvil', 'Nuevo', '1515', '2024-08-14', 'Mecanico', 'Gasolina', '4', '646464', 1, 1, '2024-08-10 23:39:50', '2024-08-10 23:39:50');
        INSERT INTO `vehicles` (`id`, `name`, `plate`, `brand`, `model`, `color`, `category`, `state`, `soat`, `soat_expiration_date`, `type`, `fuel_type`, `capacity`, `mileage`, `is_enabled`, `supplier_id`, `created_at`, `updated_at`) 
        VALUES
             (2, 'Toyota - Hilux - A2F-154', 'A2F-154', 'Toyota', 'Hilux', '', 'Camioneta', 'Nuevo', '1515', '2024-08-07', 'Mecanico', 'Gasolina', '5', '0', 1, 2, '2024-08-19 01:05:36', '2024-08-19 01:05:36');

        */

        $vehicles = [
            [
                'id' => 1,
                'plate' => '654-SFS',
                'brand' => 'Chevrolet',
                'model' => '54',
                'name' => 'Chevrolet - 54 - 654-SFS',
                'color' => '',
                'category' => 'Automóvil',
                'state' => 'Nuevo',
                'soat' => '1515',
                'soat_expiration_date' => '2024-08-14',
                'type' => 'Mecanico',
                'fuel_type' => 'Gasolina',
                'capacity' => '4',
                'mileage' => '646464',
                'is_enabled' => 1,
                'supplier_id' => 1,
                'created_at' => '2024-08-10 23:39:50',
                'updated_at' => '2024-08-10 23:39:50',
            ],

            [
                'id' => 2,
                'plate' => 'A2F-154',
                'brand' => 'Toyota',
                'model' => 'Hilux',
                'name' => 'Toyota - Hilux - A2F-154',
                'color' => '',
                'category' => 'Camioneta',
                'state' => 'Nuevo',
                'soat' => '1515',
                'soat_expiration_date' => '2024-08-07',
                'type' => 'Mecanico',
                'fuel_type' => 'Gasolina',
                'capacity' => '5',
                'mileage' => '0',
                'is_enabled' => 1,
                'supplier_id' => 1,
                'created_at' => '2024-08-19 01:05:36',
                'updated_at' => '2024-08-19 01:05:36',
            ],            
        ];

        foreach ($vehicles as $vehicle) {
            \App\Models\Vehicle::create($vehicle);
        }

        $this->command->info('Vehicles created!');

    }
}
