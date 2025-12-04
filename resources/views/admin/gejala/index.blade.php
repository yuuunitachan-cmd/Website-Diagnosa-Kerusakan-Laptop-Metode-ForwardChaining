@extends('admin.layout')

@section('title', 'Data Gejala')
@section('subtitle', 'Kelola data gejala kerusakan laptop')

@section('content')
<div class="space-y-6">
    <!-- Header dengan Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Data Gejala</h2>
            <p class="text-gray-600">Kelola gejala-gejala yang digunakan dalam sistem</p>
        </div>
        <a href="{{ route('admin.gejala.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center">
            <i class="fas fa-plus mr-2"></i>Tambah Gejala
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-lg shadow border">
            <div class="text-2xl font-bold text-blue-600">{{ $gejala->count() }}</div>
            <p class="text-gray-600 text-sm">Total Gejala</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border">
            <div class="text-2xl font-bold text-green-600">{{ $gejala->where('is_aktif', true)->count() }}</div>
            <p class="text-gray-600 text-sm">Gejala Aktif</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border">
            <div class="text-2xl font-bold text-orange-600">{{ $gejala->where('is_aktif', false)->count() }}</div>
            <p class="text-gray-600 text-sm">Gejala Nonaktif</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border">
            <div class="text-2xl font-bold text-purple-600">{{ $gejala->sum('total_kerusakan') }}</div>
            <p class="text-gray-600 text-sm">Total Rules</p>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Gejala</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rules</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($gejala as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded font-mono">
                                {{ $item->kode_gejala }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div>
                                <p class="font-medium text-gray-800">{{ $item->nama_gejala }}</p>
                                @if($item->deskripsi)
                                <p class="text-sm text-gray-600 truncate max-w-xs">{{ $item->deskripsi }}</p>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 capitalize">
                                {{ $item->kategori }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-sm text-gray-600">{{ $item->total_kerusakan ?? 0 }}</span>
                        </td>
                        <td class="px-4 py-3">
                            @if($item->is_aktif)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times mr-1"></i>Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.gejala.show', $item->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 transition" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.gejala.edit', $item->id) }}" 
                                   class="text-green-600 hover:text-green-800 transition" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.gejala.toggle-status', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-orange-600 hover:text-orange-800 transition" 
                                            title="{{ $item->is_aktif ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="fas {{ $item->is_aktif ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.gejala.destroy', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 transition" 
                                            title="Hapus"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus gejala ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-3xl mb-2"></i>
                            <p>Belum ada data gejala</p>
                            <a href="{{ route('admin.gejala.create') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                                Tambah gejala pertama
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Info -->
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
            <div>
                <p class="text-blue-700 font-semibold">Informasi:</p>
                <p class="text-blue-600 text-sm mt-1">
                    Gejala yang nonaktif tidak akan muncul dalam proses diagnosa. 
                    Pastikan gejala yang digunakan dalam rules berstatus aktif.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection