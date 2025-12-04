@extends('admin.layout')

@section('title', 'Edit Rule')
@section('subtitle', 'Edit rule Forward Chaining')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center mb-6">
            <i class="fas fa-edit text-green-600 text-xl mr-3"></i>
            <h2 class="text-xl font-bold text-gray-800">Edit Rule</h2>
        </div>

        <!-- Current Rule Info -->
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <h3 class="font-semibold text-gray-700 mb-2">Rule Saat Ini:</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm text-gray-500">Kerusakan</label>
                    <p class="font-medium text-gray-800">
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm mr-2">
                            {{ $basisPengetahuan->kerusakan->kode_kerusakan }}
                        </span>
                        {{ $basisPengetahuan->kerusakan->nama_kerusakan }}
                    </p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">Gejala</label>
                    <p class="font-medium text-gray-800">
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm mr-2">
                            {{ $basisPengetahuan->gejala->kode_gejala }}
                        </span>
                        {{ $basisPengetahuan->gejala->nama_gejala }}
                    </p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.basis-pengetahuan.update', $basisPengetahuan->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Urutan -->
                <div>
                    <label for="urutan" class="block text-sm font-medium text-gray-700 mb-2">
                        Urutan *
                    </label>
                    <input type="number" name="urutan" id="urutan" 
                           value="{{ old('urutan', $basisPengetahuan->urutan) }}" min="1"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                           required>
                    @error('urutan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Status
                    </label>
                    <div class="flex items-center">
                        <input type="checkbox" name="is_aktif" id="is_aktif" 
                               {{ old('is_aktif', $basisPengetahuan->is_aktif) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_aktif" class="ml-2 text-sm text-gray-700">
                            Aktif (rule akan digunakan dalam diagnosa)
                        </label>
                    </div>
                    @error('is_aktif')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Updated Rule Preview -->
            <div class="mt-6 p-4 bg-blue-50 rounded-lg border">
                <h3 class="font-semibold text-gray-700 mb-2">Rule:</h3>
                <code class="text-lg bg-white px-3 py-2 rounded border font-mono">
                    IF {{ $basisPengetahuan->gejala->kode_gejala }} THEN {{ $basisPengetahuan->kerusakan->kode_kerusakan }}
                </code>
                <p class="text-sm text-gray-600 mt-2">
                    Urutan: <strong>{{ old('urutan', $basisPengetahuan->urutan) }}</strong> | 
                    Status: 
                    @if(old('is_aktif', $basisPengetahuan->is_aktif))
                        <span class="text-green-600 font-semibold">Aktif</span>
                    @else
                        <span class="text-red-600 font-semibold">Nonaktif</span>
                    @endif
                </p>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.basis-pengetahuan.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition flex items-center">
                    <i class="fas fa-save mr-2"></i>Update Rule
                </button>
            </div>
        </form>
    </div>

    <!-- Info -->
    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded mt-6">
        <div class="flex items-start">
            <i class="fas fa-exclamation-triangle text-yellow-500 mt-1 mr-3"></i>
            <div>
                <p class="text-yellow-700 font-semibold">Perhatian:</p>
                <ul class="text-yellow-600 text-sm mt-1 list-disc list-inside space-y-1">
                    <li>Mengubah urutan dapat mempengaruhi alur diagnosa</li>
                    <li>Rule yang nonaktif tidak akan diproses dalam diagnosa</li>
                    <li>Pastikan urutan sesuai dengan logika Forward Chaining</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection