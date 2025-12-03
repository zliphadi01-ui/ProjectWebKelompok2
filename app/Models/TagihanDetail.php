<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagihanDetail extends Model
{
    protected $fillable = [
        'tagihan_id',
        'item_name',
        'item_type',
        'jumlah',
        'harga',
        'subtotal',
    ];

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }
}
