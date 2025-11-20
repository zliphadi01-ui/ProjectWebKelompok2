<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pasien;
use Illuminate\Support\Str;

class PasienSeeder extends Seeder
{
    public function run()
    {
        Pasien::insert([
            [
                'no_rm' => 'RM-0001',
                'nama' => 'Budi Santoso',
                'nik' => '3201123456789001',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1990-05-12',
                'telepon' => '081234567890',
                'email' => 'budi@example.com',
                'alamat' => 'Jl. Merpati No. 12',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_rm' => 'RM-0002',
                'nama' => 'Siti Aminah',
                'nik' => '3201123456789002',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '1988-11-20',
                'telepon' => '081298765432',
                'email' => 'siti@example.com',
                'alamat' => 'Jl. Kenari No. 45',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
