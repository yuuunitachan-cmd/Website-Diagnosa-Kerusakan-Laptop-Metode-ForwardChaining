@extends('layouts.app')

@section('title', 'Riwayat Diagnosa')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <i class="fas fa-history text-blue-600 text-2xl mr-3"></i>
                <h1 class="text-2xl font-bold text-gray-800">Riwayat Diagnosa</h1>
            </div>
            <a href="{{ route('diagnosa.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center">
                <i class="fas fa-plus mr-2"></i>Diagnosa Baru
            </a>
        </div>

        @if($histories->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gejala Dipilih</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hasil</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Langkah</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($histories as $history)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ $history->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ count($history->gejala_terpilih) }} gejala
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <span class="font-medium text-gray-800">{{ $history->hasil_akhir }}</span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ $history->langkah_diagnosa }} langkah
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <a href="{{ route('diagnosa.detail', $history->id) }}" 
                               class="text-blue-600 hover:text-blue-800 transition flex items-center">
                                <i class="fas fa-eye mr-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 text-sm text-gray-500">
            Total: {{ $histories->count() }} riwayat diagnosa
        </div>
        @else
        <div class="text-center py-12">
            <i class="fas fa-clipboard-list text-gray-400 text-6xl mb-4"></i>
            <h3 class="text-lg font-medium text-gray-600 mb-2">Belum ada riwayat diagnosa</h3>
            <p class="text-gray-500 mb-4">Lakukan diagnosa pertama Anda untuk melihat riwayat di sini.</p>
            <a href="{{ route('diagnosa.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition inline-flex items-center">
                <i class="fas fa-stethoscope mr-2"></i> Mulai Diagnosa
            </a>
        </div>
        @endif
    </div>
</div>
@endsection