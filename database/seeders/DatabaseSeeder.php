<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PasienSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(Icd10Seeder::class);
        $this->call(Icd9Seeder::class);
        $this->call(BedSeeder::class);
        $this->call(PetugasLabSeeder::class);
        $this->call(ResepSeeder::class);
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
    
}
