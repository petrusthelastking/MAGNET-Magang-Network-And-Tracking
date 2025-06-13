<?php

use function Livewire\Volt\{layout, state, usesPagination, with, computed};
use App\Models\FormPengajuanMagang;

layout('components.layouts.user.main');

state([
    'totalRowsPerPage' => 10,
    'searchTerm' => '',
    'statusFilter' => '',
    'sortBy' => 'created_at',
    'sortDirection' => 'desc',
]);

usesPagination();

$filteredQuery = computed(function () {
    $query = FormPengajuanMagang::with([
        'berkasPengajuanMagang.mahasiswa:id,nama,nim,program_studi,angkatan'
    ]);

    if (!empty($this->searchTerm)) {
        $query->whereHas('berkasPengajuanMagang.mahasiswa', function ($q) {
            $q->where('nama', 'like', '%' . $this->searchTerm . '%')
              ->orWhere('nim', 'like', '%' . $this->searchTerm . '%');
        });
    }

    if (!empty($this->statusFilter)) {
        $query->where('status', $this->statusFilter);
    }

    if ($this->sortBy === 'nama') {
        $query->join('berkas_pengajuan_magang', 'form_pengajuan_magang.pengajuan_id', '=', 'berkas_pengajuan_magang.id')
              ->join('mahasiswa', 'berkas_pengajuan_magang.mahasiswa_id', '=', 'mahasiswa.id')
              ->orderBy('mahasiswa.nama', $this->sortDirection)
              ->select('form_pengajuan_magang.*');
    } else {
        $query->orderBy($this->sortBy, $this->sortDirection);
    }

    return $query;
});

with(function () {
    return [
        'dataPengajuan' => $this->filteredQuery->paginate($this->totalRowsPerPage)->through(
            fn($form) => [
                'id' => $form->id,
                'nama' => $form->berkasPengajuanMagang->mahasiswa->nama ?? 'N/A',
                'nim' => $form->berkasPengajuanMagang->mahasiswa->nim ?? 'N/A',
                'program_studi' => $form->berkasPengajuanMagang->mahasiswa->program_studi ?? 'N/A',
                'angkatan' => $form->berkasPengajuanMagang->mahasiswa->angkatan ?? 'N/A',
                'tanggal_pengajuan' => $form->created_at->format('d M Y H:i'),
                'status' => $form->status,
                'keterangan' => $form->keterangan,
                'has_documents' => [
                    'cv' => !empty($form->berkasPengajuanMagang->cv),
                    'transkrip' => !empty($form->berkasPengajuanMagang->transkrip_nilai),
                    'portfolio' => !empty($form->berkasPengajuanMagang->portfolio),
                ],
            ],
        ),
        'statusCounts' => [
            'total' => FormPengajuanMagang::count(),
            'diproses' => FormPengajuanMagang::where('status', 'diproses')->count(),
            'diterima' => FormPengajuanMagang::where('status', 'diterima')->count(),
            'ditolak' => FormPengajuanMagang::where('status', 'ditolak')->count(),
        ],
    ];
});

$goToSpecificPage = fn(int $page) => $this->setPage($page);
$goToPrevPage = fn() => $this->previousPage();
$goToNextPage = fn() => $this->nextPage();

$resetFilters = function () {
    $this->searchTerm = '';
    $this->statusFilter = '';
    $this->sortBy = 'created_at';
    $this->sortDirection = 'desc';
    $this->setPage(1);
};

$sortBy = function (string $column) {
    if ($this->sortBy === $column) {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    } else {
        $this->sortBy = $column;
        $this->sortDirection = 'asc';
    }
    $this->setPage(1);
};

?>

