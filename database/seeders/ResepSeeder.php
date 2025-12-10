<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pendaftaran;
use App\Models\Pemeriksaan;
use App\Models\Resep;
use App\Models\ResepDetail;
use App\Models\Obat;
use App\Models\User;
use App\Models\Pasien;

class ResepSeeder extends Seeder
{
    public function run()
    {
        // Ensure we have medicines
        $obats = Obat::all();
        if ($obats->isEmpty()) {
            $this->call(ObatSeeder::class);
            $obats = Obat::all();
        }

        // Get a doctor
        $dokter = User::where('role', 'dokter')->first();
        if (!$dokter) return;

        // Get Pendaftarans
        $pendaftarans = Pendaftaran::where('status', '!=', 'Selesai')->get();

        foreach ($pendaftarans as $pendaftaran) {
            // Check if Pemeriksaan exists
            $pemeriksaan = Pemeriksaan::where('pendaftaran_id', $pendaftaran->id)->first();
            
            if (!$pemeriksaan) {
                // Create dummy Pemeriksaan
                $pemeriksaan = Pemeriksaan::create([
                    'pendaftaran_id' => $pendaftaran->id,
                    'pasien_id' => $pendaftaran->pasien_id,
                    'subjective' => 'Keluhan pusing dan demam.',
                    'objective' => 'Suhu 38C, Tensi 120/80.',
                    'assessment' => 'Febris suspek viral infection.',
                    'plan' => 'Istirahat dan obat simptomatik.',
                    'diagnosis' => 'Demam',
                ]);
            }

            // Check if Resep exists
            $resep = Resep::where('pemeriksaan_id', $pemeriksaan->id)->first();

            if (!$resep) {
                $resep = Resep::create([
                    'pemeriksaan_id' => $pemeriksaan->id,
                    'pasien_id' => $pendaftaran->pasien_id,
                    'dokter_id' => $dokter->id,
                    'status' => 'Menunggu',
                    'catatan' => 'Diminum sesudah makan.',
                ]);
            }

            // Check if Resep Details exist
            if ($resep->details()->count() == 0) {
                // Add 2 random medicines
                $randomObats = $obats->random(min(2, $obats->count()));
                
                foreach ($randomObats as $obat) {
                    $jumlah = rand(1, 3);
                    ResepDetail::create([
                        'resep_id' => $resep->id,
                        'obat_id' => $obat->id,
                        'jumlah' => $jumlah,
                        'dosis' => '3x1',
                        'harga_satuan' => $obat->harga_jual,
                        'subtotal' => $jumlah * $obat->harga_jual,
                    ]);
                }
            }
        }
    }
}
