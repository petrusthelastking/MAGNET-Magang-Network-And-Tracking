<?php

use App\Models\LogMagang;
use Illuminate\Support\Facades\Auth;

use function Livewire\Volt\{layout, state, mount, computed, updated};

// Define individual state variables instead of array
state('logs', []);
state('debug_info', []);
state('currentPage', 1);
state('perPage', 10);
state('totalLogs', 0);
state('mahasiswa');

mount(function () {
    $this->mahasiswa = Auth::guard('mahasiswa')->user();
    $this->debug_info['mahasiswa_id'] = $this->mahasiswa->id ?? 'null';

    // Hitung total logs
    $this->totalLogs = LogMagang::whereHas('kontrakMagang', function ($query) {
        $query->where('mahasiswa_id', $this->mahasiswa->id);
    })->count();

    $this->loadLogs();
});

// Method untuk load logs dengan pagination
$loadLogs = function () {
    $offset = ($this->currentPage - 1) * $this->perPage;

    $this->logs = LogMagang::whereHas('kontrakMagang', function ($query) {
        $query->where('mahasiswa_id', $this->mahasiswa->id);
    })
        ->orderBy('created_at', 'desc')
        ->offset($offset)
        ->limit($this->perPage)
        ->get();

    $this->debug_info['jumlah_log_ditemukan'] = $this->logs->count();
    $this->debug_info['total_logs'] = $this->totalLogs;
};

// Computed property untuk total pages
$totalPages = computed(function () {
    return ceil($this->totalLogs / $this->perPage);
});

// Method untuk navigasi halaman
$goToPage = function ($page) {
    if ($page >= 1 && $page <= $this->totalPages) {
        $this->currentPage = $page;
        $this->loadLogs();
    }
};

$previousPage = function () {
    if ($this->currentPage > 1) {
        $this->currentPage--;
        $this->loadLogs();
    }
};

$nextPage = function () {
    if ($this->currentPage < $this->totalPages) {
        $this->currentPage++;
        $this->loadLogs();
    }
};

// Updated hook untuk handle perubahan perPage
updated([
    'perPage' => function ($value) {
        $this->currentPage = 1;
        $this->loadLogs();
    },
]);

// Method untuk redirect
$redirectToLogMagang = function ($logId) {
    return redirect()->route('mahasiswa.log-magang', ['id' => $logId]);
};

$redirectToTambahLog = function () {
    return redirect()->route('mahasiswa.tambah-log');
};

layout('components.layouts.user.main');
?>

