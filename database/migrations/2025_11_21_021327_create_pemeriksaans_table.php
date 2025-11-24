<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pemeriksaans', function (Blueprint $table) {
            $table->id();
            // JEMBATAN RELASI
            $table->foreignId('pendaftaran_id')->constrained('pendaftarans')->onDelete('cascade');
            $table->foreignId('pasien_id')->constrained('pasien')->onDelete('cascade');
            
            // DATA SOAP
            $table->text('subjective')->nullable(); // Keluhan
            $table->text('objective')->nullable();  // Pemeriksaan Fisik
            $table->text('assessment')->nullable(); // Diagnosa
            $table->text('plan')->nullable();       // Tindakan
            
            // DATA TAMBAHAN
            $table->string('tekanan_darah')->nullable();
            $table->string('berat_badan')->nullable();
            $table->string('suhu')->nullable();
            $table->text('resep_obat')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pemeriksaans');
    }
};