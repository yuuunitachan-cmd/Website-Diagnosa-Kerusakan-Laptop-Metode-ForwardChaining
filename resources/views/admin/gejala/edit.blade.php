@extends('admin.layout')

@section('title', 'Edit Gejala')
@section('subtitle', 'Edit data gejala')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center mb-6">
            <i class="fas fa-edit text-green-600 text-xl mr-3"></i>
            <h2 class="text-xl font-bold text-gray-800">Edit Gejala</h2>
        </div>

        <form action="{{ route('admin.gejala.update', $gejala->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kode Gejala -->
                <div>
                    <label for="kode_gejala" class="block text-sm font-medium text-gray-700 mb-2">
                        Kode Gejala *
                    </label>
                    <input type="text" name="kode_gejala" id="kode_gejala" 
                           value="{{ old('kode_gejala', $gejala->kode_gejala) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                           required>
                    @error('kode_gejala')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Gejala -->
                <div>
                    <label for="nama_gejala" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Gejala *
                    </label>
                    <input type="text" name="nama_gejala" id="nama_gejala" 
                           value="{{ old('nama_gejala', $gejala->nama_gejala) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                           required>
                    @error('nama_gejala')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori *
                    </label>
                    <select name="kategori" id="kategori" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoriOptions as $value => $label)
                            <option value="{{ $value }}" {{ old('kategori', $gejala->kategori) == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori')
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
                               {{ old('is_aktif', $gejala->is_aktif) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_aktif" class="ml-2 text-sm text-gray-700">
                            Aktif (dapat digunakan dalam diagnosa)
                        </label>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi *
                    </label>
                    <textarea name="deskripsi" id="deskripsi" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                              required>{{ old('deskripsi', $gejala->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.gejala.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition flex items-center">
                    <i class="fas fa-save mr-2"></i>Update Gejala
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
                <p class="text-yellow-600 text-sm mt-1">
                    Mengubah data gejala dapat mempengaruhi proses diagnosa. 
                    Pastikan perubahan konsisten dengan rules yang ada.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection