<footer class="bg-magnet-deep-ocean-blue text-white flex flex-col">
    <div class="container mx-auto px-6 py-8">
        <div class="flex flex-col md:flex-row items-start justify-between">
            <div class="mb-6 md:mb-0">
                <a href="{{ route('guest.landing-page') }}">
                    <h1 class="text-2xl font-bold">MAGNET</h1>
                    <p class="text-sm">Magang Network and Tracking</p>
                </a>
                <div class="mt-4 text-xs text-gray-300">
                    <p>Jurusan Teknologi</p>
                    <p>Informasi Politeknik Negeri</p>
                    <p>Malang</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 w-full md:w-auto">
                <div class="flex flex-col gap-2">
                    <h2 class="font-semibold">Petunjuk</h2>
                    <ul>
                        <li><a href="{{ route('guest.cara-magang') }}" class="text-sm hover:text-blue-300">Cara
                                mengajukan magang</a></li>
                        <li><a href="{{ route('guest.tips-memilih-magang') }}" class="text-sm hover:text-blue-300">Tips
                                memilih tempat magang terbaik</a></li>
                    </ul>
                </div>

                <div class="flex flex-col gap-2">
                    <h2 class="font-semibold">Tata Tertib</h2>
                    <ul>
                        <li><a href="{{ route('guest.tata-tertib') }}" class="text-sm hover:text-blue-300">Informasi
                                resmi tata tertib magang</a></li>
                    </ul>
                </div>

                <div class="flex flex-col gap-2">
                    <h2 class="font-semibold">Pusat Bantuan</h2>
                    <ul>
                        <li><a href="#" class="text-sm hover:text-blue-300">Aduan pengguna</a></li>
                    </ul>
                </div>

                <div class="flex flex-col gap-2">
                    <h2 class="font-semibold">Tim Pengembang</h2>
                    <ul>
                        <li>
                            <a href="{{ route('guest.pengembang') }}" class="text-sm hover:text-blue-300">Informasi pengembang</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-magnet-abyssal-blue">
        <div class="container mx-auto py-3 text-center">
            <p class="mb-2">&copy; 2025 Jurusan Teknologi Informasi - Politeknik Negeri Malang</p>
        </div>
    </div>
</footer>
