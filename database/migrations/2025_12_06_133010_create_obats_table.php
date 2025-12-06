<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('obats', function (Blueprint $table) {
            $table->id();
            $table->string('kode_obat')->unique();
            $table->string('nama_obat');
            $table->string('kategori')->nullable(); // Tablet, Sirup, Injeksi, dll
            $table->integer('stok')->default(0);
            $table->string('satuan')->default('tablet'); // tablet, kapsul, botol, ml, dll
            $table->decimal('harga_beli', 10, 2)->default(0);
            $table->decimal('harga_jual', 10, 2)->default(0);
            $table->date('expired_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('obats');
    }
};
