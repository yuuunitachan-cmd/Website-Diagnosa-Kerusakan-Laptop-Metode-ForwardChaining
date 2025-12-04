<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // 1. UPDATE TABLE basis_pengetahuan - HAPUS BOBOT, TAMBAH URUTAN
        Schema::table('basis_pengetahuan', function (Blueprint $table) {
            // Hapus kolom bobot (karena FC tidak pakai bobot)
            $table->dropColumn('bobot');
            
            // Tambah kolom baru untuk FC
            $table->integer('urutan')->default(1)->after('gejala_id');
            $table->boolean('is_aktif')->default(true)->after('urutan');
        });

        // 2. UPDATE TABLE histories - HAPUS KOLOM CF, TAMBAH KOLOM FC
        Schema::table('histories', function (Blueprint $table) {
            // Hapus kolom yang terkait CF
            $table->dropColumn(['kerusakan_terdiagnosa', 'cf_tertinggi']);
            
            // Tambah kolom untuk Forward Chaining
            $table->json('fakta_terbukti')->nullable()->after('gejala_terpilih');
            $table->json('rules_tertrigger')->nullable()->after('fakta_terbukti');
            $table->string('hasil_akhir')->nullable()->after('rules_tertrigger');
            $table->integer('langkah_diagnosa')->default(0)->after('hasil_akhir');
        });

        // 3. UPDATE TABLE kerusakan - TAMBAH KOLOM IS_FINAL
        Schema::table('kerusakan', function (Blueprint $table) {
            $table->boolean('is_final')->default(true)->after('tingkat_kerusakan');
        });

        // 4. UPDATE TABLE gejala - PASTIKAN KOLOM SUDAH ADA
        // Kolom kategori dan is_aktif sudah ada di database Anda, jadi tidak perlu perubahan
    }

    public function down()
    {
        // ROLLBACK jika perlu undo migration
        
        // Rollback basis_pengetahuan
        Schema::table('basis_pengetahuan', function (Blueprint $table) {
            $table->double('bobot', 8, 2)->nullable();
            $table->dropColumn(['urutan', 'is_aktif']);
        });

        // Rollback histories  
        Schema::table('histories', function (Blueprint $table) {
            $table->string('kerusakan_terdiagnosa')->nullable();
            $table->double('cf_tertinggi', 8, 2)->nullable();
            $table->dropColumn(['fakta_terbukti', 'rules_tertrigger', 'hasil_akhir', 'langkah_diagnosa']);
        });

        // Rollback kerusakan
        Schema::table('kerusakan', function (Blueprint $table) {
            $table->dropColumn('is_final');
        });
    }
};