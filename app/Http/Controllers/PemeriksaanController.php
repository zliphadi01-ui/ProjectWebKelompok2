<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemeriksaan;
use App\Models\Pendaftaran;
use App\Models\Pasien;
use App\Events\DashboardStatsUpdated;
use Carbon\Carbon;

class PemeriksaanController extends Controller
{
    // ==========================================================
    // MENAMPILKAN HALAMAN SOAP
    // ==========================================================
    public function soap($id = null)
    {
        $pendaftaran = null;
        $pasien = null;

        if ($id) {
            $pendaftaran = Pendaftaran::find($id);

            if ($pendaftaran) {
                // Ambil pasien dari relasi atau fallback manual
                $pasien = $pendaftaran->pasien ?? Pasien::find($pendaftaran->pasien_id);
            }
        }

        // Jika data pasien rusak/hilang, buat dummy object agar tidak error di view
        if (!$pasien && $pendaftaran) {
            $pasien = new Pasien(); 
            $pasien->id = $pendaftaran->pasien_id;
            $pasien->nama = $pendaftaran->nama; // Ambil nama dari pendaftaran
            $pasien->no_rm = 'Data Lama';
            $pasien->jenis_kelamin = $pendaftaran->jenis_kelamin;
            $pasien->tanggal_lahir = $pendaftaran->tanggal_lahir;
            $pasien->alamat = $pendaftaran->alamat;
        }

        return view('pemeriksaan.soap', ['pasien' => $pasien, 'pendaftaran' => $pendaftaran]);
    }

    // ==========================================================
    // DAFTAR ANTRIAN PEMERIKSAAN
    // ==========================================================
    public function index()
    {
        try {
            $daftar_pasien = Pendaftaran::with('pasien')
                                    ->whereNotIn('status', ['Selesai', 'Dibatalkan'])
                                    ->orderBy('created_at', 'asc')
                                    ->get();
        } catch (\Exception $e) {
            $daftar_pasien = collect();
        }

        return view('pemeriksaan.index', compact('daftar_pasien'));
    }
    
    // ==========================================================
    // SIMPAN DATA SOAP
    // ==========================================================
    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'pendaftaran_id' => 'nullable',
            'pasien_id'      => 'nullable',
            'subjective'     => 'required|string', // Wajib
            'objective'      => 'required|string', // Wajib
            'plan'           => 'required|string', // Wajib
            'diagnosis'      => 'required|string', // Wajib
            
            // Assessment kita buat BOLEH KOSONG (nullable) agar tidak error saat dikosongkan
            'assessment'     => 'nullable|string', 
            'tekanan_darah'  => 'nullable|string',
            'nadi'           => 'nullable|string',
            'suhu'           => 'nullable|string',
            'berat_badan'    => 'nullable|string',
            'icd_code'       => 'nullable|string',
            'icd9_code'      => 'nullable|string',
            'procedure'      => 'nullable|string',
        ]);

        // Simpan ke Database
        $pemeriksaan = Pemeriksaan::create($validated);

        // Update Status Pendaftaran jadi Selesai
        if (!empty($validated['pendaftaran_id'])) {
            $p = Pendaftaran::find($validated['pendaftaran_id']);
            if ($p) { 
                $p->status = 'Selesai'; 
                $p->save(); 
            }
        }

        // Cek tombol mana yang ditekan (Simpan Biasa atau Simpan & Cetak)
        if ($request->has('action') && $request->action == 'print') {
            return redirect()->route('pemeriksaan.print', ['id' => $pemeriksaan->id]);
        }

        return redirect()->route('kunjungan.hari-ini')
            ->with('success', 'Data Pemeriksaan berhasil disimpan!');
    }

    // ==========================================================
    // FUNGSI KHUSUS SIMPAN & CETAK
    // ==========================================================
    public function storeAndPrint(Request $request)
    {
        // Kita alihkan ke fungsi store tapi tambahkan parameter action
        $request->merge(['action' => 'print']);
        return $this->store($request);
    }
    
    // Cetak hasil
    public function print($id)
    {
        $pemeriksaan = Pemeriksaan::with(['pasien','pendaftaran'])->findOrFail($id);
        return view('pemeriksaan.print', compact('pemeriksaan'));
    }

    // Riwayat (Placeholder)
    public function riwayat($no_rm)
    {
        return view('pemeriksaan.riwayat');
    }
}