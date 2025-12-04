@extends('admin.layout')

@section('title', 'Tambah Rule')
@section('subtitle', 'Tambah rule baru untuk Forward Chaining')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center mb-6">
            <i class="fas fa-plus-circle text-blue-600 text-xl mr-3"></i>
            <h2 class="text-xl font-bold text-gray-800">Tambah Rule Baru</h2>
        </div>

        <form action="{{ route('admin.basis-pengetahuan.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kerusakan -->
                <div>
                    <label for="kerusakan_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Kerusakan *
                    </label>
                    <select name="kerusakan_id" id="kerusakan_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Pilih Kerusakan</option>
                        @foreach($kerusakanList as $kerusakan)
                            <option value="{{ $kerusakan->id }}" {{ old('kerusakan_id') == $kerusakan->id ? 'selected' : '' }}>
                                {{ $kerusakan->kode_kerusakan }} - {{ $kerusakan->nama_kerusakan }}
                            </option>
                        @endforeach
                    </select>
                    @error('kerusakan_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gejala -->
                <div>
                    <label for="gejala_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Gejala *
                    </label>
                    <select name="gejala_id" id="gejala_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Pilih Gejala</option>
                        @foreach($gejalaList as $gejala)
                            <option value="{{ $gejala->id }}" {{ old('gejala_id') == $gejala->id ? 'selected' : '' }}>
                                {{ $gejala->kode_gejala }} - {{ $gejala->nama_gejala }}
                            </option>
                        @endforeach
                    </select>
                    @error('gejala_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Urutan -->
                <div>
                    <label for="urutan" class="block text-sm font-medium text-gray-700 mb-2">
                        Urutan *
                    </label>
                    <input type="number" name="urutan" id="urutan" 
                           value="{{ old('urutan', 1) }}" min="1"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                           required>
                    @error('urutan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Urutan eksekusi rule (1 = pertama)</p>
                </div>
            </div>

            <!-- Preview Rule -->
            <div id="rulePreview" class="mt-6 p-4 bg-gray-50 rounded-lg border hidden">
                <h3 class="font-semibold text-gray-700 mb-2">Preview Rule:</h3>
                <code class="text-lg bg-white px-3 py-2 rounded border font-mono" id="previewText">
                    IF [GEJALA] THEN [KERUSAKAN]
                </code>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.basis-pengetahuan.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition flex items-center">
                    <i class="fas fa-save mr-2"></i>Simpan Rule
                </button>
            </div>
        </form>
    </div>

    <!-- Info -->
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded mt-6">
        <div class="flex items-start">
            <i class="fas fa-lightbulb text-blue-500 mt-1 mr-3"></i>
            <div>
                <p class="text-blue-700 font-semibold">Konsep Forward Chaining:</p>
                <ul class="text-blue-600 text-sm mt-1 list-disc list-inside space-y-1">
                    <li><strong>IF [Gejala] THEN [Kerusakan]</strong> - Jika gejala terpenuhi, maka kerusakan mungkin terjadi</li>
                    <li>Urutan menentukan prioritas eksekusi rule</li>
                    <li>Satu gejala bisa terkait dengan multiple kerusakan</li>
                    <li>Satu kerusakan bisa memiliki multiple gejala</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const kerusakanSelect = document.getElementById('kerusakan_id');
        const gejalaSelect = document.getElementById('gejala_id');
        const previewDiv = document.getElementById('rulePreview');
        const previewText = document.getElementById('previewText');

        function updatePreview() {
            const selectedKerusakan = kerusakanSelect.options[kerusakanSelect.selectedIndex];
            const selectedGejala = gejalaSelect.options[gejalaSelect.selectedIndex];
            
            if (selectedKerusakan.value && selectedGejala.value) {
                const kodeGejala = selectedGejala.text.split(' - ')[0];
                const kodeKerusakan = selectedKerusakan.text.split(' - ')[0];
                
                previewText.textContent = `IF ${kodeGejala} THEN ${kodeKerusakan}`;
                previewDiv.classList.remove('hidden');
            } else {
                previewDiv.classList.add('hidden');
            }
        }

        kerusakanSelect.addEventListener('change', updatePreview);
        gejalaSelect.addEventListener('change', updatePreview);
        
        // Initial check
        updatePreview();
    });
</script>
@endpush
@endsection