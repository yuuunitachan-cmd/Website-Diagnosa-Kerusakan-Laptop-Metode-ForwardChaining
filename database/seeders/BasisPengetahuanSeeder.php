<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BasisPengetahuanSeeder extends Seeder
{
    public function run()
    {
        // Kosongkan tabel dulu
        DB::table('basis_pengetahuan')->delete();

        $rules = [
            // Hardware Failure (K001)
            ['kerusakan_id' => 1, 'gejala_id' => 1, 'urutan' => 1, 'is_aktif' => true],  // G001 - tidak bisa menyala
            ['kerusakan_id' => 1, 'gejala_id' => 2, 'urutan' => 2, 'is_aktif' => true],  // G002 - mati sendiri
            ['kerusakan_id' => 1, 'gejala_id' => 7, 'urutan' => 3, 'is_aktif' => true],  // G007 - layar blank
            
            // Software Corruption (K002)  
            ['kerusakan_id' => 2, 'gejala_id' => 3, 'urutan' => 1, 'is_aktif' => true],  // G003 - blue screen
            ['kerusakan_id' => 2, 'gejala_id' => 4, 'urutan' => 2, 'is_aktif' => true],  // G004 - lambat/hang
            
            // Battery Problem (K003)
            ['kerusakan_id' => 3, 'gejala_id' => 5, 'urutan' => 1, 'is_aktif' => true],  // G005 - tidak bisa charge
            ['kerusakan_id' => 3, 'gejala_id' => 10, 'urutan' => 2, 'is_aktif' => true], // G010 - baterai cepat habis
            
            // Overheating (K004)
            ['kerusakan_id' => 4, 'gejala_id' => 6, 'urutan' => 1, 'is_aktif' => true],  // G006 - cepat panas
            ['kerusakan_id' => 4, 'gejala_id' => 9, 'urutan' => 2, 'is_aktif' => true],  // G009 - kipas berisik
            
            // Display Issue (K005)
            ['kerusakan_id' => 5, 'gejala_id' => 7, 'urutan' => 1, 'is_aktif' => true],  // G007 - layar blank
            ['kerusakan_id' => 5, 'gejala_id' => 8, 'urutan' => 2, 'is_aktif' => true],  // G008 - garis di layar
        ];

        foreach ($rules as $rule) {
            DB::table('basis_pengetahuan')->insert(array_merge($rule, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
        
        $this->command->info('Basis pengetahuan berhasil di-seed!');
    }
}