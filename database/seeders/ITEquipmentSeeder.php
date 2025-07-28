<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ITEquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $itEquipment = [
            [
                'name' => 'Laptop Dell Latitude 5520',
                'brand' => 'Dell',
                'model' => 'Latitude 5520',
                'serial_number' => 'DL123456789',
                'asset_tag' => 'IT-LAP-001',
                'type' => 'laptop',
                'description' => 'Laptop biznesowy z procesorem Intel i7',
                'status' => 'active',
                'purchase_date' => '2023-02-15',
                'purchase_price' => 4500.00,
                'warranty_expiry' => '2026-02-15',
                'operating_system' => 'Windows 11 Pro',
                'specifications' => 'Intel i7-1165G7, 16GB RAM, 512GB SSD, Intel Iris Xe',
                'mac_address' => '00:1B:63:84:45:E6',
                'ip_address' => '192.168.1.101',
                'location' => 'Biuro IT',
                'notes' => 'Przypisany do działu IT'
            ],
            [
                'name' => 'Komputer Dell OptiPlex 7090',
                'brand' => 'Dell',
                'model' => 'OptiPlex 7090',
                'serial_number' => 'DL987654321',
                'asset_tag' => 'IT-PC-001',
                'type' => 'desktop',
                'description' => 'Komputer stacjonarny dla biura',
                'status' => 'active',
                'purchase_date' => '2023-01-20',
                'purchase_price' => 3200.00,
                'warranty_expiry' => '2026-01-20',
                'operating_system' => 'Windows 11 Pro',
                'specifications' => 'Intel i5-11500, 16GB RAM, 256GB SSD + 1TB HDD',
                'mac_address' => '00:1B:63:84:45:E7',
                'ip_address' => '192.168.1.102',
                'location' => 'Biuro księgowości',
                'notes' => 'Komputer główny księgowej'
            ],
            [
                'name' => 'Monitor Dell UltraSharp U2719D',
                'brand' => 'Dell',
                'model' => 'UltraSharp U2719D',
                'serial_number' => 'DM456789123',
                'asset_tag' => 'IT-MON-001',
                'type' => 'monitor',
                'description' => 'Monitor 27" QHD dla grafików',
                'status' => 'active',
                'purchase_date' => '2022-11-10',
                'purchase_price' => 1200.00,
                'warranty_expiry' => '2025-11-10',
                'operating_system' => null,
                'specifications' => '27", 2560x1440, IPS, 99% sRGB',
                'mac_address' => null,
                'ip_address' => null,
                'location' => 'Dział marketingu',
                'notes' => 'Używany do prac graficznych'
            ],
            [
                'name' => 'Drukarka HP LaserJet Pro M404dn',
                'brand' => 'HP',
                'model' => 'LaserJet Pro M404dn',
                'serial_number' => 'HP789123456',
                'asset_tag' => 'IT-PRT-001',
                'type' => 'printer',
                'description' => 'Drukarka laserowa sieciowa',
                'status' => 'active',
                'purchase_date' => '2023-03-05',
                'purchase_price' => 800.00,
                'warranty_expiry' => '2024-03-05',
                'operating_system' => null,
                'specifications' => 'Laser, A4, 38 str/min, duplex, sieć',
                'mac_address' => '00:68:EA:12:34:56',
                'ip_address' => '192.168.1.201',
                'location' => 'Biuro główne',
                'notes' => 'Drukarka sieciowa dla całego biura'
            ],
            [
                'name' => 'Serwer Dell PowerEdge T340',
                'brand' => 'Dell',
                'model' => 'PowerEdge T340',
                'serial_number' => 'DS345678901',
                'asset_tag' => 'IT-SRV-001',
                'type' => 'server',
                'description' => 'Serwer plikowy i aplikacyjny',
                'status' => 'active',
                'purchase_date' => '2022-05-15',
                'purchase_price' => 12000.00,
                'warranty_expiry' => '2025-05-15',
                'operating_system' => 'Windows Server 2022',
                'specifications' => 'Xeon E-2234, 32GB ECC RAM, 2x 1TB SSD RAID1',
                'mac_address' => '00:1B:63:84:45:E8',
                'ip_address' => '192.168.1.10',
                'location' => 'Serwerownia',
                'notes' => 'Główny serwer aplikacyjny firmy'
            ],
            [
                'name' => 'Tablet iPad Pro 12.9"',
                'brand' => 'Apple',
                'model' => 'iPad Pro 12.9" (5th gen)',
                'serial_number' => 'AP567890123',
                'asset_tag' => 'IT-TAB-001',
                'type' => 'tablet',
                'description' => 'Tablet do prezentacji mobilnych',
                'status' => 'active',
                'purchase_date' => '2023-04-20',
                'purchase_price' => 5500.00,
                'warranty_expiry' => '2024-04-20',
                'operating_system' => 'iPadOS 17',
                'specifications' => 'M1 chip, 256GB, WiFi + Cellular, Apple Pencil',
                'mac_address' => '00:3E:E1:12:34:56',
                'ip_address' => null,
                'location' => 'Dział sprzedaży',
                'notes' => 'Używany do prezentacji u klientów'
            ],
            [
                'name' => 'Router Cisco ISR 4331',
                'brand' => 'Cisco',
                'model' => 'ISR 4331',
                'serial_number' => 'CS890123456',
                'asset_tag' => 'IT-NET-001',
                'type' => 'other',
                'description' => 'Router główny sieci firmowej',
                'status' => 'active',
                'purchase_date' => '2021-08-12',
                'purchase_price' => 8500.00,
                'warranty_expiry' => '2024-08-12',
                'operating_system' => 'Cisco IOS XE',
                'specifications' => '4-port Gigabit, VPN, QoS, redundant PSU',
                'mac_address' => '00:1E:F7:12:34:56',
                'ip_address' => '192.168.1.1',
                'location' => 'Serwerownia',
                'notes' => 'Główny router łączący z internetem'
            ],
            [
                'name' => 'Laptop MacBook Pro 16"',
                'brand' => 'Apple',
                'model' => 'MacBook Pro 16"',
                'serial_number' => 'AP123987654',
                'asset_tag' => 'IT-LAP-002',
                'type' => 'laptop',
                'description' => 'Laptop dla projektantów graficznych',
                'status' => 'maintenance',
                'purchase_date' => '2022-09-30',
                'purchase_price' => 12000.00,
                'warranty_expiry' => '2025-09-30',
                'operating_system' => 'macOS Sonoma',
                'specifications' => 'M2 Pro, 32GB RAM, 1TB SSD, ProRes',
                'mac_address' => '00:3E:E1:78:90:12',
                'ip_address' => null,
                'location' => 'Serwis Apple',
                'notes' => 'W naprawie - wymiana klawiatury'
            ]
        ];

        foreach ($itEquipment as $equipmentData) {
            \App\Models\ITEquipment::updateOrCreate(
                ['serial_number' => $equipmentData['serial_number']],
                $equipmentData
            );
        }
    }
}
