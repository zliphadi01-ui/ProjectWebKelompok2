<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PharmacyController extends Controller
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

    public function gudangObat()
    {
        $counts = [];
        if (Schema::hasTable('pasien')) {
            $counts['pasien'] = DB::table('pasien')->count();
        }
        return view('pages.gudang', compact('counts'));
    }

    public function apotek()
    {
        $reseps = \App\Models\Resep::with(['pasien', 'dokter', 'pemeriksaan'])
            ->whereIn('status', ['Menunggu', 'Diproses'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $counts = $this->commonCounts();
        return view('apotek.index', compact('reseps', 'counts'));
    }

    public function searchObat(Request $request)
    {
        $query = $request->get('q');
        
        $obats = \App\Models\Obat::where('nama_obat', 'LIKE', "%{$query}%")
            ->orWhere('kode_obat', 'LIKE', "%{$query}%")
            ->where('stok', '>', 0)
            ->limit(10)
            ->get();
        
        return response()->json($obats);
    }

    public function detailResep($id)
    {
        $resep = \App\Models\Resep::with(['pasien', 'dokter', 'pemeriksaan', 'details.obat'])->findOrFail($id);
        $counts = $this->commonCounts();
        return view('apotek.detail', compact('resep', 'counts'));
    }

    public function updateStatus(Request $request, $id)
    {
        $resep = \App\Models\Resep::findOrFail($id);
        $oldStatus = $resep->status;
        $resep->status = $request->status;
        $resep->save();

        // AUTO-GENERATE TAGIHAN when resep status becomes 'Selesai'
        if ($request->status == 'Selesai' && $oldStatus != 'Selesai') {
            // Check if tagihan already exists for this resep
            $existingTagihan = \App\Models\Tagihan::where('resep_id', $resep->id)->first();
            
            if (!$existingTagihan) {
                // Generate bill number: INV-YYYYMMDD-XXXX
                $today = date('Ymd');
                $lastBill = \App\Models\Tagihan::whereDate('created_at', today())->count();
                $no_tagihan = 'INV-' . $today . '-' . str_pad($lastBill + 1, 4, '0', STR_PAD_LEFT);

                // Calculate total from resep details
                $total = 0;
                foreach ($resep->details as $detail) {
                    $total += $detail->subtotal;
                }

                // Create Tagihan
                $tagihan = \App\Models\Tagihan::create([
                    'no_tagihan' => $no_tagihan,
                    'pendaftaran_id' => $resep->pemeriksaan_id ? $resep->pemeriksaan->pendaftaran_id : null,
                    'pasien_id' => $resep->pasien_id,
                    'resep_id' => $resep->id,
                    'total_biaya' => $total,
                    'status_bayar' => 'Belum Bayar',
                ]);

                // Create Tagihan Details from Resep Details
                foreach ($resep->details as $detail) {
                    \App\Models\TagihanDetail::create([
                        'tagihan_id' => $tagihan->id,
                        'item_name' => $detail->obat->nama_obat ?? 'Obat',
                        'item_type' => 'obat',
                        'jumlah' => $detail->jumlah,
                        'harga' => $detail->harga_satuan,
                        'subtotal' => $detail->subtotal,
                    ]);
                }
            }
        }

        return redirect()->route('apotek')->with('success', 'Status resep berhasil diupdate' . ($request->status == 'Selesai' ? ' dan tagihan otomatis dibuat' : ''));
    }


    public function stokObat()
    {
        $obats = \App\Models\Obat::orderBy('nama_obat', 'asc')->get();
        $counts = $this->commonCounts();
        return view('apotek.stok', compact('obats', 'counts'));
    }

    public function riwayat()
    {
        $reseps = \App\Models\Resep::with(['pasien', 'dokter', 'pemeriksaan'])
            ->where('status', 'Selesai')
            ->orderBy('updated_at', 'desc')
            ->paginate(20);
        
        $counts = $this->commonCounts();
        return view('apotek.riwayat', compact('reseps', 'counts'));
    }
}
