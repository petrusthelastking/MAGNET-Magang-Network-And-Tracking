<flux:navbar class="px-6 fixed top-0 w-full z-50 flex justify-between">
    <flux:navbar.item href="{{ route('home') }}">
        <flux:text class="font-black text-black text-2xl">{{ config('app.name') }}</flux:text>
    </flux:navbar.item>
    <div class="flex">
        <flux:navbar.item href="{{ route('home') }}">
            <flux:text class=" text-black text-lg">Tentang</flux:text>
        </flux:navbar.item>
        <flux:navbar.item href="{{ route('home') }}">
            <flux:text class=" text-black text-lg">Panduan</flux:text>
        </flux:navbar.item>
        <flux:navbar.item href="{{ route('home') }}">
            <flux:text class=" text-black text-lg">Hubungi Kami</flux:text>
        </flux:navbar.item>
    </div>
</flux:navbar>