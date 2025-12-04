<?php  
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'nama_pengguna', 
        'email', 
        'gejala_terpilih',
        'fakta_terbukti',
        'rules_tertrigger', 
        'hasil_akhir',
        'langkah_diagnosa',
        'hasil_diagnosa'
    ];

    protected $casts = [
        'gejala_terpilih' => 'array',
        'fakta_terbukti' => 'array',
        'rules_tertrigger' => 'array',
        'hasil_diagnosa' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Method untuk mendapatkan kesimpulan
    public function getKesimpulanAttribute()
    {
        return $this->hasil_akhir ?? 'Tidak dapat didiagnosa';
    }
}