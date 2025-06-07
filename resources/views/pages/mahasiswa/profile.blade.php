<?php

use Flux\Flux;
use function Livewire\Volt\{state, mount};
use App\Helpers\DecisionMaking\RecommendationSystem;

state([
    'mahasiswa',
    'bidang_industri',
    'jenis_magang',
    'lokasi_magang',
    'pekerjaan',
    'open_remote',

    'isUpdatePreference' => false
]);

mount(function () {
    $this->mahasiswa = auth('mahasiswa')->user();

    $this->bidang_industri = $this->mahasiswa->kriteriaBidangIndustri->bidangIndustri->nama;
    $this->jenis_magang = $this->mahasiswa->kriteriaJenisMagang->jenis_magang;
    $this->lokasi_magang = $this->mahasiswa->kriteriaLokasiMagang->lokasiMagang->kategori_lokasi;
    $this->pekerjaan = $this->mahasiswa->kriteriaPekerjaan->pekerjaan->nama;
    $this->open_remote = $this->mahasiswa->kriteriaOpenRemote->open_remote;
});

$updatePreference = function () {
    $this->isUpdatePreference = true;
};

$saveNewPreference = function () {
    $recommendationSystem = new RecommendationSystem($this->mahasiswa);
    $recommendationSystem->runRecommendationSystem();

    Flux::modal('response-modal')->show();
    $this->isUpdatePreference = false;
};

$cancelUpdatePreference = function () {
    $this->isUpdatePreference = false;
};

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
                @if (!$isUpdatePreference)
                    <flux:input readonly value="{{ $pekerjaan }}" type="text" label="Pekerjaan" />
                    <flux:input readonly value="{{ $bidang_industri }}" type="text" label="Bidang industri" />
                    <flux:input readonly value="{{ $lokasi_magang }}" type="text" label="Lokasi magang" />
                    <flux:input readonly value="{{ ucfirst($jenis_magang) }}" type="text" label="Jenis magang" />
                    <flux:input readonly value="{{ ucfirst($open_remote) }}" type="text" label="Open remote" />
                @else
                    <flux:input value="{{ $pekerjaan }}" type="text" label="Pekerjaan" />
                    <flux:input value="{{ $bidang_industri }}" type="text" label="Bidang industri" />
                    <flux:input value="{{ $lokasi_magang }}" type="text" label="Lokasi magang" />
                    <flux:input value="{{ ucfirst($jenis_magang) }}" type="text" label="Jenis magang" />
                    <flux:input value="{{ ucfirst($open_remote) }}" type="text" label="Open remote" />
                @endif
            </div>

            <div class="card-actions flex justify-end p-5">
                <div wire:show="!isUpdatePreference">
                    <flux:button wire:click="updatePreference" class="bg-magnet-sky-teal! text-white! hover:bg-emerald-400!" icon="pencil">
                        Edit data preferensi magang
                    </flux:button>
                </div>
                <div wire:show="isUpdatePreference">
                    <flux:button wire:click="cancelUpdatePreference" class="bg-gray-700! text-white! hover:bg-gray-400!" icon="x">
                        Batalkan pembaruan
                    </flux:button>
                    <flux:button wire:click="saveNewPreference" class="bg-magnet-sky-teal! text-white! hover:bg-emerald-400!" icon="pencil">
                        Perbarui preferensi magang
                    </flux:button>
                </div>
            </div>
        </div>
    </div>


        <flux:modal name="response-modal" class="min-w-[24rem]">
        <div class="space-y-6">
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <flux:icon.check class="w-8 h-8 text-green-600" />
                </div>
                <flux:heading size="lg">Memperbarui data preferensi magang</flux:heading>
                <flux:text class="mt-2 text-gray-600">
                    <p>Data preferensi magang sukses diperbarui</p>
                </flux:text>
            </div>
            <div class="flex gap-2 justify-center">
                <flux:modal.close>
                    <flux:button type="submit" variant="primary" class="bg-magnet-sky-teal px-8 py-2">
                        Oke
                    </flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>
</div>
