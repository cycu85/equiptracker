<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeightEquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $heightEquipment = [
            [
                'name' => 'Drabina aluminiowa 3-elementowa',
                'brand' => 'Krause',
                'model' => 'Stabilo',
                'serial_number' => 'KR001234',
                'type' => 'ladder',
                'description' => 'Profesjonalna drabina 3-elementowa z aluminium',
                'status' => 'available',
                'purchase_date' => '2023-01-15',
                'purchase_price' => 899.99,
                'last_inspection_date' => '2024-01-15',
                'next_inspection_date' => '2025-01-15',
                'inspection_interval_months' => 12,
                'certification_number' => 'CERT2023001',
                'certification_expiry' => '2025-12-31',
                'max_load_kg' => 150.00,
                'working_height_m' => 7.50,
                'location' => 'Magazyn A',
                'notes' => 'Stan bardzo dobry, regularne przeglądy'
            ],
            [
                'name' => 'Rusztowanie ruchome Krause',
                'brand' => 'Krause',
                'model' => 'ClimTec',
                'serial_number' => 'KR005678',
                'type' => 'scaffold',
                'description' => 'Rusztowanie ruchome z platformą roboczą',
                'status' => 'in_use',
                'purchase_date' => '2022-06-10',
                'purchase_price' => 2450.00,
                'last_inspection_date' => '2024-06-10',
                'next_inspection_date' => '2025-06-10',
                'inspection_interval_months' => 12,
                'certification_number' => 'CERT2022015',
                'certification_expiry' => '2025-06-30',
                'max_load_kg' => 200.00,
                'working_height_m' => 4.00,
                'location' => 'Budowa 1',
                'notes' => 'Obecnie używane na budowie hali produkcyjnej'
            ],
            [
                'name' => 'Platforma robocza Genie',
                'brand' => 'Genie',
                'model' => 'GS-1932',
                'serial_number' => 'GN789123',
                'type' => 'platform',
                'description' => 'Samojezdna platforma robocza nożycowa',
                'status' => 'available',
                'purchase_date' => '2021-09-20',
                'purchase_price' => 45000.00,
                'last_inspection_date' => '2024-09-20',
                'next_inspection_date' => '2025-03-20',
                'inspection_interval_months' => 6,
                'certification_number' => 'CERT2021089',
                'certification_expiry' => '2025-09-30',
                'max_load_kg' => 230.00,
                'working_height_m' => 7.79,
                'location' => 'Plac maszyn',
                'notes' => 'Wymaga przeglądu hydrauliki co 6 miesięcy'
            ],
            [
                'name' => 'Drabina teleskopowa Xtend+Climb',
                'brand' => 'Xtend+Climb',
                'model' => 'Pro Series',
                'serial_number' => 'XC456789',
                'type' => 'ladder',
                'description' => 'Teleskopowa drabina aluminiowa z blokadą',
                'status' => 'maintenance',
                'purchase_date' => '2023-11-05',
                'purchase_price' => 1250.00,
                'last_inspection_date' => '2024-11-05',
                'next_inspection_date' => '2025-11-05',
                'inspection_interval_months' => 12,
                'certification_number' => 'CERT2023156',
                'certification_expiry' => '2025-11-30',
                'max_load_kg' => 125.00,
                'working_height_m' => 5.20,
                'location' => 'Serwis',
                'notes' => 'W naprawie - wymiana mechanizmu teleskopowego'
            ],
            [
                'name' => 'Podnośnik koszowy JLG',
                'brand' => 'JLG',
                'model' => '600S',
                'serial_number' => 'JLG123456',
                'type' => 'lift',
                'description' => 'Samojezdny podnośnik koszowy z napędem elektrycznym',
                'status' => 'available',
                'purchase_date' => '2020-03-12',
                'purchase_price' => 78000.00,
                'last_inspection_date' => '2024-03-12',
                'next_inspection_date' => '2024-09-12',
                'inspection_interval_months' => 6,
                'certification_number' => 'CERT2020078',
                'certification_expiry' => '2025-03-31',
                'max_load_kg' => 227.00,
                'working_height_m' => 15.24,
                'location' => 'Magazyn B',
                'notes' => 'Wysokiej klasy sprzęt do prac na dużych wysokościach'
            ]
        ];

        foreach ($heightEquipment as $equipmentData) {
            \App\Models\HeightEquipment::updateOrCreate(
                ['serial_number' => $equipmentData['serial_number']],
                $equipmentData
            );
        }
    }
}
