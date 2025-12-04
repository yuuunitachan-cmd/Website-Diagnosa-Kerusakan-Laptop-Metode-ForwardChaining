@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center mb-6">
            <i class="fas fa-tachometer-alt text-blue-600 text-2xl mr-3"></i>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                <div class="flex items-center">
                    <i class="fas fa-history text-blue-600 text-3xl mr-4"></i>
                    <div>
                        <p class="text-sm text-blue-600">Total Diagnosa</p>
                        <p class="text-3xl font-bold text-blue-800">{{ $riwayatCount }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-green-50 p-6 rounded-lg border border-green-200">
                <div class="flex items-center">
                    <i class="fas fa-list-check text-green-600 text-3xl mr-4"></i>
                    <div>
                        <p class="text-sm text-green-600">Gejala Tersedia</p>
                        <p class="text-3xl font-bold text-green-800">{{ $gejalaCount }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-purple-50 p-6 rounded-lg border border-purple-200">
                <div class="flex items-center">
                    <i class="fas fa-bug text-purple-600 text-3xl mr-4"></i>
                    <div>
                        <p class="text-sm text-purple-600">Jenis Kerusakan</p>
                        <p class="text-3xl font-bold text-purple-800">{{ $kerusakanCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <a href="{{ route('diagnosa.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white p-6 rounded-lg transition transform hover:scale-105 flex items-center">
                <i class="fas fa-stethoscope text-3xl mr-4"></i>
                <div>
                    <h3 class="text-xl font-bold">Diagnosa Baru</h3>
                    <p class="text-blue-100">Periksa kerusakan laptop Anda</p>
                </div>
            </a>
            <a href="{{ route('diagnosa.riwayat') }}" class="bg-green-600 hover:bg-green-700 text-white p-6 rounded-lg transition transform hover:scale-105 flex items-center">
                <i class="fas fa-history text-3xl mr-4"></i>
                <div>
                    <h3 class="text-xl font-bold">Riwayat Diagnosa</h3>
                    <p class="text-green-100">Lihat diagnosa sebelumnya</p>
                </div>
            </a>
        </div>

        <!-- Riwayat Terbaru -->
        @if($riwayatTerbaru->count() > 0)
        <div class="bg-gray-50 rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-clock mr-2"></i>Diagnosa Terbaru
            </h2>
            <div class="space-y-3">
                @foreach($riwayatTerbaru as $history)
                <div class="bg-white p-4 rounded-lg border border-gray-200 hover:shadow-md transition">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $history->hasil_akhir }}</h3>
                            <p class="text-sm text-gray-600">{{ $history->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <a href="{{ route('diagnosa.detail', $history->id) }}" class="text-blue-600 hover:text-blue-800 transition flex items-center">
                            <i class="fas fa-eye mr-1"></i> Detail
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection