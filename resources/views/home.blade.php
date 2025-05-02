<x-layouts.home>
    <x-navbar></x-navbar>

    <section class="h-screen mt-14 px-16 py-14 flex justify-around items-center text-burnt-orange">
        <div>
            <h1 class="font-bold text-8xl">MAGNET</h1>
            <p>Magang Network and Tracking</p>

            <div class="mt-10">
                <flux:button variant="primary" href="{{ route('login') }}">Masuk ke sistem</flux:button>
            </div>
        </div>

        <div>
            <img src="{{ asset('assets/img/magnet-logo.png') }}" alt="Magnet logo" class="w-96">
        </div>
    </section>

    <section class="h-screen px-16 py-14">
        <div>Section 2</div>
    </section>

    <section class="h-screen px-16 py-14">
        <div>Section 3</div>
    </section>

    <x-footer></x-footer>
</x-layouts.home>