<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ObatSeeder extends Seeder
{
    public function run()
    {
        $obats = [
            ['kode_obat' => 'OBT001', 'nama_obat' => 'Paracetamol 500mg', 'kategori' => 'Tablet', 'stok' => 500, 'satuan' => 'tablet', 'harga_beli' => 300, 'harga_jual' => 500, 'expired_date' => '2026-12-31'],
            ['kode_obat' => 'OBT002', 'nama_obat' => 'Amoxicillin 500mg', 'kategori' => 'Kapsul', 'stok' => 300, 'satuan' => 'kapsul', 'harga_beli' => 800, 'harga_jual' => 1200, 'expired_date' => '2026-06-30'],
            ['kode_obat' => 'OBT003', 'nama_obat' => 'OBH Combi', 'kategori' => 'Sirup', 'stok' => 100, 'satuan' => 'botol', 'harga_beli' => 12000, 'harga_jual' => 15000, 'expired_date' => '2025-12-31'],
            ['kode_obat' => 'OBT004', 'nama_obat' => 'Antasida DOEN', 'kategori' => 'Tablet', 'stok' => 200, 'satuan' => 'tablet', 'harga_beli' => 250, 'harga_jual' => 400, 'expired_date' => '2026-03-31'],
            ['kode_obat' => 'OBT005', 'nama_obat' => 'Ibuprofen 400mg', 'kategori' => 'Tablet', 'stok' => 250, 'satuan' => 'tablet', 'harga_beli' => 500, 'harga_jual' => 800, 'expired_date' => '2026-09-30'],
            ['kode_obat' => 'OBT006', 'nama_obat' => 'Cetirizine 10mg', 'kategori' => 'Tablet', 'stok' => 180, 'satuan' => 'tablet', 'harga_beli' => 600, 'harga_jual' => 1000, 'expired_date' => '2026-08-31'],
            ['kode_obat' => 'OBT007', 'nama_obat' => 'Vitamin C 1000mg', 'kategori' => 'Tablet', 'stok' => 400, 'satuan' => 'tablet', 'harga_beli' => 200, 'harga_jual' => 350, 'expired_date' => '2027-12-31'],
            ['kode_obat' => 'OBT008', 'nama_obat' => 'Salbutamol Inhaler', 'kategori' => 'Inhaler', 'stok' => 50, 'satuan' => 'unit', 'harga_beli' => 35000, 'harga_jual' => 45000, 'expired_date' => '2026-05-31'],
            ['kode_obat' => 'OBT009', 'nama_obat' => 'Metformin 500mg', 'kategori' => 'Tablet', 'stok' => 350, 'satuan' => 'tablet', 'harga_beli' => 400, 'harga_jual' => 700, 'expired_date' => '2026-11-30'],
            ['kode_obat' => 'OBT010', 'nama_obat' => 'Omeprazole 20mg', 'kategori' => 'Kapsul', 'stok' => 200, 'satuan' => 'kapsul', 'harga_beli' => 1000, 'harga_jual' => 1500, 'expired_date' => '2026-07-31'],
        ];

        foreach ($obats as $obat) {
            DB::table('obats')->insert(array_merge($obat, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
