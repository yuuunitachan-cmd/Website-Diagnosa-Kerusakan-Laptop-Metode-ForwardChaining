<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Kerusakan;
use App\Models\Gejala;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display welcome page for guests
     */
    public function welcome()
    {
        $totalDiagnosa = History::count();
        $totalGejala = Gejala::count();
        $totalKerusakan = Kerusakan::count();

        return view('welcome', compact('totalDiagnosa', 'totalGejala', 'totalKerusakan'));
    }

    /**
     * Display user dashboard
     */
    public function userDashboard()
    {
        $riwayatCount = History::where('user_id', auth()->id())->count();
        $gejalaCount = Gejala::where('is_aktif', true)->count();
        $kerusakanCount = Kerusakan::count();
        $riwayatTerbaru = History::where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('riwayatCount', 'gejalaCount', 'kerusakanCount', 'riwayatTerbaru'));
    }

    /**
     * Display admin dashboard
     */
    public function adminDashboard()
    {
        // Basic Statistics
        $totalDiagnosa = History::count();
        $totalUser = User::where('role', 'user')->count();
        $totalGejala = Gejala::count();
        $totalKerusakan = Kerusakan::count();
        $totalRules = \App\Models\BasisPengetahuan::count();

        // Today's statistics
        $diagnosaHariIni = History::whereDate('created_at', today())->count();
        $userBaruHariIni = User::where('role', 'user')
            ->whereDate('created_at', today())
            ->count();

        // Weekly statistics
        $diagnosaMingguIni = History::whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->count();

        // Recent data
        $diagnosaTerbaru = History::with('user')
            ->latest()
            ->take(5)
            ->get();

        $userTerbaru = User::where('role', 'user')
            ->latest()
            ->take(5)
            ->get();

        // Statistics for charts
        $statistikKerusakan = History::selectRaw('hasil_akhir, COUNT(*) as total')
            ->whereNotNull('hasil_akhir')
            ->where('hasil_akhir', '!=', 'Tidak dapat didiagnosa')
            ->groupBy('hasil_akhir')
            ->orderBy('total', 'DESC')
            ->take(5)
            ->get();

        // Monthly statistics for chart
        $monthlyDiagnosa = $this->getMonthlyDiagnosa();

        // System health
        $gejalaAktif = Gejala::where('is_aktif', true)->count();
        $rulesAktif = \App\Models\BasisPengetahuan::where('is_aktif', true)->count();
        $gejalaTanpaRules = $this->getGejalaTanpaRules();

        return view('admin.dashboard', compact(
            'totalDiagnosa',
            'totalUser', 
            'totalGejala',
            'totalKerusakan',
            'totalRules',
            'diagnosaHariIni',
            'userBaruHariIni',
            'diagnosaMingguIni',
            'diagnosaTerbaru',
            'userTerbaru',
            'statistikKerusakan',
            'monthlyDiagnosa',
            'gejalaAktif',
            'rulesAktif',
            'gejalaTanpaRules'
        ));
    }

    /**
     * Get monthly diagnosa data for chart
     */
    private function getMonthlyDiagnosa()
    {
        $currentYear = now()->year;
        
        $monthlyData = History::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Fill missing months with zero
        $allMonths = collect(range(1, 12))->mapWithKeys(function ($month) use ($monthlyData) {
            $data = $monthlyData->firstWhere('month', $month);
            return [$month => $data ? $data->total : 0];
        });

        return $allMonths;
    }

    /**
     * Get gejala without rules
     */
    private function getGejalaTanpaRules()
    {
        return Gejala::where('is_aktif', true)
            ->whereDoesntHave('basisPengetahuan')
            ->count();
    }
}