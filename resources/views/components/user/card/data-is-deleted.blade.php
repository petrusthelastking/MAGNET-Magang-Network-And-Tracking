<div class="card h-fit w-full flex items-center justify-center text-center text-black">
    <div class="card-body flex flex-row gap-6 items-center h-full w-full bg-white rounded-xl">
        <div>
            <flux:icon.triangle-alert />
        </div>
        <div class="text-left flex flex-col gap-6">
            <div>
                <h1 class="text-lg font-bold">Data tidak dapat ditemukan!</h1>
                <flux:text>Data yang anda lihat sudah terhapus</flux:text>
            </div>
            <flux:button variant="primary" class="bg-magnet-sky-teal w-fit" href="{{ $backRoute }}">
                Kembali ke halaman sebelumnya</flux:button>
        </div>
    </div>
</div>
