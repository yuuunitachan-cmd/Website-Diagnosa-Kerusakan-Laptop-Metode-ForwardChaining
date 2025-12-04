@extends('layouts.app')

@section('title', 'Hasil Diagnosa')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header Hasil -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <i class="fas fa-clipboard-check text-green-600 text-2xl mr-3"></i>
                <h1 class="text-2xl font-bold text-gray-800">Hasil Diagnosa</h1>
            </div>
            <a href="{{ route('diagnosa.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center">
                <i class="fas fa-redo mr-2"></i>Diagnosa Baru
            </a>
        </div>

        <!-- Ringkasan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                <div class="flex items-center">
                    <i class="fas fa-list-check text-blue-600 text-xl mr-3"></i>
                    <div>
                        <p class="text-sm text-blue-600">Gejala Dipilih</p>
                        <p class="text-2xl font-bold text-blue-800">{{ count($hasil['fakta_terbukti']) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                <div class="flex items-center">
                    <i class="fas fa-gears text-green-600 text-xl mr-3"></i>
                    <div>
                        <p class="text-sm text-green-600">Rules Terpakai</p>
                        <p class="text-2xl font-bold text-green-800">{{ $hasil['total_rules_tertrigger'] }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                <div class="flex items-center">
                    <i class="fas fa-stairs text-purple-600 text-xl mr-3"></i>
                    <div>
                        <p class="text-sm text-purple-600">Langkah Diagnosa</p>
                        <p class="text-2xl font-bold text-purple-800">{{ $hasil['total_langkah'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kesimpulan Utama -->
    @if(!empty($hasil['kesimpulan_akhir']))
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
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

                    <!-- Info Rules (tanpa confidence) -->
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
    @else
    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-6 rounded-lg mb-6">
        <div class="flex items-center">
            <i class="fas fa-exclamation-triangle text-yellow-600 text-xl mr-3"></i>
            <div>
                <h3 class="text-lg font-bold text-yellow-800">Tidak Dapat Menentukan Diagnosa</h3>
                <p class="text-yellow-700 mt-1">Sistem tidak menemukan kecocokan yang cukup untuk menentukan kerusakan spesifik.</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Proses Forward Chaining -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center mb-4">
            <i class="fas fa-sitemap text-blue-500 text-xl mr-3"></i>
            <h2 class="text-xl font-bold text-gray-800">Proses Forward Chaining</h2>
        </div>

        <!-- Rules yang Ter-trigger (SOLUSI 2) -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">
                Rules yang Berhasil Di-trigger
                <span class="text-sm font-normal text-gray-500">
                    ({{ count($hasil['rules_tertrigger']) }} rules untuk {{ count($hasil['semua_kemungkinan']) }} kemungkinan kerusakan)
                </span>
            </h3>
            
            <!-- Rules untuk Kesimpulan Utama (Paling Menonjol) -->
            <div class="mb-4">
                <div class="flex items-center mb-2">
                    <i class="fas fa-trophy text-yellow-500 mr-2"></i>
                    <h4 class="font-bold text-lg text-gray-800">Kesimpulan Terbaik</h4>
                    <span class="ml-2 bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded font-semibold">
                        {{ $hasil['kesimpulan_akhir']['total_rules'] }} rules
                    </span>
                </div>
                
                <div class="space-y-2 ml-6">
                    @foreach($hasil['rules_tertrigger'] as $rule)
                        @php
                            // Cek apakah rule untuk kesimpulan utama
                            $isForConclusion = strpos($rule['rule'], $hasil['kesimpulan_akhir']['kerusakan']['kode_kerusakan']) !== false;
                        @endphp
                        
                        @if($isForConclusion)
                        <div class="flex items-center p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <span class="bg-yellow-600 text-white text-sm px-2 py-1 rounded mr-3">
                                ✓ Step {{ $rule['step'] }}
                            </span>
                            <code class="text-yellow-800 font-mono bg-yellow-100 px-2 py-1 rounded text-sm">
                                {{ $rule['rule'] }}
                            </code>
                            <span class="ml-auto text-sm text-yellow-700 font-medium">
                                {{ $rule['gejala_nama'] }} → {{ $rule['kerusakan_nama'] }}
                            </span>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            
            <!-- Rules untuk Kemungkinan Lainnya -->
            @if(count($hasil['semua_kemungkinan']) > 1)
            <div>
                <h4 class="font-semibold text-gray-700 mb-2">Kemungkinan Lainnya</h4>
                
                @foreach($hasil['semua_kemungkinan'] as $index => $kemungkinan)
                    @if($index > 0) <!-- Skip yang pertama karena sudah ditampilkan -->
                    <div class="mb-3">
                        <div class="flex items-center mb-1">
                            <span class="text-sm font-medium text-gray-600">
                                {{ $kemungkinan['kerusakan']['nama_kerusakan'] }}
                            </span>
                            <span class="ml-2 bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">
                                {{ $kemungkinan['total_rules'] }} rules
                            </span>
                        </div>
                        
                        <div class="space-y-2 ml-4">
                            @foreach($hasil['rules_tertrigger'] as $rule)
                                @php
                                    // Cek apakah rule untuk kemungkinan ini
                                    $isForThisKerusakan = strpos($rule['rule'], $kemungkinan['kerusakan']['kode_kerusakan']) !== false;
                                @endphp
                                
                                @if($isForThisKerusakan)
                                <div class="flex items-center p-2 bg-gray-50 border border-gray-200 rounded text-sm">
                                    <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded mr-2">
                                        Step {{ $rule['step'] }}
                                    </span>
                                    <code class="text-gray-700 font-mono bg-gray-100 px-2 py-1 rounded text-xs">
                                        {{ $rule['rule'] }}
                                    </code>
                                    <span class="ml-auto text-xs text-gray-600">
                                        {{ $rule['gejala_nama'] }}
                                    </span>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
            @endif
        </div>

        <!-- Langkah-langkah Diagnosa -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Langkah-langkah Inference</h3>
            <div class="space-y-4">
                @foreach($hasil['langkah_diagnosa'] as $step)
                <div class="border-l-4 border-blue-500 pl-4 py-2">
                    <div class="flex items-center mb-1">
                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded">Step {{ $step['step'] }}</span>
                        <span class="ml-2 text-sm text-blue-600">{{ $step['action'] }}</span>
                    </div>
                    <div class="text-xs text-gray-500 mt-1">
                        Working Memory: [{{ implode(', ', $step['working_memory']) }}]
                        @if(!empty($step['conclusions']))
                        | Conclusions: [{{ implode(', ', $step['conclusions']) }}]
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Kemungkinan Lain -->
    @if(count($hasil['semua_kemungkinan']) > 1)
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center mb-4">
            <i class="fas fa-list-ul text-purple-500 text-xl mr-3"></i>
            <h2 class="text-xl font-bold text-gray-800">Kemungkinan Lainnya</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($hasil['semua_kemungkinan'] as $index => $kemungkinan)
                @if($index > 0) <!-- Skip yang pertama karena sudah ditampilkan sebagai kesimpulan utama -->
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                    <h3 class="font-semibold text-gray-800 mb-2">{{ $kemungkinan['kerusakan']['nama_kerusakan'] }}</h3>
                    <div class="flex items-center text-sm text-gray-600 mb-2">
                        <span class="bg-gray-200 px-2 py-1 rounded mr-2">{{ $kemungkinan['kerusakan']['kode_kerusakan'] }}</span>
                        <span>{{ $kemungkinan['total_rules'] }} rules terpenuhi</span>
                    </div>
                    <p class="text-sm text-gray-600 line-clamp-2">{{ $kemungkinan['kerusakan']['deskripsi'] }}</p>
                </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection