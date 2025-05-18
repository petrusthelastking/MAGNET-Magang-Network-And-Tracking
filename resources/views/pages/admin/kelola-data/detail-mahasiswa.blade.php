<x-layouts.admin.admin>
    <flux:breadcrumbs class="mb-5">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('data-mahasiswa') }}" class="text-black">Kelola Data Mahasiswa
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('detail-mahasiswa') }}" class="text-black">Detail Data Mahasiswa
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <h1 class="text-base font-bold leading-6 text-black">Detail Informasi Mahasiswa</h1>

    <div class="min-h-screen p-6">
        <div class="px-4 font-sans text-black">
            @livewire('detail-mahasiswa')
        </div>
    </div>
    <flux:modal name="delete-profile" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Hapus Data?</flux:heading>
                <flux:text class="mt-2">
                    <p>Apakah anda yakin ingin menghapus data mahasiswa ?</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Batalkan</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="danger">Hapus</flux:button>
            </div>
        </div>
    </flux:modal>
</x-layouts.admin.admin>