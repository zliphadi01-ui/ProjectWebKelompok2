<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';
    protected $fillable = [
        'no_rm',
        'nama',
        'nik',
        'jenis_kelamin',
        'tanggal_lahir',
        'telepon',
        'email',
        'alamat',
    ];

    // accessor sederhana umur (opsional)
    public function getUmurAttribute()
    {
        if (! $this->tanggal_lahir) return null;
        return \Carbon\Carbon::parse($this->tanggal_lahir)->age;
    }

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class, 'pasien_id');
    }
}
