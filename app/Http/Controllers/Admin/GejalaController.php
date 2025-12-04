<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gejala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GejalaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gejala = Gejala::withKerusakanCount()
                        ->orderBy('kode_gejala')
                        ->get();
        
        return view('admin.gejala.index', compact('gejala'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoriOptions = Gejala::getKategoriOptions();
        return view('admin.gejala.create', compact('kategoriOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_gejala' => 'required|unique:gejala,kode_gejala|max:10',
            'nama_gejala' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|in:hardware,software,battery,display,other',
            'is_aktif' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            $data = $request->all();
            $data['is_aktif'] = $request->has('is_aktif');

            Gejala::create($data);

            DB::commit();

            return redirect()->route('admin.gejala.index')
                ->with('success', 'Data gejala berhasil ditambahkan.');

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
    public function show(Gejala $gejala)
    {
        $gejala->load(['basisPengetahuan.kerusakan']);
        return view('admin.gejala.show', compact('gejala'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gejala $gejala)
    {
        $kategoriOptions = Gejala::getKategoriOptions();
        return view('admin.gejala.edit', compact('gejala', 'kategoriOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gejala $gejala)
    {
        $request->validate([
            'kode_gejala' => 'required|unique:gejala,kode_gejala,' . $gejala->id . '|max:10',
            'nama_gejala' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|in:hardware,software,battery,display,other',
            'is_aktif' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            $data = $request->all();
            $data['is_aktif'] = $request->has('is_aktif');

            $gejala->update($data);

            DB::commit();

            return redirect()->route('admin.gejala.index')
                ->with('success', 'Data gejala berhasil diupdate.');

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
    public function destroy(Gejala $gejala)
    {
        try {
            DB::beginTransaction();

            // Cek apakah gejala memiliki relasi di basis pengetahuan
            if ($gejala->basisPengetahuan()->count() > 0) {
                return redirect()->route('admin.gejala.index')
                    ->with('error', 'Tidak dapat menghapus gejala karena masih terkait dengan basis pengetahuan.');
            }

            $gejala->delete();

            DB::commit();

            return redirect()->route('admin.gejala.index')
                ->with('success', 'Data gejala berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.gejala.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Toggle status aktif/nonaktif gejala
     */
    public function toggleStatus(Gejala $gejala)
    {
        try {
            $gejala->toggleStatus();
            
            $status = $gejala->is_aktif ? 'diaktifkan' : 'dinonaktifkan';
            
            return redirect()->route('admin.gejala.index')
                ->with('success', "Gejala berhasil $status.");

        } catch (\Exception $e) {
            return redirect()->route('admin.gejala.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get gejala by kategori (API)
     */
    public function getByKategori($kategori)
    {
        $gejala = Gejala::where('kategori', $kategori)
                        ->aktif()
                        ->orderBy('kode_gejala')
                        ->get();

        return response()->json($gejala);
    }
}