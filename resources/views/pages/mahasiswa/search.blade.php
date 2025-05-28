<?php

use function Livewire\Volt\{layout, state, mount};

layout('components.layouts.mahasiswa.main');

state([
    'isOpenDetailJob' => false,
]); 

$openDetailJob = fn() => $this->isOpenDetailJob = true;

?>


<div>
    <!-- Search Bar -->
    <div class="flex gap-3">
        <flux:input class="rounded-3xl!" placeholder="Cari Data Pengajuan Magang" icon="magnifying-glass" />
        <flux:button variant="primary" class="bg-white! text-black! w-17 rounded-full!" icon="arrow-down-wide-narrow">
        </flux:button>
        <flux:button variant="primary" class="bg-white! text-black! w-17 rounded-full!" icon="funnel-plus">
        </flux:button>
    </div>

    <div class="flex gap-3 w-full h-[calc(100vh-6rem)] mt-5 overflow-hidden">
        <div class="w-1/2 flex-shrink-0 rounded-[15px] p-4 flex flex-col overflow-y-auto">
            @for ($i = 0; $i < 7; $i++)
                <div class="card shadow-md bg-white text-accent-content w-full mb-4">
                    <button type="button" wire:click="openDetailJob">
                        <div class="card-body">
                            <div class="flex align-middle items-center">
                                <img src="{{ asset('logo-perusahaan.png') }}" alt="Logo Perusahaan"
                                    class="w-10 h-10 object-contain">
                                <p class="h-fit px-3">PT.Kimia Farma</p>
                            </div>
                            <div class="font-bold text-lg">
                                <p>Frontend Web Developer</p>
                            </div>
                            <p>Jakarta</p>
                        </div>
                    </button>
                </div>
            @endfor
        </div>

        <!-- Kolom kanan -->
        <div
            class="w-1/2 flex-shrink-0 rounded-[15px] bg-white shadow-[0px_4px_4px_0px_rgba(0,0,0,0.25)] p-4 overflow-y-auto text-gray-400!">
            @if (!$isOpenDetailJob)
                <flux:navlist class="w-64">
                    <flux:navlist.item icon="move-left" class="text-black!">Pilih lowongan magang</flux:navlist.item>
                </flux:navlist>
                <p>Tampilkan detail di sini</p>
            @else
                <livewire:components.main.detail-perusahaan />
            @endif
        </div>
    </div>
</div>
