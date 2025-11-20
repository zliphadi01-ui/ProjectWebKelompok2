<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rawat_inaps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien_id')->nullable()->index();
            $table->string('kamar')->nullable();
            $table->string('no_kamar')->nullable();
            $table->dateTime('tanggal_masuk')->nullable();
            $table->dateTime('tanggal_keluar')->nullable();
            $table->string('status')->default('Dirawat');
            $table->text('diagnosis')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // foreign key can be added later if desired
        });
    }

    public function down()
    {
        Schema::dropIfExists('rawat_inaps');
    }
};
