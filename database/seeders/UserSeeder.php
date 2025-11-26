<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@example.com',
                'role' => 'admin',
                'password' => Hash::make('12345'),
            ],
            [
                'name' => 'dokter',
                'email' => 'dokter@example.com',
                'role' => 'dokter',
                'password' => Hash::make('12345'),
            ],
            [
                'name' => 'pendaftaran',
                'email' => 'pendaftaran@example.com',
                'role' => 'pendaftaran',
                'password' => Hash::make('12345'),
            ],
            [
                'name' => 'apotek',
                'email' => 'apotek@example.com',
                'role' => 'apotek',
                'password' => Hash::make('12345'),
            ],
            [
                'name' => 'kasir',
                'email' => 'kasir@example.com',
                'role' => 'kasir',
                'password' => Hash::make('12345'),
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['name' => $userData['name']], // Check by name
                $userData
            );
        }
        
        $this->command->info('Users (admin, dokter, pendaftaran, apotek, kasir) created successfully.');
    }
}
