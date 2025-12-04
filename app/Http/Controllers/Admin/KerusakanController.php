<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kerusakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KerusakanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kerusakan = Kerusakan::withCount(['basisPengetahuan as total_gejala' => function($q) {
                        $q->where('is_aktif', true);
                    }])
                    ->orderBy('kode_kerusakan')
                    ->get();
                    
        return view('admin.kerusakan.index', compact('kerusakan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoriOptions = [
            'hardware' => 'Hardware',
            'software' => 'Software',
            'battery' => 'Battery', 
            'display' => 'Display',
            'other' => 'Other'
        ];

        $tingkatOptions = [
            'ringan' => 'Ringan',
            'sedang' => 'Sedang',
            'berat' => 'Berat'
        ];

        return view('admin.kerusakan.create', compact('kategoriOptions', 'tingkatOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_kerusakan' => 'required|unique:kerusakan,kode_kerusakan|max:10',
            'nama_kerusakan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'solusi' => 'required|string',
            'kategori' => 'required|in:hardware,software,battery,display,other',
            'tingkat_kerusakan' => 'required|in:ringan,sedang,berat'
        ]);

        try {
            DB::beginTransaction();

            Kerusakan::create($request->all());

            DB::commit();

            return redirect()->route('admin.kerusakan.index')
                ->with('success', 'Data kerusakan berhasil ditambahkan.');

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
    public function show(Kerusakan $kerusakan)
    {
        $kerusakan->load(['basisPengetahuan.gejala']);
        return view('admin.kerusakan.show', compact('kerusakan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kerusakan $kerusakan)
    {
        $kategoriOptions = [
            'hardware' => 'Hardware',
            'software' => 'Software',
            'battery' => 'Battery',
            'display' => 'Display',
            'other' => 'Other'
        ];

        $tingkatOptions = [
            'ringan' => 'Ringan',
            'sedang' => 'Sedang', 
            'berat' => 'Berat'
        ];

        return view('admin.kerusakan.edit', compact('kerusakan', 'kategoriOptions', 'tingkatOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kerusakan $kerusakan)
    {
        $request->validate([
            'kode_kerusakan' => 'required|unique:kerusakan,kode_kerusakan,' . $kerusakan->id . '|max:10',
            'nama_kerusakan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'solusi' => 'required|string',
            'kategori' => 'required|in:hardware,software,battery,display,other',
            'tingkat_kerusakan' => 'required|in:ringan,sedang,berat'
        ]);

        try {
            DB::beginTransaction();

            $kerusakan->update($request->all());

            DB::commit();

            return redirect()->route('admin.kerusakan.index')
                ->with('success', 'Data kerusakan berhasil diupdate.');

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
    public function destroy(Kerusakan $kerusakan)
    {
        try {
            DB::beginTransaction();

            // Cek apakah kerusakan memiliki relasi di basis pengetahuan
            if ($kerusakan->basisPengetahuan()->count() > 0) {
                return redirect()->route('admin.kerusakan.index')
                    ->with('error', 'Tidak dapat menghapus kerusakan karena masih terkait dengan basis pengetahuan.');
            }

            $kerusakan->delete();

            DB::commit();

            return redirect()->route('admin.kerusakan.index')
                ->with('success', 'Data kerusakan berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.kerusakan.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get kerusakan by kategori (API)
     */
    public function getByKategori($kategori)
    {
        $kerusakan = Kerusakan::where('kategori', $kategori)
                            ->orderBy('kode_kerusakan')
                            ->get();

        return response()->json($kerusakan);
    }
}