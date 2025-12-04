@extends('layouts.app')

@section('title', 'Detail Riwayat Diagnosa')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <i class="fas fa-file-alt text-blue-600 text-2xl mr-3"></i>
                <h1 class="text-2xl font-bold text-gray-800">Detail Riwayat Diagnosa</h1>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('diagnosa.riwayat') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
                <a href="{{ route('diagnosa.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center">
                    <i class="fas fa-redo mr-2"></i>Diagnosa Baru
                </a>
            </div>
        </div>

        <!-- Info Utama -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                <div class="flex items-center">
                    <i class="fas fa-calendar text-blue-600 mr-3"></i>
                    <div>
                        <p class="text-sm text-blue-600">Tanggal</p>
                        <p class="font-semibold text-blue-800">
                            {{ \Carbon\Carbon::parse($history->created_at)->timezone('Asia/Makassar')->translatedFormat('j F Y') }}
                            <span class="text-gray-600 ml-2">
                                {{ \Carbon\Carbon::parse($history->created_at)->timezone('Asia/Makassar')->format('H:i') }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                <div class="flex items-center">
                    <i class="fas fa-list-check text-green-600 mr-3"></i>
                    <div>
                        <p class="text-sm text-green-600">Gejala Dipilih</p>
                        <p class="font-semibold text-green-800">{{ count($history->gejala_terpilih) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                <div class="flex items-center">
                    <i class="fas fa-flag text-purple-600 mr-3"></i>
                    <div>
                        <p class="text-sm text-purple-600">Hasil</p>
                        <p class="font-semibold text-purple-800">{{ $history->hasil_akhir }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-orange-50 p-4 rounded-lg border border-orange-200">
                <div class="flex items-center">
                    <i class="fas fa-stairs text-orange-600 mr-3"></i>
                    <div>
                        <p class="text-sm text-orange-600">Langkah</p>
                        <p class="font-semibold text-orange-800">{{ $history->langkah_diagnosa }}</p>
                    </div>
                </div>
            </div>
        </div>

        @php
            $hasil = $history->hasil_diagnosa;
        @endphp

        <!-- Kesimpulan -->
        @if(!empty($hasil['kesimpulan_akhir']))
        <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
            <div class="flex items-center mb-4">
                <i class="fas fa-flag-checkered text-red-500 text-xl mr-3"></i>
                <h2 class="text-xl font-bold text-gray-800">Kesimpulan Diagnosa</h2>
            </div>

            @php $kesimpulan = $hasil['kesimpulan_akhir']; @endphp
            <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-lg">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-red-800 mb-2">
                            {{ $kesimpulan['kerusakan']['nama_kerusakan'] }}
                        </h3>
                        <p class="text-red-700 mb-3">{{ $kesimpulan['kerusakan']['deskripsi'] }}</p>
                        
                        <div class="flex items-center text-sm text-red-600 mb-4">
                            <span class="bg-red-200 px-2 py-1 rounded mr-3">
                                {{ $kesimpulan['kerusakan']['kode_kerusakan'] }}
                            </span>
                            <span class="capitalize">{{ $kesimpulan['kerusakan']['kategori'] }}</span>
                            <span class="mx-2">•</span>
                            <span class="capitalize">{{ $kesimpulan['kerusakan']['tingkat_kerusakan'] }}</span>
                        </div>

                        <!-- Info Rules -->
                        <div class="mb-4">
                            <div class="text-sm text-red-700">
                                <span class="font-semibold">{{ $kesimpulan['total_rules'] }} rules terpenuhi</span>
                            </div>
                        </div>
                    </div>
                    <div class="ml-6">
                        <div class="bg-red-100 text-red-800 px-3 py-2 rounded-lg text-center">
                            <div class="text-2xl font-bold">{{ $kesimpulan['total_rules'] }}</div>
                            <div class="text-sm">Rules Terpenuhi</div>
                        </div>
                    </div>
                </div>

                <!-- Solusi -->
                <div class="mt-4 pt-4 border-t border-red-200">
                    <h4 class="font-semibold text-red-800 mb-3 flex items-center">
                        <i class="fas fa-lightbulb mr-2"></i>Solusi yang Direkomendasikan:
                    </h4>
                    <div class="text-red-700">
                        @php
                            // Pisahkan solusi berdasarkan newline atau nomor
                            $solusiItems = preg_split('/\r\n|\n|\d\./', $kesimpulan['kerusakan']['solusi'], -1, PREG_SPLIT_NO_EMPTY);
                        @endphp
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($solusiItems as $item)
                                @if(trim($item) !== '')
                                    <li>{{ trim($item) }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Gejala yang Dipilih -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
            <div class="flex items-center mb-4">
                <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                <h2 class="text-xl font-bold text-gray-800">Gejala yang Dipilih</h2>
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
                <h2 class="text-xl font-bold text-gray-800">Proses Forward Chaining</h2>
            </div>

            <!-- Rules yang Ter-trigger -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">
                    Rules yang Berhasil Di-trigger ({{ count($hasil['rules_tertrigger']) }})
                </h3>
                <div class="space-y-3">
                    @foreach($hasil['rules_tertrigger'] as $rule)
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
                <h3 class="text-lg font-semibold text-gray-700 mb-3">
                    Langkah-langkah Inference ({{ $history->langkah_diagnosa }} langkah)
                </h3>
                <div class="space-y-4 max-h-96 overflow-y-auto p-2">
                    @foreach($hasil['langkah_diagnosa'] as $step)
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