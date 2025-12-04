@extends('admin.layout')

@section('title', 'Edit Kerusakan')
@section('subtitle', 'Edit data kerusakan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center mb-6">
            <i class="fas fa-edit text-green-600 text-xl mr-3"></i>
            <h2 class="text-xl font-bold text-gray-800">Edit Kerusakan</h2>
        </div>

        <form action="{{ route('admin.kerusakan.update', $kerusakan->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kode Kerusakan -->
                <div>
                    <label for="kode_kerusakan" class="block text-sm font-medium text-gray-700 mb-2">
                        Kode Kerusakan *
                    </label>
                    <input type="text" name="kode_kerusakan" id="kode_kerusakan" 
                           value="{{ old('kode_kerusakan', $kerusakan->kode_kerusakan) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                           required>
                    @error('kode_kerusakan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Kerusakan -->
                <div>
                    <label for="nama_kerusakan" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Kerusakan *
                    </label>
                    <input type="text" name="nama_kerusakan" id="nama_kerusakan" 
                           value="{{ old('nama_kerusakan', $kerusakan->nama_kerusakan) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                           required>
                    @error('nama_kerusakan')
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
                            <option value="{{ $value }}" {{ old('kategori', $kerusakan->kategori) == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tingkat Kerusakan -->
                <div>
                    <label for="tingkat_kerusakan" class="block text-sm font-medium text-gray-700 mb-2">
                        Tingkat Kerusakan *
                    </label>
                    <select name="tingkat_kerusakan" id="tingkat_kerusakan" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Pilih Tingkat</option>
                        @foreach($tingkatOptions as $value => $label)
                            <option value="{{ $value }}" {{ old('tingkat_kerusakan', $kerusakan->tingkat_kerusakan) == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('tingkat_kerusakan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi *
                    </label>
                    <textarea name="deskripsi" id="deskripsi" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                              required>{{ old('deskripsi', $kerusakan->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Solusi -->
                <div class="md:col-span-2">
                    <label for="solusi" class="block text-sm font-medium text-gray-700 mb-2">
                        Solusi *
                    </label>
                    <textarea name="solusi" id="solusi" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                              required>{{ old('solusi', $kerusakan->solusi) }}</textarea>
                    @error('solusi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.kerusakan.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition flex items-center">
                    <i class="fas fa-save mr-2"></i>Update Kerusakan
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
                    Mengubah data kerusakan dapat mempengaruhi hasil diagnosa. 
                    Pastikan perubahan konsisten dengan rules yang ada.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection