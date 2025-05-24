<?php

use function Livewire\Volt\{layout, state, mount};
use App\Models\FormPengajuanMagang;

layout('components.layouts.admin.main');

state([
    'totalRowsPerPage' => 10,
    'data_pengajuan' => []
]);

mount(function () {
    $this->data_pengajuan = FormPengajuanMagang::with(['berkasPengajuanMagang.mahasiswa'])
        ->get()
        ->map(function ($form) {
            return [
                'nama' => $form->berkasPengajuanMagang->mahasiswa->nama ?? null,
                'tanggal_pengajuan' => $form->created_at,
                'status' => $form->status,
            ];
        })
        ->toArray();
});

?>

<div class="flex flex-col gap-5">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('admin.data-lowongan') }}" class="text-black">Kelola data pengajuan magang
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
                @for ($i = 0; $i < count($data_pengajuan) && $i < $totalRowsPerPage; $i++)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3 text-center">{{ $i + 1 }}</td>
                        <td class="px-6 py-3">{{ $data_pengajuan[$i]['nama'] }}</td>
                        <td class="px-6 py-3">{{ $data_pengajuan[$i]['tanggal_pengajuan'] }}</td>
                        <td class="px-6 py-3">
                            @php
                                $status = $data_pengajuan[$i]['status'] == 'diproses' ? 'Belum diverifikasi' : ucfirst($data_pengajuan[$i]['status']);

                                $badgeColor = match ($status) {
                                    'Diterima' => 'green',
                                    'Ditolak' => 'red',
                                    'Belum diverifikasi' => 'yellow',
                                };
                            @endphp

                            <flux:badge variant="solid" color="{{ $badgeColor }}">{{ $status }}</flux:badge>
                        </td>
                        <td class="px-6 py-3 text-center">
                            <flux:button icon="ellipsis-vertical" href="{{ route('admin.detail-pengajuan') }}" variant="ghost" />
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
        <div class="flex items-center justify-between w-full px-8 py-4">
            <div class="text-black">
                <p>Menampilkan 10 dari {{ $totalRowsPerPage }} data</p>
            </div>
            <div class="flex">
                <flux:button icon="chevron-left" variant="ghost" />
                @for ($i = 0; $i < ceil(count($data_pengajuan) / $totalRowsPerPage); $i++)
                    <flux:button variant="ghost">{{ $i + 1 }}</flux:button>
                @endfor
                <flux:button icon="chevron-right" variant="ghost" />
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
