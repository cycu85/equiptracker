<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = [
            [
                'employee_number' => 'EMP001',
                'first_name' => 'Piotr',
                'last_name' => 'Wiśniewski',
                'email' => 'p.wisniewski@firma.pl',
                'phone' => '+48 123 456 789',
                'department' => 'Produkcja',
                'position' => 'Operator maszyn',
                'hire_date' => '2020-01-15',
                'status' => 'active',
            ],
            [
                'employee_number' => 'EMP002',
                'first_name' => 'Katarzyna',
                'last_name' => 'Dąbrowska',
                'email' => 'k.dabrowska@firma.pl',
                'phone' => '+48 123 456 790',
                'department' => 'IT',
                'position' => 'Specjalista IT',
                'hire_date' => '2019-03-20',
                'status' => 'active',
            ],
            [
                'employee_number' => 'EMP003',
                'first_name' => 'Marek',
                'last_name' => 'Lewandowski',
                'email' => 'm.lewandowski@firma.pl',
                'phone' => '+48 123 456 791',
                'department' => 'Budowa',
                'position' => 'Brygadzista',
                'hire_date' => '2018-07-10',
                'status' => 'active',
            ],
            [
                'employee_number' => 'EMP004',
                'first_name' => 'Agnieszka',
                'last_name' => 'Wójcik',
                'email' => 'a.wojcik@firma.pl',
                'phone' => '+48 123 456 792',
                'department' => 'Administracja',
                'position' => 'Sekretarka',
                'hire_date' => '2021-02-01',
                'status' => 'active',
            ],
            [
                'employee_number' => 'EMP005',
                'first_name' => 'Tomasz',
                'last_name' => 'Kamiński',
                'email' => 't.kaminski@firma.pl',
                'phone' => '+48 123 456 793',
                'department' => 'Magazyn',
                'position' => 'Magazynier',
                'hire_date' => '2019-11-15',
                'status' => 'active',
            ],
        ];

        foreach ($employees as $employeeData) {
            \App\Models\Employee::updateOrCreate(
                ['employee_number' => $employeeData['employee_number']], // Warunek wyszukiwania
                $employeeData // Dane do utworzenia/aktualizacji
            );
        }
    }
}
