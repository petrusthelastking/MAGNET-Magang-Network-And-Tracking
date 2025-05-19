<?php

use Livewire\Volt\Component;

new class extends Component {
    public array $data = [];
    public array $headers = [];
    public int $totalRowsPerPage = 10;

    public function mount(
        array $data,
        int $totalRowsPerPage = 10
    ) : void
    {
        $this->data = $data;
        $this->headers = array_keys($data[0]);
        $this->totalRowsPerPage = $totalRowsPerPage;
    }
}

?>

<div class="overflow-y-auto rounded-lg shadow bg-white">
    <table class="table-auto w-full">
        <thead class="bg-white text-black">
            <tr class="border-b">
                <th class="text-center px-6 py-3">No</th>
                @foreach ($headers as $col)
                <th class="text-left px-6 py-3">{{ $col }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-white text-black">
            @for ($i = 0; $i < count($data) && $i < $totalRowsPerPage; $i++)
                <tr class="border-b hover:bg-gray-50 odd:bg-gray-50">
                    <td class="px-6 py-3 text-center">{{ $i + 1 }}</td>

                    @foreach ($data[$i] as $val)
                    <td class="px-6 py-3">{{ $val }}</td>
                    @endforeach
                </tr>
            @endfor
        </tbody>
    </table>
    <div class="flex justify-between w-full px-8 py-4">
        <p class="text-black">Menampilkan {{ $totalRowsPerPage }} dari {{ count($data) }} data</p>
        <div class="flex">
            <flux:button icon="chevron-left" variant="ghost" />
            @for ($i = 0; $i < ceil(count($data) / $totalRowsPerPage); $i++)
                <flux:button variant="ghost">{{ $i + 1 }}</flux:button>
            @endfor
            <flux:button icon="chevron-right" variant="ghost" />
        </div>
        <div>
            <div class="flex gap-3 items-center text-black">
                <p>Baris per halaman</p>
                <flux:select class="w-20!" wire:model.live="totalRowsPerPage">
                    <flux:select.option value="10" selected>10</flux:select.option>
                    <flux:select.option value="25">25</flux:select.option>
                    <flux:select.option value="50">50</flux:select.option>
                    <flux:select.option value="100">100</flux:select.option>
                </flux:select>
            </div>
        </div>
    </div>

    <div>
        <x-slot name="my-slot">

        </x-slot>
    </div>
</div>