@extends('admin.layout')

@section('title', 'Riwayat Diagnosa')
@section('subtitle', 'Kelola riwayat diagnosa pengguna')

@section('content')
<div class="space-y-6">
    <!-- Header dengan Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <i class="fas fa-stethoscope text-blue-600 text-2xl mr-4"></i>
                <div>
                    <p class="text-sm text-gray-600">Total Diagnosa</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalDiagnosa }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <i class="fas fa-calendar-day text-green-600 text-2xl mr-4"></i>
                <div>
                    <p class="text-sm text-gray-600">Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $diagnosaHariIni }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
            <div class="flex items-center">
                <i class="fas fa-calendar-week text-purple-600 text-2xl mr-4"></i>
                <div>
                    <p class="text-sm text-gray-600">Minggu Ini</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $diagnosaMingguIni }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-500">
            <div class="flex items-center">
                <i class="fas fa-chart-line text-orange-600 text-2xl mr-4"></i>
                <div>
                    <p class="text-sm text-gray-600">Rata-rata/hari</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalDiagnosa > 0 ? round($totalDiagnosa / 30, 1) : 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Kerusakan -->
    @if($statistikKerusakan->count() > 0)
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-chart-bar mr-2"></i>Statistik Kerusakan Terbanyak
        </h3>
        <div class="space-y-3">
            @foreach($statistikKerusakan as $stat)
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-700">{{ $stat->hasil_akhir }}</span>
                        <span class="font-medium text-gray-800">{{ $stat->total }} diagnosa</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        @php
                            $percentage = $totalDiagnosa > 0 ? ($stat->total / $totalDiagnosa) * 100 : 0;
                        @endphp
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Table Riwayat -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Riwayat Diagnosa</h3>
                <p class="text-sm text-gray-600">Data lengkap semua diagnosa yang dilakukan</p>
            </div>
            <div class="flex space-x-2">
                <form id="bulkDeleteForm" action="{{ route('admin.history.bulk-delete') }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="ids" id="bulkDeleteIds">
                </form>
                <button id="bulkDeleteBtn" 
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition flex items-center hidden">
                    <i class="fas fa-trash mr-2"></i>Hapus Terpilih
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-8">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300">
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pengguna</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gejala Dipilih</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hasil</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Langkah</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($histories as $history)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">
                            <input type="checkbox" name="selected_ids[]" value="{{ $history->id }}" 
                                   class="row-checkbox rounded border-gray-300">
                        </td>
                        <td class="px-4 py-3">
                            <div>
                                <p class="font-medium text-gray-800">{{ $history->nama_pengguna }}</p>
                                <p class="text-sm text-gray-600">{{ $history->email }}</p>
                                @if($history->user)
                                <p class="text-xs text-gray-500">User ID: {{ $history->user_id }}</p>
                                @else
                                <p class="text-xs text-gray-500">Guest</p>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3">
    <span class="text-sm text-gray-600">
        @php
            // Pastikan kita menghitung array, bukan menampilkan array sebagai string
            $gejalaTerpilih = $history->gejala_terpilih;
            $jumlahGejala = is_array($gejalaTerpilih) ? count($gejalaTerpilih) : 0;
        @endphp
        {{ $jumlahGejala }} gejala
    </span>
</td>
                        <td class="px-4 py-3">
                            <span class="font-medium text-gray-800">{{ $history->hasil_akhir }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-sm text-gray-600">{{ $history->langkah_diagnosa }} langkah</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-gray-600">
                                <p>{{ $history->created_at->format('d M Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $history->created_at->format('H:i') }}</p>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.history.show', $history->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 transition" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.history.destroy', $history->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 transition" 
                                            title="Hapus"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus riwayat ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-3xl mb-2"></i>
                            <p>Belum ada riwayat diagnosa</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($histories->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $histories->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.row-checkbox');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const bulkDeleteForm = document.getElementById('bulkDeleteForm');
    const bulkDeleteIds = document.getElementById('bulkDeleteIds');

    // Select All functionality
    selectAll.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        toggleBulkDeleteButton();
    });

    // Individual checkbox change
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            selectAll.checked = allChecked;
            toggleBulkDeleteButton();
        });
    });

    // Toggle bulk delete button
    function toggleBulkDeleteButton() {
        const selectedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
        if (selectedCount > 0) {
            bulkDeleteBtn.classList.remove('hidden');
        } else {
            bulkDeleteBtn.classList.add('hidden');
        }
    }

    // Bulk delete
    bulkDeleteBtn.addEventListener('click', function() {
        const selectedIds = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        if (selectedIds.length > 0 && confirm(`Apakah Anda yakin ingin menghapus ${selectedIds.length} riwayat?`)) {
            bulkDeleteIds.value = JSON.stringify(selectedIds);
            bulkDeleteForm.submit();
        }
    });
});
</script>
@endpush
@endsection