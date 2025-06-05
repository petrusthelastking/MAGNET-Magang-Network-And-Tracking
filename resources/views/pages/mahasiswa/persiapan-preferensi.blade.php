<?php

use Flux\Flux;
use function Livewire\Volt\{layout, state, updated};
use Illuminate\Support\Facades\DB;
use App\Models\{PreferensiMahasiswa, BidangIndustri, Pekerjaan, LokasiMagang, KriteriaPekerjaan, KriteriaBidangIndustri, KriteriaJenisMagang, KriteriaLokasiMagang, KriteriaOpenRemote, KriteriaReputasiPerusahaan};
use App\Helpers\DecisionMaking\ROC;

layout('components.layouts.guest.with-navbar');

state([
    'step' => 1,
    'showStep1' => true,
    'showStep2' => false,

    'pekerjaan_list' => Pekerjaan::pluck('nama', 'id'),
    'bidang_industri_list' => BidangIndustri::pluck('nama', 'id'),
    'lokasi_magang_list' => LokasiMagang::pluck('kategori_lokasi', 'id'),

    'pekerjaan',
    'bidang_industri',
    'lokasi_magang',
    'jenis_magang',
    'reputasi_perusahaan',
    'open_remote',

    'available_ranks' => [1, 2, 3, 4, 5, 6],

    'pekerjaan_rank',
    'bidang_industri_rank',
    'lokasi_magang_rank',
    'jenis_magang_rank',
    'reputasi_perusahaan_rank',
    'open_remote_rank',
]);

$prevStep = fn() => $this->step--;
$nextStep = fn() => $this->step++;

$storePreferensiMahasiswa = function () {
    DB::transaction(function () {
        $kriteria_pekerjaan = KriteriaPekerjaan::create([
            'pekerjaan_id' => $this->pekerjaan,
            'rank' => $this->pekerjaan_rank,
            'bobot' => ROC::getWeight($this->pekerjaan_rank, 6),
        ]);

        $kriteria_bidang_industri = KriteriaBidangIndustri::create([
            'bidang_industri_id' => $this->bidang_industri,
            'rank' => $this->bidang_industri_rank,
            'bobot' => ROC::getWeight($this->bidang_industri_rank, 6),
        ]);

        $kriteria_lokasi_magang = KriteriaLokasiMagang::create([
            'lokasi_magang_id' => $this->lokasi_magang,
            'rank' => $this->lokasi_magang_rank,
            'bobot' => ROC::getWeight($this->lokasi_magang_rank, 6),
        ]);

        $kriteria_reputasi_perusahaan = KriteriaReputasiPerusahaan::create([
            'reputasi_perusahaan' => $this->reputasi_perusahaan,
            'rank' => $this->reputasi_perusahaan_rank,
            'bobot' => ROC::getWeight($this->reputasi_perusahaan_rank, 6),
        ]);

        $kriteria_jenis_magang = KriteriaJenisMagang::create([
            'jenis_magang' => $this->jenis_magang,
            'rank' => $this->jenis_magang_rank,
            'bobot' => ROC::getWeight($this->jenis_magang_rank, 6),
        ]);

        $kriteria_open_remote = KriteriaOpenRemote::create([
            'open_remote' => $this->open_remote,
            'rank' => $this->open_remote_rank,
            'bobot' => ROC::getWeight($this->open_remote_rank, 6),
        ]);

        $preferensi_mahasiswa = PreferensiMahasiswa::create([
            'mahasiswa_id' => auth('mahasiswa')->user()->id,
            'kriteria_pekerjaan_id' => $kriteria_pekerjaan->id,
            'kriteria_bidang_industri_id' => $kriteria_bidang_industri->id,
            'kriteria_lokasi_magang_id' => $kriteria_lokasi_magang->id,
            'kriteria_reputasi_perusahaan_id' => $kriteria_reputasi_perusahaan->id,
            'kriteria_jenis_magang_id' => $kriteria_jenis_magang->id,
            'kriteria_open_remote_id' => $kriteria_open_remote->id,
        ]);

        if ($preferensi_mahasiswa) {
            $message = "Data preferensi magang berhasil dibuat";
        } else {
            $message = "Data preferensi magang gagal dibuat!";
        }

        session()->flash('task', 'Membuat data preferensi magang');
        session()->flash('message', $message);

        Flux::modal('response-modal')->show();
    });
};

$redirectToDashboard = fn() => redirect()->route('dashboard');

$updateRank = function ($selectedRank) {
    $this->available_ranks = array_values(array_diff($this->available_ranks, [$selectedRank]));
};

updated([
    'pekerjaan_rank' => $updateRank,
    'bidang_industri_rank' => $updateRank,
    'lokasi_magang_rank' => $updateRank,
    'jenis_magang_rank' => $updateRank,
    'reputasi_perusahaan_rank' => $updateRank,
    'open_remote_rank' => $updateRank,
]);

?>


