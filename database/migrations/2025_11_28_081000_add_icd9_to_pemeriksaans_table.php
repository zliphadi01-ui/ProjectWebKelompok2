<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pemeriksaans', function (Blueprint $table) {
            $table->string('icd9_code')->nullable()->after('icd_code');
            $table->string('procedure')->nullable()->after('icd9_code');
        });
    }

    public function down()
    {
        Schema::table('pemeriksaans', function (Blueprint $table) {
            $table->dropColumn(['icd9_code', 'procedure']);
        });
    }
};