<div class="flex flex-col gap-5">
    <x-slot:user>admin</x-slot:user>

    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item class="text-black">Kelola Data Pengajuan Magang</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex justify-between items-center">
        <h1 class="text-xl font-bold leading-6 text-black">Kelola Data Pengajuan Magang</h1>

        <div class="flex gap-4">
            <div class="bg-blue-50 border border-blue-200 rounded-lg px-4 py-2">
                <div class="text-sm text-blue-600">Total</div>
                <div class="text-lg font-semibold text-blue-800">{{ $statusCounts['total'] }}</div>
            </div>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg px-4 py-2">
                <div class="text-sm text-yellow-600">Diproses</div>
                <div class="text-lg font-semibold text-yellow-800">{{ $statusCounts['diproses'] }}</div>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-lg px-4 py-2">
                <div class="text-sm text-green-600">Diterima</div>
                <div class="text-lg font-semibold text-green-800">{{ $statusCounts['diterima'] }}</div>
            </div>
            <div class="bg-red-50 border border-red-200 rounded-lg px-4 py-2">
                <div class="text-sm text-red-600">Ditolak</div>
                <div class="text-lg font-semibold text-red-800">{{ $statusCounts['ditolak'] }}</div>
            </div>
        </div>
    </div>

    <div class="bg-white p-4 rounded-lg shadow-sm">
        <div class="flex flex-wrap gap-3 items-center justify-between">
            <div class="flex gap-3 flex-1">
                <flux:input
                    class="rounded-3xl flex-1 max-w-md"
                    placeholder="Cari nama atau NIM mahasiswa..."
                    icon="magnifying-glass"
                    wire:model.live.debounce.300ms="searchTerm"
                />

                <flux:select class="w-48" wire:model.live="statusFilter" placeholder="Filter Status">
                    <flux:select.option value="">Semua Status</flux:select.option>
                    <flux:select.option value="diproses">Belum Diverifikasi</flux:select.option>
                    <flux:select.option value="diterima">Diterima</flux:select.option>
                    <flux:select.option value="ditolak">Ditolak</flux:select.option>
                </flux:select>
            </div>

            <div class="flex gap-2">
                <flux:button variant="ghost" icon="arrow-path" wire:click="resetFilters">
                    Reset
                </flux:button>
                <flux:button variant="primary" class="bg-white! text-black! w-12 rounded-full!" icon="funnel">
                </flux:button>
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-lg shadow bg-white">
        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <thead class="bg-gray-50 text-gray-700">
                    <tr class="border-b">
                        <th class="text-center px-6 py-4 w-12">
                            <flux:checkbox />
                        </th>
                        <th class="text-center px-6 py-4 w-16">No</th>
                        <th class="text-left px-6 py-4 w-1/4">
                            <button class="flex items-center gap-1 hover:text-blue-600" wire:click="sortBy('nama')">
                                Mahasiswa
                                @if($sortBy === 'nama')
                                    <flux:icon.chevron-up class="w-4 h-4 {{ $sortDirection === 'asc' ? '' : 'rotate-180' }}" />
                                @endif
                            </button>
                        </th>
                        <th class="text-left px-6 py-4 w-1/6">Program Studi</th>
                        <th class="text-left px-6 py-4 w-1/6">
                            <button class="flex items-center gap-1 hover:text-blue-600" wire:click="sortBy('created_at')">
                                Waktu Pengajuan
                                @if($sortBy === 'created_at')
                                    <flux:icon.chevron-up class="w-4 h-4 {{ $sortDirection === 'asc' ? '' : 'rotate-180' }}" />
                                @endif
                            </button>
                        </th>
                        <th class="text-center px-6 py-4 w-1/6">Dokumen</th>
                        <th class="text-left px-6 py-4 w-1/6">Status</th>
                        <th class="text-center px-6 py-4 w-20">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white text-gray-900 divide-y divide-gray-200">
                    @forelse ($dataPengajuan as $pengajuan)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 text-center">
                                <flux:checkbox value="{{ $pengajuan['id'] }}" />
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ ($dataPengajuan->currentPage() - 1) * $dataPengajuan->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <div class="font-medium text-gray-900">{{ $pengajuan['nama'] }}</div>
                                    <div class="text-sm text-gray-500">{{ $pengajuan['nim'] }}</div>
                                    <div class="text-xs text-gray-400">Angkatan {{ $pengajuan['angkatan'] }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">{{ $pengajuan['program_studi'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $pengajuan['tanggal_pengajuan'] }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-1">
                                    <flux:badge
                                        variant="outline"
                                        color="{{ $pengajuan['has_documents']['cv'] ? 'green' : 'red' }}"
                                        size="sm"
                                    >CV</flux:badge>
                                    <flux:badge
                                        variant="outline"
                                        color="{{ $pengajuan['has_documents']['transkrip'] ? 'green' : 'red' }}"
                                        size="sm"
                                    >T</flux:badge>
                                    <flux:badge
                                        variant="outline"
                                        color="{{ $pengajuan['has_documents']['portfolio'] ? 'green' : 'red' }}"
                                        size="sm"
                                    >P</flux:badge>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $status = $pengajuan['status'] == 'diproses'
                                        ? 'Belum diverifikasi'
                                        : ucfirst($pengajuan['status']);

                                    $badgeColor = match ($status) {
                                        'Diterima' => 'green',
                                        'Ditolak' => 'red',
                                        'Belum diverifikasi' => 'yellow',
                                    };
                                @endphp
                                <flux:badge
                                    class="min-w-32 flex justify-center"
                                    variant="solid"
                                    color="{{ $badgeColor }}"
                                >
                                    {{ $status }}
                                </flux:badge>
                                @if($pengajuan['keterangan'])
                                    <div class="text-xs text-gray-500 mt-1">{{ $pengajuan['keterangan'] }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <flux:button
                                    icon="eye"
                                    href="{{ route('admin.detail-pengajuan-pembaruan-status-magang', $pengajuan['id']) }}"
                                    variant="ghost"
                                    size="sm"
                                />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center gap-2">
                                    <flux:icon.document-text class="w-12 h-12 text-gray-300" />
                                    <div>Tidak ada data pengajuan ditemukan</div>
                                    @if($searchTerm || $statusFilter)
                                        <flux:button variant="ghost" wire:click="resetFilters" size="sm">
                                            Hapus Filter
                                        </flux:button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between w-full px-6 py-4 bg-gray-50 border-t">
            <div class="flex items-center gap-4">
                <p class="text-sm text-gray-600">
                    Menampilkan {{ $dataPengajuan->count() }} dari {{ $dataPengajuan->total() }} data
                </p>
            </div>

            <div class="flex items-center gap-2">
                <flux:button icon="chevron-left" variant="ghost" wire:click="goToPrevPage" size="sm" />

                @if ($dataPengajuan->lastPage() <= 7)
                    @for ($i = 1; $i <= $dataPengajuan->lastPage(); $i++)
                        <flux:button
                            variant="{{ $i === $dataPengajuan->currentPage() ? 'primary' : 'ghost' }}"
                            wire:click="goToSpecificPage({{ $i }})"
                            size="sm"
                        >
                            {{ $i }}
                        </flux:button>
                    @endfor
                @else
                    @if ($dataPengajuan->currentPage() > 3)
                        <flux:button variant="ghost" wire:click="goToSpecificPage(1)" size="sm">1</flux:button>
                        <span class="text-gray-500">...</span>
                    @endif

                    @for ($i = max(1, $dataPengajuan->currentPage() - 1); $i <= min($dataPengajuan->lastPage(), $dataPengajuan->currentPage() + 1); $i++)
                        <flux:button
                            variant="{{ $i === $dataPengajuan->currentPage() ? 'primary' : 'ghost' }}"
                            wire:click="goToSpecificPage({{ $i }})"
                            size="sm"
                        >
                            {{ $i }}
                        </flux:button>
                    @endfor

                    @if ($dataPengajuan->currentPage() < $dataPengajuan->lastPage() - 2)
                        <span class="text-gray-500">...</span>
                        <flux:button variant="ghost" wire:click="goToSpecificPage({{ $dataPengajuan->lastPage() }})" size="sm">
                            {{ $dataPengajuan->lastPage() }}
                        </flux:button>
                    @endif
                @endif

                <flux:button icon="chevron-right" variant="ghost" wire:click="goToNextPage" size="sm" />
            </div>

            <div class="flex gap-3 items-center text-sm text-gray-600">
                <label>Baris per halaman:</label>
                <flux:select class="w-20" wire:model.live="totalRowsPerPage">
                    <flux:select.option value="10">10</flux:select.option>
                    <flux:select.option value="25">25</flux:select.option>
                    <flux:select.option value="50">50</flux:select.option>
                    <flux:select.option value="100">100</flux:select.option>
                </flux:select>
            </div>
        </div>
    </div>
</div>
