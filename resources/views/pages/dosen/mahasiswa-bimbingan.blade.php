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
                <div class="bg-white card py-4">
                    <a href="{{ route('dosen.detail-mahasiswa-bimbingan')}}"> 
                        <div class="p-4">
                            <img src="https://picsum.photos/200/300" class="rounded-full w-32 h-32 object-cover mx-auto" alt="Foto Profil" />
                        </div>
                        <p class="text-base leading-6 font-bold text-black text-center">Ratih Saputri</p>
                        <flux:button icon="user-round" variant="ghost" class="text-gray-500!">Frontend Developer</flux:button>
                        <flux:button icon="building-2" variant="ghost" class="text-gray-500!">PT Cinta Abadi</flux:button>
                    </a>
            </div>
            @endfor
            
            
        </div>
</x-layouts.dosen.dosen>