<x-layouts.admin.admin>

    <h1 class="text-base font-bold leading-6">Kelola Data Mahasiswa</h1>

    <div class="flex justify-end mb-8 mt-4">
        <flux:button variant="primary" class="bg-[#276DA9]!">Tambah data mahasiswa</flux:button>
    </div>

    <div class="overflow-y-auto flex flex-col items-center ">
        <table class="table-auto border border-collapse w-full">
            <thead class="bg-[#041D56]">
                <tr>
                    <th class="text-center px-6 py-3">No</th>
                    <th class="text-left px-6 py-3">Nama</th>
                    <th class="text-left px-6 py-3">NIM</th>
                    <th class="text-left px-6 py-3">Status</th>
                    <th class="text-center px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-[#CCCCCC] text-black">
                @for ($i = 0; $i < 10; $i++)
                    <tr>
                        <td class="px-6 py-3 text-center">{{ $i+1 }}</td>
                        <td class="px-6 py-3">Budi Gunawan Herlambang Sejahtera Saputra Widodo</td>
                        <td class="px-6 py-3">1291921281281</td>
                        <td class="px-6 py-3">
                            <flux:badge color="green" variant="solid">Sedang magang</flux:badge>
                        </td>
                        <td class="px-6 py-3 text-center ">
                            <flux:button icon="ellipsis-vertical" />
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>

        <div class="flex mt-6">
            <flux:button icon="chevron-left" />
            @for ($i = 0; $i < 5; $i++)
                <flux:button variant="ghost">{{ $i+1 }}</flux:button>
            @endfor
            <flux:button icon="chevron-right" />
        </div>
    </div>
</div>

</x-layouts.admin.admin>