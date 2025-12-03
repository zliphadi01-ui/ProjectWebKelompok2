<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tindakan extends Model
{
    protected $fillable = [
        'nama_tindakan',
        'kode_tindakan',
        'kategori',
        'harga',
        'is_active',
    ];
}
