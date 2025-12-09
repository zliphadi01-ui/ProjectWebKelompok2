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
        Schema::create('rekam_medis_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dokter_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pasien_id')->constrained('pasien')->onDelete('cascade');
            $table->enum('status', ['pending', 'approved', 'rejected', 'expired'])->default('pending');
            $table->text('keterangan')->nullable(); // Doctor's reason for request
            $table->text('catatan_penolakan')->nullable(); // Rejection notes from rekam medis staff
            $table->timestamp('requested_at')->useCurrent();
            $table->timestamp('processed_at')->nullable(); // When approved/rejected
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null'); // Rekam medis staff who processed
            $table->timestamp('expires_at')->nullable(); // 24 hours from approval
            $table->timestamps();

            // Indexes for performance
            $table->index('dokter_id');
            $table->index('pasien_id');
            $table->index('status');
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis_requests');
    }
};
