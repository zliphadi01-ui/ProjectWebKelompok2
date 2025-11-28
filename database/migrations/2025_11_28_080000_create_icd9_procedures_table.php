<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('icd9_procedures', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // e.g., 89.01
            $table->string('name'); // e.g., Interview and evaluation, described as brief
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('icd9_procedures');
    }
};
