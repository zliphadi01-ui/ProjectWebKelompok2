<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
// use Illuminate\Broadcasting\ShouldBroadcastNow; // <-- INI BARIS YANG SALAH (SAYA HAPUS)
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow; // <-- INI YANG BENAR (TETAP DI SINI)
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DashboardStatsUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $kunjungan_hari_ini;
    public $pasien_baru;
    public $antrean_aktif;
    public $resep_pending;

    /**
     * Create a new event instance.
     */
    public function __construct($kunjungan_hari_ini, $pasien_baru, $antrean_aktif, $resep_pending = 0)
    {
        $this->kunjungan_hari_ini = $kunjungan_hari_ini;
        $this->pasien_baru = $pasien_baru;
        $this->antrean_aktif = $antrean_aktif;
        $this->resep_pending = $resep_pending;
    }

    /**
     * Get the channels the event should broadcast on.
     * Public channel 'dashboard'
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('dashboard');
    }

    public function broadcastWith()
    {
        return [
            'kunjungan_hari_ini' => $this->kunjungan_hari_ini,
            'pasien_baru' => $this->pasien_baru,
            'antrean_aktif' => $this->antrean_aktif,
            'resep_pending' => $this->resep_pending,
        ];
    }
}