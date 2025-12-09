<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class AddBpjsFieldsToPasienTable extends Migration
{
    public function up()
    {
        Schema::table('pasien', function (Blueprint $table) {
            // Data demografis yang hilang
            $table->string('tempat_lahir')->nullable()->after('nik');
            $table->string('rt_rw')->nullable()->after('alamat');
            $table->string('kelurahan')->nullable()->after('rt_rw');
            $table->string('kecamatan')->nullable()->after('kelurahan');
            $table->string('kota')->nullable()->after('kecamatan');
            $table->string('provinsi')->nullable()->after('kota');
            $table->string('kode_pos', 10)->nullable()->after('provinsi');
            
            // Kontak darurat
            $table->string('nama_keluarga')->nullable()->after('email');
            $table->string('hubungan_keluarga')->nullable()->after('nama_keluarga');
            $table->string('telepon_keluarga')->nullable()->after('hubungan_keluarga');
            
            // Jenis pembayaran & BPJS
            $table->enum('jenis_pembayaran', ['Umum', 'BPJS', 'Asuransi'])->default('Umum')->after('telepon_keluarga');
            $table->string('no_bpjs', 20)->nullable()->after('jenis_pembayaran');
            $table->string('scan_bpjs')->nullable()->after('no_bpjs'); // Path file scan kartu BPJS
            
            // Asuransi swasta
            $table->string('nama_asuransi')->nullable()->after('scan_bpjs');
            $table->string('no_polis')->nullable()->after('nama_asuransi');
            
            // Riwayat medis
            $table->text('alergi_obat')->nullable()->after('no_polis');
            $table->text('riwayat_penyakit')->nullable()->after('alergi_obat');
        });
    }
    public function down()
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropColumn([
                'tempat_lahir', 'rt_rw', 'kelurahan', 'kecamatan', 'kota', 'provinsi', 'kode_pos',
                'nama_keluarga', 'hubungan_keluarga', 'telepon_keluarga',
                'jenis_pembayaran', 'no_bpjs', 'scan_bpjs',
                'nama_asuransi', 'no_polis',
                'alergi_obat', 'riwayat_penyakit'
            ]);
        });
    }
}