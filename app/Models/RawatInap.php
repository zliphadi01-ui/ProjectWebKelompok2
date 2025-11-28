<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawatInap extends Model
{
    use HasFactory;

    protected $table = 'rawat_inaps';

    protected $fillable = [
        'pasien_id',
        'bed_id',
        'kamar', // Keep for backward compatibility or fallback
        'no_kamar', // Keep for backward compatibility or fallback
        'tanggal_masuk',
        'tanggal_keluar',
        'status',
        'diagnosis',
        'notes',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function bed()
    {
        return $this->belongsTo(Bed::class);
    }

    public function cppt()
    {
        return $this->hasMany(Cppt::class)->orderBy('tanggal', 'desc');
    }
}
