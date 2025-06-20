<?php

use Flux\Flux;
use function Livewire\Volt\{layout, state, usesPagination, with};
use App\Models\Pekerjaan;

layout('components.layouts.user.main');

state([
    'totalRowsPerPage' => 10,
    'statusInsertSingleData',
    'storePekerjaanNama',
]);

usesPagination();

with(function () {
    return [
        'dataPekerjaan' => Pekerjaan::orderBy('nama')
            ->paginate($this->totalRowsPerPage, ['id', 'nama'])
    ];
});

$storeSingleData = function (): void {
    $pekerjaan = Pekerjaan::create([
        'nama' => $this->storePekerjaanNama,
    ]);

    $this->statusInsertSingleData = $pekerjaan ? 'success' : 'failed';
    Flux::modal('add-new-data')->close();

    if ($pekerjaan) {
        Flux::modal('success-submit-form')->show();
    } else {
        Flux::modal('failed-submit-form')->show();
    }
};

$goToSpecificPage = fn(int $page) => $this->setPage($page);
$goToPrevPage = fn() => $this->previousPage();
$goToNextPage = fn() => $this->nextPage();

?>

<div class="flex flex-col gap-5">
    <x-slot:user>admin</x-slot:user>

    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item class="text-black">Kelola Data pekerjaan
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <h1 class="text-base font-bold leading-6 text-black">Kelola Data pekerjaan</h1>

    <div class="flex justify-between">
        <div class="flex gap-3">
            <flux:input class="rounded-3xl!" placeholder="Cari Data pekerjaan" icon="magnifying-glass" />
            <flux:button variant="primary" class="bg-white! text-black! w-17 rounded-full!"
                icon="arrow-down-wide-narrow"></flux:button>
            <flux:button variant="primary" class="bg-white! text-black! w-17 rounded-full!" icon="funnel-plus">
            </flux:button>
        </div>
        <div class="flex gap-3">
            <flux:modal.trigger name="add-new-data">
                <flux:button variant="primary" class="bg-magnet-sky-teal" icon="plus">Tambah Pekerjaan</flux:button>
            </flux:modal.trigger>
            <flux:button variant="primary" class="bg-magnet-sky-teal" icon="download">Import</flux:button>
            <flux:button variant="primary" class="bg-magnet-sky-teal" icon="upload">Export</flux:button>
        </div>
    </div>

    <div class="overflow-y-auto flex flex-col items-center rounded-lg shadow bg-white">
        <table class="table-fixed w-full">
            <thead class="bg-white text-black">
                <tr class="border-b">
                    <th class="text-center px-6 py-3 w-16">No</th>
                    <th class="text-left px-6 py-3 w-1/3">Nama</th>
                    <th class="text-center px-6 py-3 w-20">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white text-black">
                @foreach ($dataPekerjaan as $pekerjaan)
                    <tr class="border-b">
                        <td class="px-6 py-3 text-center">{{ $loop->iteration + ($dataPekerjaan->firstItem() - 1) }}</td>
                        <td class="px-6 py-3">{{ $pekerjaan['nama'] }}</td>
                        <td class="px-6 py-3 text-center">
                            <flux:button variant="ghost" class="bg-blue-500! hover:bg-blue-600! text-white! font-semibold py-1 px-3 rounded">Edit</flux:button>
                            <flux:button variant="ghost" class="bg-red-500! hover:bg-red-600! text-white! font-semibold py-1 px-3 rounded ml-2">Hapus</flux:button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex items-center justify-between w-full px-8 py-4">
            <p>Menampilkan {{ $dataPekerjaan->count() }} dari {{ $dataPekerjaan->total() }} data</p>

            <div class="flex">
                <flux:button icon="chevron-left" variant="ghost" wire:click="goToPrevPage" />
                @for ($i = $dataPekerjaan->currentPage(); $i <= $dataPekerjaan->currentPage() + 5 && $i < $dataPekerjaan->lastPage(); $i++)
                    <flux:button variant="ghost" wire:click="goToSpecificPage({{ $i }})">
                        {{ $i }}
                    </flux:button>
                @endfor

                @if ($dataPekerjaan->lastPage() > 6)
                    <flux:button variant="ghost" disabled>...</flux:button>
                    <flux:button variant="ghost" wire:click="goToSpecificPage({{ $dataPekerjaan->lastPage() }})">
                        {{ $dataPekerjaan->lastPage() }}
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


    <flux:modal name="add-new-data" class="md:w-96">
        <form wire:submit="storeSingleData" class="space-y-6">
            <div>
                <flux:heading size="lg">Tambahkan data pekerjaan baru</flux:heading>
            </div>

            <flux:input label="Nama" placeholder="Nama pekerjaan" wire:model="storePekerjaanNama" />

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary" class="bg-magnet-sky-teal">Simpan</flux:button>
            </div>
        </form>
    </flux:modal>

    <flux:modal name="success-submit-form">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Sukses menambahkan data pekerjaan!</flux:heading>
            </div>
            <div class="flex">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button type="submit" variant="primary" class="bg-magnet-sky-teal">OK</flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="failed-submit-form">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Gagal menambahkan data pekerjaan!</flux:heading>
            </div>
            <div class="flex">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button type="submit" variant="primary" class="bg-magnet-sky-teal">OK</flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>
</div>
