<?php

use function Livewire\Volt\{layout, state, mount};

layout('components.layouts.admin.main');

state([
    'totalRowsPerPage' => 10,
    'data_dosen' => []
]);

mount(function () {
    $this->data_dosen = DB::table('dosen_profiles')
        ->join('users', 'dosen_profiles.user_id', '=', 'users.id')
        ->select(
            'users.name',
            'dosen_profiles.nip',
            DB::raw("'3/10' as jumlah_bimbingan"),
        )
        ->get();
});

?>

<div class="flex flex-col gap-5">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('admin.detail-dosen') }}" class="text-black">Kelola Data Dosen
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <h1 class="text-base font-bold leading-6 text-black">Kelola Data Dosen</h1>

    <div class="flex justify-between">
        <div class="flex gap-3">
            <flux:input class="rounded-3xl!" placeholder="Cari Data Dosen" icon="magnifying-glass" />
            <flux:button variant="primary" class="bg-white! text-black! w-17 rounded-full!"
                icon="arrow-down-wide-narrow"></flux:button>
            <flux:button variant="primary" class="bg-white! text-black! w-17 rounded-full!" icon="funnel-plus">
            </flux:button>
        </div>
        <div class="flex gap-3">
            <flux:button variant="primary" class="bg-magnet-sky-teal" icon="plus">Tambah Dosen</flux:button>
            <flux:button variant="primary" class="bg-magnet-sky-teal" icon="download">Import</flux:button>
            <flux:button variant="primary" class="bg-magnet-sky-teal" icon="upload">Export</flux:button>
        </div>
    </div>

    <div class="overflow-y-auto flex flex-col items-center rounded-lg shadow bg-white">
        <table class="table-auto w-full ">
            <thead class="bg-white text-black">
                <tr class="border-b">
                    <th class="text-center px-6 py-3">No</th>
                    <th class="text-left px-6 py-3">Nama</th>
                    <th class="text-left px-6 py-3">NIDN</th>
                    <th class="text-left px-6 py-3">Jumlah Bimbingan</th>
                    <th class="text-center px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white text-black">
                @for ($i = 0; $i < count($data_dosen) && $i < $totalRowsPerPage; $i++)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3 text-center">{{ $i + 1 }}</td>
                        <td class="px-6 py-3">{{ $data_dosen[$i]->name }}</td>
                        <td class="px-6 py-3">{{ $data_dosen[$i]->nip }}</td>
                        <td class="px-6 py-3">{{ $data_dosen[$i]->jumlah_bimbingan }}</td>
                        <td class="px-6 py-3 text-center">
                            <flux:button icon="ellipsis-vertical" href="{{ route('admin.detail-dosen') }}" variant="ghost" />
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
                @for ($i = 0; $i < ceil(count($data_dosen) / $totalRowsPerPage); $i++)
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
