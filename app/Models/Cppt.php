<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cppt extends Model
{
    use HasFactory;

    protected $table = 'cppt';

    protected $fillable = [
        'rawat_inap_id',
        'dokter_id',
        'tanggal',
        'subjective',
        'objective',
        'assessment',
        'plan',
        'instruksi_ppa',
    ];

    public function rawatInap()
    {
        return $this->belongsTo(RawatInap::class);
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }
}
