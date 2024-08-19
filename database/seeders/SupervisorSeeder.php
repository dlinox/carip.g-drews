<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupervisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        INSERT INTO `supervisors` (`id`, `name`, `paternal_surname`, `maternal_surname`, `document_type`, `document_number`, `phone`, `email`, `gender`, `birth_place`, `residence_place`, `birthdate`, `is_enabled`, `created_at`, `updated_at`)
        VALUES (3, 'DENIS LINO', 'PUMA', 'TICONA', '001', '71822317', '951208164', 'NEARLI@ADAD.COM', 'M', '200401', '110311', '2024-08-16', 1, '2024-08-10 23:37:46', '2024-08-10 23:37:46');

        */

        $supervisors = [
            [
                'id' => 1,
                'name' => 'DENIS LINO',
                'paternal_surname' => 'PUMA',
                'maternal_surname' => 'TICONA',
                'document_type' => '001',
                'document_number' => '71822317',
                'phone' => '951208164',
                'email' => 'nearlino20@gmail.com',
                'gender' => 'M',
                'birth_place' => '200401',
                'residence_place' => '110311',
                'birthdate' => '2024-08-16',
                'is_enabled' => 1,
                'created_at' => '2024-08-10 23:37:46',
                'updated_at' => '2024-08-10 23:37:46',
            ],
            [
                'id' => 2,
                'name' => 'JUAN',
                'paternal_surname' => 'PEREZ',
                'maternal_surname' => 'PEREZ',
                'document_type' => '001',
                'document_number' => '71822318',
                'phone' => '951208165',
                'email' => 'juan@gmail.com',
                'gender' => 'M',
                'birth_place' => '200401',
                'residence_place' => '110311',
                'birthdate' => '2024-08-16',
                'is_enabled' => 1,
                'created_at' => '2024-08-10 23:37:46',
                'updated_at' => '2024-08-10 23:37:46',
            ],
            [
                'id' => 3,
                'name' => 'MARIA',
                'paternal_surname' => 'PEREZ',
                'maternal_surname' => 'PEREZ',
                'document_type' => '001',
                'document_number' => '71822319',
                'phone' => '951208166',
                'email' => 'maria@gmail.com',
                'gender' => 'F',
                'birth_place' => '200401',
                'residence_place' => '110311',
                'birthdate' => '2024-08-16',
                'is_enabled' => 1,
                'created_at' => '2024-08-10 23:37:46',
                'updated_at' => '2024-08-10 23:37:46',
            ]
        ];

        foreach ($supervisors as $supervisor) {
            \App\Models\Supervisor::create($supervisor);
        }

    }
}
