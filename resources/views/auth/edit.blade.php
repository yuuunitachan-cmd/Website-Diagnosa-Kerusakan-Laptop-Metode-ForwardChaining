@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center mb-6">
            <i class="fas fa-user-edit text-blue-600 text-2xl mr-3"></i>
            <h1 class="text-2xl font-bold text-gray-800">Edit Profil</h1>
        </div>

        <!-- Update Profile Information -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Profil</h2>
            
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap
                        </label>
                        <input type="text" name="name" id="name" 
                               value="{{ old('name', $user->name) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                               required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat Email
                        </label>
                        <input type="email" name="email" id="email" 
                               value="{{ old('email', $user->email) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                               required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition flex items-center">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- User Statistics -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Statistik Pengguna</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                    <div class="flex items-center">
                        <i class="fas fa-stethoscope text-blue-600 mr-3"></i>
                        <div>
                            <p class="text-sm text-blue-600">Total Diagnosa</p>
                            <p class="text-xl font-bold text-blue-800">{{ $user->histories->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                    <div class="flex items-center">
                        <i class="fas fa-calendar text-green-600 mr-3"></i>
                        <div>
                            <p class="text-sm text-green-600">Bergabung</p>
                            <p class="text-xl font-bold text-green-800">{{ $user->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                    <div class="flex items-center">
                        <i class="fas fa-user-tag text-purple-600 mr-3"></i>
                        <div>
                            <p class="text-sm text-purple-600">Role</p>
                            <p class="text-xl font-bold text-purple-800 capitalize">{{ $user->role }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Account -->
        <div class="border-t border-gray-200 pt-6">
            <h2 class="text-lg font-semibold text-red-800 mb-4">Hapus Akun</h2>
            <p class="text-gray-600 mb-4">
                Setelah akun Anda dihapus, semua resource dan data yang terkait akan dihapus secara permanen. 
                Sebelum menghapus akun Anda, harap unduh data atau informasi yang ingin Anda simpan.
            </p>

            <form method="POST" action="{{ route('profile.delete') }}">
                @csrf
                @method('DELETE')

                <div class="flex items-center">
                    <input type="checkbox" name="confirm_delete" id="confirm_delete" 
                           class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded" required>
                    <label for="confirm_delete" class="ml-2 text-sm text-gray-700">
                        Saya memahami konsekuensi penghapusan akun
                    </label>
                </div>

                <button type="submit" 
                        class="mt-4 bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition flex items-center"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan!')">
                    <i class="fas fa-trash mr-2"></i>Hapus Akun
                </button>
            </form>
        </div>
    </div>
</div>
@endsection