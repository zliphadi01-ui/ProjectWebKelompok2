<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftarans';
    protected $guarded = []; // IZINKAN SEMUA KOLOM DIISI

    // Relasi ke Master Pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }
    
    // Relasi ke Rekam Medis (SOAP)
    public function pemeriksaan()
    {
        return $this->hasOne(Pemeriksaan::class);
    }
}