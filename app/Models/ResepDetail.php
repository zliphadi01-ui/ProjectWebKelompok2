<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Obat;
use App\Models\Resep;

class ResepDetail extends Model
{
    protected $fillable = [
        'resep_id',
        'obat_id',
        'jumlah',
        'dosis',
        'harga_satuan',
        'subtotal',
    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }

    public function resep()
    {
        return $this->belongsTo(Resep::class);
    }
}
