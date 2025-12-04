<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use App\Models\History;
use App\Models\Kerusakan;
use App\Services\ForwardChainingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DiagnosaController extends Controller
{
    protected $fcService;

    public function __construct(ForwardChainingService $fcService)
    {
        $this->fcService = $fcService;
    }

    /**
     * Tampilkan form diagnosa
     */
    public function index()
    {
        $gejalaByKategori = $this->fcService->getGejalaByKategori();
        return view('diagnosa.index', compact('gejalaByKategori'));
    }

    /**
     * Proses diagnosa dengan Forward Chaining
     */
    public function proses(Request $request)
    {
        try {
            Log::info('Memulai proses Forward Chaining', $request->all());

            // Validasi input
            $request->validate([
                'gejala' => 'required|array|min:1',
                'gejala.*' => 'exists:gejala,id'
            ]);

            $gejalaIds = $request->gejala;
            Log::info('Gejala yang dipilih:', $gejalaIds);

            // Proses dengan Forward Chaining
           $hasil = $this->fcService->prosesDiagnosa($gejalaIds);

// Simpan riwayat dengan format yang benar
$history = History::create([
    'user_id' => auth()->id(),
    'nama_pengguna' => auth()->user()->name,
    'email' => auth()->user()->email,
    'gejala_terpilih' => $gejalaIds,
    'fakta_terbukti' => $hasil['fakta_terbukti'],
    'rules_tertrigger' => $hasil['rules_tertrigger'],
    'hasil_akhir' => $hasil['kesimpulan_akhir']['kerusakan']['nama_kerusakan'] ?? 'Tidak dapat didiagnosa',
    'langkah_diagnosa' => $hasil['total_langkah'],
    'hasil_diagnosa' => $hasil
]);

            Log::info('History berhasil disimpan:', ['history_id' => $history->id]);

            return view('diagnosa.hasil', compact('hasil', 'gejalaIds'));

        } catch (\Exception $e) {
            Log::error('Error dalam proses diagnosa: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return back()
                ->with('error', 'Terjadi kesalahan dalam proses diagnosa: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Tampilkan riwayat diagnosa user
     */
    public function riwayat()
    {
        $histories = auth()->check() 
            ? History::where('user_id', auth()->id())->latest()->get()
            : collect();

        return view('diagnosa.riwayat', compact('histories'));
    }

    /**
     * Detail riwayat diagnosa
     */
    public function detailRiwayat($id)
    {
        $history = History::where('user_id', auth()->id())->findOrFail($id);
        return view('diagnosa.detail-riwayat', compact('history'));
    }

    /**
     * Halaman bantuan
     */
    public function bantuan()
    {
        $gejala = Gejala::where('is_aktif', true)->get();
        $kerusakan = Kerusakan::all();
        
        return view('diagnosa.bantuan', compact('gejala', 'kerusakan'));
    }

    /**
     * Cetak hasil diagnosa
     */
    public function cetakHasil($id)
    {
        $history = History::where('user_id', auth()->id())->findOrFail($id);
        
        // Untuk sementara redirect ke detail
        return redirect()->route('diagnosa.detail', $id)
            ->with('info', 'Fitur cetak PDF akan segera tersedia.');
    }
}