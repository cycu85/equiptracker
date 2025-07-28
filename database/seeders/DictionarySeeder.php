<?php

namespace Database\Seeders;

use App\Models\Dictionary;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DictionarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dictionaries = [
            // Tool categories
            [
                'category' => 'tool_categories',
                'key' => 'narzędzia ręczne',
                'value' => 'Narzędzia ręczne',
                'description' => 'Młotki, śrubokręty, klucze itp.',
                'sort_order' => 1,
                'is_system' => true,
            ],
            [
                'category' => 'tool_categories', 
                'key' => 'elektronarzędzia',
                'value' => 'Elektronarzędzia',
                'description' => 'Wiertarki, szlifierki, piły elektryczne',
                'sort_order' => 2,
                'is_system' => true,
            ],
            [
                'category' => 'tool_categories',
                'key' => 'maszyny',
                'value' => 'Maszyny',
                'description' => 'Tokarki, frezarki, prasy',
                'sort_order' => 3,
                'is_system' => true,
            ],
            [
                'category' => 'tool_categories',
                'key' => 'narzędzia pomiarowe',
                'value' => 'Narzędzia pomiarowe',
                'description' => 'Suwmiarki, mikrometry, poziomice',
                'sort_order' => 4,
                'is_system' => true,
            ],

            // Tool statuses
            [
                'category' => 'tool_statuses',
                'key' => 'available',
                'value' => 'Dostępne',
                'description' => 'Narzędzie gotowe do użycia',
                'sort_order' => 1,
                'is_system' => true,
            ],
            [
                'category' => 'tool_statuses',
                'key' => 'in_use',
                'value' => 'W użyciu',
                'description' => 'Narzędzie wydane pracownikowi',
                'sort_order' => 2,
                'is_system' => true,
            ],
            [
                'category' => 'tool_statuses',
                'key' => 'maintenance',
                'value' => 'Konserwacja',
                'description' => 'Narzędzie w serwisie',
                'sort_order' => 3,
                'is_system' => true,
            ],
            [
                'category' => 'tool_statuses',
                'key' => 'damaged',
                'value' => 'Uszkodzone',
                'description' => 'Narzędzie niesprawne',
                'sort_order' => 4,
                'is_system' => true,
            ],
            [
                'category' => 'tool_statuses',
                'key' => 'retired',
                'value' => 'Wycofane',
                'description' => 'Narzędzie wycofane z użytku',
                'sort_order' => 5,
                'is_system' => true,
            ],

            // Height equipment types
            [
                'category' => 'height_equipment_types',
                'key' => 'ladder',
                'value' => 'Drabina',
                'description' => 'Drabiny różnych typów',
                'sort_order' => 1,
                'is_system' => true,
            ],
            [
                'category' => 'height_equipment_types',
                'key' => 'scaffold',
                'value' => 'Rusztowanie',
                'description' => 'Rusztowania budowlane',
                'sort_order' => 2,
                'is_system' => true,
            ],
            [
                'category' => 'height_equipment_types',
                'key' => 'platform',
                'value' => 'Platforma',
                'description' => 'Platformy robocze',
                'sort_order' => 3,
                'is_system' => true,
            ],
            [
                'category' => 'height_equipment_types',
                'key' => 'harness',
                'value' => 'Uprząż',
                'description' => 'Uprzęże i pasy bezpieczeństwa',
                'sort_order' => 4,
                'is_system' => true,
            ],

            // Height equipment statuses (same as tools)
            [
                'category' => 'height_equipment_statuses',
                'key' => 'available',
                'value' => 'Dostępne',
                'description' => 'Sprzęt gotowy do użycia',
                'sort_order' => 1,
                'is_system' => true,
            ],
            [
                'category' => 'height_equipment_statuses',
                'key' => 'in_use',
                'value' => 'W użyciu',
                'description' => 'Sprzęt wydany pracownikowi',
                'sort_order' => 2,
                'is_system' => true,
            ],
            [
                'category' => 'height_equipment_statuses',
                'key' => 'maintenance',
                'value' => 'Konserwacja',
                'description' => 'Sprzęt w serwisie',
                'sort_order' => 3,
                'is_system' => true,
            ],
            [
                'category' => 'height_equipment_statuses',
                'key' => 'damaged',
                'value' => 'Uszkodzone',
                'description' => 'Sprzęt niesprawny',
                'sort_order' => 4,
                'is_system' => true,
            ],
            [
                'category' => 'height_equipment_statuses',
                'key' => 'retired',
                'value' => 'Wycofane',
                'description' => 'Sprzęt wycofany z użytku',
                'sort_order' => 5,
                'is_system' => true,
            ],

            // Set statuses
            [
                'category' => 'toolset_statuses',
                'key' => 'active',
                'value' => 'Aktywny',
                'description' => 'Zestaw gotowy do użycia',
                'sort_order' => 1,
                'is_system' => true,
            ],
            [
                'category' => 'toolset_statuses',
                'key' => 'inactive',
                'value' => 'Nieaktywny',
                'description' => 'Zestaw tymczasowo niedostępny',
                'sort_order' => 2,
                'is_system' => true,
            ],
            [
                'category' => 'toolset_statuses',
                'key' => 'maintenance',
                'value' => 'Konserwacja',
                'description' => 'Zestaw w trakcie przeglądu',
                'sort_order' => 3,
                'is_system' => true,
            ],

            // Height equipment set statuses (same as toolset)
            [
                'category' => 'height_equipment_set_statuses',
                'key' => 'active',
                'value' => 'Aktywny',
                'description' => 'Zestaw gotowy do użycia',
                'sort_order' => 1,
                'is_system' => true,
            ],
            [
                'category' => 'height_equipment_set_statuses',
                'key' => 'inactive', 
                'value' => 'Nieaktywny',
                'description' => 'Zestaw tymczasowo niedostępny',
                'sort_order' => 2,
                'is_system' => true,
            ],
            [
                'category' => 'height_equipment_set_statuses',
                'key' => 'maintenance',
                'value' => 'Konserwacja',
                'description' => 'Zestaw w trakcie przeglądu',
                'sort_order' => 3,
                'is_system' => true,
            ],
        ];

        foreach ($dictionaries as $dictionary) {
            Dictionary::updateOrCreate(
                ['category' => $dictionary['category'], 'key' => $dictionary['key']],
                $dictionary
            );
        }
    }
}