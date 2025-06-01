<x-layouts.user.main user="dosen">
    <flux:breadcrumbs class="mb-5">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('dosen.mahasiswa-bimbingan') }}" class="text-black">Mahasiswa Bimbingan</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('dosen.detail-mahasiswa-bimbingan') }}" class="text-black">Detail Mahasiswa Bimbingan
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item class="text-black">Beri Masukan
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <div>
        <flux:textarea
        label="Beri Masukan Kepada Mahasiswa Bimbingan"
        placeholder="Tuliskan masukan anda kepada mahasiswa bimbingan di sini"/>
        <div class="flex justify-end">
            <flux:button class="bg-magnet-sky-teal! text-white! my-5">Kirim</flux:button>
        </div>
    </div>

</x-layouts.dosen.main>
