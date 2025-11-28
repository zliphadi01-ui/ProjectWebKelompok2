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
        Schema::create('lab_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pendaftaran_id')->nullable();
            $table->unsignedBigInteger('pasien_id');
            $table->unsignedBigInteger('dokter_id')->nullable(); // User ID of the doctor
            $table->text('jenis_pemeriksaan'); // JSON or comma-separated list
            $table->text('catatan')->nullable();
            $table->text('hasil')->nullable();
            $table->enum('status', ['requested', 'processing', 'completed', 'cancelled'])->default('requested');
            $table->timestamps();

            // Foreign keys (assuming tables exist, otherwise might need to be careful)
             $table->foreign('pasien_id')->references('id')->on('pasien')->onDelete('cascade');
             // $table->foreign('pendaftaran_id')->references('id')->on('pendaftarans')->onDelete('set null');
             // $table->foreign('dokter_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_requests');
    }
};
