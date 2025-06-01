<?php

use function Livewire\Volt\{layout, state, usesPagination, with};
use App\Models\FormPengajuanMagang;

layout('components.layouts.user.main');

state([
    'totalRowsPerPage' => 10,
]);

usesPagination();

with(function () {
    return [
        'dataPengajuan' => FormPengajuanMagang::with('berkasPengajuanMagang.mahasiswa')
            ->paginate($this->totalRowsPerPage)
            ->through(
            fn($form) => [
                'nama' => $form->berkasPengajuanMagang->mahasiswa->nama ?? null,
                'tanggal_pengajuan' => $form->created_at,
                'status' => $form->status,
            ],
        ),
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
        <flux:breadcrumbs.item href="{{ route('admin.data-pengajuan-magang') }}" class="text-black">Kelola data pengajuan
            magang
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <h1 class="text-base font-bold leading-6 text-black">Kelola Data Pengajuan Magang</h1>

    <div class="flex justify-start">
        <div class="flex gap-3">
            <flux:input class="rounded-3xl!" placeholder="Cari Data Pengajuan" icon="magnifying-glass" />
            <flux:button variant="primary" class="bg-white! text-black! w-17 rounded-full!"
                icon="arrow-down-wide-narrow"></flux:button>
            <flux:button variant="primary" class="bg-white! text-black! w-17 rounded-full!" icon="funnel-plus">
            </flux:button>
        </div>
    </div>

    <div class="overflow-y-auto flex flex-col items-center rounded-lg shadow bg-white">
        <table class="table-auto w-full ">
            <thead class="bg-white text-black">
                <tr class="border-b">
                    <th class="text-center px-6 py-3">No</th>
                    <th class="text-left px-6 py-3">Mahasiswa</th>
                    <th class="text-left px-6 py-3">Tanggal Pengajuan</th>
                    <th class="text-center px-6 py-3">Status</th>
                    <th class="text-center px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white text-black">
                @foreach ($dataPengajuan as $pengajuan)
                    <tr class="border-b">
                        <td class="px-6 py-3 text-center">{{ $loop->iteration }}</td>
                        <td class="px-6 py-3">{{ $pengajuan['nama'] }}</td>
                        <td class="px-6 py-3">{{ $pengajuan['tanggal_pengajuan'] }}</td>
                        <td class="px-6 py-3">
                            @php
                                $status =
                                    $pengajuan['status'] == 'diproses'
                                        ? 'Belum diverifikasi'
                                        : ucfirst($pengajuan['status']);

                                $badgeColor = match ($status) {
                                    'Diterima' => 'green',
                                    'Ditolak' => 'red',
                                    'Belum diverifikasi' => 'yellow',
                                };
                            @endphp

                            <flux:badge variant="solid" color="{{ $badgeColor }}">{{ $status }}</flux:badge>
                        </td>
                        <td class="px-6 py-3 text-center">
                            <flux:button icon="ellipsis-vertical" href="{{ route('admin.detail-pengajuan') }}"
                                variant="ghost" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex items-center justify-between w-full px-8 py-4">
            <div class="text-black">
                <p>Menampilkan {{ $dataPengajuan->count() }} dari {{ $dataPengajuan->perPage() }} data</p>
            </div>
            <div class="flex">
                <flux:button icon="chevron-left" variant="ghost" wire:click="goToPrevPage" />
                @for ($i = 0; $i < $dataPengajuan->lastPage(); $i++)
                    <flux:button variant="ghost" wire:click="goToSpecificPage({{ $i + 1 }})">
                        {{ $i + 1 }}
                    </flux:button>
                @endfor
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
