<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-home mr-2"></i>Beranda
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-gradient-to-r from-blue-500 to-purple-600 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                            <p class="mt-2 opacity-90">Gunakan sistem pakar ini untuk mendiagnosa kerusakan laptop Anda dengan mudah.</p>
                        </div>
                        <i class="fas fa-laptop-medical text-5xl opacity-50"></i>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <a href="{{ route('diagnosa.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-300">
                    <div class="p-6 border-l-4 border-green-500">
                        <div class="flex items-center">
                            <i class="fas fa-stethoscope text-3xl text-green-500 mr-4"></i>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Diagnosa Kerusakan</h3>
                                <p class="text-gray-600 mt-1">Lakukan diagnosa kerusakan laptop berdasarkan gejala</p>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('diagnosa.riwayat') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-300">
                    <div class="p-6 border-l-4 border-blue-500">
                        <div class="flex items-center">
                            <i class="fas fa-history text-3xl text-blue-500 mr-4"></i>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Riwayat Diagnosa</h3>
                                <p class="text-gray-600 mt-1">Lihat riwayat diagnosa yang telah dilakukan</p>
                                <p class="text-sm text-gray-500 mt-2">Total: {{ $totalDiagnosa }} diagnosa</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Recent Diagnosa -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold flex items-center">
                        <i class="fas fa-clock mr-2 text-orange-500"></i>Diagnosa Terbaru
                    </h3>
                </div>
                <div class="p-6">
                    @if($userHistories->count() > 0)
                        <div class="space-y-4">
                            @foreach($userHistories as $history)
                            <div class="border rounded-lg p-4 hover:bg-gray-50 transition-colors duration-200">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $history->nama_kerusakan }}</p>
                                        <p class="text-sm text-gray-600 mt-1">{{ $history->tanggal_diagnosa }}</p>
                                    </div>
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                        {{ $history->persentase_keyakinan }}
                                    </span>
                                </div>
                                <div class="mt-3">
                                    <p class="text-sm text-gray-700"><strong>Gejala:</strong> 
                                        {{ implode(', ', array_slice($history->gejala_names, 0, 3)) }}
                                        @if(count($history->gejala_names) > 3)
                                            ... dan {{ count($history->gejala_names) - 3 }} lainnya
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="mt-4 text-center">
                            <a href="{{ route('diagnosa.riwayat') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                Lihat Semua Riwayat →
                            </a>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-clipboard-list text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500">Belum ada riwayat diagnosa.</p>
                            <a href="{{ route('diagnosa.index') }}" class="inline-block mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                Lakukan Diagnosa Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>