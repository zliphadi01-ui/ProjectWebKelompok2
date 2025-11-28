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
        Schema::table('pemeriksaans', function (Blueprint $table) {
            $table->string('tindak_lanjut')->nullable()->after('resep_obat'); // Pulang, Rawat Inap, Rujuk, Kontrol
            $table->text('keterangan_tindak_lanjut')->nullable()->after('tindak_lanjut'); // Catatan tambahan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemeriksaans', function (Blueprint $table) {
            $table->dropColumn(['tindak_lanjut', 'keterangan_tindak_lanjut']);
        });
    }
};
