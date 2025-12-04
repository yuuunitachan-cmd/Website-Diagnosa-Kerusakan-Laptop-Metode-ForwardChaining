@extends('admin.layout')

@section('title', 'Detail Kerusakan')
@section('subtitle', 'Detail informasi kerusakan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Header -->
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $kerusakan->nama_kerusakan }}</h2>
                <p class="text-gray-600">Detail informasi kerusakan</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.kerusakan.edit', $kerusakan->id) }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition flex items-center">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <a href="{{ route('admin.kerusakan.index') }}" 
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
                            <label class="text-sm text-gray-500">Kode Kerusakan</label>
                            <p class="font-mono bg-red-100 text-red-800 px-2 py-1 rounded text-sm inline-block">
                                {{ $kerusakan->kode_kerusakan }}
                            </p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Kategori</label>
                            <p>
                                @php
                                    $kategoriColors = [
                                        'hardware' => 'bg-blue-100 text-blue-800',
                                        'software' => 'bg-green-100 text-green-800',
                                        'battery' => 'bg-yellow-100 text-yellow-800',
                                        'display' => 'bg-purple-100 text-purple-800'
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $kategoriColors[$kerusakan->kategori] }} capitalize">
                                    {{ $kerusakan->kategori }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Tingkat Kerusakan</label>
                            <p>
                                @php
                                    $tingkatColors = [
                                        'ringan' => 'bg-green-100 text-green-800',
                                        'sedang' => 'bg-yellow-100 text-yellow-800',
                                        'berat' => 'bg-red-100 text-red-800'
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $tingkatColors[$kerusakan->tingkat_kerusakan] }} capitalize">
                                    {{ $kerusakan->tingkat_kerusakan }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deskripsi & Solusi -->
            <div class="space-y-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-file-alt text-green-600 mr-2"></i>Deskripsi
                    </h3>
                    <p class="text-gray-700">{{ $kerusakan->deskripsi }}</p>
                </div>

                <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                    <h3 class="font-semibold text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-lightbulb text-green-600 mr-2"></i>Solusi
                    </h3>
                    <p class="text-gray-700">{{ $kerusakan->solusi }}</p>
                </div>
            </div>
        </div>

        <!-- Related Rules -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="font-semibold text-gray-700 mb-3 flex items-center">
                <i class="fas fa-sitemap text-purple-600 mr-2"></i>Rules Terkait
                <span class="ml-2 bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded">
                    {{ $kerusakan->basisPengetahuan->count() }} rules
                </span>
            </h3>

            @if($kerusakan->basisPengetahuan->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Gejala</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Urutan</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($kerusakan->basisPengetahuan as $rule)
                        <tr class="hover:bg-gray-100">
                            <td class="px-3 py-2">
                                <div class="flex items-center">
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-2">
                                        {{ $rule->gejala->kode_gejala }}
                                    </span>
                                    {{ $rule->gejala->nama_gejala }}
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
                            <td class="px-3 py-2">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.basis-pengetahuan.edit', $rule->id) }}" 
                                       class="text-green-600 hover:text-green-800 transition" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.basis-pengetahuan.destroy', $rule->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-800 transition" 
                                                title="Hapus"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus rule ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-4 text-gray-500">
                <i class="fas fa-unlink text-2xl mb-2"></i>
                <p>Kerusakan ini belum memiliki rules terkait</p>
                <a href="{{ route('admin.basis-pengetahuan.create') }}" class="text-blue-600 hover:text-blue-800 text-sm mt-2 inline-block">
                    Tambah Rule
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection