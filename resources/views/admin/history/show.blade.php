@extends('admin.layout')

@section('title', 'Detail Riwayat Diagnosa')
@section('subtitle', 'Detail lengkap proses diagnosa')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Header -->
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Detail Diagnosa</h2>
                <p class="text-gray-600">Proses lengkap Forward Chaining</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.history.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>

        @php
            $hasil = $history->hasil_diagnosa;
        @endphp

        <!-- User Info -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                <div class="flex items-center">
                    <i class="fas fa-user text-blue-600 mr-3"></i>
                    <div>
                        <p class="text-sm text-blue-600">Pengguna</p>
                        <p class="font-semibold text-blue-800">{{ $history->nama_pengguna }}</p>
                        <p class="text-xs text-blue-600">{{ $history->email }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                <div class="flex items-center">
                    <i class="fas fa-calendar text-green-600 mr-3"></i>
                    <div>
                        <p class="text-sm text-green-600">Waktu Diagnosa</p>
                        <p class="font-semibold text-green-800">{{ $history->created_at->format('d M Y H:i') }}</p>
                        <p class="text-xs text-green-600">{{ $history->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                <div class="flex items-center">
                    <i class="fas fa-chart-line text-purple-600 mr-3"></i>
                    <div>
                        <p class="text-sm text-purple-600">Proses</p>
                        <p class="font-semibold text-purple-800">{{ $history->langkah_diagnosa }} langkah</p>
                        <p class="text-xs text-purple-600">{{ count($history->gejala_terpilih) }} gejala</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hasil Diagnosa -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
            <div class="flex items-center mb-4">
                <i class="fas fa-flag-checkered text-red-500 text-xl mr-3"></i>
                <h3 class="text-xl font-bold text-gray-800">Hasil Diagnosa</h3>
            </div>

            <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-lg">
                <h4 class="text-lg font-bold text-red-800 mb-2">{{ $history->hasil_akhir }}</h4>
                
                @if(!empty($hasil['kesimpulan_akhir']))
                @php $kesimpulan = $hasil['kesimpulan_akhir']; @endphp
                <div class="mt-4 space-y-3">
                    <div>
                        <label class="text-sm text-red-600 font-semibold">Deskripsi:</label>
                        <p class="text-red-700">{{ $kesimpulan['kerusakan']['deskripsi'] }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-red-600 font-semibold">Solusi:</label>
                        <p class="text-red-700">{{ $kesimpulan['kerusakan']['solusi'] }}</p>
                    </div>
                    <div class="flex items-center space-x-4 text-sm text-red-600">
                        <span>Kategori: {{ $kesimpulan['kerusakan']['kategori'] }}</span>
                        <span>Tingkat: {{ $kesimpulan['kerusakan']['tingkat_kerusakan'] }}</span>
                        <span>Confidence: {{ number_format($kesimpulan['confidence'], 1) }}%</span>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Gejala yang Dipilih -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
            <div class="flex items-center mb-4">
                <i class="fas fa-list-check text-green-500 text-xl mr-3"></i>
                <h3 class="text-xl font-bold text-gray-800">Gejala yang Dipilih</h3>
                <span class="ml-3 bg-green-100 text-green-800 text-sm px-2 py-1 rounded">
                    {{ count($history->gejala_terpilih) }} gejala
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach($history->gejala_terpilih as $gejalaId)
                @php
                    $gejala = \App\Models\Gejala::find($gejalaId);
                @endphp
                @if($gejala)
                <div class="flex items-center p-3 bg-green-50 border border-green-200 rounded-lg">
                    <i class="fas fa-check text-green-600 mr-3"></i>
                    <div>
                        <span class="font-medium text-green-800">{{ $gejala->nama_gejala }}</span>
                        <span class="ml-2 text-xs bg-green-200 text-green-800 px-2 py-1 rounded">
                            {{ $gejala->kode_gejala }}
                        </span>
                        <p class="text-sm text-green-600 mt-1">{{ $gejala->kategori }}</p>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>

        <!-- Proses Forward Chaining -->
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <div class="flex items-center mb-4">
                <i class="fas fa-sitemap text-blue-500 text-xl mr-3"></i>
                <h3 class="text-xl font-bold text-gray-800">Proses Forward Chaining</h3>
                <span class="ml-3 bg-blue-100 text-blue-800 text-sm px-2 py-1 rounded">
                    {{ count($hasil['rules_tertrigger'] ?? []) }} rules ter-trigger
                </span>
            </div>

            <!-- Rules yang Ter-trigger -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-700 mb-3">Rules yang Berhasil Di-trigger</h4>
                <div class="space-y-3">
                    @foreach($hasil['rules_tertrigger'] ?? [] as $rule)
                    <div class="flex items-center p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <span class="bg-blue-600 text-white text-sm px-2 py-1 rounded mr-3">
                            Step {{ $rule['step'] }}
                        </span>
                        <code class="text-blue-800 font-mono bg-blue-100 px-2 py-1 rounded text-sm">
                            {{ $rule['rule'] }}
                        </code>
                        <span class="ml-auto text-sm text-blue-600">
                            {{ $rule['gejala_nama'] }} → {{ $rule['kerusakan_nama'] }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Langkah-langkah Inference -->
            <div>
                <h4 class="text-lg font-semibold text-gray-700 mb-3">Langkah-langkah Inference</h4>
                <div class="space-y-4 max-h-96 overflow-y-auto p-2 border border-gray-200 rounded-lg">
                    @foreach($hasil['langkah_diagnosa'] ?? [] as $step)
                    <div class="border-l-4 border-blue-500 pl-4 py-2 bg-blue-50 rounded">
                        <div class="flex items-center mb-1">
                            <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded">Step {{ $step['step'] }}</span>
                            <span class="ml-2 text-sm text-blue-800 font-medium">{{ $step['action'] }}</span>
                        </div>
                        <div class="text-xs text-gray-600 mt-1">
                            <strong>Working Memory:</strong> 
                            @foreach($step['working_memory'] as $wm)
                            <span class="bg-white px-1 rounded mx-1">G{{ sprintf('%03d', $wm) }}</span>
                            @endforeach
                        </div>
                        @if(!empty($step['conclusions']))
                        <div class="text-xs text-gray-600 mt-1">
                            <strong>Conclusions:</strong> 
                            @foreach($step['conclusions'] as $conc)
                            <span class="bg-green-100 px-1 rounded mx-1">K{{ sprintf('%03d', $conc) }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection