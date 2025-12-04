@extends('admin.layout')

@section('title', 'Tambah Gejala')
@section('subtitle', 'Tambah data gejala baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center mb-6">
            <i class="fas fa-plus-circle text-blue-600 text-xl mr-3"></i>
            <h2 class="text-xl font-bold text-gray-800">Tambah Gejala Baru</h2>
        </div>

        <form action="{{ route('admin.gejala.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kode Gejala -->
                <div>
                    <label for="kode_gejala" class="block text-sm font-medium text-gray-700 mb-2">
                        Kode Gejala *
                    </label>
                    <input type="text" name="kode_gejala" id="kode_gejala" 
                           value="{{ old('kode_gejala') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                           placeholder="G001" required>
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
                           value="{{ old('nama_gejala') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Laptop tidak bisa menyala" required>
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
                            <option value="{{ $value }}" {{ old('kategori') == $value ? 'selected' : '' }}>
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
                               {{ old('is_aktif', true) ? 'checked' : '' }}
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
                              placeholder="Jelaskan detail gejala ini..." required>{{ old('deskripsi') }}</textarea>
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
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition flex items-center">
                    <i class="fas fa-save mr-2"></i>Simpan Gejala
                </button>
            </div>
        </form>
    </div>

    <!-- Info -->
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded mt-6">
        <div class="flex items-start">
            <i class="fas fa-lightbulb text-blue-500 mt-1 mr-3"></i>
            <div>
                <p class="text-blue-700 font-semibold">Tips:</p>
                <ul class="text-blue-600 text-sm mt-1 list-disc list-inside space-y-1">
                    <li>Kode gejala harus unik dan mudah diingat</li>
                    <li>Deskripsi harus jelas dan detail</li>
                    <li>Pilih kategori yang sesuai untuk pengelompokan</li>
                    <li>Nonaktifkan gejala jika tidak digunakan sementara</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection