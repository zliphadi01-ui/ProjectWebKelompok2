<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Pasien extends Model
{
    protected $table = 'pasien'; // Pastikan nama tabel benar
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = [
        'no_rm', 'nama', 'nik', 'jenis_kelamin', 'tanggal_lahir',
        'telepon', 'email', 'alamat'
    ];

    /**
     * Scope untuk memfilter pasien berdasarkan nama atau no_rm.
     */
    public function scopeFilter(Builder $query, $q = null): void
    {
        if ($q) {
            $query->where('nama', 'like', "%{$q}%")
                  ->orWhere('no_rm', 'like', "%{$q}%")
                  ->orWhere('nik', 'like', "%{$q}%");
        }
    }

    /**
     * Relasi ke Pendaftaran
     */
    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}