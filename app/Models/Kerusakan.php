<?php
// app/Models/Kerusakan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kerusakan extends Model
{
    use HasFactory;

    protected $table = 'kerusakan';
    protected $fillable = [
        'kode_kerusakan', 
        'nama_kerusakan', 
        'deskripsi', 
        'solusi',
        'kategori',
        'tingkat_kerusakan',
        'is_final'
    ];

    public function basisPengetahuan()
    {
        return $this->hasMany(BasisPengetahuan::class);
    }

    // Scope untuk kerusakan final
    public function scopeFinal($query)
    {
        return $query->where('is_final', true);
    }

    // Method untuk mendapatkan rules aktif
    public function getRulesAktifAttribute()
    {
        return $this->basisPengetahuan()->aktif()->berurutan()->get();
    }
}