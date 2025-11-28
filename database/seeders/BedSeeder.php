<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bed;

class BedSeeder extends Seeder
{
    public function run()
    {
        // Kelas 1
        Bed::create(['nama_kamar' => 'Mawar 1', 'no_bed' => '1', 'kelas' => '1', 'status' => 'available']);
        Bed::create(['nama_kamar' => 'Mawar 1', 'no_bed' => '2', 'kelas' => '1', 'status' => 'available']);
        
        // Kelas 2
        Bed::create(['nama_kamar' => 'Melati 1', 'no_bed' => '1', 'kelas' => '2', 'status' => 'available']);
        Bed::create(['nama_kamar' => 'Melati 1', 'no_bed' => '2', 'kelas' => '2', 'status' => 'occupied']); // Simulasi terisi
        Bed::create(['nama_kamar' => 'Melati 1', 'no_bed' => '3', 'kelas' => '2', 'status' => 'available']);

        // Kelas 3
        Bed::create(['nama_kamar' => 'Anggrek 1', 'no_bed' => '1', 'kelas' => '3', 'status' => 'available']);
        Bed::create(['nama_kamar' => 'Anggrek 1', 'no_bed' => '2', 'kelas' => '3', 'status' => 'maintenance']);
        Bed::create(['nama_kamar' => 'Anggrek 1', 'no_bed' => '3', 'kelas' => '3', 'status' => 'available']);
        Bed::create(['nama_kamar' => 'Anggrek 1', 'no_bed' => '4', 'kelas' => '3', 'status' => 'available']);
        
        // VIP
        Bed::create(['nama_kamar' => 'Tulip VIP', 'no_bed' => '1', 'kelas' => 'VIP', 'status' => 'available']);
    }
}
