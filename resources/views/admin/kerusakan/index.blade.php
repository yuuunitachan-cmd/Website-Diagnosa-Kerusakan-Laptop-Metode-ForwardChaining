@extends('admin.layout')

@section('title', 'Data Kerusakan')
@section('subtitle', 'Kelola data jenis kerusakan laptop')

@section('content')
<div class="space-y-6">
    <!-- Header dengan Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Data Kerusakan</h2>
            <p class="text-gray-600">Kelola jenis-jenis kerusakan laptop</p>
        </div>
        <a href="{{ route('admin.kerusakan.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center">
            <i class="fas fa-plus mr-2"></i>Tambah Kerusakan
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-lg shadow border">
            <div class="text-2xl font-bold text-blue-600">{{ $kerusakan->count() }}</div>
            <p class="text-gray-600 text-sm">Total Kerusakan</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border">
            <div class="text-2xl font-bold text-green-600">{{ $kerusakan->where('kategori', 'hardware')->count() }}</div>
            <p class="text-gray-600 text-sm">Hardware</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border">
            <div class="text-2xl font-bold text-orange-600">{{ $kerusakan->where('kategori', 'software')->count() }}</div>
            <p class="text-gray-600 text-sm">Software</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border">
            <div class="text-2xl font-bold text-purple-600">{{ $kerusakan->sum('total_gejala') }}</div>
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
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Kerusakan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tingkat</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gejala</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($kerusakan as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">
                            <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded font-mono">
                                {{ $item->kode_kerusakan }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div>
                                <p class="font-medium text-gray-800">{{ $item->nama_kerusakan }}</p>
                                <p class="text-sm text-gray-600 truncate max-w-xs">{{ Str::limit($item->deskripsi, 50) }}</p>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $kategoriColors = [
                                    'hardware' => 'bg-blue-100 text-blue-800',
                                    'software' => 'bg-green-100 text-green-800', 
                                    'battery' => 'bg-yellow-100 text-yellow-800',
                                    'display' => 'bg-purple-100 text-purple-800'
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $kategoriColors[$item->kategori] ?? 'bg-gray-100 text-gray-800' }} capitalize">
                                {{ $item->kategori }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $tingkatColors = [
                                    'ringan' => 'bg-green-100 text-green-800',
                                    'sedang' => 'bg-yellow-100 text-yellow-800',
                                    'berat' => 'bg-red-100 text-red-800'
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $tingkatColors[$item->tingkat_kerusakan] }} capitalize">
                                {{ $item->tingkat_kerusakan }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-sm text-gray-600">{{ $item->total_gejala ?? 0 }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.kerusakan.show', $item->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 transition" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.kerusakan.edit', $item->id) }}" 
                                   class="text-green-600 hover:text-green-800 transition" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.kerusakan.destroy', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 transition" 
                                            title="Hapus"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus kerusakan ini?')">
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
                            <p>Belum ada data kerusakan</p>
                            <a href="{{ route('admin.kerusakan.create') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                                Tambah kerusakan pertama
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
                    Setiap kerusakan harus memiliki rules (gejala) untuk dapat didiagnosa. 
                    Pastikan setiap kerusakan memiliki minimal satu rule yang terkait.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection