<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Administrator role
        $adminRole = Role::updateOrCreate(
            ['name' => 'administrator'],
            [
                'display_name' => 'Administrator',
                'description' => 'Pełny dostęp do wszystkich funkcji systemu',
                'is_system' => true
            ]
        );

        // Manager role
        $managerRole = Role::updateOrCreate(
            ['name' => 'manager'],
            [
                'display_name' => 'Kierownik',
                'description' => 'Dostęp do większości funkcji z wyłączeniem administracji systemem',
                'is_system' => true
            ]
        );

        // User role
        $userRole = Role::updateOrCreate(
            ['name' => 'user'],
            [
                'display_name' => 'Użytkownik',
                'description' => 'Podstawowy dostęp do funkcji systemu',
                'is_system' => true
            ]
        );

        // Viewer role
        $viewerRole = Role::updateOrCreate(
            ['name' => 'viewer'],
            [
                'display_name' => 'Obserwator',
                'description' => 'Tylko przeglądanie danych bez możliwości modyfikacji',
                'is_system' => true
            ]
        );

        // Assign permissions to roles
        $allPermissions = Permission::all();
        
        // Administrator gets all permissions
        $adminRole->permissions()->sync($allPermissions->pluck('id'));

        // Manager gets all permissions except admin
        $managerPermissions = Permission::where('module', '!=', 'admin')->get();
        $managerRole->permissions()->sync($managerPermissions->pluck('id'));

        // User gets view, create, edit permissions (no delete, no admin)
        $userPermissions = Permission::whereIn('action', ['view', 'create', 'edit'])
            ->where('module', '!=', 'admin')
            ->get();
        $userRole->permissions()->sync($userPermissions->pluck('id'));

        // Viewer gets only view permissions
        $viewerPermissions = Permission::where('action', 'view')
            ->where('module', '!=', 'admin')
            ->get();
        $viewerRole->permissions()->sync($viewerPermissions->pluck('id'));
    }
}