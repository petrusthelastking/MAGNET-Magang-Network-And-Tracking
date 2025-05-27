<?php

use Flux\Flux;
use function Livewire\Volt\{layout, state, usesPagination, with};
use App\Models\DosenPembimbing;


layout('components.layouts.admin.main');

state([
    'totalRowsPerPage' => 10,
    'statusInsertSingleData' => '',
    'storeDosenNama' => null,
    'storeDosenNIDN' => null,
    'storeDosenJenisKelamin' => null
]);

usesPagination();

with(function () {
    return ['dataDosen' => DosenPembimbing::select('id', 'nama', 'nidn')
                            ->withCount([
                                'kontrakMagang as jumlah_bimbingan'
                            ])
                            ->orderBy('jumlah_bimbingan', 'desc')
                            ->paginate($this->totalRowsPerPage)];
});

$storeSingleData = function (): void {
    $dosen = DosenPembimbing::create([
        'nama' => $this->storeDosenNama,
        'nidn' => $this->storeDosenNIDN,
        'jenis_kelamin' => $this->storeDosenJenisKelamin
    ]);

    $this->statusInsertSingleData = $dosen ? 'success' : 'failed';
    Flux::modal('add-new-data')->close();

    if ($dosen) {
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
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('admin.data-dosen') }}" class="text-black">Kelola Data Dosen
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
            <flux:modal.trigger name="add-new-data">
                <flux:button variant="primary" class="bg-magnet-sky-teal" icon="plus">Tambah Dosen</flux:button>
            </flux:modal.trigger>
            <flux:button variant="primary" class="bg-magnet-sky-teal" icon="download">Import</flux:button>
            <flux:button variant="primary" class="bg-magnet-sky-teal" icon="upload">Export</flux:button>
        </div>
    </div>

    <div class="overflow-y-auto flex flex-col items-center rounded-lg shadow bg-white">
        <table class="table-auto w-full">
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
                @foreach ($dataDosen as $dosen)
                    <tr onclick="window.location.href='{{ route('admin.detail-dosen', $dosen['id']) }}'" class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3 text-center">{{ $loop->iteration }}</td>
                        <td class="px-6 py-3">{{ $dosen['nama'] }}</td>
                        <td class="px-6 py-3">{{ $dosen['nidn'] }}</td>
                        <td class="px-6 py-3 text-right">{{ $dosen['jumlah_bimbingan'] }}</td>
                        <td class="px-6 py-3 text-center">
                            <flux:button icon="chevron-right" href="{{ route('admin.detail-dosen', $dosen['id']) }}" variant="ghost" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex items-center justify-between w-full px-8 py-4">
            <div class="text-black">
                <p>Menampilkan 10 dari {{ $dataDosen->perPage() }} data</p>
            </div>
            <div class="flex">
                <flux:button icon="chevron-left" variant="ghost" wire:click="goToPrevPage"/>
                @for ($i = 0; $i < $dataDosen->lastPage(); $i++)
                    <flux:button variant="ghost" wire:click="goToSpecificPage({{ $i + 1 }})">{{ $i + 1 }}
                    </flux:button>
                @endfor
                <flux:button icon="chevron-right" variant="ghost" wire:click="goToNextPage"/>
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
                <flux:heading size="lg">Tambahkan data dosen baru</flux:heading>
            </div>

            <flux:input label="Nama" placeholder="Nama dosen" wire:model="storeDosenNama" />
            <flux:input label="NIM" placeholder="NIDN" wire:model="storeDosenNIDN" />
            <flux:field>
                <flux:label>Jenis Kelamin</flux:label>
                <flux:select placeholder="Jenis kelamin mahasiswa" wire:model="storeDosenJenisKelamin">
                    <flux:select.option value="L">Laki-laki</flux:select.option>
                    <flux:select.option value="P">Perempuan</flux:select.option>
                </flux:select>
                <flux:error name="jenis_kelamin" />
            </flux:field>

            <div class="flex">
                <flux:spacer />
                <flux:modal.trigger name="store-student-data-confirmation">
                    <flux:button type="submit" variant="primary" class="bg-magnet-sky-teal">Simpan</flux:button>
                </flux:modal.trigger>
            </div>
        </form>
    </flux:modal>

    <flux:modal name="success-submit-form">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Sukses menambahkan data dosen!</flux:heading>
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
                <flux:heading size="lg">Gagal menambahkan data dosen!</flux:heading>
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
