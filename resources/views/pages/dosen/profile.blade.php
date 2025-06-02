<x-layouts.dosen.main>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('profile') }}" class="text-black">Profil Anda
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <h1 class="text-base font-bold leading-6 text-black">Profil Anda</h1>
    <div class="gap-3 flex flex-col">
        <div class="card bg-white shadow-md">
            <div class="card-body p-5">
                <flux:avatar circle src="https://unavatar.io/x/Jane Doe" class="w-24 h-24" />
                <div class="grid grid-cols-2 gap-3 ">
                    <flux:input readonly value="{{ auth('dosen')->user()->nama }}" type="text" label="Nama Lengkap" />
                    <flux:input readonly value="{{ auth('dosen')->user()->nidn }}" type="text" label="NIDN" />
                    <flux:input readonly value="{{ auth('dosen')->user()->jenis_kelamin == 'L' ? 'Laki-Laki' : (auth('dosen')->user()->jenis_kelamin == 'P' ? 'Perempuan' : '-')}}" type="text" label="Jenis Kelamin" />
                </div>
            </div>
            
            <div class="card-actions flex justify-end p-5">
                <flux:button class="bg-magnet-sky-teal! text-white!" icon="pencil">Edit data anda</flux:button>
            </div>
        </div>
    </div>
</x-layouts.dos.main>
