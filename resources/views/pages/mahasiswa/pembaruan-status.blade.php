<?php
use function Livewire\Volt\{layout, state};

state([
    'status' => '',
]);

layout('components.layouts.mahasiswa.main');

?>

<div>
    <div class="bg-[#DFF6F9] min-h-screen p-6">
        <h2 class="text-lg font-semibold text-black mb-1">Pembaruan status magang</h2>
        <p class="text-black mb-6">Anda perlu memperbarui status magang anda secara manual jika telah diterima atau
            selesai kontrak magang</p>

        <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <form wire:submit="updateStatus">
                <div class="mb-4">
                    <flux:field>
                        <flux:label>Status Magang Saat Ini</flux:label>
                        <flux:select wire:model.live="status" placeholder="Status Magang Saat Ini">
                            <flux:select.option value="Tidak Magang">Tidak Magang</flux:select.option>
                            <flux:select.option value="Sedang Magang">Sedang Magang</flux:select.option>
                            <flux:select.option value="Selesai Magang">Selesai Magang</flux:select.option>
                        </flux:select>
                    </flux:field>
                </div>

                @if ($status == 'Sedang Magang')
                    @livewire('mahasiswa.pembaruan-status-sedang-magang')
                @elseif($status == 'Selesai Magang')
                    @livewire('mahasiswa.pembaruan-status-selesai-magang')
                @endif
            </form>
        </div>
    </div>
</div>
