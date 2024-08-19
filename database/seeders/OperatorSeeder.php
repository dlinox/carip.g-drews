<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OperatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        INSERT INTO `operators` (`id`, `document_type`, `document_number`, `name`, `paternal_surname`, `maternal_surname`, `birthdate`, `birth_place`, `residence_place`, `phone`, `email`, `gender`, `license_number`, `license_category`, `license_expiration_date`, `is_enabled`, `created_at`, `updated_at`) 
            VALUES (1, '001', '74515444', 'GIAN CLAUDIO', 'MENDOZA', 'CHARAJA', '2004-12-29', '140101', '140101', '951457845', 'gian@gmail.com', 'M', '464646454', 'A-IIa', '2024-09-19', 1, '2024-08-19 01:14:53', '2024-08-19 01:14:53');
        INSERT INTO `operators` (`id`, `document_type`, `document_number`, `name`, `paternal_surname`, `maternal_surname`, `birthdate`, `birth_place`, `residence_place`, `phone`, `email`, `gender`, `license_number`, `license_category`, `license_expiration_date`, `is_enabled`, `created_at`, `updated_at`) 
            VALUES (2, '001', '45154544', 'WILSON FERRER', 'CHURATA', 'FLORES', '2001-02-01', '220101', '220101', '902154878', 'wilson@gmail.com', 'M', '646546464', 'A-IIIa', '2028-07-13', 1, '2024-08-19 01:15:56', '2024-08-19 01:15:56');

        */

        $operators = [
            [
                'id' => 1,
                'document_type' => '001',
                'document_number' => '74515444',
                'name' => 'GIAN CLAUDIO',
                'paternal_surname' => 'MENDOZA',
                'maternal_surname' => 'CHARAJA',
                'birthdate' => '2004-12-29',
                'birth_place' => '140101',
                'residence_place' => '140101',
                'phone' => '951457845',
                'email' => 'gian@gmail.com',
                'gender' => 'M',
                'license_number' => '464646454',
                'license_category' => 'A-IIa',
                'license_expiration_date' => '2024-09-19',
                'is_enabled' => 1,
                'created_at' => '2024-08-19 01:14:53',
                'updated_at' => '2024-08-19 01:14:53',
            ],
            [
                'id' => 2,
                'document_type' => '001',
                'document_number' => '45154544',
                'name' => 'WILSON FERRER',
                'paternal_surname' => 'CHURATA',
                'maternal_surname' => 'FLORES',
                'birthdate' => '2001-02-01',
                'birth_place' => '220101',
                'residence_place' => '220101',
                'phone' => '902154878',
                'email' => 'wilson@gmail.com',
                'gender' => 'M',
                'license_number' => '646546464',
                'license_category' => 'A-IIIa',
                'license_expiration_date' => '2028-07-13',
                'is_enabled' => 1,
                'created_at' => '2024-08-19 01:15:56',
                'updated_at' => '2024-08-19 01:15:56',
            ],
        ];

        foreach ($operators as $operator) {
            \App\Models\Operator::create($operator);
        }

        $this->command->info('Operators created!');
    }
}
