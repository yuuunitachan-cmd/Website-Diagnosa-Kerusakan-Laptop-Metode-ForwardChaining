<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $histories = History::with('user')
            ->latest()
            ->paginate(10);
        
        $totalDiagnosa = History::count();
        $diagnosaHariIni = History::whereDate('created_at', today())->count();
        $diagnosaMingguIni = History::whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->count();

        $statistikKerusakan = History::selectRaw('hasil_akhir, COUNT(*) as total')
            ->whereNotNull('hasil_akhir')
            ->where('hasil_akhir', '!=', 'Tidak dapat didiagnosa')
            ->groupBy('hasil_akhir')
            ->orderBy('total', 'DESC')
            ->take(5)
            ->get();

        return view('admin.history.index', compact(
            'histories', 
            'totalDiagnosa',
            'diagnosaHariIni',
            'diagnosaMingguIni',
            'statistikKerusakan'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(History $history)
    {
        $history->load('user');
        return view('admin.history.show', compact('history'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(History $history)
    {
        try {
            DB::beginTransaction();

            $history->delete();

            DB::commit();

            return redirect()->route('admin.history.index')
                ->with('success', 'Riwayat diagnosa berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.history.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete histories
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:histories,id'
        ]);

        try {
            DB::beginTransaction();

            History::whereIn('id', $request->ids)->delete();

            DB::commit();

            return redirect()->route('admin.history.index')
                ->with('success', count($request->ids) . ' riwayat berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.history.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Export data (placeholder)
     */
    public function export(Request $request)
    {
        // Untuk fitur export data (bisa dikembangkan nanti)
        return redirect()->route('admin.history.index')
            ->with('info', 'Fitur export akan segera tersedia.');
    }

    /**
     * Get statistics data (API)
     */
    public function getStatistics()
    {
        $totalDiagnosa = History::count();
        $diagnosaHariIni = History::whereDate('created_at', today())->count();
        $diagnosaMingguIni = History::whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->count();
        $diagnosaBulanIni = History::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $topKerusakan = History::selectRaw('hasil_akhir, COUNT(*) as total')
            ->whereNotNull('hasil_akhir')
            ->where('hasil_akhir', '!=', 'Tidak dapat didiagnosa')
            ->groupBy('hasil_akhir')
            ->orderBy('total', 'DESC')
            ->take(5)
            ->get();

        return response()->json([
            'total_diagnosa' => $totalDiagnosa,
            'diagnosa_hari_ini' => $diagnosaHariIni,
            'diagnosa_minggu_ini' => $diagnosaMingguIni,
            'diagnosa_bulan_ini' => $diagnosaBulanIni,
            'top_kerusakan' => $topKerusakan
        ]);
    }

    /**
     * Get monthly statistics (API)
     */
    public function getMonthlyStatistics()
    {
        $monthlyData = History::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get();

        return response()->json($monthlyData);
    }
}