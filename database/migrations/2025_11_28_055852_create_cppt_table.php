<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cppt', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rawat_inap_id');
            $table->unsignedBigInteger('dokter_id')->nullable(); // User ID
            $table->dateTime('tanggal');
            $table->text('subjective');
            $table->text('objective');
            $table->text('assessment');
            $table->text('plan');
            $table->text('instruksi_ppa')->nullable(); // Instruksi Profesional Pemberi Asuhan
            $table->timestamps();

            $table->foreign('rawat_inap_id')->references('id')->on('rawat_inaps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cppt');
    }
};
