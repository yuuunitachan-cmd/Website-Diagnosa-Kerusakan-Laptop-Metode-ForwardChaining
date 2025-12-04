<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasisPengetahuan extends Model
{
    use HasFactory;

    protected $table = 'basis_pengetahuan';
    protected $fillable = ['kerusakan_id', 'gejala_id', 'urutan', 'is_aktif'];

    public function kerusakan()
    {
        return $this->belongsTo(Kerusakan::class);
    }

    public function gejala()
    {
        return $this->belongsTo(Gejala::class);
    }

    // Scope untuk rules aktif
    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }

    // Scope untuk urutan
    public function scopeBerurutan($query)
    {
        return $query->orderBy('urutan');
    }
}