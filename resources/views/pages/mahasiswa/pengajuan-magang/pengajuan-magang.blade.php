<?php

use function Livewire\Volt\{layout, rules, state, protect};

layout('components.layouts.mahasiswa.mahasiswa');

?>

<div class="text-black flex flex-col gap-6">
    <h2 class="text-base leading-6 font-bold">Pengajuan Magang</h2>

    <x-mahasiswa.pengajuan-magang.belum-diajukan />
</div>
