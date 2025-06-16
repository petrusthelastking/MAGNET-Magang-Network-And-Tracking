<?php

use function Livewire\Volt\{state, on};


state([
    'status',
    'title'
]);

on([
    'open-modal-response-form' => function ($data) {
        $this->status = $data['status'];
        $this->title = $data['title'];
    }
]);

?>


<flux:modal name="modal-response-form" class="min-w-52 w-fit">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">{{ $title }}</flux:heading>
        </div>
        <div class="w-full flex justify-center items-center">
            @if ($status == 'success')
                <flux:icon.check-circle class="w-10 h-10 text-green-600" />
            @else
                <flux:icon.x-circle class="w-10 h-10 text-red-600" />
            @endif
        </div>
        <div class="flex">
            <flux:spacer />
            <flux:modal.close>
                <flux:button type="submit" variant="primary" class="bg-magnet-sky-teal">OK</flux:button>
            </flux:modal.close>
        </div>
    </div>
</flux:modal>