<div class="font-sans">
    <x-slot:user>mahasiswa</x-slot:user>

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Log Harian Magang</h1>
        <p class="text-gray-500 mt-1">Catatan progres dan kegiatan harian Anda selama periode magang.</p>
    </div>

    <div
        class="flex flex-col md:flex-row items-center justify-between gap-4 mb-8 p-4 bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center gap-3 w-full md:w-auto">
            <span class="text-sm font-medium text-gray-600">Total:</span>
            <span
                class="px-3 py-1 text-sm font-semibold text-magnet-sky-teal bg-teal-50 rounded-full">{{ $this->totalLogs }}
                Laporan</span>
        </div>
        <div class="flex items-center gap-4 w-full md:w-auto">
            <div class="flex items-center gap-2">
                <label for="perPage" class="text-sm font-medium text-gray-600">Tampilkan:</label>
                <select id="perPage" wire:model.live="perPage"
                    class="w-20 px-2 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-magnet-sky-teal focus:border-magnet-sky-teal transition">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
            <flux:button variant="primary" class="bg-magnet-sky-teal w-full md:w-auto" icon="plus"
                wire:click="redirectToTambahLog">
                Buat Log Baru
            </flux:button>
        </div>
    </div>

    @if ($logs->count() > 0)
        <div class="space-y-4">
            @foreach ($logs as $log)
                @php
                    $tanggal = \Carbon\Carbon::parse($log->tanggal);
                @endphp
                <div class="flex items-start gap-4 md:gap-6 group">
                    <div class="flex-shrink-0 text-center w-20 p-3 bg-slate-50 border border-slate-200 rounded-xl">
                        <p class="text-magnet-sky-teal font-bold text-lg">{{ $tanggal->locale('id')->isoFormat('ddd') }}
                        </p>
                        <p class="text-2xl font-extrabold text-slate-700">{{ $tanggal->format('d') }}</p>
                        <p class="text-xs text-slate-500">{{ $tanggal->locale('id')->isoFormat('MMM') }}</p>
                    </div>

                    <div
                        class="flex-grow bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-lg hover:border-magnet-sky-teal transition-all duration-300">
                        <div class="p-5">
                            <p class="text-gray-700 font-semibold leading-relaxed line-clamp-2"
                                title="{{ $log->kegiatan }}">
                                {{ $log->kegiatan }}
                            </p>
                            <div class="flex items-center gap-4 mt-3 pt-3 border-t border-gray-100">
                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ \Carbon\Carbon::parse($log->jam_masuk)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($log->jam_keluar)->format('H:i') }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $tanggal->translatedFormat('d F Y') }}</span>
                                </div>
                                <div class="mrounded-b-xl border-t flex justify-end">
                                    <button wire:click="redirectToLogMagang({{ $log->id }})"
                                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-magnet-sky-teal hover:text-white hover:bg-magnet-sky-teal border border-magnet-sky-teal rounded-lg transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd"
                                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Lihat Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($this->totalPages > 1)
            <div class="mt-10 px-6 py-4 bg-white border-t border-gray-200 rounded-lg shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        Menampilkan <span class="font-semibold">{{ ($currentPage - 1) * $perPage + 1 }}</span> -
                        <span class="font-semibold">{{ min($currentPage * $perPage, $totalLogs) }}</span> dari <span
                            class="font-semibold">{{ $totalLogs }}</span> data
                    </div>

                    <div class="flex items-center space-x-2">
                        <button wire:click="previousPage" @if ($currentPage <= 1) disabled @endif
                            class="px-3 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed transition">
                            Sebelumnya
                        </button>

                        <div class="hidden md:flex items-center space-x-1">
                            @php
                                $start = max(1, $currentPage - 1);
                                $end = min($this->totalPages, $currentPage + 1);
                            @endphp

                            @if ($start > 1)
                                <button wire:click="goToPage(1)"
                                    class="px-3 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">1</button>
                                @if ($start > 2)
                                    <span class="px-2 text-gray-400">...</span>
                                @endif
                            @endif

                            @for ($i = $start; $i <= $end; $i++)
                                <button wire:click="goToPage({{ $i }})"
                                    class="px-3 py-1 text-sm rounded-lg {{ $i == $currentPage ? 'text-white bg-magnet-sky-teal' : 'text-gray-700 bg-white border border-gray-300 hover:bg-gray-50' }}">
                                    {{ $i }}
                                </button>
                            @endfor

                            @if ($end < $this->totalPages)
                                @if ($end < $this->totalPages - 1)
                                    <span class="px-2 text-gray-400">...</span>
                                @endif
                                <button wire:click="goToPage({{ $this->totalPages }})"
                                    class="px-3 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">{{ $this->totalPages }}</button>
                            @endif
                        </div>

                        <button wire:click="nextPage" @if ($currentPage >= $this->totalPages) disabled @endif
                            class="px-3 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed transition">
                            Selanjutnya
                        </button>
                    </div>
                </div>
            </div>
        @endif
    @else
        <div class="text-center py-20 px-6 bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="mx-auto w-28 h-28 bg-slate-50 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-slate-400" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mt-6">Belum Ada Log Magang</h3>
            <p class="text-gray-500 mt-2 mb-6 max-w-sm mx-auto">Sepertinya Anda belum membuat laporan harian. Mulai
                catat kegiatan Anda sekarang.</p>
            <button wire:click="redirectToTambahLog"
                class="inline-flex items-center px-5 py-2.5 bg-magnet-sky-teal text-white text-sm font-semibold rounded-lg hover:bg-opacity-90 transition-colors shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Buat Log Pertama Anda
            </button>
        </div>
    @endif
</div>
