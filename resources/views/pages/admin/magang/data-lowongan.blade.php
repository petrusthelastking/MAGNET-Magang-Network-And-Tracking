<?php

use function Livewire\Volt\{layout, state, with, usesPagination};
use App\Models\Magang;

layout('components.layouts.user.main');

state([
    'totalRowsPerPage' => 10,
]);

usesPagination();

with(function () {
    return [
        'dataPengajuanMagang' => Magang::select('id', 'nama', 'perusahaan_id', 'lokasi', 'status')
            ->with([
                'perusahaan' => function ($query) {
                    $query->select('id', 'nama');
                },
            ])
            ->withCount(['kontrakMagang as jumlah_pendaftar'])
            ->orderBy('created_at', 'desc')
            ->paginate($this->totalRowsPerPage),
    ];
});

$goToSpecificPage = fn(int $page) => $this->setPage($page);
$goToPrevPage = fn() => $this->previousPage();
$goToNextPage = fn() => $this->nextPage();

?>

<div class="flex flex-col gap-5">
    <x-slot:user>admin</x-slot:user>

    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item class="text-black">Kelola data lowongan magang
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <h1 class="text-base font-bold leading-6 text-black">Kelola Data Lowongan Magang</h1>

    <div class="flex justify-between">
        <div class="flex gap-3">
            <flux:input class="rounded-3xl!" placeholder="Cari Data Mahasiswa" icon="magnifying-glass" />
            <flux:button variant="primary" class="bg-white! text-black! w-17 rounded-full!"
                icon="arrow-down-wide-narrow"></flux:button>
            <flux:button variant="primary" class="bg-white! text-black! w-17 rounded-full!" icon="funnel-plus">
            </flux:button>
        </div>
        <div class="flex gap-3">
            <flux:button variant="primary" class="bg-magnet-sky-teal" icon="plus">Tambah Magang</flux:button>
            <flux:button variant="primary" class="bg-magnet-sky-teal" icon="download">Import</flux:button>
            <flux:button variant="primary" class="bg-magnet-sky-teal" icon="upload">Export</flux:button>
        </div>
    </div>

    <div class="overflow-y-auto flex flex-col items-center mt-4 rounded-lg shadow bg-white">
        <table class="table-auto w-full ">
            <thead class="bg-white text-black">
                <tr class="border-b">
                    <th class="text-center px-6 py-3">No</th>
                    <th class="text-left px-6 py-3">Nama Lowongan</th>
                    <th class="text-left px-6 py-3">Perusahaan</th>
                    <th class="text-left px-6 py-3">Lokasi</th>
                    <th class="text-center px-6 py-3">Status</th>
                    <th class="text-center px-6 py-3">Jumlah Pendaftar</th>
                </tr>
            </thead>
            <tbody class="bg-white text-black">
                @foreach ($dataPengajuanMagang as $pengajuan)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3 text-center">
                            {{ $loop->iteration + ($dataPengajuanMagang->firstItem() - 1) }}</td>
                        <td class="px-6 py-3">{{ $pengajuan['nama'] }}</td>
                        <td class="px-6 py-3">{{ $pengajuan['perusahaan']['nama'] }}</td>
                        <td class="px-6 py-3">{{ $pengajuan['lokasi'] }}</td>
                        <td class="px-6 py-3">{{ $pengajuan['status'] }}</td>
                        <td class="px-6 py-3 text-right">{{ $pengajuan['jumlah_pendaftar'] }}</td>
                        <td class="px-6 py-3 text-center">
                            <flux:button icon="ellipsis-vertical" href="{{ route('admin.detail-lowongan') }}"
                                variant="ghost" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex items-center justify-between w-full px-8 py-4">
            <p>Menampilkan {{ $dataPengajuanMagang->count() }} dari {{ $dataPengajuanMagang->total() }} data</p>

            <div class="flex">
                <flux:button icon="chevron-left" variant="ghost" wire:click="goToPrevPage" />
                @for ($i = $dataPengajuanMagang->currentPage(); $i <= $dataPengajuanMagang->currentPage() + 5 && $i < $dataPengajuanMagang->lastPage(); $i++)
                    <flux:button variant="ghost" wire:click="goToSpecificPage({{ $i }})">
                        {{ $i }}
                    </flux:button>
                @endfor

                @if ($dataPengajuanMagang->lastPage() > 6)
                    <flux:button variant="ghost" disabled>...</flux:button>
                    <flux:button variant="ghost" wire:click="goToSpecificPage({{ $dataPengajuanMagang->lastPage() }})">
                        {{ $dataPengajuanMagang->lastPage() }}
                    </flux:button>
                @endif
                <flux:button icon="chevron-right" variant="ghost" wire:click="goToNextPage" />
            </div>
            <div class="flex gap-3 items-center text-black">
                <p>Baris per halaman</p>
                <flux:select class="w-20!" wire:model.live="totalRowsPerPage">
                    <flux:select.option>10</flux:select.option>
                    <flux:select.option>25</flux:select.option>
                    <flux:select.option>50</flux:select.option>
                    <flux:select.option>100</flux:select.option>
                </flux:select>
            </div>
        </div>
    </div>
</div>
