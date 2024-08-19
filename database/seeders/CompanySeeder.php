<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        INSERT INTO `companies` (`id`, `document_number`, `name`, `address`, `phone`, `email`, `location`, `is_enabled`, `created_at`, `updated_at`) VALUES (1, '20447774101', 'SERVICIOS MULTIPLES DREWS SOCIEDAD ANONIMA CERRADA', 'JR. MARIANO NUñEZ NRO. 230 CERCADO, PUNO - SAN ROMAN - JULIACA', '989124060', NULL, '040101', 1, '2024-08-10 23:20:03', '2024-08-10 23:20:03');

        */

        $companies = [
            [
                'id' => 1,
                'document_number' => '20447774101',
                'name' => 'SERVICIOS MULTIPLES DREWS SOCIEDAD ANONIMA CERRADA',
                'address' => 'JR. MARIANO NUñEZ NRO. 230 CERCADO, PUNO - SAN ROMAN - JULIACA',
                'phone' => '989124060',
                'email' => null,
                'location' => '040101',
                'is_enabled' => 1,
                'created_at' => '2024-08-10 23:20:03',
                'updated_at' => '2024-08-10 23:20:03',
            ],
        ];

        foreach ($companies as $company) {
            \App\Models\Company::create($company);
        }

        $this->command->info('Companies created!');

        // INSERT INTO `areas` (`id`, `name`, `is_enabled`, `company_id`, `created_at`, `updated_at`) VALUES (1, 'Administración', 1, 1, '2024-08-19 01:41:59', '2024-08-19 01:41:59');

        $areas = [
            [
                'id' => 1,
                'name' => 'Administración',
                'is_enabled' => 1,
                'company_id' => 1,
                'created_at' => '2024-08-19 01:41:59',
                'updated_at' => '2024-08-19 01:41:59',
            ],
        ];

        foreach ($areas as $area) {
            \App\Models\Area::create($area);
        }

        $this->command->info('Areas created!');

        /*
        INSERT INTO `workers` (`id`, `name`, `paternal_surname`, `maternal_surname`, `document_type`, `document_number`, `phone`, `email`, `gender`, `birth_place`, `residence_place`, `birthdate`, `is_enabled`, `company_id`, `area_id`, `created_at`, `updated_at`) VALUES (1, 'CAMILO ALFREDO', 'HUANCA', 'QUISPE', '001', '70412121', '951457845', 'camilo@gmail.com', 'M', '040101', '040101', '2012-05-31', 1, 1, 1, '2024-08-19 01:43:09', '2024-08-19 01:43:09');
        INSERT INTO `workers` (`id`, `name`, `paternal_surname`, `maternal_surname`, `document_type`, `document_number`, `phone`, `email`, `gender`, `birth_place`, `residence_place`, `birthdate`, `is_enabled`, `company_id`, `area_id`, `created_at`, `updated_at`) VALUES (2, 'CELINA', 'CIEZA', 'TIRADO', '001', '40784515', '951208106', 'celina@gmail.com', 'F', '020107', '050101', '1944-08-17', 1, 1, 1, '2024-08-19 01:44:02', '2024-08-19 01:44:02');
        */

        $workers = [
            [
                'id' => 1,
                'name' => 'CAMILO ALFREDO',
                'paternal_surname' => 'HUANCA',
                'maternal_surname' => 'QUISPE',
                'document_type' => '001',
                'document_number' => '70412121',
                'phone' => '951457845',
                'email' => 'camilo@gmail.com',
                'gender' => 'M',
                'birth_place' => '040101',
                'residence_place' => '040101',
                'birthdate' => '2012-05-31',
                'is_enabled' => 1,
                'company_id' => 1,
                'area_id' => 1,
                'created_at' => '2024-08-19 01:43:09',
                'updated_at' => '2024-08-19 01:43:09',
            ],

            [
                'id' => 2,
                'name' => 'CELINA',
                'paternal_surname' => 'CIEZA',
                'maternal_surname' => 'TIRADO',
                'document_type' => '001',
                'document_number' => '40784515',
                'phone' => '951208106',
                'email' => 'celina@gmail.com',
                'gender' => 'F',
                'birth_place' => '020107',
                'residence_place' => '050101',
                'birthdate' => '1944-08-17',
                'is_enabled' => 1,
                'company_id' => 1,
                'area_id' => 1,
                'created_at' => '2024-08-19 01:44:02',
                'updated_at' => '2024-08-19 01:44:02',
            ],
        ];

        foreach ($workers as $worker) {
            \App\Models\Worker::create($worker);
        }

        $this->command->info('Workers created!');

    }
}
