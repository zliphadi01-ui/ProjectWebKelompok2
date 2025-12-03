<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TindakanPemeriksaan extends Model
{
    protected $fillable = [
        'pemeriksaan_id',
        'tindakan_id',
        'harga',
        'qty',
        'subtotal',
        'keterangan',
    ];

    public function tindakan()
    {
        return $this->belongsTo(Tindakan::class);
    }

    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class);
    }
}
