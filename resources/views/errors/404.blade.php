<x-layouts.guest.main>
    <div class="h-screen w-screen flex justify-center items-center">
        <div class="card bg-white">
            <div class="card-body flex flex-col gap-6">
                <div>
                    <h1 class="text-magnet-deep-ocean-blue text-2xl font-bold">⚠️ Halaman tidak ditemukan</h1>
                    <flux:text>Pastikan URL yang anda masukkan sesuai dengan halaman yang ingin anda tuju</flux:text>
                </div>
                <flux:button
                    href="{{ url()->previous() }}"
                    class="w-fit! bg-magnet-sky-teal! text-white! hover:bg-magnet-icy-blue!">
                    Kembali ke halaman sebelumnya
                </flux:button>
            </div>
        </div>
    </div>
</x-layouts.guest.main>
