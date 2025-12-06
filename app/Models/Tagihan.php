<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $fillable = [
        'no_tagihan',
        'pendaftaran_id',
        'pasien_id',
        'resep_id',
        'total_biaya',
        'total_bayar',
        'kembalian',
        'status_bayar',
        'metode_pembayaran',
        'kasir_id',
    ];

    public function details()
    {
        return $this->hasMany(TagihanDetail::class);
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}
