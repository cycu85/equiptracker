<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'username' => 'admin',
                'email' => 'admin@equiptracker.com',
                'first_name' => 'Admin',
                'last_name' => 'Systemu',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'auth_type' => 'local',
                'is_active' => true,
            ],
            [
                'username' => 'manager',
                'email' => 'manager@equiptracker.com',
                'first_name' => 'Jan',
                'last_name' => 'Kowalski',
                'password' => bcrypt('manager123'),
                'role' => 'manager',
                'auth_type' => 'local',
                'is_active' => true,
            ],
            [
                'username' => 'user1',
                'email' => 'user1@equiptracker.com',
                'first_name' => 'Anna',
                'last_name' => 'Nowak',
                'password' => bcrypt('user123'),
                'role' => 'user',
                'auth_type' => 'local',
                'is_active' => true,
            ],
        ];

        foreach ($users as $userData) {
            \App\Models\User::updateOrCreate(
                ['username' => $userData['username']], // Warunek wyszukiwania po username
                $userData // Dane do utworzenia/aktualizacji
            );
        }
    }
}
