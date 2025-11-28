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
                'password' => '12345',
            ],
            [
                'name' => 'dokter',
                'email' => 'dokter@example.com',
                'role' => 'dokter',
                'password' => '12345',
            ],
            [
                'name' => 'perawat',
                'email' => 'perawat@example.com',
                'role' => 'perawat',
                'password' => '12345',
            ],
            [
                'name' => 'pendaftaran',
                'email' => 'pendaftaran@example.com',
                'role' => 'pendaftaran',
                'password' => '12345',
            ],
            [
                'name' => 'apotek',
                'email' => 'apotek@example.com',
                'role' => 'apotek',
                'password' => '12345',
            ],
            [
                'name' => 'kasir',
                'email' => 'kasir@example.com',
                'role' => 'kasir',
                'password' => '12345',
            ],
            [
                'name' => 'pasien',
                'email' => 'pasien@example.com',
                'role' => 'pasien',
                'password' => '12345',
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
