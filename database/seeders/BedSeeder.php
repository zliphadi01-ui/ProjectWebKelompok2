<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bed;

class BedSeeder extends Seeder
{
    public function run()
    {
        $beds = [
            // Kelas 1 (2 Kamar, masing-masing 2 bed)
            ['nama_kamar' => 'Mawar 101', 'no_bed' => '1', 'kelas' => '1', 'gender' => 'L'],
            ['nama_kamar' => 'Mawar 101', 'no_bed' => '2', 'kelas' => '1', 'gender' => 'L'],
            ['nama_kamar' => 'Mawar 102', 'no_bed' => '1', 'kelas' => '1', 'gender' => 'P'],
            ['nama_kamar' => 'Mawar 102', 'no_bed' => '2', 'kelas' => '1', 'gender' => 'P'],

            // Kelas 2 (2 Kamar, masing-masing 4 bed)
            ['nama_kamar' => 'Melati 201', 'no_bed' => '1', 'kelas' => '2', 'gender' => 'L'],
            ['nama_kamar' => 'Melati 201', 'no_bed' => '2', 'kelas' => '2', 'gender' => 'L'],
            ['nama_kamar' => 'Melati 201', 'no_bed' => '3', 'kelas' => '2', 'gender' => 'L'],
            ['nama_kamar' => 'Melati 201', 'no_bed' => '4', 'kelas' => '2', 'gender' => 'L'],
            
            ['nama_kamar' => 'Melati 202', 'no_bed' => '1', 'kelas' => '2', 'gender' => 'P'],
            ['nama_kamar' => 'Melati 202', 'no_bed' => '2', 'kelas' => '2', 'gender' => 'P'],
            ['nama_kamar' => 'Melati 202', 'no_bed' => '3', 'kelas' => '2', 'gender' => 'P'],
            ['nama_kamar' => 'Melati 202', 'no_bed' => '4', 'kelas' => '2', 'gender' => 'P'],

            // Kelas 3 (2 Kamar, masing-masing 6 bed)
            ['nama_kamar' => 'Anggrek 301', 'no_bed' => '1', 'kelas' => '3', 'gender' => 'L'],
            ['nama_kamar' => 'Anggrek 301', 'no_bed' => '2', 'kelas' => '3', 'gender' => 'L'],
            ['nama_kamar' => 'Anggrek 301', 'no_bed' => '3', 'kelas' => '3', 'gender' => 'L'],
            ['nama_kamar' => 'Anggrek 301', 'no_bed' => '4', 'kelas' => '3', 'gender' => 'L'],
            ['nama_kamar' => 'Anggrek 301', 'no_bed' => '5', 'kelas' => '3', 'gender' => 'L'],
            ['nama_kamar' => 'Anggrek 301', 'no_bed' => '6', 'kelas' => '3', 'gender' => 'L'],

            ['nama_kamar' => 'Anggrek 302', 'no_bed' => '1', 'kelas' => '3', 'gender' => 'P'],
            ['nama_kamar' => 'Anggrek 302', 'no_bed' => '2', 'kelas' => '3', 'gender' => 'P'],
            ['nama_kamar' => 'Anggrek 302', 'no_bed' => '3', 'kelas' => '3', 'gender' => 'P'],
            ['nama_kamar' => 'Anggrek 302', 'no_bed' => '4', 'kelas' => '3', 'gender' => 'P'],
            ['nama_kamar' => 'Anggrek 302', 'no_bed' => '5', 'kelas' => '3', 'gender' => 'P'],
            ['nama_kamar' => 'Anggrek 302', 'no_bed' => '6', 'kelas' => '3', 'gender' => 'P'],

            // VIP (2 Kamar, 1 bed)
            ['nama_kamar' => 'Tulip VIP 1', 'no_bed' => '1', 'kelas' => 'VIP', 'gender' => 'Campur'],
            ['nama_kamar' => 'Tulip VIP 2', 'no_bed' => '1', 'kelas' => 'VIP', 'gender' => 'Campur'],
        ];

        foreach ($beds as $bed) {
            Bed::create(array_merge($bed, ['status' => 'available']));
        }
    }
}
