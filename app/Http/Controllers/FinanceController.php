<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FinanceController extends Controller
{
    protected function commonCounts()
    {
        $counts = [];
        if (Schema::hasTable('pasien')) {
            $counts['pasien'] = DB::table('pasien')->count();
        }
        if (Schema::hasTable('pendaftarans')) {
            $counts['pendaftaran'] = DB::table('pendaftarans')->count();
        }
        if (Schema::hasTable('pemeriksaans')) {
            $counts['pemeriksaan'] = DB::table('pemeriksaans')->count();
        }
        return $counts;
    }

    public function kasir()
    {
        $tagihans = \App\Models\Tagihan::with(['pasien', 'pendaftaran'])
            ->where('status_bayar', 'Belum Bayar')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $counts = $this->commonCounts();
        return view('kasir.index', compact('tagihans', 'counts'));
    }

    public function processPayment(Request $request, $id)
    {
        $tagihan = \App\Models\Tagihan::findOrFail($id);
        
        $validated = $request->validate([
            'total_bayar' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|string',
        ]);

        $kembalian = $validated['total_bayar'] - $tagihan->total_biaya;

        $tagihan->update([
            'total_bayar' => $validated['total_bayar'],
            'kembalian' => $kembalian >= 0 ? $kembalian : 0,
            'status_bayar' => $kembalian >= 0 ? 'Lunas' : 'Belum Bayar',
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'kasir_id' => auth()->id(),
            'paid_at' => $kembalian >= 0 ? now() : null,
        ]);

        return redirect()->route('kasir')->with('success', 'Pembayaran berhasil diproses');
    }

    public function billing()
    {
        $tagihans = \App\Models\Tagihan::with(['pasien', 'pendaftaran'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        $counts = $this->commonCounts();
        return view('billing.index', compact('tagihans', 'counts'));
    }

    public function detailBilling($id)
    {
        $tagihan = \App\Models\Tagihan::with(['pasien', 'pendaftaran', 'details', 'resep'])->findOrFail($id);
        $counts = $this->commonCounts();
        return view('billing.detail', compact('tagihan', 'counts'));
    }
}
