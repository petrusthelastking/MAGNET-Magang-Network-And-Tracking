<?php

use function Livewire\Volt\{layout, state, usesPagination, with, computed};
use App\Models\KontrakMagang;

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
    $query = KontrakMagang::with(['mahasiswa:id,nama,nim,program_studi,angkatan', 'dosenPembimbing:id,nama,nidn', 'lowonganMagang:id,pekerjaan_id,perusahaan_id', 'lowonganMagang.pekerjaan:id,nama', 'lowonganMagang.perusahaan:id,nama']);

    if (!empty($this->searchTerm)) {
        $query->where(function ($q) {
            $q->whereHas('mahasiswa', function ($subQuery) {
                $subQuery->where('nama', 'like', '%' . $this->searchTerm . '%')->orWhere('nim', 'like', '%' . $this->searchTerm . '%');
            })
                ->orWhereHas('lowonganMagang.pekerjaan', function ($subQuery) {
                    $subQuery->where('nama', 'like', '%' . $this->searchTerm . '%');
                })
                ->orWhereHas('lowonganMagang.perusahaan', function ($subQuery) {
                    $subQuery->where('nama', 'like', '%' . $this->searchTerm . '%');
                });
        });
    }

    if (!empty($this->statusFilter)) {
        $query->where('status', $this->statusFilter);
    }

    if ($this->sortBy === 'nama') {
        $query->join('mahasiswa', 'kontrak_magang.mahasiswa_id', '=', 'mahasiswa.id')->orderBy('mahasiswa.nama', $this->sortDirection)->select('kontrak_magang.*');
    } elseif ($this->sortBy === 'perusahaan') {
        $query->join('lowongan_magang', 'kontrak_magang.lowongan_magang_id', '=', 'lowongan_magang.id')->join('perusahaan', 'lowongan_magang.perusahaan_id', '=', 'perusahaan.id')->orderBy('perusahaan.nama', $this->sortDirection)->select('kontrak_magang.*');
    } else {
        $query->orderBy($this->sortBy, $this->sortDirection);
    }

    return $query;
});

