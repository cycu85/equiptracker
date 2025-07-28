<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Tools module
            [
                'name' => 'tools.view',
                'display_name' => 'Przeglądanie narzędzi',
                'description' => 'Możliwość przeglądania listy narzędzi',
                'module' => 'tools',
                'action' => 'view'
            ],
            [
                'name' => 'tools.create',
                'display_name' => 'Dodawanie narzędzi',
                'description' => 'Możliwość dodawania nowych narzędzi',
                'module' => 'tools',
                'action' => 'create'
            ],
            [
                'name' => 'tools.edit',
                'display_name' => 'Edycja narzędzi',
                'description' => 'Możliwość edytowania istniejących narzędzi',
                'module' => 'tools',
                'action' => 'edit'
            ],
            [
                'name' => 'tools.delete',
                'display_name' => 'Usuwanie narzędzi',
                'description' => 'Możliwość usuwania narzędzi',
                'module' => 'tools',
                'action' => 'delete'
            ],

            // Height Equipment module
            [
                'name' => 'height-equipment.view',
                'display_name' => 'Przeglądanie sprzętu wysokościowego',
                'description' => 'Możliwość przeglądania listy sprzętu wysokościowego',
                'module' => 'height-equipment',
                'action' => 'view'
            ],
            [
                'name' => 'height-equipment.create',
                'display_name' => 'Dodawanie sprzętu wysokościowego',
                'description' => 'Możliwość dodawania nowego sprzętu wysokościowego',
                'module' => 'height-equipment',
                'action' => 'create'
            ],
            [
                'name' => 'height-equipment.edit',
                'display_name' => 'Edycja sprzętu wysokościowego',
                'description' => 'Możliwość edytowania istniejącego sprzętu wysokościowego',
                'module' => 'height-equipment',
                'action' => 'edit'
            ],
            [
                'name' => 'height-equipment.delete',
                'display_name' => 'Usuwanie sprzętu wysokościowego',
                'description' => 'Możliwość usuwania sprzętu wysokościowego',
                'module' => 'height-equipment',
                'action' => 'delete'
            ],

            // IT Equipment module
            [
                'name' => 'it-equipment.view',
                'display_name' => 'Przeglądanie sprzętu IT',
                'description' => 'Możliwość przeglądania listy sprzętu IT',
                'module' => 'it-equipment',
                'action' => 'view'
            ],
            [
                'name' => 'it-equipment.create',
                'display_name' => 'Dodawanie sprzętu IT',
                'description' => 'Możliwość dodawania nowego sprzętu IT',
                'module' => 'it-equipment',
                'action' => 'create'
            ],
            [
                'name' => 'it-equipment.edit',
                'display_name' => 'Edycja sprzętu IT',
                'description' => 'Możliwość edytowania istniejącego sprzętu IT',
                'module' => 'it-equipment',
                'action' => 'edit'
            ],
            [
                'name' => 'it-equipment.delete',
                'display_name' => 'Usuwanie sprzętu IT',
                'description' => 'Możliwość usuwania sprzętu IT',
                'module' => 'it-equipment',
                'action' => 'delete'
            ],

            // Employees module
            [
                'name' => 'employees.view',
                'display_name' => 'Przeglądanie pracowników',
                'description' => 'Możliwość przeglądania listy pracowników',
                'module' => 'employees',
                'action' => 'view'
            ],
            [
                'name' => 'employees.create',
                'display_name' => 'Dodawanie pracowników',
                'description' => 'Możliwość dodawania nowych pracowników',
                'module' => 'employees',
                'action' => 'create'
            ],
            [
                'name' => 'employees.edit',
                'display_name' => 'Edycja pracowników',
                'description' => 'Możliwość edytowania danych pracowników',
                'module' => 'employees',
                'action' => 'edit'
            ],
            [
                'name' => 'employees.delete',
                'display_name' => 'Usuwanie pracowników',
                'description' => 'Możliwość usuwania pracowników',
                'module' => 'employees',
                'action' => 'delete'
            ],

            // Admin module
            [
                'name' => 'admin.manage',
                'display_name' => 'Zarządzanie panelem administratora',
                'description' => 'Pełny dostęp do panelu administracyjnego',
                'module' => 'admin',
                'action' => 'manage'
            ],
            [
                'name' => 'admin.users',
                'display_name' => 'Zarządzanie użytkownikami',
                'description' => 'Możliwość zarządzania użytkownikami systemu',
                'module' => 'admin',
                'action' => 'manage'
            ],
            [
                'name' => 'admin.roles',
                'display_name' => 'Zarządzanie rolami',
                'description' => 'Możliwość zarządzania rolami i uprawnieniami',
                'module' => 'admin',
                'action' => 'manage'
            ],
            [
                'name' => 'admin.modules',
                'display_name' => 'Zarządzanie modułami',
                'description' => 'Możliwość zarządzania modułami systemu',
                'module' => 'admin',
                'action' => 'manage'
            ],
            [
                'name' => 'admin.data',
                'display_name' => 'Zarządzanie danymi',
                'description' => 'Możliwość zarządzania danymi systemu',
                'module' => 'admin',
                'action' => 'manage'
            ]
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}