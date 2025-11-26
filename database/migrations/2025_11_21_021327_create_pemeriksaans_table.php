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
            $table->unsignedBigInteger('pendaftaran_id')->nullable()->index();
            $table->unsignedBigInteger('pasien_id')->nullable()->index();
            // JEMBATAN RELASI
            // Menghubungkan pemeriksaan dengan pendaftaran dan pasien
            $table->foreignId('pendaftaran_id')->constrained('pendaftarans')->onDelete('cascade');
            $table->foreignId('pasien_id')->constrained('pasien')->onDelete('cascade');
            
            // DATA UTAMA SOAP
            $table->text('subjective')->nullable();  // S: Keluhan Pasien
            $table->text('objective')->nullable();   // O: Hasil Pemeriksaan Fisik
            $table->text('assessment')->nullable();  // A: Kode Diagnosa (R51, dst)
            $table->text('plan')->nullable();        // P: Rencana Tindakan / Obat
            
            // KOLOM YANG KEMARIN ERROR (MISSING)
            $table->string('diagnosis')->nullable(); // Nama Diagnosa (Sakit Kepala, dst)
            $table->string('icd_code')->nullable();  // Kode ICD-10
            
            // TANDA VITAL (TTV)
            $table->string('tekanan_darah')->nullable();
            $table->string('nadi')->nullable();      // Ini sebelumnya hilang
            $table->string('suhu')->nullable();
            $table->string('berat_badan')->nullable();
            
            // TAMBAHAN
            $table->text('resep_obat')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pemeriksaans');
    }
};