<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            [
                'name' => 'Tools',
                'display_name' => 'Narzędzia',
                'description' => 'Zarządzanie narzędziami i wyposażeniem warsztatowym',
                'is_enabled' => true,
                'sort_order' => 1,
                'icon' => 'fa-tools',
                'route_prefix' => 'tools',
            ],
            [
                'name' => 'HeightEquipment',
                'display_name' => 'Sprzęt wysokościowy',
                'description' => 'Zarządzanie sprzętem do pracy na wysokości',
                'is_enabled' => true,
                'sort_order' => 2,
                'icon' => 'fa-hard-hat',
                'route_prefix' => 'height-equipment',
            ],
            [
                'name' => 'ITEquipment',
                'display_name' => 'Sprzęt IT',
                'description' => 'Zarządzanie sprzętem informatycznym',
                'is_enabled' => true,
                'sort_order' => 3,
                'icon' => 'fa-laptop',
                'route_prefix' => 'it-equipment',
            ],
            [
                'name' => 'Employees',
                'display_name' => 'Pracownicy',
                'description' => 'Zarządzanie danymi pracowników',
                'is_enabled' => true,
                'sort_order' => 4,
                'icon' => 'fa-users',
                'route_prefix' => 'employees',
            ],
        ];

        foreach ($modules as $module) {
            \App\Models\Module::updateOrCreate(
                ['name' => $module['name']], // Warunek wyszukiwania
                $module // Dane do utworzenia/aktualizacji
            );
        }
    }
}
