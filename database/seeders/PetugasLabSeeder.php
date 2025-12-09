<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PetugasLabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if user already exists to avoid duplication
        if (!DB::table('users')->where('email', 'laborat@example.com')->exists()) {
            DB::table('users')->insert([
                'name' => 'Petugas Laboratorium',
                'email' => 'laborat@example.com',
                'role' => 'petugas_lab',
                'password' => Hash::make('12345'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
