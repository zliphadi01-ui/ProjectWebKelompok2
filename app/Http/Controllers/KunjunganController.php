<?php

namespace App\Http\Controllers;

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