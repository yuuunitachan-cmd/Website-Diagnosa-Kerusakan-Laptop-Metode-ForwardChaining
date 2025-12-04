@extends('admin.layout')

@section('title', 'Basis Pengetahuan')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center">
                <i class="fas fa-brain text-blue-600 text-2xl mr-3"></i>
                <h1 class="text-2xl font-bold text-gray-800">Basis Pengetahuan</h1>
            </div>
            <a href="{{ route('admin.basis-pengetahuan.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center">
                <i class="fas fa-plus mr-2"></i>Tambah Rule
            </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                <p class="text-sm text-blue-600">Total Rules</p>
                <p class="text-2xl font-bold text-blue-800">{{ $basisPengetahuan->count() }}</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                <p class="text-sm text-green-600">Rules Aktif</p>
                <p class="text-2xl font-bold text-green-800">{{ $basisPengetahuan->where('is_aktif', true)->count() }}</p>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                <p class="text-sm text-purple-600">Jenis Kerusakan</p>
                <p class="text-2xl font-bold text-purple-800">{{ $kerusakanList->count() }}</p>
            </div>
            <div class="bg-orange-50 p-4 rounded-lg border border-orange-200">
                <p class="text-sm text-orange-600">Gejala Tersedia</p>
                <p class="text-2xl font-bold text-orange-800">{{ $gejalaList->count() }}</p>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rule</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kerusakan</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gejala</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urutan</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($basisPengetahuan as $rule)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                IF <span class="text-blue-600">{{ $rule->gejala->kode_gejala }}</span> 
                                THEN <span class="text-green-600">{{ $rule->kerusakan->kode_kerusakan }}</span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                <div class="font-medium">{{ $rule->kerusakan->nama_kerusakan }}</div>
                                <div class="text-xs text-gray-500">{{ $rule->kerusakan->kode_kerusakan }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                <div class="font-medium">{{ $rule->gejala->nama_gejala }}</div>
                                <div class="text-xs text-gray-500">{{ $rule->gejala->kode_gejala }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $rule->urutan }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                @if($rule->is_aktif)
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
                                    <a href="{{ route('admin.basis-pengetahuan.edit', $rule->id) }}"
                                       class="text-green-600 hover:text-green-800 transition" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <!-- ✅ FORM TOGGLE STATUS YANG DIPERBAIKI -->
                                    <form action="{{ route('admin.basis-pengetahuan.toggle-status', $rule->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-orange-600 hover:text-orange-800 transition"
                                                title="{{ $rule->is_aktif ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            <i class="fas {{ $rule->is_aktif ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                        </button>
                                    </form>

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
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                <i class="fas fa-database text-3xl mb-2 text-gray-300"></i>
                                <p>Belum ada data basis pengetahuan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Info -->
        <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                <div>
                    <h3 class="font-semibold text-blue-800">Informasi Basis Pengetahuan</h3>
                    <p class="text-sm text-blue-600 mt-1">
                        Basis pengetahuan berisi rules IF-THEN untuk sistem pakar. Setiap rule menghubungkan gejala dengan kerusakan tertentu.
                        Urutan menentukan prioritas eksekusi dalam proses forward chaining.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection