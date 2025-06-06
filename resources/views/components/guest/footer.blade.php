<footer class="bg-magnet-deep-ocean-blue text-white flex">
    <div class="container mx-auto px-6 py-8">
        <div class="flex flex-col md:flex-row items-start justify-between">
            <div class="mb-6 md:mb-0">
                <h1 class="text-2xl font-bold">MAGNET</h1>
                <p class="text-sm">Magang Network and Tracking</p>
                <div class="mt-4 text-xs text-gray-300">
                    <p>Jurusan Teknologi</p>
                    <p>Informasi Politeknik Negeri</p>
                    <p>Malang</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full md:w-auto">
                <!-- Section 1 -->
                <div>
                    <h2 class="font-semibold mb-2">Petunjuk</h2>
                    <ul>
                        <li><a href="{{ route('cara-magang') }}" class="text-sm hover:text-blue-300">Cara mengajukan magang</a></li>
                        <li><a href="{{route('tips-memilih-magang')}}" class="text-sm hover:text-blue-300">Tips memilih tempat magang terbaik</a></li>
                    </ul>
                </div>
                
                <!-- Section 2 -->
                <div>
                    <h2 class="font-semibold mb-2">Tata Tertib</h2>
                    <ul>
                        <li><a href="{{ route('tatatertib') }}" class="text-sm hover:text-blue-300">Informasi resmi tata tertib magang</a></li>
                    </ul>
                </div>
                
                <!-- Section 3 -->
                <div>
                    <h2 class="font-semibold mb-2">Pusat Bantuan</h2>
                    <ul>
                        <li><a href="#" class="text-sm hover:text-blue-300">Ajuan pengguna</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>