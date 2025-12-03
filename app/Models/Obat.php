<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $fillable = [
        'nama_obat',
        'kode_obat',
        'kategori',
        'stok',
        'satuan',
        'harga_beli',
        'harga_jual',
        'expired_date',
    ];
}
