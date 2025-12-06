<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ObatSeeder extends Seeder
{
    public function run()
    {
        $obats = [
            ['kode_obat' => 'OBT001', 'nama_obat' => 'Paracetamol 500mg', 'kategori' => 'Analgesik', 'satuan' => 'Strip', 'stok' => 100, 'harga_beli' => 3000, 'harga_jual' => 5000, 'expired_date' => '2026-12-31'],
            ['kode_obat' => 'OBT002', 'nama_obat' => 'Amoxicillin 500mg', 'kategori' => 'Antibiotik', 'satuan' => 'Strip', 'stok' => 80, 'harga_beli' => 8000, 'harga_jual' => 12000, 'expired_date' => '2026-06-30'],
            ['kode_obat' => 'OBT003', 'nama_obat' => 'OBH Combi', 'kategori' => 'Batuk & Flu', 'satuan' => 'Botol', 'stok' => 50, 'harga_beli' => 12000, 'harga_jual' => 18000, 'expired_date' => '2025-12-31'],
            ['kode_obat' => 'OBT004', 'nama_obat' => 'Antasida DOEN', 'kategori' => 'Maag', 'satuan' => 'Botol', 'stok' => 60, 'harga_beli' => 4000, 'harga_jual' => 7000, 'expired_date' => '2026-03-31'],
            ['kode_obat' => 'OBT005', 'nama_obat' => 'Ibuprofen 400mg', 'kategori' => 'Analgesik', 'satuan' => 'Strip', 'stok' => 75, 'harga_beli' => 5000, 'harga_jual' => 8000, 'expired_date' => '2026-09-30'],
            ['kode_obat' => 'OBT006', 'nama_obat' => 'Cetirizine 10mg', 'kategori' => 'Antihistamin', 'satuan' => 'Strip', 'stok' => 90, 'harga_beli' => 6000, 'harga_jual' => 10000, 'expired_date' => '2026-08-31'],
            ['kode_obat' => 'OBT007', 'nama_obat' => 'Vitamin C 1000mg', 'kategori' => 'Vitamin', 'satuan' => 'Strip', 'stok' => 120, 'harga_beli' => 8000, 'harga_jual' => 12000, 'expired_date' => '2027-01-31'],
            ['kode_obat' => 'OBT008', 'nama_obat' => 'Salbutamol Inhaler', 'kategori' => 'Asma', 'satuan' => 'Unit', 'stok' => 30, 'harga_beli' => 25000, 'harga_jual' => 35000, 'expired_date' => '2026-05-31'],
            ['kode_obat' => 'OBT009', 'nama_obat' => 'Metformin 500mg', 'kategori' => 'Diabetes', 'satuan' => 'Strip', 'stok' => 70, 'harga_beli' => 10000, 'harga_jual' => 15000, 'expired_date' => '2026-11-30'],
            ['kode_obat' => 'OBT010', 'nama_obat' => 'Omeprazole 20mg', 'kategori' => 'Maag', 'satuan' => 'Strip', 'stok' => 65, 'harga_beli' => 15000, 'harga_jual' => 20000, 'expired_date' => '2026-07-31'],
        ];

        foreach ($obats as $obat) {
            DB::table('obats')->insert(array_merge($obat, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
