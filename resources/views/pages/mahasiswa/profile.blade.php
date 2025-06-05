<?php

use function Livewire\Volt\{state, mount};

state([
    'isUpdatePreference' => false,
    'bidang_industri',
    'jenis_magang',
    'lokasi_magang',
    'pekerjaan',
    'open_remote'

]);

mount(function () {
    $preferensiMahasiswa = auth('mahasiswa')->user()->preferensiMahasiswa()->first();
    $this->bidang_industri = $preferensiMahasiswa->kriteriaBidangIndustri->bidangIndustri->nama;
    $this->jenis_magang = $preferensiMahasiswa->kriteriaJenisMagang->jenis_magang;
    $this->lokasi_magang = $preferensiMahasiswa->kriteriaLokasiMagang->lokasiMagang->kategori_lokasi;
    $this->pekerjaan = $preferensiMahasiswa->kriteriaPekerjaan->pekerjaan->nama;
    $this->open_remote = $preferensiMahasiswa->kriteriaOpenRemote->open_remote;
});

?>

<div>
    <div class="gap-3 flex flex-col">
        <div class="card bg-white shadow-md">
            <div class="card-body p-5">
                <flux:avatar circle src="https://unavatar.io/x/{{ auth('mahasiswa')->user()->nama }}" class="w-24 h-24" />
                <div class="grid grid-cols-2 gap-3 ">
                    <flux:input readonly value="{{ auth('mahasiswa')->user()->nama }}" type="text"
                        label="Nama Lengkap" />
                    <flux:input readonly value="{{ auth('mahasiswa')->user()->nim }}" type="text" label="NIM" />
                    <flux:input readonly value="{{ auth('mahasiswa')->user()->jurusan }}" type="text"
                        label="Jurusan" />
                    <flux:input readonly value="{{ auth('mahasiswa')->user()->program_studi }}" type="text"
                        label="Program Studi" />
                    <flux:input readonly
                        value="{{ auth('mahasiswa')->user()->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}"
                        type="text" label="Jenis Kelamin" />
                    <flux:input readonly value="{{ auth('mahasiswa')->user()->alamat }}" type="text"
                        label="Alamat" />

                </div>
            </div>

            <div class="card-actions flex justify-end p-5">
                <flux:button class="bg-magnet-sky-teal! text-white!" icon="pencil">Edit data anda</flux:button>
            </div>
        </div>

        <div class="card bg-white shadow-md">
            <div class="card-body grid grid-cols-2 gap-3">
                <flux:input readonly
                    value="{{ $pekerjaan }}"
                    type="text" label="Pekerjaan" />
                <flux:input readonly
                    value="{{ $bidang_industri }}"
                    type="text" label="Bidang industri" />
                <flux:input readonly value="{{ $lokasi_magang }}"
                    type="text" label="Lokasi magang" />
                <flux:input readonly value="{{ ucfirst($jenis_magang) }}"
                    type="text" label="Jenis magang" />
                <flux:input readonly
                    value="{{ ucfirst($open_remote) }}" type="text"
                    label="Open remote" />
            </div>

            <div class="card-actions flex justify-end p-5">
                <flux:button class="bg-magnet-sky-teal! text-white!" icon="pencil">Edit data preferensi magang
                </flux:button>
            </div>
        </div>
    </div>
</div>
