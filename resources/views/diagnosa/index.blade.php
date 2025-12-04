@extends('layouts.app')

@section('title', 'Diagnosa Kerusakan Laptop')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center mb-6">
            <i class="fas fa-stethoscope text-blue-600 text-2xl mr-3"></i>
            <h1 class="text-2xl font-bold text-gray-800">Diagnosa Kerusakan Laptop</h1>
        </div>

        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                <div>
                    <p class="text-blue-700 font-semibold">Cara Penggunaan:</p>
                    <p class="text-blue-600 text-sm mt-1">
                        Pilih gejala-gejala yang dialami laptop Anda. Sistem akan menganalisis menggunakan 
                        <strong>Forward Chaining</strong> untuk menentukan kemungkinan kerusakan.
                    </p>
                </div>
            </div>
        </div>

        <form action="{{ route('diagnosa.proses') }}" method="POST" id="diagnosaForm">
            @csrf
            
            @foreach($gejalaByKategori as $kategori => $gejalas)
            <div class="mb-8">
                <div class="flex items-center mb-4 p-3 bg-gray-100 rounded-lg">
                    @php
                        $icons = [
                            'hardware' => 'fas fa-microchip',
                            'software' => 'fas fa-code',
                            'battery' => 'fas fa-battery-half',
                            'display' => 'fas fa-desktop'
                        ];
                    @endphp
                    <i class="{{ $icons[$kategori] ?? 'fas fa-question-circle' }} text-blue-600 text-xl mr-3"></i>
                    <h2 class="text-xl font-semibold text-gray-800 capitalize">{{ $kategori }}</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($gejalas as $gejala)
                    <div class="flex items-start p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <input type="checkbox" name="gejala[]" value="{{ $gejala->id }}" 
                               id="gejala_{{ $gejala->id }}" 
                               class="mt-1 mr-3 h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <div>
                            <label for="gejala_{{ $gejala->id }}" class="font-medium text-gray-700 cursor-pointer">
                                {{ $gejala->nama_gejala }}
                            </label>
                            @if($gejala->deskripsi)
                            <p class="text-sm text-gray-500 mt-1">{{ $gejala->deskripsi }}</p>
                            @endif
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mt-2">
                                {{ $gejala->kode_gejala }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach

            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <div class="text-sm text-gray-500">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Sistem menggunakan metode <strong>Forward Chaining</strong>
                </div>
                <button type="submit" 
                        id="submitBtn"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-200 flex items-center">
                    <i class="fas fa-play-circle mr-2"></i>
                    Proses Diagnosa
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('diagnosaForm').addEventListener('submit', function(e) {
    const checkboxes = document.querySelectorAll('input[name="gejala[]"]:checked');
    if (checkboxes.length === 0) {
        e.preventDefault();
        alert('Pilih minimal 1 gejala untuk memulai diagnosa.');
        return false;
    }
    
    // Show loading state
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
    submitBtn.disabled = true;
});
</script>
@endpush
@endsection