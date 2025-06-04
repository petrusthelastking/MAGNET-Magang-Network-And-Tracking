<x-layouts.user.main user="mahasiswa">
    <div class="card bg-white shadow-md">
        <div class="card-body flex flex-row items-center">
            <div class="flex items-center gap-4 w-full">
                <img src="{{ asset('img/company-kimia-farma.png') }}" alt="Logo Perusahaan" class="w-16 h-16 object-contain ">
                <div class="flex flex-col gap-4">
                    <h2 class="text-xl font-bold">CUDA Programming</h2>
                    <div>
                        <div class="flex items-center text-sm text-gray-600 gap-2">
                            <flux:icon.building-2 class="size-4" />
                            <p>PT ESEMKA</p>
                        </div>
                        <div class="flex items-center text-sm text-gray-600 gap-2">
                            <flux:icon.map-pin class="size-4" />
                            <p>Jayapura</p>
                        </div>
                        <div class="flex items-center text-sm text-gray-600 gap-2">
                            <flux:icon.banknote class="size-4" />
                            <p>Tidak dibayar</p>
                        </div>
                        <div class="flex items-center text-sm text-gray-600 gap-2">
                            <flux:icon.users class="size-4" />
                            <p>200 kuota</p>
                        </div>
                    </div>
                    <div>
                        <flux:link href="{{ route('mahasiswa.profil-perusahaan') }}"
                            class="flex! items-center! text-xs text-gray-400">
                            Lihat selengkapnya profil perusahaan
                            <flux:icon.chevron-right class="ml-1 size-4" />
                        </flux:link>
                    </div>
                </div>
            </div>
            <flux:button variant="primary" class="bg-magnet-sky-teal! text-white!" icon="bookmark-plus">Simpan</flux:button>
        </div>
    </div>

    <div class="card bg-white shadow-md">
        <div class="card-body">
            <h3 class="text-base font-semibold">Deskripsi magang</h3>
            <p class="text-sm text-gray-700 mt-2">
                Lorem ipsum dolor sit amet consectetur. Tristique egestas pharetra euismod iaculis fames velit accumsan
                nec ullamcorper...
            </p>
        </div>
    </div>

    <div class="card bg-white shadow-md">
        <div class="card-body">
            <h3 class="text-base font-semibold">Ulasan magang</h3>
            <div class="flex flex-col gap-4">
                @foreach (range(1, 3) as $ulasan)
                    <div class="bg-white rounded-lg shadow-sm p-4 flex gap-3">
                        <img src="https://unavatar.io/budi" class="w-10 h-10 rounded-full object-cover" alt="Foto Reviewer">
                        <div>
                            <h4 class="font-semibold">Budi Herlambang</h4>
                            <p class="text-sm mt-1 text-gray-700">
                                Sungguh sebuah pengalaman yang luar biasa bisa bekerja di PT Maju Mundur Pantang Sukses
                                ini... 🔥
                            </p>
                            <span class="text-xs text-gray-500 mt-1 block">20 April 2020</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card bg-white shadow-md">
        <div class="card-body">
            <h3 class="text-base font-semibold">Lowongan Serupa</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach (range(1, 4) as $item)
                    <div class="bg-white rounded-xl shadow-sm border p-4">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('logo-perusahaan.png') }}" alt="Logo Perusahaan"
                                class="w-16 h-16 object-contain ">
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