<div>
    <div class="min-h-screen w-full">
        <div wire:show="step == 1" class="flex min-h-screen">
            <div class="w-1/2 p-24">
                <h1 class="text-xl leading-7 font-black">Isi Data-Data Pendukung</h1>
                <flux:text>Data-data berikut akan digunakan untuk kebutuhan pemrosesan preferensi magang</flux:text>
            </div>
            <div class="w-1/2 bg-white p-24 flex flex-col justify-between">
                <div class="flex flex-col gap-5">
                    <flux:field>
                        <flux:label>Pekerjaan yang anda inginkan</flux:label>
                        <flux:select placeholder="Pilih salah satu pekerjaan yang anda inginkan" wire:model.live="pekerjaan">
                            @foreach ($pekerjaan_list as $id => $nama)
                            <flux:select.option value="{{ $id }}">{{ $nama }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>Bidang Industri</flux:label>
                        <flux:select placeholder="Bidang industri perusahaan" wire:model.live="bidang_industri">
                            @foreach ($bidang_industri_list as $id => $nama)
                            <flux:select.option value="{{ $id }}">{{ $nama }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>Lokasi Magang</flux:label>
                        <flux:select placeholder="Lokasi magang yang anda inginkan" wire:model.live="lokasi_magang">
                            @foreach ($lokasi_magang_list as $id => $lokasi)
                            <flux:select.option value="{{ $id }}">{{ $lokasi }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>Jenis Magang</flux:label>
                        <flux:select placeholder="Jenis magang berdasarkan uang saku" wire:model.live="jenis_magang">
                            <flux:select.option value="tidak berbayar">Tidak dirubah (unpaid)</flux:select.option>
                            <flux:select.option value="berbayar">Berbayar (paid)</flux:select.option>
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>Reputasi perusahaan</flux:label>
                        <flux:select placeholder="Pilih jenis reputasi perusahaan yang anda inginkan" wire:model.live="reputasi_perusahaan">
                            <flux:select.option value="<1">&lt;1</flux:select.option>
                            <flux:select.option value="1<= x <2">1&le;x&lt;2</flux:select.option>
                            <flux:select.option value="2<= x <3">2&le;x&lt;3</flux:select.option>
                            <flux:select.option value="3<= x <4">3&le;x&lt;4</flux:select.option>
                            <flux:select.option value="4<= x <5">4&le;x&lt;5</flux:select.option>
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>Bersedia magang secara remote?</flux:label>
                        <flux:select placeholder="Ya/tidak" wire:model.live="open_remote">
                            <flux:select.option value="ya">Ya</flux:select.option>
                            <flux:select.option value="tidak">Tidak</flux:select.option>
                        </flux:select>
                    </flux:field>
                </div>

                <div class="flex justify-between w-full">
                    <flux:spacer />
                    <flux:button variant="primary" icon="move-right" wire:click="nextStep" class="bg-magnet-sky-teal">
                        Lanjut</flux:button>
                </div>
            </div>
        </div>
        <div wire:show="step == 2" class="flex min-h-screen">
            <div class="w-1/2 p-24">
                <h1 class="text-xl leading-7 font-black">Urutan Preferensi Magang</h1>
                <flux:text>Ranking pertama akan lebih diprioritaskan daripada ranking di bawahnya</flux:text>
            </div>
            <div class="w-1/2 bg-white p-24 flex flex-col justify-between">
                <div class="flex flex-col gap-5">
                    <flux:field>
                        <flux:label>Kesesuaian pekerjaan</flux:label>
                        <flux:select placeholder="Ranking kriteria skil yang anda miliki" wire:model.live="pekerjaan_rank">
                            @for ($i = 1; $i <= 6; $i++)
                            <flux:select.option value="{{ $i }}">{{ $i }}</flux:select.option>
                            @endfor
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>Keseuaian bidang industri</flux:label>
                        <flux:select placeholder="Ranking kriteria bidang industri"
                            wire:model.live="bidang_industri_rank">
                            @for ($i = 1; $i <= 6; $i++)
                            <flux:select.option value="{{ $i }}">{{ $i }}</flux:select.option>
                            @endfor
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>Keseuaian lokasi tempat magang</flux:label>
                        <flux:select placeholder="Ranking kriteria lokasi" wire:model.live="lokasi_magang_rank">
                            @for ($i = 1; $i <= 6; $i++)
                            <flux:select.option value="{{ $i }}">{{ $i }}</flux:select.option>
                            @endfor
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>Jenis magang</flux:label>
                        <flux:select placeholder="Ranking kriteria uang saku" wire:model.live="jenis_magang_rank">
                            @for ($i = 1; $i <= 6; $i++)
                            <flux:select.option value="{{ $i }}">{{ $i }}</flux:select.option>
                            @endfor
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>Kesesuaian reputasi perusahaan</flux:label>
                        <flux:select placeholder="Ranking kriteria ketersediaan open remote"
                            wire:model.live="reputasi_perusahaan_rank">
                            @for ($i = 1; $i <= 6; $i++)
                            <flux:select.option value="{{ $i }}">{{ $i }}</flux:select.option>
                            @endfor
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>Ketersediaan open remote</flux:label>
                        <flux:select placeholder="Ranking kriteria uang saku" wire:model.live="open_remote_rank">
                            @for ($i = 1; $i <= 6; $i++)
                            <flux:select.option value="{{ $i }}">{{ $i }}</flux:select.option>
                            @endfor
                        </flux:select>
                    </flux:field>
                </div>

                <div class="flex justify-between w-full">
                    <flux:button variant="primary" icon="move-left" wire:click="prevStep" class="bg-magnet-sky-teal">
                        Kembali</flux:button>
                    <flux:button variant="primary" icon="move-right" wire:click="storePreferensiMahasiswa"
                        class="bg-magnet-sky-teal">
                        Lanjut</flux:button>
                </div>
            </div>
        </div>
    </div>


    <flux:modal name="response-modal" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ session('task') }}</flux:heading>
                <flux:text class="mt-2">
                    <p>{{ session('message') }}</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button type="submit" variant="primary" class="bg-magnet-sky-teal" wire:click="redirectToDashboard">Simpan</flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>
</div>
