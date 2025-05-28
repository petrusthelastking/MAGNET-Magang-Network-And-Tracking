<?php

use Flux\Flux;
use function Livewire\Volt\{layout, state, updating};
use Illuminate\Support\Facades\DB;
use App\Models\Kriteria;
use App\Models\PreferensiMahasiswa;
use App\Helpers\ROC;

layout('components.layouts.guest.with-navbar');

state([
    'step' => 1,
    'showStep1' => true,
    'showStep2' => false,

    'skil' => null,
    'bidang_industri' => null,
    'open_remote' => null,
    'lokasi' => null,
    'uang_saku' => null,

    'skil_rank' => null,
    'bidang_industri_rank' => null,
    'open_remote_rank' => null,
    'lokasi_rank' => null,
    'uang_saku_rank' => null,

    'rank_1' => null,
    'rank_2' => null,
    'rank_3' => null,
    'rank_4' => null,
    'rank_5' => null,
]);

$prevStep = fn() => $this->step--;
$nextStep = fn() => $this->step++;

$storePreferensiMahasiswa = function () {
    DB::transaction(function () {
        $skil_kriteria = Kriteria::create([
            'nama_kriteria' => 'skil',
            'nilai' => $this->skil,
            'nilai_numerik' => ROC::getRank($this->skil_rank, 5),
            'rank' => $this->skil_rank,
        ]);

        $bidang_industri_kriteria = Kriteria::create([
            'nama_kriteria' => 'bidang industri',
            'nilai' => $this->bidang_industri,
            'nilai_numerik' => ROC::getRank($this->bidang_industri_rank, 5),
            'rank' => $this->bidang_industri_rank,
        ]);

        $open_remote_kriteria = Kriteria::create([
            'nama_kriteria' => 'open remote',
            'nilai' => $this->open_remote,
            'nilai_numerik' => ROC::getRank($this->open_remote_rank, 5),
            'rank' => $this->open_remote_rank,
        ]);

        $lokasi_kriteria = Kriteria::create([
            'nama_kriteria' => 'lokasi',
            'nilai' => $this->lokasi,
            'nilai_numerik' => ROC::getRank($this->lokasi_rank, 5),
            'rank' => $this->lokasi_rank,
        ]);

        $uang_saku_kriteria = Kriteria::create([
            'nama_kriteria' => 'uang saku',
            'nilai' => $this->uang_saku,
            'nilai_numerik' => ROC::getRank($this->uang_saku_rank, 5),
            'rank' => $this->uang_saku_rank,
        ]);

        $preferensi_mahasiswa = PreferensiMahasiswa::create([
            'mahasiswa_id' => auth('mahasiswa')->user()->id,
            'skil' => $skil_kriteria->id,
            'bidang_industri' => $bidang_industri_kriteria->id,
            'open_remote' => $open_remote_kriteria->id,
            'lokasi' => $lokasi_kriteria->id,
            'uang_saku' => $uang_saku_kriteria->id,
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
                        <flux:label>Skil yang anda miliki</flux:label>
                        <flux:select placeholder="Pilih salah satu skil yang anda miliki" wire:model.live="skil">
                            <flux:select.option value="data engineer">Data Engineer</flux:select.option>
                            <flux:select.option value="security analyst">Security Analyst</flux:select.option>
                            <flux:select.option value="ui/ux designer">UI/UX Designer</flux:select.option>
                            <flux:select.option value="devops">DevOps</flux:select.option>
                            <flux:select.option value="backend development">Backend Development</flux:select.option>
                            <flux:select.option value="data administrator">Data Administrator</flux:select.option>
                            <flux:select.option value="machine learning engineer">Machine Learning Engineer
                            </flux:select.option>
                            <flux:select.option value="frontend web development">Frontend Web Development
                            </flux:select.option>
                            <flux:select.option value="data analyst">Data Analyst</flux:select.option>
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>Bidang Industri</flux:label>
                        <flux:select placeholder="Bidang industri perusahaan" wire:model.live="bidang_industri">
                            <flux:select.option value="Perbankan">Perbankan</flux:select.option>
                            <flux:select.option value="Kesehatan">Kesehatan</flux:select.option>
                            <flux:select.option value="Pendidikan">Pendidikan</flux:select.option>
                            <flux:select.option value="E-Commerce">E-Commerce</flux:select.option>
                            <flux:select.option value="Telekomunikasi">Telekomunikasi</flux:select.option>
                            <flux:select.option value="Transportasi">Transportasi</flux:select.option>
                            <flux:select.option value="Pemerintahan">Pemerintahan</flux:select.option>
                            <flux:select.option value="Manufaktur">Manufaktur</flux:select.option>
                            <flux:select.option value="Energi">Energi</flux:select.option>
                            <flux:select.option value="Media">Media</flux:select.option>
                            <flux:select.option value="Teknologi">Teknologi</flux:select.option>
                            <flux:select.option value="Agrikultur">Agrikultur</flux:select.option>
                            <flux:select.option value="Pariwisata">Pariwisata</flux:select.option>
                            <flux:select.option value="Keamanan">Keamanan</flux:select.option>
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>Bersedia magang secara remote?</flux:label>
                        <flux:select placeholder="Ya/tidak" wire:model.live="open_remote">
                            <flux:select.option value="ya">Ya</flux:select.option>
                            <flux:select.option value="tidak">Tidak</flux:select.option>
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>Lokasi</flux:label>
                        <flux:select placeholder="Lokasi magang yang anda inginkan" wire:model.live="lokasi">
                            <flux:select.option value="area malang raya">Area Malang Raya</flux:select.option>
                            <flux:select.option value="luar area malang raya">Luar area Malang Raya (dalam provinsi)
                            </flux:select.option>
                            <flux:select.option value="luar provinsi jawa timur">Luar provinsi Jawa Timur
                            </flux:select.option>
                            <flux:select.option value="luar negeri">Luar negeri</flux:select.option>
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>Uang Saku Magang</flux:label>
                        <flux:select placeholder="Jenis magang berdasarkan uang saku" wire:model.live="uang_saku">
                            <flux:select.option value="unpaid">Tanpa upah (unpaid)</flux:select.option>
                            <flux:select.option value="paid">Dibayar (paid)</flux:select.option>
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
                        <flux:label>Kesesuaian skil yang anda miliki</flux:label>
                        <flux:select placeholder="Ranking kriteria skil yang anda miliki" wire:model.live="skil_rank">
                            <flux:select.option value="1">1</flux:select.option>
                            <flux:select.option value="2">2</flux:select.option>
                            <flux:select.option value="3">3</flux:select.option>
                            <flux:select.option value="4">4</flux:select.option>
                            <flux:select.option value="5">5</flux:select.option>
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>Bidang industri</flux:label>
                        <flux:select placeholder="Ranking kriteria bidang industri"
                            wire:model.live="bidang_industri_rank">
                            <flux:select.option value="1">1</flux:select.option>
                            <flux:select.option value="2">2</flux:select.option>
                            <flux:select.option value="3">3</flux:select.option>
                            <flux:select.option value="4">4</flux:select.option>
                            <flux:select.option value="5">5</flux:select.option>
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>Ketersediaan open remote</flux:label>
                        <flux:select placeholder="Ranking kriteria ketersediaan open remote"
                            wire:model.live="open_remote_rank">
                            <flux:select.option value="1">1</flux:select.option>
                            <flux:select.option value="2">2</flux:select.option>
                            <flux:select.option value="3">3</flux:select.option>
                            <flux:select.option value="4">4</flux:select.option>
                            <flux:select.option value="5">5</flux:select.option>
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>Lokasi</flux:label>
                        <flux:select placeholder="Ranking kriteria lokasi" wire:model.live="lokasi_rank">
                            <flux:select.option value="1">1</flux:select.option>
                            <flux:select.option value="2">2</flux:select.option>
                            <flux:select.option value="3">3</flux:select.option>
                            <flux:select.option value="4">4</flux:select.option>
                            <flux:select.option value="5">5</flux:select.option>
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label>Uang Saku</flux:label>
                        <flux:select placeholder="Ranking kriteria uang saku" wire:model.live="uang_saku_rank">
                            <flux:select.option value="1">1</flux:select.option>
                            <flux:select.option value="2">2</flux:select.option>
                            <flux:select.option value="3">3</flux:select.option>
                            <flux:select.option value="4">4</flux:select.option>
                            <flux:select.option value="5">5</flux:select.option>
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
