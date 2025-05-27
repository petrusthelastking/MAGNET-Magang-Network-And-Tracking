<?php

use Flux\Flux;
use function Livewire\Volt\{layout, state, mount};
use App\Models\DosenPembimbing;

layout('components.layouts.admin.main');

state([
    'dosen' => null,
    'nama' => '',
    'nidn' => '',
    'jenis_kelamin' => null,

    'isEditing' => false,

    'isDataDeleted' => false,
]);

mount(function (int $id) {
    $this->dosen = DosenPembimbing::findOrFail($id);
    $this->nama = $this->dosen->nama;
    $this->nidn = $this->dosen->nidn;
    $this->jenis_kelamin = $this->dosen->jenis_kelamin;
});

$editData = fn() => ($this->isEditing = !$this->isEditing);

$updateData = function () {
    $this->dosen->nama = $this->nama;
    $this->dosen->nidn = $this->nidn;
    $this->dosen->jenis_kelamin = $this->jenis_kelamin;
    $isSuccess = $this->dosen->save();

    $message = '';
    if ($isSuccess) {
        $message = 'Sukses memperbarui data dosen';
    } else {
        $message = 'Gagal memperbarui data dosen';
    }

    $this->isEditing = false;

    session()->flash('task', 'Memperbarui data dosen');
    session()->flash('message', $message);

    Flux::modal('response-modal')->show();
};

$deleteData = function () {
    $isSuccess = $this->dosen->delete();

    $message = '';
    if ($isSuccess) {
        $this->isDataDeleted = true;
        $message = 'Sukses menghapus data dosen';
    } else {
        $message = 'Gagal menghapus data dosen';
    }

    session()->flash('task', 'Menghapus data dosen');
    session()->flash('message', $message);

    Flux::modal('delete-data')->close();
    Flux::modal('response-modal')->show();
};

?>

<div class="flex flex-col gap-5">
    <flux:breadcrumbs class="mb-5">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('admin.data-dosen') }}" class="text-black">Kelola Data Dosen
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item class="text-black">Detail Data Dosen
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <h1 class="text-base font-bold leading-6 text-black">Detail Informasi Dosen</h1>

    @if (!$isDataDeleted)
        <div class="min-h-full flex gap-8 items-start">
            <div class="flex flex-col items-center bg-white p-4 rounded-xl shadow-md w-72 max-w-72">
                <img src="{{ asset('img/student-dosen.png') }}" alt="Foto Dosen"
                    class="w-64 object-cover rounded-md mb-4" />
                <div class="flex flex-col gap-4 w-full">
                    @if ($isEditing)
                        <div class="flex w-full gap-2">
                            <flux:button wire:click="editData" icon="pencil"
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

            <div class="card bg-white rounded-xl shadow-md w-full  text-black">
                <div class="card-body">
                    <h2 class="text-lg font-semibold">Informasi Pribadi</h2>

                    <div class="flex flex-col gap-4">
                        <flux:field>
                            <flux:label>Nama</flux:label>
                            @if ($isEditing)
                                <flux:input value="{{ $nama }}" wire:model="nama" />
                            @else
                                <flux:input value="{{ $nama }}" wire:model="nama" readonly
                                    class="caret-transparent" />
                            @endif
                            <flux:error name="nama" />
                        </flux:field>

                        <flux:field>
                            <flux:label>NIDN</flux:label>
                            @if ($isEditing)
                                <flux:input value="{{ $nidn }}" wire:model="nidn" />
                            @else
                                <flux:input value="{{ $nidn }}" wire:model="nidn" readonly
                                    class="caret-transparent" />
                            @endif
                            <flux:error name="nidn" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Jenis Kelamin</flux:label>
                            @if ($isEditing)
                                <flux:select placeholder="Jenis Kelamin" wire:model="jenis_kelamin">
                                    <flux:select.option value="L">Laki-Laki</flux:select.option>
                                    <flux:select.option value="P">Perempuan</flux:select.option>
                                </flux:select>
                            @else
                                <flux:select placeholder="Jenis Kelamin" wire:model="jenis_kelamin" disabled>
                                    <flux:select.option value="L">Laki-Laki</flux:select.option>
                                    <flux:select.option value="P">Perempuan</flux:select.option>
                                </flux:select>
                            @endif
                            <flux:error name="jenis_kelamin" />
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
