<x-layouts.mahasiswa.mahasiswa>
    <flux:breadcrumbs class="mb-5">
        <flux:breadcrumbs.item href="{{ route('mahasiswa.dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('mahasiswa.pengajuan-magang') }}" class="text-black">Pengajuan Magang
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="card bg-white shadow-md">
        <div class="card-body">
            <flux:input type="text" label="Nama Lengkap" />
            <flux:input type="text" label="Jurusan" />
            <flux:input type="text" label="Program Studi" />
            <flux:input type="file" wire:model="attachments" label="CV" />
        </div>

        <div class="card-actions flex justify-end p-5">
            <flux:button class="bg-magnet-sky-teal! text-white!">Kirim Lamaran</flux:button>
        </div>
    </div>
</x-layouts.mahasiswa.mahasiswa>