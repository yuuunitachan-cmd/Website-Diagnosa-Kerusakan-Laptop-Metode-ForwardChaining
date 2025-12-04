<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Hapus tabel basis_pengetahuan lama jika ada struktur salah
        Schema::dropIfExists('basis_pengetahuans');
        
        // 2. Buat tabel basis_pengetahuan yang benar
        if (!Schema::hasTable('basis_pengetahuan')) {
            Schema::create('basis_pengetahuan', function (Blueprint $table) {
                $table->id();
                $table->foreignId('kerusakan_id')->constrained('kerusakans')->onDelete('cascade');
                $table->foreignId('gejala_id')->constrained('gejalas')->onDelete('cascade');
                $table->integer('urutan')->default(1);
                $table->boolean('is_aktif')->default(true);
                $table->timestamps();
                
                $table->unique(['kerusakan_id', 'gejala_id']);
            });
        }

        // 3. Update tabel histories - tambah kolom yang missing
        Schema::table('histories', function (Blueprint $table) {
            if (!Schema::hasColumn('histories', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('histories', 'fakta_terbukti')) {
                $table->json('fakta_terbukti')->nullable();
            }
            if (!Schema::hasColumn('histories', 'rules_tertrigger')) {
                $table->json('rules_tertrigger')->nullable();
            }
            if (!Schema::hasColumn('histories', 'hasil_akhir')) {
                $table->string('hasil_akhir')->nullable();
            }
            if (!Schema::hasColumn('histories', 'langkah_diagnosa')) {
                $table->integer('langkah_diagnosa')->default(0);
            }
        });
    }

    public function down()
    {
        // Untuk rollback
        Schema::dropIfExists('basis_pengetahuan');
        
        Schema::table('histories', function (Blueprint $table) {
            $table->dropColumn([
                'user_id', 
                'fakta_terbukti', 
                'rules_tertrigger', 
                'hasil_akhir', 
                'langkah_diagnosa'
            ]);
        });
    }
};