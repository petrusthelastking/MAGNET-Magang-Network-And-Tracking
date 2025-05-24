<x-layouts.admin.admin>
    <flux:breadcrumbs class="mb-5">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('admin.data-lowongan') }}" class="text-black">Kelola data pengajuan-magang
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <h1 class="text-base font-bold leading-6 text-black">Kelola Data Pengajuan Magang</h1>

    <div class="flex justify-start mt-4">
        <div class="flex gap-3">
            <flux:input class="rounded-3xl!" placeholder="Cari Data Pengajuan" icon="magnifying-glass" />
            <flux:button variant="primary" class="bg-white! text-black! w-17 rounded-full!"
                icon="arrow-down-wide-narrow"></flux:button>
            <flux:button variant="primary" class="bg-white! text-black! w-17 rounded-full!" icon="funnel-plus">
            </flux:button>
        </div>
    </div>

    <div class="overflow-y-auto flex flex-col items-center mt-4 rounded-lg shadow bg-white">
        <table class="table-auto w-full ">
    <div class="overflow-y-auto flex flex-col items-center mt-4 rounded-lg shadow bg-white">
        <table class="table-auto w-full ">
            <thead class="bg-white text-black">
                <tr class="border-b">
                    <th class="text-center px-6 py-3">No</th>
                    <th class="text-left px-6 py-3">Mahasiswa</th>
                    <th class="text-left px-6 py-3">Lamaran yang dituju</th>
                    <th class="text-left px-6 py-3">Tanggal Pengajuan</th>
                    <th class="text-center px-6 py-3">Status</th>
                    <th class="text-center px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white text-black">
                @for ($i = 0; $i < 10; $i++)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3 text-center">{{ $i + 1 }}</td>
                        <td class="px-6 py-3">Edy Kurnia Setyawan</td>
                        <td class="px-6 py-3">PT Maju Mundur</td>
                        <td class="px-6 py-3">22-11-2022</td>
                        <td class="px-6 py-3">Terverifikasi</td>
                        <td class="px-6 py-3 text-center">
                            <flux:button icon="ellipsis-vertical" href="{{ route('admin.detail-pengajuan') }}" variant="ghost" />
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
    </div>

</x-layouts.admin.admin>
