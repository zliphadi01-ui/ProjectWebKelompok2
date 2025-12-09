<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class RekamMedisRequest extends Model
{
    protected $table = 'rekam_medis_requests';

    protected $fillable = [
        'dokter_id',
        'pasien_id',
        'status',
        'keterangan',
        'catatan_penolakan',
        'requested_at',
        'processed_at',
        'processed_by',
        'expires_at',
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'processed_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    // Relationships
    public function dokter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    public function scopeForDokter($query, $dokterId)
    {
        return $query->where('dokter_id', $dokterId);
    }

    public function scopeForPasien($query, $pasienId)
    {
        return $query->where('pasien_id', $pasienId);
    }

    // Helper Methods
    public function isExpired(): bool
    {
        if ($this->status !== 'approved' || !$this->expires_at) {
            return false;
        }

        return Carbon::now()->isAfter($this->expires_at);
    }

    public function isActive(): bool
    {
        return $this->status === 'approved' && !$this->isExpired();
    }

    public function approve($processedBy): void
    {
        $this->status = 'approved';
        $this->processed_at = now();
        $this->processed_by = $processedBy;
        $this->expires_at = now()->addHours(24); // 24 hours from approval
        $this->save();
    }

    public function reject($processedBy, $catatanPenolakan): void
    {
        $this->status = 'rejected';
        $this->processed_at = now();
        $this->processed_by = $processedBy;
        $this->catatan_penolakan = $catatanPenolakan;
        $this->save();
    }

    public function markAsExpired(): void
    {
        $this->status = 'expired';
        $this->save();
    }

    // Get time remaining until expiration (in hours)
    public function getTimeRemaining(): ?float
    {
        if (!$this->isActive()) {
            return null;
        }

        $now = Carbon::now();
        return $now->diffInHours($this->expires_at, false);
    }

    // Get formatted expiration time
    public function getExpirationStatus(): string
    {
        if ($this->status === 'pending') {
            return 'Menunggu Persetujuan';
        }

        if ($this->status === 'rejected') {
            return 'Ditolak';
        }

        if ($this->status === 'expired') {
            return 'Kadaluarsa';
        }

        if ($this->isExpired()) {
            return 'Kadaluarsa';
        }

        $hoursRemaining = $this->getTimeRemaining();
        if ($hoursRemaining !== null) {
            if ($hoursRemaining < 1) {
                $minutesRemaining = round($hoursRemaining * 60);
                return "Tersisa {$minutesRemaining} menit";
            }
            $hours = round($hoursRemaining);
            return "Tersisa {$hours} jam";
        }

        return 'Aktif';
    }
}
