<x-layouts.user.main user="admin">
    <flux:breadcrumbs class="mb-5">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('admin.statistik-magang') }}" class="text-black">Statistik magang
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <h1 class="text-base font-bold leading-6 text-black">Statistik Magang</h1>
    <div class="grid grid-cols-3 gap-4">
        <flux:button href="{{ route('admin.perusahaan-terpopuler') }}"
            class="bg-magnet-def-red-300! text-white! rounded-md shadow-lg h-28 p-4 flex items-center gap-3 justify-start">
            <flux:icon.building class="w-12 h-12" />
            <p class="text-lg">Perusahaan Terpopuler</p>
            
        </flux:button>

        <flux:button
            class="bg-magnet-def-red-300! text-white! rounded-md shadow-lg h-28 p-4 flex items-center gap-3 justify-start">
            <flux:icon.building class="w-12 h-12" />
            <p class="text-lg">Perusahaan Paling Direkomendasikan</p>
        </flux:button>

        <flux:button
            class="bg-magnet-def-yellow-300! text-white! rounded-md shadow-lg h-28 p-4 flex items-center gap-3 justify-start">
            <flux:icon.circle-dot class="w-12 h-12" />
            <p class="text-lg">Bidang Terfavorit</p>
        </flux:button>

        <flux:button
            class="bg-magnet-def-green-300! text-white! rounded-md shadow-lg h-28 p-4 flex items-center gap-3 justify-start">
            <flux:icon.map-pinned class="w-12 h-12" />
            <p class="text-lg">Lokasi Magang</p>
        </flux:button>

        <flux:button
            class="bg-magnet-def-purple-300! text-white! rounded-md shadow-lg h-28 p-4 flex items-center gap-3 justify-start">
            <flux:icon.circuit-board class="w-12 h-12" />
            <p class="text-lg">Pemetaan skil dengan perusahaan</p>
        </flux:button>

        <flux:button
            class="bg-magnet-def-indigo-300! text-white! rounded-md shadow-lg h-28 p-4 flex items-center gap-3 justify-start">
            <flux:icon.crown class="w-12 h-12" />
            <p class="text-lg">Top performa mahasiswa magang</p>
        </flux:button>


    </div>
</x-layouts.user.main>