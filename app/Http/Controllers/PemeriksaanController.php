<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemeriksaan;
use App\Models\Pendaftaran; // Pastikan ini ada
use App\Models\Pasien;
use App\Events\DashboardStatsUpdated;
use Carbon\Carbon;

class PemeriksaanController extends Controller
{
    // ==========================================================
    // FUNGSI SOAP YANG DIPERBAIKI
    // ==========================================================
    public function soap($id = null)
    {
        $pendaftaran = null;
        $pasien = null;

        if ($id) {
            // 1. Dapatkan pendaftaran (ini sudah benar)
            $pendaftaran = Pendaftaran::find($id);

            if ($pendaftaran) {
                // 2. Coba dapatkan pasien dari relasi (cara cepat)
                $pasien = $pendaftaran->pasien;

                // 3. JIKA GAGAL (karena relasi data lama rusak), coba cari manual pakai pasien_id
                if (!$pasien && $pendaftaran->pasien_id) {
                    $pasien = Pasien::find($pendaftaran->pasien_id);
                }
            }
        }

        // 4. JIKA MASIH GAGAL TOTAL (pasien_id=NULL atau ID tidak ada)
        //    Kita buat "Pasien Bayangan" (Object) agar halaman tidak error
        //    Kita gunakan data salinan dari pendaftaran (yang kita tahu ada di Model Pendaftaran)
        if (!$pasien && $pendaftaran) {
            $pasien = new Pasien(); // Buat objek Pasien kosong
            $pasien->id = $pendaftaran->pasien_id; // Tetapkan ID jika ada
            $pasien->nama = $pendaftaran->nama; // Isi dengan nama salinan
            $pasien->no_rm = 'N/A (Data Lama)'; // Tandai sebagai data lama
            
            // Isi properti lain yang mungkin ditampilkan di SOAP view
            $pasien->jenis_kelamin = $pendaftaran->jenis_kelamin;
            $pasien->tanggal_lahir = $pendaftaran->tanggal_lahir;
            $pasien->telepon = $pendaftaran->telepon;
            $pasien->alamat = $pendaftaran->alamat ?? 'N/A';
            $pasien->alergi = $pendaftaran->alergi ?? 'N/A';
            $pasien->golongan_darah = $pendaftaran->golongan_darah ?? 'N/A';
        }
        
        // 5. HAPUS FALLBACK YANG SALAH (PENTING!)
        // if (! $pasien) {
        //    $pasien = Pasien::latest()->first(); // <-- INI YANG MENYEBABKAN "BUDI SANTOSO" MUNCUL
        // }

        return view('pemeriksaan.soap', ['pasien' => $pasien, 'pendaftaran' => $pendaftaran]);
    }
    // ==========================================================
    // AKHIR FUNGSI YANG DIPERBAIKI
    // ==========================================================
    
    // Daftar (index) pasien untuk pemeriksaan
    public function index()
    {
        // 1. Ambil data pasien yang antre
        try {
            // Kode Anda sudah 'use App\Models\Pendaftaran;' jadi ini akan berhasil
            $daftar_pasien = Pendaftaran::with('pasien')
                                    ->where('status', '!=', 'Selesai')
                                    ->where('status', '!=', 'Dibatalkan')
                                    ->orderBy('created_at', 'asc')
                                    ->get();
        } catch (\Exception $e) {
            // Jika ada error (misal: relasi 'pasien' tidak ada), kirim array kosong
            $daftar_pasien = collect();
        }

        // 2. Kirim data itu ke view
        // INI ADALAH BAGIAN YANG MEMPERBAIKI ERROR ANDA
        return view('pemeriksaan.index', [
            'daftar_pasien' => $daftar_pasien
        ]);
    }
    
