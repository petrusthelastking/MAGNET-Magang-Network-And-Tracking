<?php

use function Livewire\Volt\{layout, state};

layout('components.layouts.user.main');

state([
    'isOpenDetailJob' => false,
]);

$openDetailJob = fn() => ($this->isOpenDetailJob = true);

?>


<div class="flex flex-col gap-5 h-screen overflow-y-hidden">
    <x-slot:user>mahasiswa</x-slot:user>

    <div class="flex gap-3 p-1">
        <flux:input class="rounded-3xl!" placeholder="Cari Data Pengajuan Magang" icon="magnifying-glass" />
        <flux:button variant="primary" class="bg-white! text-black! w-17 rounded-full!" icon="arrow-down-wide-narrow">
        </flux:button>
        <flux:button variant="primary" class="bg-white! text-black! w-17 rounded-full!" icon="funnel-plus">
        </flux:button>
    </div>

    <div class="flex gap-6 w-full h-full">
        <div class="w-1/2 flex flex-col gap-4 overflow-y-auto">
            @for ($i = 0; $i < 200; $i++)
                <div role="button" class="card shadow-lg hover:cursor-pointer" wire:click="openDetailJob">
                    <div class="card-body bg-white hover:bg-gray-100 transition-colors rounded-md">
                        <div class="flex align-middle items-center gap-4">
                            <img src="{{ asset('img/company-kimia-farma.png') }}" alt="Logo Perusahaan"
                                class="w-10 h-10 object-contain">
                            <p>PT Kimia Farma</p>
                        </div>
                        <div>
                            <p class="font-bold text-base">Frontend Web Developer</p>
                            <p class="text-sm text-gray-600">Jakarta</p>
                        </div>
                    </div>
                </div>
            @endfor
        </div>

        <div class="card w-1/2 rounded-lg bg-white shadow-lg">
            <div class="card-body h-full overflow-y-auto">
                @if (!$isOpenDetailJob)
                    <flux:navlist class="w-64">
                        <flux:navlist.item icon="move-left" class="text-black! hover:bg-inherit! hover:cursor-default!">
                            Pilih lowongan magang</flux:navlist.item>
                    </flux:navlist>
                    <p>Tampilan detail lowongan magang akan ditampilkan di sini</p>
                @else
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-6">
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('logo-samsung.png') }}" alt="Logo Perusahaan"
                                    class="w-16 h-16 object-contain">
                                <div>
                                    <h2 class="text-md font-bold text-gray-800">CUDA PROGRAMMING</h2>
                                    <p class="text-sm text-gray-600">PT ESEMKA</p>
                                    <div class="flex items-center text-sm text-gray-600 gap-2">
                                        <flux:icon.map-pin class="size-4" />
                                        <p>Jayapura</p>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600 gap-2">
                                        <flux:icon.banknote class="size-4" />
                                        <p>Tidak dibayar</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <flux:button icon="save" class="bg-magnet-sky-teal! text-white!">Simpan</flux:button>
                                <div class="flex items-center text-sm text-black gap-2">
                                    <a href="www.google.com" class="underline flex items-center">Cek lokasi perusahaan
                                        di peta
                                        <flux:icon.map class="size-4 ml-1" />
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-2">Deskripsi magang</h3>
                            <p class="text-gray-700 leading-relaxed">
                                Lorem ipsum dolor sit amet consectetur. Tristique egestas pharetra euismod iaculis fames
                                velit accumsan nec ullamcorper. Vestibulum et quis aliquam mattis egestas. Vel tincidunt
                                quam nec et. Sed amet nunc sem massa mattis. A congue malesuada vel massa sagittis sed
                                elit sit. In magna in odio cursus. Venenatis pulvinar faucibus nullam mi in lectus
                                lobortis pellentesque scelerisque. Donec diam eget ante arcu mattis sapien aliquet
                                tellus. Mauris id porta sit sapien eget scelerisque nunc. Elit eget ut nam lacus in.
                                Faucibus a at dolor consectetur massa sagittis vitae. Nibh sit ullamcorper tincidunt
                                convallis rhoncus tristique. Ac laoreet tortor eros integer arcu sed lectus. Mauris nisi
                                elit faucibus eu condimentum eleifend. In netus adipiscing vitae nisi augue. Proin non
                                dis purus magna in. Faucibus massa pharetra magna tincidunt hendrerit est. Mauris
                                molestie ut massa neque netus aliquet quis leo. Morbi elit senectus dui pulvinar.
                            </p>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Ulasan magang</h3>
                            @for ($i = 0; $i < 5; $i++)
                            <div class="bg-white rounded-lg shadow-sm p-4 mb-4 border border-gray-200">
                                <div class="flex items-center mb-2">
                                    <img src="{{ asset('budi-herlambang-profile.png') }}" alt="Budi Herlambang"
                                        class="w-10 h-10 rounded-full mr-3">
                                    <div>
                                        <p class="font-semibold text-gray-900">Budi Herlambang</p>
                                        <p class="text-xs text-gray-500">20 April 2020</p>
                                    </div>
                                </div>
                                <p class="text-gray-700 leading-snug">
                                    Sungguh sebuah pengalaman yang luar biasa bisa bekerja di PT Maju Mundur Pantang
                                    Sukses ini. Pengalaman kerja yang komprehensif membuat saya...
                                </p>
                            </div>
                            @endfor
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
