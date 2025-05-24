<div class="card bg-white shadow-md p-5 text-black flex flex-col gap-5">
    <flux:text>Anda belum pernah mengajukan magang. Silakan ajukan terlebih dahulu ke admin</flux:text>

    <div class="flex gap-5">
        <p>Status pengajuan magang: </p>
        <flux:badge variant="solid" color="orange">Belum diajukan</flux:badge>
    </div>

    <flux:button variant="primary" href="{{ route('mahasiswa.form-pengajuan-magang') }}" class="bg-magnet-sky-teal w-fit">
        Ajukan Magang
    </flux:button>
</div>
