<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Pendaftaran;

class KunjunganController extends Controller
{
    // Menampilkan kunjungan hari ini
    public function hariIni()
    {
        $today = Carbon::today();

        // Ambil data pendaftaran hari ini
        $kunjungan = Pendaftaran::with('pasien')
                        ->whereDate('created_at', $today)
                        ->orderBy('created_at', 'desc')
                        ->get();

        // Hitung statistik
        $statistik = [
            'total' => $kunjungan->count(),
            'menunggu' => $kunjungan->where('status', 'Menunggu')->count(),
            'sedang_diperiksa' => $kunjungan->where('status', 'Diperiksa')->count(),
            'selesai' => $kunjungan->where('status', 'Selesai')->count()
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
        // Idealnya ini mengirim parameter ke index/hariIni, tapi untuk sekarang redirect back saja
        return redirect()->route('kunjungan.hari-ini', [
            'poliklinik' => $poliklinik, 
            'status' => $status
        ])->with('success', 'Filter berhasil diterapkan');
    }
    
    // Panggil pasien untuk pemeriksaan
    public function panggil($id)
    {
        // Update status kunjungan menjadi sedang diperiksa
        $pendaftaran = Pendaftaran::find($id);
        if ($pendaftaran) {
            $pendaftaran->status = 'Diperiksa';
            $pendaftaran->save();
        }

        return redirect()->route('pemeriksaan.soap', $id);
    }
    
    // Refresh data kunjungan
    public function refresh()
    {
        return redirect()->route('kunjungan.hari-ini')
            ->with('success', 'Data berhasil direfresh');
    }
}