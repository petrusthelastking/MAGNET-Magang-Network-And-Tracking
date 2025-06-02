<x-layouts.user.main user="mahasiswa">
    <div class="space-y-5 bg-[#E6FAFA] min-h-screen p-6 text-black">

        {{-- === Kartu Info Magang === --}}
        <div class="bg-white rounded-xl shadow-md p-6 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <img src="{{ asset('logo-perusahaan.png') }}" alt="Logo Perusahaan" class="w-16 h-16 object-contain ">
                <div>
                    <h2 class="text-xl font-bold">CUDA Programming</h2>
                    <p class="text-sm text-gray-600">PT ESEMKA</p> <!-- menambahkan icon 'map-pin' -->
                    <p class="text-sm text-gray-600">Jayapura</p> <!-- menambahkan icon 'banknote' -->
                    <p class="text-sm text-gray-600">Tidak dibayar</p>
                </div>
            </div>
            <div class="flex flex-col items-end gap-2">
                <flux:button class="bg-magnet-sky-teal! text-white!" icon="save">Simpan</flux:button>
                <a href="#" class="text-sm text-black ">Cek lokasi perusahaan di peta</a> <!-- menambahkan icon 'map' -->
            </div>
        </div>

        {{-- === Deskripsi Magang === --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold">Deskripsi magang</h3>
            <p class="text-sm text-gray-700 mt-2">
                Lorem ipsum dolor sit amet consectetur. Tristique egestas pharetra euismod iaculis fames velit accumsan nec ullamcorper...
            </p>
        </div>

        {{-- === Ulasan Magang === --}}
        <div class="bg-white rounded-xl shadow-md p-6 space-y-4">
            <h3 class="text-lg font-semibold">Ulasan magang</h3>
            @foreach(range(1, 3) as $ulasan)
                <div class="bg-gray-50 rounded-lg shadow-sm p-4 flex gap-3">
                    <img src="https://unavatar.io/budi" class="w-10 h-10 rounded-full object-cover" alt="Foto Reviewer">
                    <div>
                        <h4 class="font-semibold">Budi Herlambang</h4>
                        <p class="text-sm mt-1 text-gray-700">
                            Sungguh sebuah pengalaman yang luar biasa bisa bekerja di PT Maju Mundur Pantang Sukses ini... 🔥
                        </p>
                        <span class="text-xs text-gray-500 mt-1 block">20 April 2020</span>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- === Lowongan Serupa === --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Lowongan Serupa</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach(range(1, 4) as $item)
                    <div class="bg-white rounded-xl shadow-sm border p-4">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('logo-perusahaan.png') }}" alt="Logo Perusahaan" class="w-16 h-16 object-contain ">
                            <div class="text-sm">
                                <p class="font-bold">Frontend Web Developer</p>
                                <p class="text-gray-500">PT Kimia Farma</p>
                            </div>
                        </div>
                        <div class="flex justify-between mt-2 text-sm text-gray-600">
                            <span icon="">Jakarta</span>
                            <span>⭐3.7</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</x-layouts.user.main>
