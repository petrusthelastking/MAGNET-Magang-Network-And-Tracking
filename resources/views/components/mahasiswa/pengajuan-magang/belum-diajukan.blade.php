<div class="card bg-white shadow-md p-5">
    <p class="text-black text-base font-normal p-2!">
        Anda belum pernah mengajukan magang. Silakan ajukan terlebih dahulu ke admin.
    </p>

    <div class="card-body text-black text-base font-medium">
        <div class="flex">
            <p class="w-60">Status pengajuan magang saat ini:</p>
            <flux:badge variant="solid" color="orange">Belum diajukan</flux:badge>
        </div>
    </div>

    <div class="card-actions flex mt-4">
        <flux:button class="bg-magnet-sky-teal! text-white!" href="{{ url('/mahasiswa/formulir-pengajuan') }}">
            Ajukan Pengajuan Magang
        </flux:button>
    </div>
</div>
