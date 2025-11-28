<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pendaftaran;
use App\Models\Pemeriksaan;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function kunjungan(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $data = Pendaftaran::whereDate('created_at', '>=', $startDate)
                            ->whereDate('created_at', '<=', $endDate)
                            ->selectRaw('DATE(created_at) as date, count(*) as total')
                            ->groupBy('date')
                            ->orderBy('date')
                            ->get();

        $totalKunjungan = Pendaftaran::whereDate('created_at', '>=', $startDate)
                            ->whereDate('created_at', '<=', $endDate)
                            ->count();

        // Poli breakdown
        $poliStats = Pendaftaran::whereDate('created_at', '>=', $startDate)
                            ->whereDate('created_at', '<=', $endDate)
                            ->selectRaw('poli, count(*) as total')
                            ->groupBy('poli')
                            ->orderBy('total', 'desc')
                            ->get();

        return view('laporan.kunjungan', compact('data', 'totalKunjungan', 'poliStats', 'startDate', 'endDate'));
    }

    public function diagnosa(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Top 10 Diagnosa based on ICD-10 code
        $topDiagnosa = Pemeriksaan::whereDate('created_at', '>=', $startDate)
                            ->whereDate('created_at', '<=', $endDate)
                            ->whereNotNull('icd_code')
                            ->selectRaw('icd_code, diagnosis, count(*) as total')
                            ->groupBy('icd_code', 'diagnosis')
                            ->orderBy('total', 'desc')
                            ->limit(10)
                            ->get();

        return view('laporan.diagnosa', compact('topDiagnosa', 'startDate', 'endDate'));
    }

    // Legacy / Placeholder methods (can be removed if no longer used)
    public function laporan() { return redirect()->route('laporan.index'); }
    public function laporanPembagian() { return view('pages.generic', ['title' => 'Laporan Pembagian', 'counts' => []]); }
}
