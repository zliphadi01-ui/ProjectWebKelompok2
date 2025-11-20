<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawatInap extends Model
{
    use HasFactory;

    protected $table = 'rawat_inaps';

    protected $fillable = [
        'pasien_id', 'kamar', 'no_kamar', 'tanggal_masuk', 'tanggal_keluar', 'status', 'diagnosis', 'notes'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }
}
