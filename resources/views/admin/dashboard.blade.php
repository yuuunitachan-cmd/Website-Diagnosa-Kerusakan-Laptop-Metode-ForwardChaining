@extends('admin.layout')

@section('title', 'Admin Dashboard')
@section('subtitle', 'Overview Sistem Pakar Diagnosa Laptop')

@section('content')
<div class="space-y-6">
    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Diagnosa -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg mr-4">
                    <i class="fas fa-stethoscope text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Diagnosa</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalDiagnosa }}</p>
                    <p class="text-xs text-green-600 mt-1">
                        <i class="fas fa-arrow-up mr-1"></i>
                        {{ $diagnosaHariIni }} hari ini
                    </p>
                </div>
            </div>
        </div>

        <!-- Total User -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg mr-4">
                    <i class="fas fa-users text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total User</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalUser }}</p>
                    <p class="text-xs text-green-600 mt-1">
                        <i class="fas fa-user-plus mr-1"></i>
                        {{ $userBaruHariIni }} baru hari ini
                    </p>
                </div>
            </div>
        </div>

        <!-- Data Master -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg mr-4">
                    <i class="fas fa-database text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Data Master</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalGejala + $totalKerusakan }}</p>
                    <p class="text-xs text-gray-600 mt-1">
                        {{ $totalGejala }} gejala • {{ $totalKerusakan }} kerusakan
                    </p>
                </div>
            </div>
        </div>

        <!-- Rules Aktif -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500">
            <div class="flex items-center">
                <div class="p-3 bg-orange-100 rounded-lg mr-4">
                    <i class="fas fa-sitemap text-orange-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Rules Aktif</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $rulesAktif }}/{{ $totalRules }}</p>
                    <p class="text-xs text-gray-600 mt-1">
                        {{ $gejalaAktif }}/{{ $totalGejala }} gejala aktif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Diagnosa -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-history mr-2"></i>Diagnosa Terbaru
                </h3>
                <a href="{{ route('admin.history.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                    Lihat Semua
                </a>
            </div>
            <div class="space-y-3">
                @forelse($diagnosaTerbaru as $history)
                <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                    <div>
                        <p class="font-medium text-gray-800">{{ $history->user->name ?? 'Guest' }}</p>
                        <p class="text-sm text-gray-600">{{ $history->hasil_akhir }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">{{ $history->created_at->format('H:i') }}</p>
                        <p class="text-xs text-gray-400">{{ $history->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-gray-500">
                    <i class="fas fa-inbox text-3xl mb-2"></i>
                    <p>Belum ada data diagnosa</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Top Kerusakan -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-chart-bar mr-2"></i>Kerusakan Terbanyak
                </h3>
            </div>
            <div class="space-y-3">
                @forelse($statistikKerusakan as $stat)
                <div class="space-y-1">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-700">{{ $stat->hasil_akhir }}</span>
                        <span class="font-medium text-gray-800">{{ $stat->total }} diagnosa</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        @php
                            $percentage = $totalDiagnosa > 0 ? ($stat->total / $totalDiagnosa) * 100 : 0;
                        @endphp
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-gray-500">
                    <i class="fas fa-chart-pie text-3xl mb-2"></i>
                    <p>Belum ada statistik</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- System Health -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-heartbeat mr-2"></i>System Health
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center p-4 border border-gray-200 rounded-lg">
                <div class="text-2xl font-bold text-green-600 mb-2">{{ $gejalaAktif }}</div>
                <p class="text-sm text-gray-600">Gejala Aktif</p>
                <p class="text-xs text-gray-500">{{ $gejalaTanpaRules }} tanpa rules</p>
            </div>
            <div class="text-center p-4 border border-gray-200 rounded-lg">
                <div class="text-2xl font-bold text-blue-600 mb-2">{{ $rulesAktif }}</div>
                <p class="text-sm text-gray-600">Rules Aktif</p>
                <p class="text-xs text-gray-500">dari {{ $totalRules }} total</p>
            </div>
            <div class="text-center p-4 border border-gray-200 rounded-lg">
                <div class="text-2xl font-bold text-purple-600 mb-2">{{ $diagnosaMingguIni }}</div>
                <p class="text-sm text-gray-600">Diagnosa Minggu Ini</p>
                <p class="text-xs text-gray-500">{{ $diagnosaHariIni }} hari ini</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-bolt mr-2"></i>Quick Actions
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.gejala.create') }}" class="bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg p-4 text-center transition">
                <i class="fas fa-plus text-blue-600 text-xl mb-2"></i>
                <p class="font-medium text-blue-800">Tambah Gejala</p>
            </a>
            <a href="{{ route('admin.kerusakan.create') }}" class="bg-green-50 hover:bg-green-100 border border-green-200 rounded-lg p-4 text-center transition">
                <i class="fas fa-plus text-green-600 text-xl mb-2"></i>
                <p class="font-medium text-green-800">Tambah Kerusakan</p>
            </a>
            <a href="{{ route('admin.basis-pengetahuan.create') }}" class="bg-purple-50 hover:bg-purple-100 border border-purple-200 rounded-lg p-4 text-center transition">
                <i class="fas fa-plus text-purple-600 text-xl mb-2"></i>
                <p class="font-medium text-purple-800">Tambah Rule</p>
            </a>
            <a href="{{ route('admin.history.index') }}" class="bg-orange-50 hover:bg-orange-100 border border-orange-200 rounded-lg p-4 text-center transition">
                <i class="fas fa-chart-line text-orange-600 text-xl mb-2"></i>
                <p class="font-medium text-orange-800">Lihat Laporan</p>
            </a>
        </div>
    </div>
</div>
@endsection