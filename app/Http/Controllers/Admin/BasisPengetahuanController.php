<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BasisPengetahuan;
use App\Models\Kerusakan;
use App\Models\Gejala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BasisPengetahuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $basisPengetahuan = BasisPengetahuan::with(['kerusakan', 'gejala'])
            ->aktif()
            ->orderBy('kerusakan_id')
            ->orderBy('urutan')
            ->get();

        $kerusakanList = Kerusakan::all();
        $gejalaList = Gejala::aktif()->get();

        return view('admin.basis-pengetahuan.index', compact(
            'basisPengetahuan', 
            'kerusakanList', 
            'gejalaList'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kerusakanList = Kerusakan::all();
        $gejalaList = Gejala::aktif()->get();
        
        return view('admin.basis-pengetahuan.create', compact('kerusakanList', 'gejalaList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kerusakan_id' => 'required|exists:kerusakan,id',
            'gejala_id' => 'required|exists:gejala,id',
            'urutan' => 'required|integer|min:1'
        ]);

        try {
            DB::beginTransaction();

            // Cek apakah kombinasi sudah ada
            $existing = BasisPengetahuan::where('kerusakan_id', $request->kerusakan_id)
                ->where('gejala_id', $request->gejala_id)
                ->first();

            if ($existing) {
                return redirect()->back()
                    ->with('error', 'Kombinasi kerusakan dan gejala sudah ada dalam basis pengetahuan.')
                    ->withInput();
            }

            BasisPengetahuan::create([
                'kerusakan_id' => $request->kerusakan_id,
                'gejala_id' => $request->gejala_id,
                'urutan' => $request->urutan,
                'is_aktif' => true
            ]);

            DB::commit();

            return redirect()->route('admin.basis-pengetahuan.index')
                ->with('success', 'Basis pengetahuan berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BasisPengetahuan $basisPengetahuan)
    {
        $basisPengetahuan->load(['kerusakan', 'gejala']);
        return view('admin.basis-pengetahuan.show', compact('basisPengetahuan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BasisPengetahuan $basisPengetahuan)
    {
        $basisPengetahuan->load(['kerusakan', 'gejala']);
        $kerusakanList = Kerusakan::all();
        $gejalaList = Gejala::aktif()->get();
        
        return view('admin.basis-pengetahuan.edit', compact('basisPengetahuan', 'kerusakanList', 'gejalaList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BasisPengetahuan $basisPengetahuan)
    {
        $request->validate([
            'urutan' => 'required|integer|min:1',
            'is_aktif' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            $data = $request->only(['urutan']);
            $data['is_aktif'] = $request->has('is_aktif');

            $basisPengetahuan->update($data);

            DB::commit();

            return redirect()->route('admin.basis-pengetahuan.index')
                ->with('success', 'Basis pengetahuan berhasil diupdate.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BasisPengetahuan $basisPengetahuan)
    {
        try {
            DB::beginTransaction();

            $basisPengetahuan->delete();

            DB::commit();

            return redirect()->route('admin.basis-pengetahuan.index')
                ->with('success', 'Basis pengetahuan berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.basis-pengetahuan.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Toggle status aktif/nonaktif - ✅ DIPERBAIKI
     */
    // Method toggleStatus yang diperbaiki
public function toggleStatus($id)
{
    try {
        $basisPengetahuan = BasisPengetahuan::findOrFail($id);
        
        $basisPengetahuan->update([
            'is_aktif' => !$basisPengetahuan->is_aktif
        ]);

        $status = $basisPengetahuan->is_aktif ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->route('admin.basis-pengetahuan.index')
            ->with('success', "Rule berhasil $status.");

    } catch (\Exception $e) {
        return redirect()->route('admin.basis-pengetahuan.index')
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

    /**
     * Get basis pengetahuan by kerusakan (API)
     */
    public function getByKerusakan($kerusakanId)
    {
        $basisPengetahuan = BasisPengetahuan::with(['gejala'])
            ->where('kerusakan_id', $kerusakanId)
            ->aktif()
            ->orderBy('urutan')
            ->get();

        return response()->json($basisPengetahuan);
    }

    /**
     * Get available gejala for kerusakan (API)
     */
    public function getAvailableGejala($kerusakanId)
    {
        $usedGejalaIds = BasisPengetahuan::where('kerusakan_id', $kerusakanId)
            ->pluck('gejala_id');

        $availableGejala = Gejala::aktif()
            ->whereNotIn('id', $usedGejalaIds)
            ->orderBy('kode_gejala')
            ->get();

        return response()->json($availableGejala);
    }
}