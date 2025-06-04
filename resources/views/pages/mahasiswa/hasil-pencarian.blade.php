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

    <div class="flex gap-3">
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
                        <flux:navlist.item icon="move-left" class="text-black! hover:bg-inherit! hover:cursor-default!">Pilih lowongan magang</flux:navlist.item>
                    </flux:navlist>
                    <p>Tampilan detail lowongan magang akan ditampilkan di sini</p>
                @else
                    <div>Ini tampilan detail perusahaan</div>
                @endif
            </div>
        </div>
    </div>
</div>
