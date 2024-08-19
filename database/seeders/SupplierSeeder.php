<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        INSERT INTO `suppliers` (`id`, `document_number`, `name`, `address`, `phone`, `email`, `location`, `is_enabled`, `created_at`, `updated_at`) VALUES (2, '20447774101', 'SERVICIOS MULTIPLES DREWS SOCIEDAD ANONIMA CERRADA', 'JR. MARIANO NUñEZ NRO. 230 CERCADO, PUNO - SAN ROMAN - JULIACA', NULL, NULL, '040101', 1, '2024-08-19 01:02:25', '2024-08-19 01:02:25');
        */

        $suppliers = [
            [
                'id' => 1,
                'document_number' => '20447774101',
                'name' => 'SERVICIOS MULTIPLES DREWS SOCIEDAD ANONIMA CERRADA',
                'address' => 'JR. MARIANO NUñEZ NRO. 230 CERCADO, PUNO - SAN ROMAN - JULIACA',
                'phone' => null,
                'email' => null,
                'location' => '040101',
                'is_enabled' => 1,
                'created_at' => '2024-08-19 01:02:25',
                'updated_at' => '2024-08-19 01:02:25',
            ],
        ];

        foreach ($suppliers as $supplier) {
            \App\Models\Supplier::create($supplier);
        }

        $this->command->info('Suppliers created!');
    }
}
