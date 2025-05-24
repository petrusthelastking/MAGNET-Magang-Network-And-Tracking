<?php

use function Livewire\Volt\{layout, state, mount};
use App\Models\Mahasiswa;

layout('components.layouts.admin.main');

state([
    'mahasiswa' => null,
    'program_studi' => null,
    'jenis_kelamin' => null,
    'status_magang' => null,
]);

mount(function (int $id) {
    $this->mahasiswa = Mahasiswa::findOrFail($id);
    $this->program_studi = $this->mahasiswa->program_studi;
    $this->jenis_kelamin = $this->mahasiswa->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan';
    $this->status_magang = ucfirst($this->mahasiswa->status_magang);
});

$editData = function () : void {

};

$deleteData = function () : void {

};

?>

<div class="flex flex-col gap-5">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('admin.data-mahasiswa') }}" class="text-black">Kelola Data Mahasiswa
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item class="text-black">Detail Data Mahasiswa
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <h1 class="text-base font-bold leading-6 text-black">Detail Informasi Mahasiswa</h1>

    <div class="min-h-screen p-6">
        <div>
            <div class="flex gap-8 items-start">
                <div class="flex flex-col items-center bg-white p-4 rounded-xl shadow-md">
                    <img src="{{ asset('cewek.png') }}" alt="Foto Mahasiswa"
                        class="w-40 h-52 object-cover rounded-md mb-4" />
                    <div class="flex gap-4">
                        <flux:button wire:click="toggleEdit" icon="pencil"
                            class="bg-emerald-400! hover:bg-green-500! text-white! rounded-md items-center min-w-[100px] max-w-[100px]">
                            Edit
                        </flux:button>
                        <flux:modal.trigger name="delete-profile">
                            <flux:button icon="trash-2"
                                class="bg-red-400! hover:bg-red-500! text-white! rounded-md items-center">
                                Hapus
                            </flux:button>
                        </flux:modal.trigger>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md w-full max-w-3xl text-black">
                    <h2 class="text-lg font-semibold">Informasi Pribadi</h2>

                    <div class="flex flex-col gap-4">
                        <flux:field>
                            <flux:label>Nama Lengkap</flux:label>
                            <flux:input value="{{ $mahasiswa->nama }}" readonly
                                class="caret-transparent"/>
                            <flux:error name="username" />
                        </flux:field>

                        <flux:field>
                            <flux:label>NIM</flux:label>
                            <flux:input value="{{ $mahasiswa->nim }}" readonly
                                class="caret-transparent"/>
                            <flux:error name="nim" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Jurusan</flux:label>
                            <flux:input value="{{ $mahasiswa->jurusan }}" readonly
                                class="caret-transparent"/>
                            <flux:error name="jurusan" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Program Studi</flux:label>
                            <flux:select placeholder="Program Studi Anda" wire:model="program_studi">
                                <flux:select.option value="D4 Teknik Informatika">D4 Teknik Informatika</flux:select.option>
                                <flux:select.option value="D4 Sistem Informasi Bisnis">D4 Sistem Informasi Bisnis</flux:select.option>
                                <flux:select.option value="D2 Pengembangan Perangkat Lunak Situs">D2 Pengembangan Perangkat Lunak Situs</flux:select.option>
                            </flux:select>
                            <flux:error name="program_studi" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Angkatan</flux:label>
                            <flux:input value="{{ $mahasiswa->angkatan }}" readonly
                                class="caret-transparent"/>
                            <flux:error name="angkatan" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Jenis Kelamin</flux:label>
                            <flux:select placeholder="Jenis Kelamin Mahasiswa" wire:model="jenis_kelamin">
                                <flux:select.option value="L">Laki-Laki</flux:select.option>
                                <flux:select.option value="P">Perempuan</flux:select.option>
                            </flux:select>
                            <flux:error name="jenis_kelamin" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Umur</flux:label>
                            <flux:input value="{{ $mahasiswa->umur }} tahun" readonly
                                class="caret-transparent"/>
                            <flux:error name="umur" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Status Magang</flux:label>
                            <flux:select placeholder="Status Magang Mahasiswa" wire:model="status_magang">
                                <flux:select.option value="belum magang">Belum magang</flux:select.option>
                                <flux:select.option value="sedang magang" selected>Sedang magang</flux:select.option>
                                <flux:select.option value="selesai magang">Selesai magang</flux:select.option>
                            </flux:select>
                            <flux:error name="status_magang" />
                        </flux:field>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <flux:modal name="delete-profile" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Hapus Data?</flux:heading>
                <flux:text class="mt-2">
                    <p>Apakah anda yakin ingin menghapus data mahasiswa ?</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Batalkan</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="danger">Hapus</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
