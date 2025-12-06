<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tagihan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tagihan_id')->constrained('tagihans')->onDelete('cascade');
            $table->string('item_name'); // Nama obat, tindakan, konsultasi, dll
            $table->string('item_type')->default('obat'); // obat, tindakan, konsultasi, pemeriksaan
            $table->integer('jumlah')->default(1);
            $table->decimal('harga', 10, 2)->default(0);
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tagihan_details');
    }
};
