<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            if (! Schema::hasColumn('pendaftarans', 'pasien_id')) {
                $table->unsignedBigInteger('pasien_id')->nullable()->after('no_daftar')->index();
                // foreign key optional (commented out to avoid issues if pasien table not present)
                // $table->foreign('pasien_id')->references('id')->on('pasien')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            if (Schema::hasColumn('pendaftarans', 'pasien_id')) {
                // if (Schema::hasColumn('pendaftarans', 'pasien_id')) {
                //     $table->dropForeign(['pasien_id']);
                // }
                $table->dropColumn('pasien_id');
            }
        });
    }
};
