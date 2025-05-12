<x-layouts.mahasiswa.mahasiswa>
    <flux:breadcrumbs class="mb-5">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" class="text-black">Dashboard</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Top content card -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div class="w-full md:w-[386.031px] h-[192px] flex-shrink-0 rounded-[15px] bg-[#6EE7B7] shadow-[0px_4px_4px_0px_rgba(0,0,0,0.25)] p-4 flex flex-col justify-between">
            <div class="flex items-center space-x-2">
                <flux:icon name="search" class="w-5 h-5 text-black" />
                <div class="text-black font-bold">
                    <p>Lowongan</p>
                    <p>Aktif</p>
                </div>
            </div>
            <div class="text-black text-5xl font-semibold">
                {{ isset($jumlahLowongan) ? $jumlahLowongan : '0' }}
            </div>
        </div>

        <div class="w-full md:w-[386.031px] h-[192px] flex-shrink-0 rounded-[15px] bg-[#C4B5FD] shadow-[0px_4px_4px_0px_rgba(0,0,0,0.25)] p-4 flex flex-col justify-between">
            <div class="flex items-center space-x-2">
                <flux:icon name="download" class="w-5 h-5 text-black" />
                <div class="text-black font-bold">
                    <p>Status Pengajuan</p>
                    <p>Magang</p>
                </div>
            </div>
            <div class="text-black text-5xl font-semibold">
                {{ isset($jumlahLowongan) ? $jumlahLowongan : '0' }}
            </div>
        </div>

        <div class="w-full md:w-[386.031px] h-[192px] flex-shrink-0 rounded-[15px] bg-[#FCD34D] shadow-[0px_4px_4px_0px_rgba(0,0,0,0.25)] p-4 flex flex-col justify-between">
            <div class="flex items-center space-x-2">
                <flux:icon name="download" class="w-5 h-5 text-black" />
                <div class="text-black font-bold">
                    <p>Status Magang</p>
                </div>
            </div>
            <div class="text-black text-5xl font-semibold">
                {{ isset($jumlahLowongan) ? $jumlahLowongan : '0' }}
            </div>
        </div>
    </div>

    <!-- Wrapper dengan jarak 9px antar card -->
    <div class="flex flex-col gap-[9px]">
        <!-- Mid content card -->
        <div class="w-full md:w-[1347px] h-[162px] flex-shrink-0 rounded-[15px] bg-white shadow-[0px_4px_4px_0px_rgba(0,0,0,0.25)] p-4 flex flex-col justify-between">
            <p>Status Magang</p>
        </div>

        <!-- Bottom content card -->
        <div class="w-full md:w-[1347px] h-[162px] flex-shrink-0 rounded-[15px] bg-white shadow-[0px_4px_4px_0px_rgba(0,0,0,0.25)] p-4 flex flex-col justify-between">
            <p>Status Magang</p>
        </div>
    </div>
</x-layouts.mahasiswa.mahasiswa>
