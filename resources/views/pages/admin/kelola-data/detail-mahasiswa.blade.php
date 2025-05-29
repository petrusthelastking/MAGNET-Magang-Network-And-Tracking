<?php

use Flux\Flux;
use function Livewire\Volt\{layout, state, mount};
use App\Models\Mahasiswa;

layout('components.layouts.admin.main');

state([
    'mahasiswa' => null,
    'nama' => '',
    'nim' => '',
    'jenis_kelamin' => null,
    'umur' => null,
    'angkatan' => null,
    'jurusan' => null,
    'program_studi' => null,
    'status_magang' => null,
    'alamat' => null,

    'isEditing' => false,

    'isDataDeleted' => false,
]);

mount(function (int $id) {
    $this->mahasiswa = Mahasiswa::findOrFail($id);
    $this->nama = $this->mahasiswa->nama;
    $this->nim = $this->mahasiswa->nim;
    $this->jenis_kelamin = $this->mahasiswa->jenis_kelamin;
    $this->umur = $this->mahasiswa->umur;
    $this->angkatan = $this->mahasiswa->angkatan;
    $this->jurusan = $this->mahasiswa->jurusan;
    $this->program_studi = $this->mahasiswa->program_studi;
    $this->status_magang = $this->mahasiswa->status_magang;
    $this->alamat = $this->mahasiswa->alamat;
});

$editData = fn() => ($this->isEditing = !$this->isEditing);

$updateData = function () {
    $this->mahasiswa->nama = $this->nama;
    $this->mahasiswa->nim = $this->nim;
    $this->mahasiswa->jenis_kelamin = $this->jenis_kelamin;
    $this->mahasiswa->umur = $this->umur;
    $this->mahasiswa->angkatan = $this->angkatan;
    $this->mahasiswa->jurusan = $this->jurusan;
    $this->mahasiswa->program_studi = $this->program_studi;
    $this->mahasiswa->status_magang = $this->status_magang;
    $this->mahasiswa->alamat = $this->alamat;
    $isSuccess = $this->mahasiswa->save();

    $message = '';
    if ($isSuccess) {
        $message = 'Sukses memperbarui data mahasiswa';
    } else {
        $message = 'Gagal memperbarui data mahasiswa';
    }

    $this->isEditing = false;

    session()->flash('task', 'Memperbarui data mahasiswa');
    session()->flash('message', $message);

    Flux::modal('response-modal')->show();
};

