<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('triages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftarans')->onDelete('cascade');
            
            // Kategori Triase: Merah, Kuning, Hijau, Hitam
            $table->enum('kategori', ['Merah', 'Kuning', 'Hijau', 'Hitam']);
            
            $table->text('keluhan_utama')->nullable();
            
            // Tanda Vital Awal
            $table->string('tensi')->nullable();
            $table->string('nadi')->nullable();
            $table->string('suhu')->nullable();
            $table->string('rr')->nullable(); // Respiration Rate
            $table->string('spo2')->nullable(); // Saturasi Oksigen
            
            $table->timestamp('waktu_triase')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('triages');
    }
};
