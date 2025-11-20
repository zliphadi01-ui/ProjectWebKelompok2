<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function keadaanAkhir()
    {
        return view('master.keadaan-akhir');
    }

    public function menu()
    {
        return view('master.menu');
    }

    public function mitra()
    {
        return view('master.mitra');
    }

    public function hakAkses()
    {
        return view('master.hak-akses');
    }

    public function aktivasiPoli()
    {
        return view('master.aktivasi-poli');
    }

    public function pegawai()
    {
        return view('master.pegawai');
    }

    public function jadwalPoli()
    {
        return view('master.jadwal-poli');
    }

    public function tindakanLaborat()
    {
        return view('master.tindakan-laborat');
    }

    public function diagnosa()
    {
        return view('master.diagnosa');
    }

    public function kamarRawatInap()
    {
        return view('master.kamar-rawat-inap');
    }

    public function unit()
    {
        return view('master.unit');
    }

    public function vendor()
    {
        return view('master.vendor');
    }

    public function kategoriDiagnosa()
    {
        return view('master.kategori-diagnosa');
    }

    public function jenisPembayaran()
    {
        return view('master.jenis-pembayaran');
    }

    public function profesi()
    {
        return view('master.profesi');
    }

    public function resepInfo()
    {
        return view('master.resep-info');
    }

    public function rsRujukan()
    {
        return view('master.rs-rujukan');
    }
}
