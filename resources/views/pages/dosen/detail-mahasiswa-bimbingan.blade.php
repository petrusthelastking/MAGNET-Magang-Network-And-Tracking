<x-layouts.dosen.main>
    <flux:breadcrumbs class="mb-5">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('dosen.mahasiswa-bimbingan') }}" class="text-black">Mahasiswa Bimbingan
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item class="text-black">Detail Mahasiswa Bimbingan
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <h1 class="text-base font-bold leading-6 text-black">Informasi Mahasiswa Magang</h1>

    <div class=" min-h-screen p-6">
        <div class="px-4 font-sans text-black">
            <div class="flex gap-8 items-start">
                <div class="flex flex-col items-center bg-white p-4 rounded-xl shadow-md">
                    <img src="{{ asset('dosen.png') }}" alt="Foto Dosen"
                        class="w-40 h-52 object-cover rounded-md mb-4" />
                    <div class="flex gap-4">
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md w-full">
                    <flux:field class="flex! my-2">
                        <flux:label class="w-1/12">Nama</flux:label>
                        <flux:input value="Budi Budiman Berbudi Pekerti" readonly/>
                    </flux:field>
                    <flux:field class="flex! my-2">
                        <flux:label class="w-1/12">Kelas</flux:label>
                        <flux:input value="TI-4F" readonly/>
                    </flux:field>
                    <flux:field class="flex! my-2">
                        <flux:label class="w-1/12">NIM</flux:label>
                        <flux:input value="231010101010" readonly/>
                    </flux:field>
                    <flux:field class="flex! my-2">
                        <flux:label class="w-1/12">Program Studi</flux:label>
                        <flux:input value="D4 Sastra Mesin" readonly/>
                    </flux:field>
                    <flux:field class="flex! my-2">
                        <flux:label class="w-1/12">Perusahaan yang dituju</flux:label>
                        <flux:input value="PT Terbuka Gila Banget" readonly/>
                    </flux:field>
                    <flux:field class="flex! my-2">
                        <flux:label class="w-1/12">Posisi</flux:label>
                        <flux:input value="Machine Learning Engineer" readonly/>
                    </flux:field>
                    <flux:field class="flex! my-2">
                        <flux:label class="w-1/12">Mulai Magang</flux:label>
                        <flux:input value="2 Februari 2025" readonly/>
                    </flux:field>
                    <flux:field class="flex! my-2">
                        <flux:label class="w-1/12">Akhir Magang</flux:label>
                        <flux:input value="12 Juni 2025" readonly/>
                    </flux:field>
                    <flux:field class="flex! my-2">
                        <flux:label class="w-1/12">Durasi</flux:label>
                        <flux:input value="64 hari" readonly/>
                    </flux:field>
                    <flux:field class="flex! my-2">
                        <flux:label class="w-1/12">Sisa Waktu</flux:label>
                        <flux:input value="12 hari" readonly/>
                    </flux:field>
                </div>
                </form>
            </div>
        </div>
        <flux:button class="bg-magnet-sky-teal! text-white! my-5">Berikan Masukan kepada Mahasiswa</flux:button>
        <div>
            <h1 class="text-base font-bold leading-6 text-black my-4">Log Mahasiswa</h1>
        </div>
        <div class="overflow-y-auto flex flex-col items-center mt-4 rounded-lg shadow bg-white ">
            <table class="table-auto w-full">
                <thead class="bg-white text-black">
                    <tr class="border-b">
                        <th class="text-center px-6 py-3">No</th>
                        <th class="text-left px-6 py-3">Aktivitas</th>
                        <th class="text-left px-6 py-3">Tanggal</th>
                        <th class="text-left px-6 py-3">Waktu</th>
                        <th class="text-center px-6 py-3">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="bg-white text-black">
                    @for ($i = 0; $i < 10; $i++)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3 text-center">{{ $i + 1 }}</td>
                            <td class="px-6 py-3">Ahmad Sukadani Setiawan</td>
                            <td class="px-6 py-3">12 Feb 2025</td>
                            <td class="px-6 py-3">07.12 WIB</td>
                            <td class="px-6 py-3">Keterangan itu adalah suatu informasi tambahan</td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        <div class="flex items-center justify-between w-full p-3">
            <div class="text-black mt-6">
                <p>Menampilkan 10 dari 1250 data</p>
            </div>
            <div class="flex mt-6">
                <flux:button icon="chevron-left" variant="ghost" />
                @for ($i = 0; $i < 5; $i++)
                    <flux:button variant="ghost">{{ $i + 1 }}</flux:button>
                @endfor
                <flux:button icon="chevron-right" variant="ghost" />
            </div>
            <div class="flex gap-3 items-center text-black mt-6">
                <p>Baris per halaman</p>
                <flux:select placeholder="10" class="w-20!">
                    <flux:select.option>10</flux:select.option>
                    <flux:select.option>25</flux:select.option>
                    <flux:select.option>50</flux:select.option>
                    <flux:select.option>100</flux:select.option>
                </flux:select>
            </div>
        </div>
    </div>


</x-layouts.dosen.dosen>
