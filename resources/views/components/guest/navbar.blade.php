<flux:navbar class="px-6 sticky py-4 top-0 w-full z-50 flex justify-between bg-magnet-deep-ocean-blue!">
    <flux:navbar.item href="{{ route('landing-page') }}">
        <flux:text class="font-black text-white text-2xl">{{ config('app.name') }}</flux:text>
    </flux:navbar.item>
    <div>
        <img src="{{ asset('JTI.png') }}" alt="" class="w-10">
    </div>
</flux:navbar>
