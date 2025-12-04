<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    use HasFactory;

    protected $table = 'gejala';
    
    protected $fillable = [
        'kode_gejala',
        'nama_gejala', 
        'deskripsi',
        'kategori',
        'is_aktif'
    ];

    protected $casts = [
        'is_aktif' => 'boolean'
    ];

    /**
     * Relationship with basis pengetahuan
     */
    public function basisPengetahuan()
    {
        return $this->hasMany(BasisPengetahuan::class);
    }

    /**
     * Relationship with kerusakan through basis pengetahuan
     */
    public function kerusakan()
    {
        return $this->belongsToMany(Kerusakan::class, 'basis_pengetahuan', 'gejala_id', 'kerusakan_id')
                    ->withPivot('urutan', 'is_aktif')
                    ->withTimestamps();
    }

    /**
     * Scope for active gejala - HANYA SATU VERSI INI YANG DIPAKAI
     */
    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }

    /**
     * Scope for inactive gejala
     */
    public function scopeNonaktif($query)
    {
        return $query->where('is_aktif', false);
    }

    /**
     * Scope by kategori
     */
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Get gejala with related kerusakan count
     */
    public function scopeWithKerusakanCount($query)
    {
        return $query->withCount(['basisPengetahuan as total_kerusakan' => function($q) {
            $q->where('is_aktif', true);
        }]);
    }

    /**
     * Check if gejala can be deleted
     */
    public function canDelete()
    {
        return $this->basisPengetahuan()->count() === 0;
    }

    /**
     * Toggle status aktif/nonaktif
     */
    public function toggleStatus()
    {
        $this->is_aktif = !$this->is_aktif;
        return $this->save();
    }

    /**
     * Get formatted kode and nama
     */
    public function getKodeNamaAttribute()
    {
        return "{$this->kode_gejala} - {$this->nama_gejala}";
    }

    /**
     * Get kategori options
     */
    public static function getKategoriOptions()
    {
        return [
            'hardware' => 'Hardware',
            'software' => 'Software', 
            'battery' => 'Battery',
            'display' => 'Display',
            'other' => 'Other'
        ];
    }

    /**
     * Get kategori label
     */
    public function getKategoriLabelAttribute()
    {
        $options = self::getKategoriOptions();
        return $options[$this->kategori] ?? $this->kategori;
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return $this->is_aktif ? 
            '<span class="badge bg-success">Aktif</span>' :
            '<span class="badge bg-danger">Nonaktif</span>';
    }
}