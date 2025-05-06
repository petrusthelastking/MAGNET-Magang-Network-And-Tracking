<x-layouts.home>
    <x-navbar></x-navbar>

    <section class="h-screen mt-12 px-16 py-14 flex justify-around items-center text-black font-black">
        <div>
            <p class="text-blue-900">Selamat datang di</p>
            <h1 class="text-8xl">MAGNET</h1>
            <p>Magang Network and Tracking</p>
            <p>Oleh Jurusan Teknologi Informasi Politeknik Negeri Malang</p>

            <div class="mt-10">
                <flux:button class="bg-[#276DA9]! text-white!" href="{{ route('login') }}">Masuk ke sistem</flux:button>
                <flux:button class="bg-[#276DA9]! text-white!" href="{{ route('register') }}">Daftar</flux:button>
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