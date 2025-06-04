<x-layouts.user.main user="mahasiswa">
    <h1 class="text-base font-bold leading-6 text-black">Detail Log Magang</h1>

    <div class="flex justify-between mt-4">
        <div class="flex gap-3">

        </div>
        <div class="flex gap-3">
            <flux:button variant="primary" class="bg-magnet-sky-teal" icon="plus"
                onclick="window.location='{{ route('mahasiswa.tambah-log') }}'">Buat laporan log magang baru
            </flux:button>
        </div>
    </div>
    <div class="overflow-y-auto flex flex-col items-center mt-4 rounded-lg shadow bg-white">
        <table class="table-auto w-full ">
            <thead class="bg-white text-black">
                <tr class="border-b">
                    <th class="text-center px-6 py-3">No</th>
                    <th class="text-left px-6 py-3">Tanggal</th>
                    <th class="text-left px-6 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white text-black">
                @for ($i = 0; $i < 10; $i++)
                    <tr onclick="window.location='log-magang'" class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3 text-center">{{ $i + 1 }}</td>
                        <td class="px-6 py-3">17 Agustus 1945</td>
                        <td class="px-6 py-3">Telah diisi</td>
                        <td class="px-6 py-3 text-center">
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
        <div class="flex items-center justify-between w-full p-3">
            <div class="text-black mt-6">
                <p>Menampilkan 10 dari 1250 data</p>
            </div>
            <div class="flex mt-6">
                <flux:button icon="chevron-left" variant="ghost" />
                @for ($i = 0; $i < 3; $i++)
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
</x-layouts.user.main>
