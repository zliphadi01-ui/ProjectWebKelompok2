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
     * Boot method to handle model events.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pasien) {
            // Assign temporary No RM to pass DB constraint if not provided
            if (empty($pasien->no_rm)) {
                $pasien->no_rm = 'TEMP-' . time() . rand(100,999);
            }
        });

        static::created(function ($pasien) {
            // Update with correct format based on ID (000001)
            // Check if it's our temporary format or just needs formatting
            if (str_contains($pasien->no_rm, 'TEMP-') || is_numeric($pasien->no_rm)) {
                $newNoRm = str_pad($pasien->id, 6, '0', STR_PAD_LEFT);
                
                // Only update if different to avoid loop (though saveQuietly handles it)
                if ($pasien->no_rm !== $newNoRm) {
                    $pasien->no_rm = $newNoRm;
                    $pasien->saveQuietly();
                }
            }
        });
    }

    /**
     * Relasi ke Pendaftaran
     */
    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}