<?php

use Flux\Flux;
use function Livewire\Volt\{state};
use App\Models\LowonganMagang;
use App\Models\Pekerjaan;
use App\Models\Perusahaan;
use App\Models\LokasiMagang;

state([
    'pekerjaan_list' => Pekerjaan::pluck('nama', 'id')->toArray(),
    'perusahaan_list' => Perusahaan::pluck('nama', 'id')->toArray(),
    'lokasi_magang_list' => LokasiMagang::pluck('lokasi', 'id')->toArray(),

    'pekerjaan_id',
    'perusahaan_id',
    'lokasi_magang_id',
    'deskripsi',
    'persyaratan',
    'jenis_magang',
    'kuota' => 1,
    'open_remote'
]);

$storeNewData = function (): void {
    $lowonganMagang = LowonganMagang::create([
        'pekerjaan_id' => $this->pekerjaan_id,
        'perusahaan_id' => $this->perusahaan_id,
        'lokasi_magang_id' => $this->lokasi_magang_id,
        'deskripsi' => $this->deskripsi,
        'persyaratan' => $this->persyaratan,
        'jenis_magang' => $this->jenis_magang,
        'kuota' => $this->kuota,
        'open_remote' => $this->open_remote,
    ]);

    if ($lowonganMagang) {
        $status = 'success';
        $message = 'Sukses menambahkan data lowongan magang';
    } else {
        $status = 'failed';
        $message = 'Gagal menambahkan data lowongan magang';
    }

    $this->pekerjaan_id = null;
    $this->perusahaan_id = null;
    $this->lokasi_magang_id = null;
    $this->deskripsi = null;
    $this->persyaratan = null;
    $this->jenis_magang = null;
    $this->kuota = 1;
    $this->open_remote = null;

    Flux::modal('add-new-data')->close();

    $this->dispatch('open-modal-response-form', [
        'status' => $status,
        'title' => $message
    ]);

    Flux::modal('modal-response-form')->show();
};

?>

<flux:modal name="add-new-data" class="md:w-96">
    <form wire:submit="storeNewData" class="space-y-6">
        <div>
            <flux:heading size="lg">Tambahkan data magang</flux:heading>
        </div>

        <flux:field>
            <flux:label>Perusahaan</flux:label>
            <flux:select placeholder="Pilih perusahaan" wire:model="perusahaan_id">
                @foreach ($perusahaan_list as $id => $perusahaan)
                    <flux:select.option value="{{ $id }}">{{ $perusahaan }}</flux:select.option>
                @endforeach
            </flux:select>
        </flux:field>

        <flux:field>
            <flux:label>Pekerjaan</flux:label>
            <flux:select placeholder="Pilih pekerjaan" wire:model="pekerjaan_id">
                @foreach ($pekerjaan_list as $id => $pekerjaan)
                    <flux:select.option value="{{ $id }}">{{ $pekerjaan }}</flux:select.option>
                @endforeach
            </flux:select>
        </flux:field>

        <flux:field>
            <flux:label>Lokasi magang</flux:label>
            <flux:select placeholder="Pilih lokasi magang" wire:model="lokasi_magang_id">
                @foreach ($lokasi_magang_list as $id => $lokasi)
                    <flux:select.option value="{{ $id }}">{{ $lokasi }}</flux:select.option>
                @endforeach
            </flux:select>
        </flux:field>

        <flux:field>
            <flux:label>Deskripsi</flux:label>
            <flux:textarea placeholder="Deskripsi magang" wire:model="deskripsi" />
        </flux:field>

        <flux:field>
            <flux:label>Persyaratan</flux:label>
            <flux:textarea placeholder="Persyaratan magang" wire:model="persyaratan" />
        </flux:field>

        <flux:field>
            <flux:label>Jenis Magang</flux:label>
            <flux:select placeholder="Pilih jenis magang" wire:model="jenis_magang">
                <flux:select.option value="berbayar">Berbayar (paid)</flux:select.option>
                <flux:select.option value="tidak berbayar">Tidak Berbayar (paid)</flux:select.option>
            </flux:select>
        </flux:field>

        <flux:input label="Kuota" type="number" wire:model="kuota" />

        <flux:field>
            <flux:label>Open remote</flux:label>
            <flux:select placeholder="Ketersediaan remote"  wire:model="open_remote">
                <flux:select.option value="ya">Ya</flux:select.option>
                <flux:select.option value="tidak">Tidak</flux:select.option>
            </flux:select>
        </flux:field>

        <div class="flex">
            <flux:spacer />
            <flux:button type="submit" variant="primary" class="bg-magnet-sky-teal">Simpan</flux:button>
        </div>
    </form>
</flux:modal>
