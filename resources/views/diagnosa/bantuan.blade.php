@extends('layouts.app')

@section('title', 'Bantuan & Informasi')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center mb-6">
            <i class="fas fa-question-circle text-blue-600 text-2xl mr-3"></i>
            <h1 class="text-2xl font-bold text-gray-800">Bantuan & Informasi Sistem</h1>
        </div>

        <!-- Informasi Metode Forward Chaining -->
        <div class="mb-8">
            <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg mb-6">
                <h2 class="text-xl font-bold text-blue-800 mb-3 flex items-center">
                    <i class="fas fa-sitemap mr-2"></i>Tentang Forward Chaining
                </h2>
                <p class="text-blue-700 mb-3">
                    Sistem ini menggunakan metode <strong>Forward Chaining</strong> untuk mendiagnosa kerusakan laptop. 
                    Forward Chaining adalah metode inferensi yang bekerja dari fakta menuju kesimpulan.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div class="text-center p-4 bg-white rounded-lg border border-blue-200">
                        <i class="fas fa-list-check text-blue-600 text-2xl mb-2"></i>
                        <h3 class="font-semibold text-blue-800">1. Input Fakta</h3>
                        <p class="text-sm text-blue-600">User memilih gejala yang dialami</p>
                    </div>
                    <div class="text-center p-4 bg-white rounded-lg border border-blue-200">
                        <i class="fas fa-gears text-green-600 text-2xl mb-2"></i>
                        <h3 class="font-semibold text-green-800">2. Proses Rules</h3>
                        <p class="text-sm text-green-600">Sistem memproses rules yang sesuai</p>
                    </div>
                    <div class="text-center p-4 bg-white rounded-lg border border-blue-200">
                        <i class="fas fa-flag text-red-600 text-2xl mb-2"></i>
                        <h3 class="font-semibold text-red-800">3. Hasil Diagnosa</h3>
                        <p class="text-sm text-red-600">Menghasilkan kesimpulan kerusakan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Gejala -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-list mr-2"></i>Daftar Gejala yang Tersedia
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($gejala as $item)
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-semibold text-gray-800">{{ $item->nama_gejala }}</h3>
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                            {{ $item->kode_gejala }}
                        </span>
                    </div>
                    @if($item->deskripsi)
                    <p class="text-sm text-gray-600 mb-2">{{ $item->deskripsi }}</p>
                    @endif
                    <div class="flex items-center text-xs text-gray-500">
                        <span class="bg-gray-200 px-2 py-1 rounded capitalize mr-2">{{ $item->kategori }}</span>
                        <span class="{{ $item->is_aktif ? 'text-green-600' : 'text-red-600' }}">
                            {{ $item->is_aktif ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Daftar Kerusakan -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-bug mr-2"></i>Daftar Jenis Kerusakan
            </h2>
            <div class="space-y-4">
                @foreach($kerusakan as $item)
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-semibold text-gray-800">{{ $item->nama_kerusakan }}</h3>
                        <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded">
                            {{ $item->kode_kerusakan }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">{{ $item->deskripsi }}</p>
                    <div class="flex items-center text-xs text-gray-500 space-x-2">
                        <span class="bg-gray-200 px-2 py-1 rounded capitalize">{{ $item->kategori }}</span>
                        <span class="bg-orange-100 px-2 py-1 rounded capitalize">{{ $item->tingkat_kerusakan }}</span>
                        @if($item->is_final)
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded">Final Conclusion</span>
                        @endif
                    </div>
                    <div class="mt-2 p-3 bg-yellow-50 rounded border border-yellow-200">
                        <h4 class="font-semibold text-yellow-800 text-sm mb-1">Solusi:</h4>
                        <p class="text-sm text-yellow-700">{{ $item->solusi }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Cara Penggunaan -->
        <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded-lg">
            <h2 class="text-xl font-bold text-green-800 mb-3 flex items-center">
                <i class="fas fa-play-circle mr-2"></i>Cara Menggunakan Sistem
            </h2>
            <ol class="list-decimal list-inside space-y-2 text-green-700">
                <li>Pergi ke halaman <strong>Diagnosa</strong></li>
                <li>Pilih gejala-gejala yang sesuai dengan kondisi laptop Anda</li>
                <li>Klik tombol <strong>"Proses Diagnosa"</strong></li>
                <li>Sistem akan memproses menggunakan Forward Chaining</li>
                <li>Lihat hasil diagnosa dan solusi yang direkomendasikan</li>
                <li>Simpan riwayat diagnosa untuk referensi masa depan</li>
            </ol>
        </div>
    </div>
</div>
@endsection