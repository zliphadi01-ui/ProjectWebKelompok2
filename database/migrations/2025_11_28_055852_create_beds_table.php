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
        Schema::create('beds', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kamar'); // e.g., "Mawar 1"
            $table->string('no_bed'); // e.g., "1", "2", "A", "B"
            $table->string('kelas')->default('3'); // 1, 2, 3, VIP, VVIP
            $table->enum('status', ['available', 'occupied', 'maintenance'])->default('available');
            $table->enum('gender', ['L', 'P', 'Campur'])->default('Campur'); // For gender specific wards
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beds');
    }
};
