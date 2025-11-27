<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PendaftaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pasiens = \App\Models\Pasien::all();

        if ($pasiens->count() > 0) {
            foreach ($pasiens as $index => $pasien) {
                \App\Models\Pendaftaran::create([
                    'no_daftar' => 'REG-' . time() . $index,
                    'pasien_id' => $pasien->id,
                    'nama' => $pasien->nama,
                    'jenis_kelamin' => $pasien->jenis_kelamin,
                    'nik' => $pasien->nik,
                    'poli' => 'Poli Umum', // Default poli
                    'status' => 'Menunggu',
                    'created_at' => now(),
                ]);
            }
        }
    }
}
