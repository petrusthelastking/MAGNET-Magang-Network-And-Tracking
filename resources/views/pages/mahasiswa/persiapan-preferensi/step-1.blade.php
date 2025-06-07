<?php

use function Livewire\Volt\{state};
use App\Models\{Pekerjaan, BidangIndustri, LokasiMagang};


state([
    'pekerjaan_list' => Pekerjaan::pluck('nama', 'id'),
    'bidang_industri_list' => BidangIndustri::pluck('nama', 'id'),
    'lokasi_magang_list' => LokasiMagang::pluck('kategori_lokasi', 'id'),

    'pekerjaan',
    'bidang_industri',
    'lokasi_magang',
    'jenis_magang' => 'berbayar',
    'open_remote' => 'tidak',
]);

$nextStep = function () {
    $this->dispatch('update-step', [
        'step' => 2,
        'pekerjaan' => $this->pekerjaan,
        'bidang_industri' => $this->bidang_industri,
        'lokasi_magang' => $this->lokasi_magang,
        'jenis_magang' => $this->jenis_magang,
        'open_remote' => $this->open_remote,
    ]);
};

?>

<div class="flex min-h-screen">
    <div class="w-1/2 p-24">
        <div class="sticky top-24">
            <div class="flex items-center gap-3 mb-6">
                <div
                    class="w-8 h-8 bg-magnet-sky-teal text-white rounded-full flex items-center justify-center text-sm font-semibold">
                    1</div>
                <div
                    class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-semibold">
                    2</div>
            </div>

            <h1 class="text-3xl leading-8 font-black mb-4">Isi Data Preferensi Magang</h1>
            <flux:text class="text-lg text-gray-600 mb-8">
                Data-data berikut akan digunakan untuk menentukan rekomendasi magang yang sesuai dengan
                preferensi Anda
            </flux:text>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <flux:icon.information-circle class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" />
                    <div>
                        <h3 class="font-semibold text-blue-900 mb-1">Tips Pengisian</h3>
                        <p class="text-sm text-blue-800">Pilih opsi yang paling sesuai dengan preferensi magang
                            Anda. Semua field wajib diisi untuk melanjutkan ke tahap berikutnya.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-1/2 bg-white p-24 flex flex-col justify-between">
        <div class="flex flex-col gap-6">
            <flux:field>
                <div class="flex items-center gap-2 mb-2">
                    <flux:label>Pekerjaan yang Diinginkan</flux:label>
                    <div class="group relative">
                        <flux:icon.question-mark-circle class="w-4 h-4 text-gray-400 cursor-help" />
                        <div
                            class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-10">
                            Pilih jenis pekerjaan/posisi yang ingin Anda ambil saat magang
                        </div>
                    </div>
                </div>
                <flux:select placeholder="Pilih pekerjaan yang diinginkan" wire:model.live="pekerjaan">
                    @foreach ($pekerjaan_list as $id => $nama)
                        <flux:select.option value="{{ $id }}">{{ $nama }}</flux:select.option>
                    @endforeach
                </flux:select>
            </flux:field>

            <flux:field>
                <div class="flex items-center gap-2 mb-2">
                    <flux:label>Bidang Industri</flux:label>
                    <div class="group relative">
                        <flux:icon.question-mark-circle class="w-4 h-4 text-gray-400 cursor-help" />
                        <div
                            class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-10">
                            Pilih bidang industri perusahaan yang Anda minati
                        </div>
                    </div>
                </div>
                <flux:select placeholder="Pilih bidang industri" wire:model.live="bidang_industri">
                    @foreach ($bidang_industri_list as $id => $nama)
                        <flux:select.option value="{{ $id }}">{{ $nama }}</flux:select.option>
                    @endforeach
                </flux:select>
            </flux:field>

            <flux:field>
                <div class="flex items-center gap-2 mb-2">
                    <flux:label>Lokasi Magang</flux:label>
                    <div class="group relative">
                        <flux:icon.question-mark-circle class="w-4 h-4 text-gray-400 cursor-help" />
                        <div
                            class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-10">
                            Pilih kategori lokasi magang yang diinginkan
                        </div>
                    </div>
                </div>
                <flux:select placeholder="Pilih lokasi magang" wire:model.live="lokasi_magang">
                    @foreach ($lokasi_magang_list->unique() as $id => $lokasi)
                        <flux:select.option value="{{ $id }}">{{ $lokasi }}</flux:select.option>
                    @endforeach
                </flux:select>
            </flux:field>

            <flux:field>
                <div class="flex items-center gap-2 mb-2">
                    <flux:label>Jenis Magang</flux:label>
                    <div class="group relative">
                        <flux:icon.question-mark-circle class="w-4 h-4 text-gray-400 cursor-help" />
                        <div
                            class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-10">
                            Pilih apakah Anda mengutamakan magang berbayar atau tidak
                        </div>
                    </div>
                </div>
                <flux:select placeholder="Pilih jenis magang" wire:model.live="jenis_magang">
                    <flux:select.option value="tidak berbayar">Tidak Berbayar (Unpaid)</flux:select.option>
                    <flux:select.option value="berbayar">Berbayar (Paid)</flux:select.option>
                </flux:select>
            </flux:field>

            <flux:field>
                <div class="flex items-center gap-2 mb-2">
                    <flux:label>Bersedia Magang Remote?</flux:label>
                    <div class="group relative">
                        <flux:icon.question-mark-circle class="w-4 h-4 text-gray-400 cursor-help" />
                        <div
                            class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-10">
                            Apakah Anda bersedia melakukan magang secara remote/online?
                        </div>
                    </div>
                </div>
                <flux:select placeholder="Pilih kesediaan remote" wire:model.live="open_remote">
                    <flux:select.option value="ya">Ya, bersedia</flux:select.option>
                    <flux:select.option value="tidak">Tidak, hanya on-site</flux:select.option>
                </flux:select>
            </flux:field>
        </div>

        <div class="flex justify-between w-full">
            <flux:spacer />
            <flux:button variant="primary" icon="chevron-right" wire:click="nextStep"
                class="bg-magnet-sky-teal px-6 py-2">
                Lanjut ke Ranking
            </flux:button>
        </div>
    </div>
</div>
