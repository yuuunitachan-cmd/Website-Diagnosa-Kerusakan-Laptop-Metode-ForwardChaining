<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                        <div class="flex items-center">
                            <i class="fas fa-cogs text-2xl mr-4"></i>
                            <div>
                                <p class="text-sm opacity-75">Total Kerusakan</p>
                                <p class="text-2xl font-bold">{{ $stats['total_kerusakan'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gradient-to-r from-green-500 to-green-600 text-white">
                        <div class="flex items-center">
                            <i class="fas fa-list text-2xl mr-4"></i>
                            <div>
                                <p class="text-sm opacity-75">Total Gejala</p>
                                <p class="text-2xl font-bold">{{ $stats['total_gejala'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gradient-to-r from-purple-500 to-purple-600 text-white">
                        <div class="flex items-center">
                            <i class="fas fa-history text-2xl mr-4"></i>
                            <div>
                                <p class="text-sm opacity-75">Total Riwayat</p>
                                <p class="text-2xl font-bold">{{ $stats['total_riwayat'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gradient-to-r from-orange-500 to-orange-600 text-white">
                        <div class="flex items-center">
                            <i class="fas fa-users text-2xl mr-4"></i>
                            <div>
                                <p class="text-sm opacity-75">Total Users</p>
                                <p class="text-2xl font-bold">{{ $stats['total_users'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities & Popular Kerusakan -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Histories -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold flex items-center">
                            <i class="fas fa-clock mr-2 text-blue-500"></i>Riwayat Terbaru
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($recentHistories->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentHistories as $history)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $history->nama_pengguna }}</p>
                                        <p class="text-sm text-gray-600">{{ $history->created_at->diffForHumans() }}</p>
                                    </div>
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">
                                        {{ $history->persentase_keyakinan ?? 'N/A' }}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">Belum ada riwayat diagnosa.</p>
                        @endif
                    </div>
                </div>

                <!-- Popular Kerusakan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold flex items-center">
                            <i class="fas fa-chart-bar mr-2 text-green-500"></i>Kerusakan Populer
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($popularKerusakan->count() > 0)
                            <div class="space-y-3">
                                @foreach($popularKerusakan as $namaKerusakan => $total)
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700">{{ $namaKerusakan }}</span>
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">
                                        {{ $total }}x
                                    </span>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">Data kerusakan populer belum tersedia.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>