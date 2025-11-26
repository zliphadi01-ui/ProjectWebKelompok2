<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data nyata dari database untuk ditampilkan di dashboard
        $today = Carbon::today();

        $kunjunganHariIni = Pendaftaran::whereDate('created_at', $today)->count();
        $pasienBaru = Pasien::whereDate('created_at', $today)->count();

        // Antrean aktif: coba hitung pendaftaran yang status-nya belum selesai
        $antreanAktif = Pendaftaran::whereNotIn('status', ['Selesai', 'Dibatalkan'])->count();

        $resepPending = 0; // placeholder jika belum ada model resep

        // Grafik kunjungan (7 hari terakhir)
        $labels = [];
        $dataGrafik = [];
        for ($i = 6; $i >= 0; $i--) {
            $d = Carbon::today()->subDays($i);
            $labels[] = $d->translatedFormat('D, d M');
            $dataGrafik[] = Pendaftaran::whereDate('created_at', $d)->count();
        }

        $user = Auth::user();

        $data = [
            'kunjungan_hari_ini' => $kunjunganHariIni,
            'pasien_baru' => $pasienBaru,
            'antrean_aktif' => $antreanAktif,
            'resep_pending' => $resepPending,
            'grafik_kunjungan' => [
                'labels' => $labels,
                'data' => $dataGrafik,
            ],
            'recent' => Pendaftaran::whereNotIn('status', ['Selesai', 'Dibatalkan'])->latest()->limit(5)->get(),
            'tanggal' => Carbon::now()->translatedFormat('l, j F Y')
        ];

    // Sertakan data user jika tersedia (dipakai untuk menampilkan nama / avatar di layout)
    $data['user'] = $user;

    return view('dashboard', $data);
    }
    
    // JSON endpoint untuk statistik singkat (dipakai AJAX)
    public function stats()
    {
        $today = Carbon::today();
        $kunjunganHariIni = Pendaftaran::whereDate('created_at', $today)->count();
        $pasienBaru = Pasien::whereDate('created_at', $today)->count();
        $antreanAktif = Pendaftaran::whereNotIn('status', ['Selesai', 'Dibatalkan'])->count();

        return response()->json([
            'kunjungan_hari_ini' => $kunjunganHariIni,
            'pasien_baru' => $pasienBaru,
            'antrean_aktif' => $antreanAktif,
        ]);
    }

    /**
     * Return recent items for a given dashboard card.
     * type: kunjungan | pasien-baru | antrean | resep
     */
    public function details($type)
    {
        $today = Carbon::today();
        $items = [];

        switch ($type) {
            case 'kunjungan':
                $items = Pendaftaran::whereDate('created_at', $today)->latest()->limit(15)->get();
                break;
            case 'pasien-baru':
                $items = Pasien::whereDate('created_at', $today)->latest()->limit(15)->get();
                break;
            case 'antrean':
                $items = Pendaftaran::whereNotIn('status', ['Selesai', 'Dibatalkan'])->latest()->limit(20)->get();
                break;
            case 'resep':
                // If resep model exists replace with proper model. Fallback: empty.
                $items = [];
                break;
            default:
                return response()->json(['error' => 'Invalid type'], 400);
        }

        $html = view('dashboard._card_details', ['type' => $type, 'items' => $items])->render();
        return response()->json(['html' => $html]);
    }
    
    public function filter(Request $request)
    {
        $tanggalDari = $request->input('tanggal_dari');
        $tanggalSampai = $request->input('tanggal_sampai');
        $departemen = $request->input('departemen');
        
        // Logika filter data (sementara return dummy data)
        return redirect()->back()->with('success', 'Data berhasil difilter');
    }
}