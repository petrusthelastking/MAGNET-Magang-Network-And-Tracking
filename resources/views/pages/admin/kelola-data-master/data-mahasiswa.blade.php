<?php

use Flux\Flux;
use function Livewire\Volt\{layout, state, usesPagination, with};
use Carbon\Carbon;
use App\Models\Mahasiswa;

layout('components.layouts.user.main');

state([
    'totalRowsPerPage' => 10,
    'statusInsertSingleData' => '',
    'storeMahasiswaNama' => null,
    'storeMahasiswaNIM' => null,
    'storeMahasiswaEmail',
    'storeMahasiswaJenisKelamin' => null,
    'storeMahasiswaTanggalLahir' => null,
    'storeMahasiswaProdi' => null,
    'storeMahasiswaAngkatan' => null,
    'storeMahasiswaAlamat' => null
]);

usesPagination();

with(function () {
    return ['dataMahasiswa' => Mahasiswa::orderBy('nama')->paginate($this->totalRowsPerPage, ['id', 'nama', 'nim', 'status_magang'])];
});

$storeSingleData = function (): void {
    $mahasiswa = Mahasiswa::create([
        'nama' => $this->storeMahasiswaNama,
        'nim' => $this->storeMahasiswaNIM,
        'email' => $this->storeMahasiswaEmail,
        'jenis_kelamin' => $this->storeMahasiswaJenisKelamin,
        'tanggal_lahir' => $this->storeMahasiswaTanggalLahir,
        'program_studi' => $this->storeMahasiswaProdi,
        'angkatan' => $this->storeMahasiswaAngkatan,
        'alamat' => $this->storeMahasiswaAlamat,
    ]);

    $this->statusInsertSingleData = $mahasiswa ? 'success' : 'failed';
    Flux::modal('add-new-student')->close();

    if ($mahasiswa) {
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
        <flux:breadcrumbs.item class="text-black">Kelola Data Mahasiswa
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <h1 class="text-base font-bold leading-6 text-black">Kelola Data Mahasiswa</h1>

    <div class="flex justify-between">
        <div class="flex gap-3">
            <flux:input class="rounded-3xl!" placeholder="Cari Data Mahasiswa" icon="magnifying-glass" />
            <flux:button variant="primary" class="bg-white! text-black! w-17 rounded-full!"
                icon="arrow-down-wide-narrow"></flux:button>
            <flux:button variant="primary" class="bg-white! text-black! w-17 rounded-full!" icon="funnel-plus">
            </flux:button>
        </div>
        <div class="flex gap-3">
            <flux:modal.trigger name="add-new-student">
                <flux:button variant="primary" class="bg-magnet-sky-teal" icon="plus">Tambah Mahasiswa</flux:button>
            </flux:modal.trigger>
            <flux:button variant="primary" class="bg-magnet-sky-teal" icon="download">Import</flux:button>
            <flux:button variant="primary" class="bg-magnet-sky-teal" icon="upload">Export</flux:button>
        </div>
    </div>

    <div class="overflow-y-auto flex flex-col items-center rounded-lg shadow bg-white">
        <table class="table-fixed w-full">
            <thead class="bg-white text-black">
                <tr class="border-b">
                    <th class="text-center px-6 py-3 w-16">No</th> <!-- TAMBAH: w-16 -->
                    <th class="text-left px-6 py-3 w-1/3">Nama</th> <!-- TAMBAH: w-1/3 -->
                    <th class="text-left px-6 py-3 w-1/4">NIM</th> <!-- TAMBAH: w-1/4 -->
                    <th class="text-left px-6 py-3 w-1/5">Status</th> <!-- TAMBAH: w-1/5 -->
                    <th class="text-center px-6 py-3 w-20">Detail</th> <!-- TAMBAH: w-20 -->
                </tr>
            </thead>
            <tbody class="bg-white text-black">
                @foreach ($dataMahasiswa as $mahasiswa)
                    <tr onclick="window.location.href='{{ route('admin.detail-mahasiswa', $mahasiswa['id']) }}'"
                        class="border-b">
                        <td class="px-6 py-3 text-center">{{ $loop->iteration + ($dataMahasiswa->firstItem() - 1) }}</td>
                        <td class="px-6 py-3">{{ $mahasiswa['nama'] }}</td>
                        <td class="px-6 py-3">{{ $mahasiswa['nim'] }}</td>
                        <td class="px-6 py-3">
                            @php
                                $status = ucfirst($mahasiswa['status_magang']);
                                $colorBadge = match ($status) {
                                    'Belum magang' => 'red',
                                    'Sedang magang' => 'yellow',
                                    'Selesai magang' => 'green',
                                };
                            @endphp
                            <flux:badge class="w-40! flex justify-center!" variant="solid" color="{{ $colorBadge }}">{{ $status }}</flux:badge>
                        </td>
                        <td class="px-6 py-3 text-center">
                            <flux:button icon="chevron-right"
                            href="{{ route('admin.detail-mahasiswa', $mahasiswa['id']) }}"
                                variant="ghost" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex items-center justify-between w-full px-8 py-4">
            <p>Menampilkan {{ $dataMahasiswa->count() }} dari {{ $dataMahasiswa->total() }} data</p>

            <div class="flex">
                <flux:button icon="chevron-left" variant="ghost" wire:click="goToPrevPage" />
                @for ($i = $dataMahasiswa->currentPage(); $i <= $dataMahasiswa->currentPage() + 5 && $i < $dataMahasiswa->lastPage(); $i++)
                    <flux:button variant="ghost" wire:click="goToSpecificPage({{ $i }})">
                        {{ $i }}
                    </flux:button>
                @endfor

                @if ($dataMahasiswa->lastPage() > 6)
                    <flux:button variant="ghost" disabled>...</flux:button>
                    <flux:button variant="ghost" wire:click="goToSpecificPage({{ $dataMahasiswa->lastPage() }})">
                        {{ $dataMahasiswa->lastPage() }}
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


    <flux:modal name="add-new-student" class="md:w-96">
        <form wire:submit="storeSingleData" class="space-y-6">
            <div>
                <flux:heading size="lg">Tambahkan data mahasiswa baru</flux:heading>
            </div>

            <flux:input label="Nama" placeholder="Nama mahasiswa" wire:model="storeMahasiswaNama" />
            <flux:input label="NIM" placeholder="NIM mahasiswa" wire:model="storeMahasiswaNIM" />
            <flux:input label="Email" placeholder="Email" wire:model="storeMahasiswaEmail" />
            <flux:field>
                <flux:label>Jenis Kelamin</flux:label>
                <flux:select placeholder="Jenis kelamin mahasiswa" wire:model="storeMahasiswaJenisKelamin">
                    <flux:select.option value="L">Laki-laki</flux:select.option>
                    <flux:select.option value="P">Perempuan</flux:select.option>
                </flux:select>
                <flux:error name="jenis_kelamin" />
            </flux:field>
            <flux:input label="Tanggal lahir" type="date" max="2999-12-31" wire:model="storeMahasiswaTanggalLahir" />
            <flux:input label="Angkatan" placeholder="Tahun angkatan mahasiswa" wire:model="storeMahasiswaAngkatan" />
            <flux:field>
                <flux:label>Program Studi</flux:label>
                <flux:select placeholder="Program studi mahasiswa" wire:model="storeMahasiswaProdi">
                    <flux:select.option value="D4 Teknik Informatika">D4 Teknik Informatika</flux:select.option>
                    <flux:select.option value="D4 Sistem Informasi Bisnis">D4 Sistem Informasi Bisnis
                    </flux:select.option>
                    <flux:select.option value="D2 Pengembangan Piranti Lunak Situs">D2 Pengembangan Piranti Lunak Situs
                    </flux:select.option>
                </flux:select>
                <flux:error name="program_studi" />
            </flux:field>
            <flux:input label="Alamat" placeholder="Alamat mahasiswa" wire:model="storeMahasiswaAlamat" />

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary" class="bg-magnet-sky-teal">Simpan</flux:button>
            </div>
        </form>
    </flux:modal>

    <flux:modal name="success-submit-form">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Sukses menambahkan data mahasiswa!</flux:heading>
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
                <flux:heading size="lg">Gagal menambahkan data mahasiswa!</flux:heading>
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