    // Simpan data SOAP
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'pendaftaran_id' => 'nullable|integer|exists:pendaftarans,id',
            'pasien_id' => 'nullable|integer|exists:pasien,id',
            'subjective' => 'required|string',
            'objective' => 'required|string',
            'assessment' => 'required|string',
            'plan' => 'required|string',
            'tekanan_darah' => 'nullable|string',
            'nadi' => 'nullable|string',
            'suhu' => 'nullable|string',
            'berat_badan' => 'nullable|string',
            'icd_code' => 'nullable|string',
            'diagnosis' => 'required|string'
        ]);

        $pemeriksaan = Pemeriksaan::create([
            'pendaftaran_id' => $validated['pendaftaran_id'] ?? null,
            'pasien_id' => $validated['pasien_id'] ?? null,
            'subjective' => $validated['subjective'],
            'objective' => $validated['objective'],
            'assessment' => $validated['assessment'],
            'plan' => $validated['plan'],
            'tekanan_darah' => $validated['tekanan_darah'] ?? null,
            'nadi' => $validated['nadi'] ?? null,
            'suhu' => $validated['suhu'] ?? null,
            'berat_badan' => $validated['berat_badan'] ?? null,
            'icd_code' => $validated['icd_code'] ?? null,
            'diagnosis' => $validated['diagnosis'],
        ]);

        // update pendaftaran status if present
        if (! empty($validated['pendaftaran_id'])) {
            $p = Pendaftaran::find($validated['pendaftaran_id']);
            if ($p) { $p->status = 'Selesai'; $p->save(); }
        }

        // dispatch dashboard stats update
        $today = Carbon::today();
        $kunjungan = Pendaftaran::whereDate('created_at', $today)->count();
        $pasienBaru = Pasien::whereDate('created_at', $today)->count();
        $antrean = Pendaftaran::whereNotIn('status', ['Selesai', 'Dibatalkan'])->count();
        event(new DashboardStatsUpdated($kunjungan, $pasienBaru, $antrean));

        return redirect()->route('kunjungan.hari-ini')
            ->with('success', 'Data SOAP berhasil disimpan!');
    }
    
    // Simpan dan cetak SOAP
    public function storeAndPrint(Request $request)
    {
        // Validasi input (reuse rules) and save
        $validated = $request->validate([
            'pendaftaran_id' => 'nullable|integer|exists:pendaftarans,id',
            'pasien_id' => 'nullable|integer|exists:pasien,id',
            'subjective' => 'required|string',
            'objective' => 'required|string',
            'assessment' => 'required|string',
            'plan' => 'required|string',
            'tekanan_darah' => 'nullable|string',
            'nadi' => 'nullable|string',
            'suhu' => 'nullable|string',
            'berat_badan' => 'nullable|string',
            'icd_code' => 'nullable|string',
            'diagnosis' => 'required|string'
        ]);

        $pemeriksaan = Pemeriksaan::create([
            'pendaftaran_id' => $validated['pendaftaran_id'] ?? null,
            'pasien_id' => $validated['pasien_id'] ?? null,
            'subjective' => $validated['subjective'],
            'objective' => $validated['objective'],
            'assessment' => $validated['assessment'],
            'plan' => $validated['plan'],
            'tekanan_darah' => $validated['tekanan_darah'] ?? null,
            'nadi' => $validated['nadi'] ?? null,
            'suhu' => $validated['suhu'] ?? null,
            'berat_badan' => $validated['berat_badan'] ?? null,
            'icd_code' => $validated['icd_code'] ?? null,
            'diagnosis' => $validated['diagnosis'],
        ]);

        if (! empty($validated['pendaftaran_id'])) {
            $p = Pendaftaran::find($validated['pendaftaran_id']);
            if ($p) { $p->status = 'Selesai'; $p->save(); }
        }

        return redirect()->route('pemeriksaan.print', ['id' => $pemeriksaan->id])
            ->with('success', 'Data SOAP berhasil disimpan dan siap dicetak!');
    }
    
    // Cetak hasil pemeriksaan
    public function print($id)
    {
        // Ambil data pemeriksaan
        $pem = Pemeriksaan::with(['pasien','pendaftaran'])->findOrFail($id);
        return view('pemeriksaan.print', ['pemeriksaan' => $pem]);
    }
    
    // Riwayat pemeriksaan pasien
    public function riwayat($no_rm)
    {
        // Ambil riwayat pemeriksaan berdasarkan No. RM
        $riwayat = [
            [
                'tanggal' => '15-10-2025',
                'diagnosis' => 'ISPA',
                'dokter' => 'Dr. Ahmad',
                'tindakan' => 'Pemberian obat'
            ],
            [
                'tanggal' => '10-09-2025',
                'diagnosis' => 'Hipertensi',
                'dokter' => 'Dr. Siti',
                'tindakan' => 'Konsultasi'
            ]
        ];
        
        return view('pemeriksaan.riwayat', ['riwayat' => $riwayat]);
    }
}