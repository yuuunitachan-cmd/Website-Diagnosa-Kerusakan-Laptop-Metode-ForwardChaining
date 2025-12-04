@extends('admin.layout')

@section('title', 'Detail Gejala')
@section('subtitle', 'Detail informasi gejala')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Header -->
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $gejala->nama_gejala }}</h2>
                <p class="text-gray-600">Detail informasi gejala</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.gejala.edit', $gejala->id) }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition flex items-center">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <a href="{{ route('admin.gejala.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>

        <!-- Info Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Basic Info -->
            <div class="space-y-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>Informasi Dasar
                    </h3>
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm text-gray-500">Kode Gejala</label>
                            <p class="font-mono bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm inline-block">
                                {{ $gejala->kode_gejala }}
                            </p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Kategori</label>
                            <p>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 capitalize">
                                    {{ $gejala->kategori }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Status</label>
                            <p>
                                @if($gejala->is_aktif)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check mr-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times mr-1"></i>Nonaktif
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold text-gray-700 mb-3 flex items-center">
                    <i class="fas fa-file-alt text-green-600 mr-2"></i>Deskripsi
                </h3>
                <p class="text-gray-700">{{ $gejala->deskripsi }}</p>
            </div>
        </div>

        <!-- Related Rules -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="font-semibold text-gray-700 mb-3 flex items-center">
                <i class="fas fa-sitemap text-purple-600 mr-2"></i>Rules Terkait
                <span class="ml-2 bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded">
                    {{ $gejala->basisPengetahuan->count() }} rules
                </span>
            </h3>

            @if($gejala->basisPengetahuan->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kerusakan</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Urutan</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($gejala->basisPengetahuan as $rule)
                        <tr class="hover:bg-gray-100">
                            <td class="px-3 py-2">
                                <div class="flex items-center">
                                    <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded mr-2">
                                        {{ $rule->kerusakan->kode_kerusakan }}
                                    </span>
                                    {{ $rule->kerusakan->nama_kerusakan }}
                                </div>
                            </td>
                            <td class="px-3 py-2 text-sm text-gray-600">
                                {{ $rule->urutan }}
                            </td>
                            <td class="px-3 py-2">
                                @if($rule->is_aktif)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-4 text-gray-500">
                <i class="fas fa-unlink text-2xl mb-2"></i>
                <p>Gejala ini belum memiliki rules terkait</p>
                <a href="{{ route('admin.basis-pengetahuan.create') }}" class="text-blue-600 hover:text-blue-800 text-sm mt-2 inline-block">
                    Tambah Rule
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection