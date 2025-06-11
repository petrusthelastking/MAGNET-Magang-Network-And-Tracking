<section class="lg:min-h-screen px-4 sm:px-6 lg:px-8 pt-6 mb-10 sm:mb-10 flex justify-around items-start">
    <div class="container mx-auto">
        <div
            class="bg-gradient-to-br from-magnet-deep-ocean-blue via-blue-900 to-magnet-deep-ocean-blue text-white rounded-2xl pb-32 sm:pb-48 lg:pb-72">
            <div class="navbar px-5 py-0">
                <div class="navbar-start">
                    <a href="/" class="text-white flex items-center gap-2">
                        <flux:icon.magnet class="rotate-180" />
                        MAGNET
                    </a>
                </div>
                <div class="navbar-center hidden lg:flex">
                    <ul class="menu menu-horizontal px-1 flex">
                        <flux:button variant="ghost" class="text-white!" href="#petunjuk">Pedoman Magang</flux:button>
                        <flux:button variant="ghost" class="text-white!" href="#kendala">FAQ</flux:button>
                        <flux:button variant="ghost" class="text-white!" href="#about">Tentang Kami</flux:button>
                    </ul>
                </div>
                <div class="navbar-end">
                    <img src="{{ asset('img/logo/jti.png') }}" alt="" class="w-10">
                </div>
            </div>

            <div class="text-center pt-6 sm:pt-8 px-4">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-medium mb-4 sm:mb-6 italic">
                    Langkah Awal Kariermu<br>Dimulai Di Sini!
                </h1>
                <p class="max-w-xs sm:max-w-md mx-auto text-center text-xs sm:text-sm text-white mb-4 sm:mb-6 px-2">
                    Magang nggak harus ribet. Cukup sesuaikan minatmu, dan kami bantu carikan yang paling cocok buat
                    kamu!
                </p>
                <flux:button
                    class="text-black! bg-white! rounded-full! hover:bg-gray-200 border-0 text-xs sm:text-sm px-4 py-2 sm:px-6 sm:py-3"
                    href="{{ route('login') }}" wire:navigate>
                    <span class="hidden sm:inline">Cari tempat magang impianmu Sekarang</span>
                    <span class="sm:hidden">Cari Magang Sekarang</span>
                </flux:button>
            </div>

        </div>

        <!-- Floating Cards -->
        <div
            class="bg-white rounded-lg p-4 sm:p-6 lg:p-8 shadow-lg -mt-24 sm:-mt-40 lg:-mt-64 relative z-10 mx-16 sm:mx-24 md:mx-32 lg:mx-72">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                <!-- Card 1 - Selalu tampil -->
                <div
                    class="rounded-lg h-60 w-48 md:h-72 md:w-full flex justify-center items-center overflow-hidden mx-auto">
                    <img src="{{ asset('img/card/man-1.png') }}" alt="Mobile Development"
                        class="object-cover w-full h-full">
                </div>
                <!-- Card 2 - Tampil mulai md -->
                <div class="rounded-lg h-72 justify-center items-center overflow-hidden hidden md:flex">
                    <img src="{{ asset('img/card/man-2.png') }}" alt="UI UX" class="object-cover w-full h-full">
                </div>
                <!-- Card 3 - Tampil mulai lg -->
                <div class="rounded-lg h-72 justify-center items-center overflow-hidden hidden lg:flex">
                    <img src="{{ asset('img/card/woman-1.png') }}" alt="Security Engineer"
                        class="object-cover w-full h-full">
                </div>
            </div>
        </div>
    </div>
</section>
