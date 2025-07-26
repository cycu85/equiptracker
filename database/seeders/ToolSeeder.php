<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tools = [
            [
                'name' => 'Wiertarka udarowa',
                'brand' => 'Bosch',
                'model' => 'GSB 18V-85C',
                'serial_number' => 'BSH001234',
                'category' => 'elektronarzędzia',
                'description' => 'Wiertarka udarowa akumulatorowa 18V z zestawem wierteł',
                'status' => 'available',
                'purchase_date' => '2023-01-15',
                'purchase_price' => 450.00,
                'next_inspection_date' => '2025-01-15',
                'inspection_interval_months' => 12,
                'location' => 'Magazyn A',
            ],
            [
                'name' => 'Szlifierka kątowa',
                'brand' => 'Makita',
                'model' => 'GA9020R',
                'serial_number' => 'MAK002456',
                'category' => 'elektronarzędzia',
                'description' => 'Szlifierka kątowa 230mm, 2200W',
                'status' => 'available',
                'purchase_date' => '2023-03-20',
                'purchase_price' => 280.00,
                'next_inspection_date' => '2025-03-20',
                'inspection_interval_months' => 12,
                'location' => 'Warsztat',
            ],
            [
                'name' => 'Młotek pneumatyczny',
                'brand' => 'Hilti',
                'model' => 'TE 70-ATC',
                'serial_number' => 'HLT003789',
                'category' => 'elektronarzędzia',
                'description' => 'Młotek pneumatyczny SDS-MAX 1750W',
                'status' => 'in_use',
                'purchase_date' => '2022-08-10',
                'purchase_price' => 1250.00,
                'next_inspection_date' => '2024-08-10',
                'inspection_interval_months' => 12,
                'location' => 'Budowa 1',
            ],
            [
                'name' => 'Klucz udarowy',
                'brand' => 'DeWalt',
                'model' => 'DCF899P2',
                'serial_number' => 'DWT004567',
                'category' => 'elektronarzędzia',
                'description' => 'Klucz udarowy akumulatorowy 20V MAX',
                'status' => 'available',
                'purchase_date' => '2023-05-12',
                'purchase_price' => 680.00,
                'next_inspection_date' => '2025-05-12',
                'inspection_interval_months' => 12,
                'location' => 'Magazyn B',
            ],
            [
                'name' => 'Młotek stalowy',
                'brand' => 'Stanley',
                'model' => 'STHT0-51309',
                'serial_number' => null,
                'category' => 'narzędzia ręczne',
                'description' => 'Młotek stalowy 500g z rękojeścią z tworzywa',
                'status' => 'available',
                'purchase_date' => '2023-02-28',
                'purchase_price' => 35.00,
                'next_inspection_date' => null,
                'inspection_interval_months' => null,
                'location' => 'Warsztat',
            ],
            [
                'name' => 'Zestaw kluczy płaskich',
                'brand' => 'Gedore',
                'model' => '6-19mm',
                'serial_number' => 'GED005123',
                'category' => 'narzędzia ręczne',
                'description' => 'Zestaw 8 kluczy płaskich 6-19mm w kasetce',
                'status' => 'available',
                'purchase_date' => '2023-01-05',
                'purchase_price' => 120.00,
                'next_inspection_date' => null,
                'inspection_interval_months' => null,
                'location' => 'Magazyn A',
            ],
            [
                'name' => 'Piła tarczowa',
                'brand' => 'Festool',
                'model' => 'TS 55 REBQ',
                'serial_number' => 'FST006789',
                'category' => 'elektronarzędzia',
                'description' => 'Piła tarczowa zanurna 160mm z szyną prowadzącą',
                'status' => 'maintenance',
                'purchase_date' => '2022-11-15',
                'purchase_price' => 890.00,
                'next_inspection_date' => '2024-11-15',
                'inspection_interval_months' => 12,
                'location' => 'Serwis',
                'notes' => 'Wymiana łożysk w silniku',
            ],
            [
                'name' => 'Mikrometr',
                'brand' => 'Mitutoyo',
                'model' => '103-137',
                'serial_number' => 'MIT007456',
                'category' => 'narzędzia pomiarowe',
                'description' => 'Mikrometr zewnętrzny 0-25mm, dokładność 0.01mm',
                'status' => 'available',
                'purchase_date' => '2023-04-08',
                'purchase_price' => 280.00,
                'next_inspection_date' => '2025-04-08',
                'inspection_interval_months' => 24,
                'location' => 'Laboratorium',
            ],
        ];

        foreach ($tools as $toolData) {
            \App\Models\Tool::create($toolData);
        }
    }
}
