<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
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
                'name' => 'rekam_medis',
                'email' => 'rm@example.com',
                'role' => 'rekam_medis',
                'password' => '12345',
            ],
            [
                'name' => 'pasien',
                'email' => 'pasien@example.com',
                'role' => 'pasien',
                'password' => '12345',
            ],
        ]);
    }
}
