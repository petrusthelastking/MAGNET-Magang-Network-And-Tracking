<!-- resources/views/livewire/detail-mahasiswa.blade.php -->
<div>
    <div class="flex gap-8 items-start">
        <div class="flex flex-col items-center bg-white p-4 rounded-xl shadow-md">
            <img src="{{ asset('cewek.png') }}" alt="Foto Mahasiswa"
                class="w-40 h-52 object-cover rounded-md mb-4" />
            <div class="flex gap-4">
                <flux:button wire:click="toggleEdit" icon="{{ $editMode ? 'save' : 'pencil' }}"
                    class="{{ $editMode ? 'bg-blue-500! hover:bg-blue-600!' : 'bg-emerald-500! hover:bg-emerald-600!' }} text-white! rounded-md items-center min-w-[100px] max-w-[100px]">
                    {{ $editMode ? 'Simpan' : 'Edit' }}
                </flux:button>
                <flux:modal.trigger name="delete-profile">
                    <flux:button icon="trash-2"
                        class="bg-red-500! hover:bg-red-600! text-white! rounded-md items-center">
                        Hapus
                    </flux:button>
                </flux:modal.trigger>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md w-full max-w-3xl">
            <h2 class="text-lg font-semibold mb-4">Informasi Pribadi</h2>

            <div class="grid grid-cols-1 gap-4">
                <!-- Nama Lengkap -->
                <div class="flex flex-col min-h-[64px]">
                    <span class="text-gray-500 text-sm">Nama Lengkap</span>
                    @if (!$editMode)
                        <span class="font-medium mt-2">{{ $nama }}</span>
                    @else
                        <flux:input id="nama" wire:model="nama" />
                    @endif
                </div>

                <!-- NIM -->
                <div class="flex flex-col min-h-[64px]">
                    <span class="text-gray-500 text-sm">NIM</span>
                    @if (!$editMode)
                        <span class="font-medium mt-2">{{ $nim }}</span>
                    @else
                        <flux:input id="nim" wire:model="nim" />
                    @endif
                </div>

                <!-- Jurusan -->
                <div class="flex flex-col min-h-[64px]">
                    <span class="text-gray-500 text-sm">Jurusan</span>
                    @if (!$editMode)
                        <span class="font-medium mt-2">{{ $jurusan }}</span>
                    @else
                        <flux:input id="jurusan" wire:model="jurusan" />
                    @endif
                </div>

                <!-- Program Studi -->
                <div class="flex flex-col min-h-[64px]">
                    <span class="text-gray-500 text-sm">Program Studi</span>
                    @if (!$editMode)
                        <span class="font-medium mt-2">{{ $prodi }}</span>
                    @else
                        <flux:input id="prodi" wire:model="prodi" />
                    @endif
                </div>

                <!-- Jenis Kelamin -->
                <div class="flex flex-col min-h-[64px]">
                    <span class="text-gray-500 text-sm">Jenis Kelamin</span>
                    @if (!$editMode)
                        <span class="font-medium mt-2">{{ $jk }}</span>
                    @else
                        <flux:select id="jk" wire:model="jk">
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </flux:select>
                    @endif
                </div>

                <!-- Umur -->
                <div class="flex flex-col min-h-[64px]">
                    <span class="text-gray-500 text-sm">Umur</span>
                    @if (!$editMode)
                        <span class="font-medium mt-2">{{ $umur }}</span>
                    @else
                        <flux:input id="umur" wire:model="umur" type="number" />
                    @endif
                </div>

                <!-- Status Magang -->
                <div class="flex flex-col min-h-[64px]">
                    <span class="text-gray-500 text-sm">Status Magang</span>
                    @if (!$editMode)
                        <span class="font-medium mt-2">{{ $statusMagang }}</span>
                    @else
                        <flux:select id="statusMagang" wire:model="statusMagang">
                            <option value="Aktif">Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </flux:select>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
