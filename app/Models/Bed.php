<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kamar',
        'no_bed',
        'kelas',
        'status',
        'gender',
    ];

    public function rawatInap()
    {
        return $this->hasOne(RawatInap::class)->where('status', 'Dirawat');
    }
}
