<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemeriksaan extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaans';

    protected $fillable = [
        'pendaftaran_id',
        'pasien_id',
        'subjective',
        'objective',
        'assessment',
        'plan',
        'tekanan_darah',
        'nadi',
        'suhu',
        'berat_badan',
        'icd_code',
        'diagnosis',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }
}
