<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->string('no_tagihan')->unique();
            $table->foreignId('pendaftaran_id')->nullable()->constrained('pendaftarans')->onDelete('set null');
            $table->foreignId('pasien_id')->constrained('pasien')->onDelete('cascade');
            $table->foreignId('resep_id')->nullable()->constrained('reseps')->onDelete('set null');
            $table->decimal('total_biaya', 12, 2)->default(0);
            $table->decimal('total_bayar', 12, 2)->default(0);
            $table->decimal('kembalian', 12, 2)->default(0);
            $table->enum('status_bayar', ['Belum Bayar', 'Lunas', 'Dibatalkan'])->default('Belum Bayar');
            $table->string('metode_pembayaran')->nullable(); // Tunai, Transfer, BPJS, dll
            $table->foreignId('kasir_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tagihans');
    }
};
