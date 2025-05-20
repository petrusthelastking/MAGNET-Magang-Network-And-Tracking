<x-layouts.dosen.dosen>
    <flux:breadcrumbs class="mb-5">
    <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
    <flux:breadcrumbs.item href="{{ route('dosen.mahasiswa-bimbingan') }}" class="text-black">Mahasiswa Bimbingan</flux:breadcrumbs.item>
  </flux:breadcrumbs>
        <div class="flex gap-3">
            <flux:input class="rounded-3xl!" placeholder="Cari Data Dosen" icon="magnifying-glass" />
            <flux:button variant="primary" class="bg-white! text-black! w-17 rounded-full!"
                icon="arrow-down-wide-narrow"></flux:button>
            <flux:button variant="primary" class="bg-white! text-black! w-17 rounded-full!" icon="funnel-plus">
            </flux:button>
        </div>
        <div class="grid grid-cols-5 gap-4">
            @for ($i=0; $i<20; $i++)
                <div class="bg-white card">
                <img src="https://picsum.photos/200/300">
                <p class="text-base leading-6 font-bold text-black">Ratih Saputri</p>
                <flux:button icon="user-round" variant="ghost">Frontend Developer</flux:button>
                <flux:button icon="building-2" variant="ghost">PT Cinta Abadi</flux:button>
            </div>
            @endfor
            
            
        </div>
</x-layouts.dosen.dosen>