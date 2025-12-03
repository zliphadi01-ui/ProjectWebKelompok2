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
        Schema::table('icd10_codes', function (Blueprint $table) {
            $table->text('keywords')->nullable()->after('name'); // Untuk sinonim/istilah Indonesia
        });

        // Only add keywords if icd9_procedures table exists
        if (Schema::hasTable('icd9_procedures')) {
            Schema::table('icd9_procedures', function (Blueprint $table) {
                $table->text('keywords')->nullable()->after('name'); // Untuk sinonim/istilah Indonesia
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('icd10_codes', function (Blueprint $table) {
            $table->dropColumn('keywords');
        });

        if (Schema::hasTable('icd9_procedures')) {
            Schema::table('icd9_procedures', function (Blueprint $table) {
                $table->dropColumn('keywords');
            });
        }
    }
};
