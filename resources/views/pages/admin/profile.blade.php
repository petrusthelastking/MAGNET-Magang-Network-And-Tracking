<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('profile') }}" class="text-black">Profil Anda
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="gap-3 flex flex-col">
        <div class="card bg-white shadow-md">
            <div class="card-body p-5">
                <flux:avatar circle src="https://unavatar.io/x/Jane Doe" class="w-24 h-24" />
                <div class="grid grid-cols-2 gap-3 ">
                    <flux:input readonly value="{{ auth('admin')->user()->nama }}" type="text" label="Nama Lengkap" />
                    <flux:input readonly value="{{ auth('admin')->user()->nip }}" type="text" label="NIP" />
                </div>
            </div>

            <div class="card-actions flex justify-end p-5">
                <flux:button class="bg-magnet-sky-teal! text-white!" icon="pencil">Edit data anda</flux:button>
            </div>
        </div>
    </div>
</div>
