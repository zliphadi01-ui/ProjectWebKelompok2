<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class KunjunganController extends Controller
{
    // Menampilkan kunjungan hari ini
    public function hariIni()
    {
        // Data statistik kunjungan
        $statistik = [
            'total' => 45,
            'menunggu' => 12,
            'sedang_diperiksa' => 3,
            'selesai' => 30
        ];
        
        // Data kunjungan hari ini
        $kunjungan = [
            [
                'antrean' => 'A-01',
                'waktu' => '08:15',
                'no_rm' => '12-34-56',
                'nama' => 'Budi Santoso',
                'poliklinik' => 'Poli Umum',
                'status' => 'menunggu'
            ],
            [
                'antrean' => 'G-01',
                'waktu' => '08:22',
                'no_rm' => '11-22-33',
                'nama' => 'Citra Lestari',
                'poliklinik' => 'Poli Gigi',
                'status' => 'diperiksa'
            ],
            [
                'antrean' => 'A-02',
                'waktu' => '08:30',
                'no_rm' => '22-11-44',
                'nama' => 'Ahmad Rizki',
                'poliklinik' => 'Poli Umum',
                'status' => 'menunggu'
            ],
            [
                'antrean' => 'U-01',
                'waktu' => '08:45',
                'no_rm' => '33-55-77',
                'nama' => 'Siti Nurhaliza',
                'poliklinik' => 'Poli Umum',
                'status' => 'selesai'
            ]
        ];
        
        $tanggal = Carbon::now()->translatedFormat('l, j F Y');
        
        return view('kunjungan.hari-ini', compact('statistik', 'kunjungan', 'tanggal'));
    }
    
    // Filter kunjungan berdasarkan poliklinik dan status
    public function filter(Request $request)
    {
        $poliklinik = $request->input('poliklinik');
        $status = $request->input('status');
        
        // Logika filter (sementara redirect)
        return redirect()->back()
            ->with('success', 'Filter berhasil diterapkan');
    }
    
    // Panggil pasien untuk pemeriksaan
    public function panggil($id)
    {
        // Update status kunjungan menjadi sedang diperiksa
        return redirect()->route('pemeriksaan.soap', $id);
    }
    
    // Refresh data kunjungan
    public function refresh()
    {
        return redirect()->route('kunjungan.hari-ini')
            ->with('success', 'Data berhasil direfresh');
    }
}