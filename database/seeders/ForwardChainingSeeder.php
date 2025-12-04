<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ForwardChainingSeeder extends Seeder
{
    public function run()
    {
        // KOSONGKAN DATA LAMA basis_pengetahuan
        DB::table('basis_pengetahuan')->truncate();

        // DATA RULES FORWARD CHAINING BARU
        $rules = [
            // ===== RULES UNTUK HARDWARE FAILURE (K001) =====
            ['kerusakan_id' => 1, 'gejala_id' => 1, 'urutan' => 1, 'is_aktif' => 1],  // IF G001 THEN K001
            ['kerusakan_id' => 1, 'gejala_id' => 2, 'urutan' => 2, 'is_aktif' => 1],  // IF G002 THEN K001
            ['kerusakan_id' => 1, 'gejala_id' => 7, 'urutan' => 3, 'is_aktif' => 1],  // IF G007 THEN K001

            // ===== RULES UNTUK SOFTWARE CORRUPTION (K002) =====
            ['kerusakan_id' => 2, 'gejala_id' => 3, 'urutan' => 1, 'is_aktif' => 1],  // IF G003 THEN K002
            ['kerusakan_id' => 2, 'gejala_id' => 4, 'urutan' => 2, 'is_aktif' => 1],  // IF G004 THEN K002

            // ===== RULES UNTUK BATTERY PROBLEM (K003) =====
            ['kerusakan_id' => 3, 'gejala_id' => 5, 'urutan' => 1, 'is_aktif' => 1],  // IF G005 THEN K003
            ['kerusakan_id' => 3, 'gejala_id' => 10, 'urutan' => 2, 'is_aktif' => 1], // IF G010 THEN K003

            // ===== RULES UNTUK OVERHEATING (K004) =====
            ['kerusakan_id' => 4, 'gejala_id' => 6, 'urutan' => 1, 'is_aktif' => 1],  // IF G006 THEN K004
            ['kerusakan_id' => 4, 'gejala_id' => 9, 'urutan' => 2, 'is_aktif' => 1],  // IF G009 THEN K004

            // ===== RULES UNTUK DISPLAY ISSUE (K005) =====
            ['kerusakan_id' => 5, 'gejala_id' => 7, 'urutan' => 1, 'is_aktif' => 1],  // IF G007 THEN K005
            ['kerusakan_id' => 5, 'gejala_id' => 8, 'urutan' => 2, 'is_aktif' => 1],  // IF G008 THEN K005

            // ===== RULES UNTUK CRASH/HANG (K006) =====
            ['kerusakan_id' => 6, 'gejala_id' => 4, 'urutan' => 1, 'is_aktif' => 1],  // IF G004 THEN K006
            ['kerusakan_id' => 6, 'gejala_id' => 3, 'urutan' => 2, 'is_aktif' => 1],  // IF G003 THEN K006
        ];

        // INSERT DATA RULES BARU
        DB::table('basis_pengetahuan')->insert($rules);

        // UPDATE SEMUA KERUSAKAN SEBAGAI FINAL CONCLUSION
        DB::table('kerusakan')->update(['is_final' => true]);

        $this->command->info('✅ Data Forward Chaining berhasil di-seed!');
        $this->command->info('📊 Total Rules: ' . count($rules));
    }
}