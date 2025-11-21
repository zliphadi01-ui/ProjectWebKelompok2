<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftarans';

    protected $fillable = [
        'no_daftar',
        'nama',
        'nik',
        'pasien_id',
        'jenis_kelamin',
        'tanggal_lahir',
        'telepon',
        'poli',
        'status',
    ];

    // =================================================================
    // RELASI 1: KE DATA PASIEN (BIODATA)
    // =================================================================
    // Fungsi ini yang membuat No. RM & Umur muncul (Tidak N/A lagi)
    public function pasien()
    {
        // 'pasien_id' adalah kunci tamu di tabel pendaftarans
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    // =================================================================
    // RELASI 2: KE REKAM MEDIS (PEMERIKSAAN)
    // =================================================================
    // Fungsi ini PENTING agar data periksa tersambung ke pendaftaran ini
    public function pemeriksaan()
    {
        // Satu pendaftaran punya satu hasil pemeriksaan
        return $this->hasOne(Pemeriksaan::class);
    }
}