with(function () {
    return [
        'dataKontrak' => $this->filteredQuery->paginate($this->totalRowsPerPage)->through(
            fn($kontrak) => [
                'id' => $kontrak->id,
                'mahasiswa_id' => $kontrak->mahasiswa->id ?? null, // Added mahasiswa_id
                'nama' => $kontrak->mahasiswa->nama ?? 'N/A',
                'nim' => $kontrak->mahasiswa->nim ?? 'N/A',
                'program_studi' => $kontrak->mahasiswa->program_studi ?? 'N/A',
                'angkatan' => $kontrak->mahasiswa->angkatan ?? 'N/A',
                'dosen_pembimbing' => $kontrak->dosenPembimbing->nama ?? 'N/A',
                'lowongan_judul' => $kontrak->lowonganMagang->pekerjaan->nama ?? 'N/A',
                'perusahaan' => $kontrak->lowonganMagang->perusahaan->nama ?? 'N/A',
                'waktu_awal' => $kontrak->waktu_awal ? $kontrak->waktu_awal->format('d M Y') : 'N/A',
                'waktu_akhir' => $kontrak->waktu_akhir ? $kontrak->waktu_akhir->format('d M Y') : 'N/A',
                'periode_magang' => $kontrak->waktu_awal && $kontrak->waktu_akhir ? $kontrak->waktu_awal->format('d M Y') . ' - ' . $kontrak->waktu_akhir->format('d M Y') : 'N/A',
                'tanggal_kontrak' => $kontrak->created_at->format('d M Y H:i'),
                'status' => $kontrak->status,
            ],
        ),
        'statusCounts' => [
            'total' => KontrakMagang::count(),
            'menunggu_persetujuan' => KontrakMagang::where('status', 'menunggu_persetujuan')->count(),
            'disetujui' => KontrakMagang::where('status', 'disetujui')->count(),
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
        <flux:breadcrumbs.item class="text-black">Kelola Data Pembaruan Status</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex justify-between items-center">
        <h1 class="text-xl font-bold leading-6 text-black">Kelola Data Pembaruan Status</h1>

        <div class="flex gap-4">
            <div class="bg-blue-50 border border-blue-200 rounded-lg px-4 py-2">
                <div class="text-sm text-blue-600">Total</div>
                <div class="text-lg font-semibold text-blue-800">{{ $statusCounts['total'] }}</div>
            </div>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg px-4 py-2">
                <div class="text-sm text-yellow-600">Menunggu Persetujuan</div>
                <div class="text-lg font-semibold text-yellow-800">{{ $statusCounts['menunggu_persetujuan'] }}</div>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-lg px-4 py-2">
                <div class="text-sm text-green-600">Disetujui</div>
                <div class="text-lg font-semibold text-green-800">{{ $statusCounts['disetujui'] }}</div>
            </div>
        </div>
    </div>

    <div class="bg-white p-4 rounded-lg shadow-sm">
        <div class="flex flex-wrap gap-3 items-center justify-between">
            <div class="flex gap-3 flex-1">
                <flux:input class="rounded-3xl flex-1 max-w-md"
                    placeholder="Cari nama mahasiswa, NIM, pekerjaan, atau perusahaan..." icon="magnifying-glass"
                    wire:model.live.debounce.300ms="searchTerm" />

                <flux:select class="w-48" wire:model.live="statusFilter" placeholder="Filter Status">
                    <flux:select.option value="">Semua Status</flux:select.option>
                    <flux:select.option value="menunggu_persetujuan">Menunggu Persetujuan</flux:select.option>
                    <flux:select.option value="disetujui">Disetujui</flux:select.option>
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
                        <th class="text-left px-6 py-4 w-1/5">
                            <button class="flex items-center gap-1 hover:text-blue-600" wire:click="sortBy('nama')">
                                Mahasiswa
                                @if ($sortBy === 'nama')
                                    <flux:icon.chevron-up
                                        class="w-4 h-4 {{ $sortDirection === 'asc' ? '' : 'rotate-180' }}" />
                                @endif
                            </button>
                        </th>
                        <th class="text-left px-6 py-4 w-1/6">
                            <button class="flex items-center gap-1 hover:text-blue-600"
                                wire:click="sortBy('perusahaan')">
                                Perusahaan
                                @if ($sortBy === 'perusahaan')
                                    <flux:icon.chevron-up
                                        class="w-4 h-4 {{ $sortDirection === 'asc' ? '' : 'rotate-180' }}" />
                                @endif
                            </button>
                        </th>
                        <th class="text-left px-6 py-4 w-1/6">Dosen Pembimbing</th>
                        <th class="text-left px-6 py-4 w-1/6">Periode Magang</th>
                        <th class="text-left px-6 py-4 w-1/6">
                            <button class="flex items-center gap-1 hover:text-blue-600"
                                wire:click="sortBy('created_at')">
                                Tanggal Kontrak
                                @if ($sortBy === 'created_at')
                                    <flux:icon.chevron-up
                                        class="w-4 h-4 {{ $sortDirection === 'asc' ? '' : 'rotate-180' }}" />
                                @endif
                            </button>
                        </th>
                        <th class="text-left px-6 py-4 w-1/6">Status</th>
                        <th class="text-center px-6 py-4 w-20">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white text-gray-900 divide-y divide-gray-200">
                    @forelse ($dataKontrak as $kontrak)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 text-center">
                                <flux:checkbox value="{{ $kontrak['id'] }}" />
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-gray-500">
                                {{ ($dataKontrak->currentPage() - 1) * $dataKontrak->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <div class="font-medium text-gray-900">{{ $kontrak['nama'] }}</div>
                                    <div class="text-sm text-gray-500">{{ $kontrak['nim'] }}</div>
                                    <div class="text-xs text-gray-400">{{ $kontrak['program_studi'] }} -
                                        {{ $kontrak['angkatan'] }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <div class="font-medium text-gray-900">{{ $kontrak['perusahaan'] }}</div>
                                    <div class="text-sm text-gray-500">{{ $kontrak['lowongan_judul'] }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @php
                                    $status = $kontrak['status'] == 'menunggu_persetujuan'
                                        ? 'Menunggu Persetujuan'
                                        : 'Disetujui';

                                    $dosenPembimbing = $kontrak['status'] == 'menunggu_persetujuan'
                                        ? '-'
                                        : $kontrak['dosen_pembimbing'];
                                @endphp

                                {{ $dosenPembimbing }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">{{ $kontrak['periode_magang'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $kontrak['tanggal_kontrak'] }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $status =
                                        $kontrak['status'] == 'menunggu_persetujuan'
                                        ? 'Menunggu Persetujuan'
                                        : 'Disetujui';

                                    $badgeColor = match ($kontrak['status']) {
                                        'disetujui' => 'green',
                                        'menunggu_persetujuan' => 'yellow',
                                        default => 'gray',
                                    };
                                @endphp
                                <flux:badge class="min-w-32 flex justify-center" variant="solid" color="{{ $badgeColor }}">
                                    {{ $status }}
                                </flux:badge>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($kontrak['mahasiswa_id'])
                                    <div onclick="window.location='{{ route('admin.detail-pengajuan-pembaruan-status-magang', ['id' => $kontrak['mahasiswa_id']]) }}'"
                                        class="cursor-pointer">
                                        <flux:button icon="eye" variant="ghost" size="sm" />
                                    </div>
                                @else
                                    <flux:button icon="eye" variant="ghost" size="sm" disabled />
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center gap-2">
                                    <flux:icon.document-text class="w-12 h-12 text-gray-300" />
                                    <div>Tidak ada data kontrak magang ditemukan</div>
                                    @if ($searchTerm || $statusFilter)
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
                    Menampilkan {{ $dataKontrak->count() }} dari {{ $dataKontrak->total() }} data
                </p>
            </div>

            <div class="flex items-center gap-2">
                <flux:button icon="chevron-left" variant="ghost" wire:click="goToPrevPage" size="sm" />

                @if ($dataKontrak->lastPage() <= 7)
                    @for ($i = 1; $i <= $dataKontrak->lastPage(); $i++)
                        <flux:button variant="{{ $i === $dataKontrak->currentPage() ? 'primary' : 'ghost' }}"
                            wire:click="goToSpecificPage({{ $i }})" size="sm">
                            {{ $i }}
                        </flux:button>
                    @endfor
                @else
                    @if ($dataKontrak->currentPage() > 3)
                        <flux:button variant="ghost" wire:click="goToSpecificPage(1)" size="sm">1</flux:button>
                        <span class="text-gray-500">...</span>
                    @endif

                    @for ($i = max(1, $dataKontrak->currentPage() - 1); $i <= min($dataKontrak->lastPage(), $dataKontrak->currentPage() + 1); $i++)
                        <flux:button variant="{{ $i === $dataKontrak->currentPage() ? 'primary' : 'ghost' }}"
                            wire:click="goToSpecificPage({{ $i }})" size="sm">
                            {{ $i }}
                        </flux:button>
                    @endfor

                    @if ($dataKontrak->currentPage() < $dataKontrak->lastPage() - 2)
                        <span class="text-gray-500">...</span>
                        <flux:button variant="ghost" wire:click="goToSpecificPage({{ $dataKontrak->lastPage() }})" size="sm">
                            {{ $dataKontrak->lastPage() }}
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