$deleteData = function () {
    $isSuccess = $this->mahasiswa->delete();

    $message = '';
    if ($isSuccess) {
        $this->isDataDeleted = true;
        $message = 'Sukses menghapus data mahasiswa';
    } else {
        $message = 'Gagal menghapus data mahasiswa';
    }

    session()->flash('task', 'Menghapus data mahasiswa');
    session()->flash('message', $message);

    Flux::modal('delete-data')->close();
    Flux::modal('response-modal')->show();
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

    @if (!$isDataDeleted)
        <div class="min-h-full flex gap-8 items-start">
            <div class="flex flex-col items-center bg-white p-4 rounded-xl shadow-md w-96 max-w-96">
                <img src="{{ asset('img/student-girl.png') }}" alt="Foto Mahasiswa"
                    class="w-64 object-cover rounded-md mb-4" />
                <div class="flex flex-col gap-4 w-full">
                    @if ($isEditing)
                        <div class="flex w-full gap-2">
                            <flux:button wire:click="editData" icon="x"
                                class="w-1/2 bg-gray-700! hover:bg-gray-400! text-white! text-wrap! text-left rounded-md items-center">
                                Batalkan
                            </flux:button>
                            <flux:button wire:click="updateData" icon="pencil"
                                class="w-1/2 bg-emerald-400! hover:bg-green-500! text-white! rounded-md items-center">
                                Simpan
                            </flux:button>
                        </div>
                    @else
                        <flux:button wire:click="editData" icon="pencil"
                            class="bg-emerald-400! hover:bg-green-500! text-white! rounded-md items-center">
                            Edit
                        </flux:button>
                    @endif

                    <flux:modal.trigger name="delete-data">
                        <flux:button icon="trash-2"
                            class="bg-red-400! hover:bg-red-500! text-white! rounded-md items-center">
                            Hapus
                        </flux:button>
                    </flux:modal.trigger>
                </div>
            </div>

            <div class="card bg-white rounded-xl shadow-md w-full text-black">
                <div class="card-body">
                    <h2 class="text-lg font-semibold">Informasi Pribadi</h2>

                    <div class="flex flex-col gap-4">
                        <flux:field>
                            <flux:label>Nama Lengkap</flux:label>
                            @if ($isEditing)
                                <flux:input value="{{ $nama }}" wire:model="nama" />
                            @else
                                <flux:input value="{{ $nama }}" wire:model="nama" readonly
                                    class="caret-transparent" />
                            @endif
                            <flux:error name="username" />
                        </flux:field>

                        <flux:field>
                            <flux:label>NIM</flux:label>
                            @if ($isEditing)
                                <flux:input value="{{ $nim }}" wire:model="nim" />
                            @else
                                <flux:input value="{{ $nim }}" wire:model="nim" readonly
                                    class="caret-transparent" />
                            @endif
                            <flux:error name="nim" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Jurusan</flux:label>
                            @if ($isEditing)
                                <flux:input value="{{ $jurusan }}" wire:model="jurusan" />
                            @else
                                <flux:input value="{{ $jurusan }}" wire:model="jurusan" readonly
                                    class="caret-transparent" />
                            @endif
                            <flux:error name="jurusan" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Program Studi</flux:label>
                            @if ($isEditing)
                                <flux:select placeholder="Program Studi Anda" wire:model="program_studi">
                                    <flux:select.option value="D4 Teknik Informatika">D4 Teknik Informatika
                                    </flux:select.option>
                                    <flux:select.option value="D4 Sistem Informasi Bisnis">D4 Sistem Informasi Bisnis
                                    </flux:select.option>
                                    <flux:select.option value="D2 Pengembangan Piranti Lunak Situs">D2 Pengembangan
                                        Piranti Lunak Situs</flux:select.option>
                                </flux:select>
                            @else
                                <flux:select placeholder="Program Studi Anda" wire:model="program_studi" disabled>
                                    <flux:select.option value="D4 Teknik Informatika">D4 Teknik Informatika
                                    </flux:select.option>
                                    <flux:select.option value="D4 Sistem Informasi Bisnis">D4 Sistem Informasi Bisnis
                                    </flux:select.option>
                                    <flux:select.option value="D2 Pengembangan Piranti Lunak Situs">D2 Pengembangan
                                        Piranti Lunak Situs</flux:select.option>
                                </flux:select>
                            @endif
                            <flux:error name="program_studi" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Angkatan</flux:label>
                            @if ($isEditing)
                                <flux:input value="{{ $angkatan }}" wire:model="angkatan" />
                            @else
                                <flux:input value="{{ $angkatan }}" wire:model="angkatan" readonly
                                    class="caret-transparent" />
                            @endif
                            <flux:error name="angkatan" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Jenis Kelamin</flux:label>
                            @if ($isEditing)
                                <flux:select placeholder="Jenis Kelamin Mahasiswa" wire:model="jenis_kelamin">
                                    <flux:select.option value="L">Laki-Laki</flux:select.option>
                                    <flux:select.option value="P">Perempuan</flux:select.option>
                                </flux:select>
                            @else
                                <flux:select placeholder="Jenis Kelamin Mahasiswa" wire:model="jenis_kelamin" disabled>
                                    <flux:select.option value="L">Laki-Laki</flux:select.option>
                                    <flux:select.option value="P">Perempuan</flux:select.option>
                                </flux:select>
                            @endif
                            <flux:error name="jenis_kelamin" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Umur</flux:label>
                            @if ($isEditing)
                                <flux:input value="{{ $umur }} tahun" wire:model="umur" />
                            @else
                                <flux:input value="{{ $umur }} tahun" wire:model="umur" readonly
                                    class="caret-transparent" />
                            @endif
                            <flux:error name="umur" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Status Magang</flux:label>
                            @if ($isEditing)
                                <flux:select placeholder="Status Magang Mahasiswa" wire:model="status_magang">
                                    <flux:select.option value="belum magang">Belum magang</flux:select.option>
                                    <flux:select.option value="sedang magang" selected>Sedang magang
                                    </flux:select.option>
                                    <flux:select.option value="selesai magang">Selesai magang</flux:select.option>
                                </flux:select>
                            @else
                                <flux:select placeholder="Status Magang Mahasiswa" wire:model="status_magang" disabled>
                                    <flux:select.option value="belum magang">Belum magang</flux:select.option>
                                    <flux:select.option value="sedang magang" selected>Sedang magang
                                    </flux:select.option>
                                    <flux:select.option value="selesai magang">Selesai magang</flux:select.option>
                                </flux:select>
                                <flux:error name="status_magang" />
                            @endif
                        </flux:field>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card min-h-full flex items-center justify-center text-center text-black">
            <div class="card-body h-full bg-white rounded-xl">
                <h1 class="text-4xl font-bold">Data telah terhapus!</h1>
            </div>
        </div>
    @endif



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
                    <flux:button type="submit" variant="primary" class="bg-magnet-sky-teal">Simpan</flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>


    <flux:modal name="delete-data" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Hapus data mahasiswa</flux:heading>
                <flux:text class="mt-2">
                    <p>Apakah anda yakin ingin menghapus data mahasiswa ?</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Batalkan</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="danger" wire:click="deleteData">Hapus</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
