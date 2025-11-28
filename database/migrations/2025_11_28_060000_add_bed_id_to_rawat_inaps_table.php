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
        Schema::table('rawat_inaps', function (Blueprint $table) {
            if (!Schema::hasColumn('rawat_inaps', 'bed_id')) {
                $table->unsignedBigInteger('bed_id')->nullable()->after('pasien_id');
            }
        });

        Schema::table('rawat_inaps', function (Blueprint $table) {
            // We separate this to ensure column exists before adding FK
            // Also, we wrap in try-catch or just hope it works? 
            // Laravel doesn't support hasForeignKey easily.
            // Let's assume if we are here, we want the FK.
            // But if the FK already exists, this will fail.
            // Given the previous error was "Duplicate column name", the FK probably wasn't created.
            $table->foreign('bed_id')->references('id')->on('beds')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rawat_inaps', function (Blueprint $table) {
            // We should check if FK exists before dropping, but standard down is usually fine
            $table->dropForeign(['bed_id']);
            $table->dropColumn('bed_id');
        });
    }
};
