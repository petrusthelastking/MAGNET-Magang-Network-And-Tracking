<div class="card bg-white shadow-md p-5 text-black flex flex-col gap-5">
    <div class="flex gap-5">
        <p>Status pengajuan magang: </p>
        <flux:badge variant="solid" color="green">Pengajuan diterima</flux:badge>
    </div>

    <div>
        <p class="font-semibold">Dosen pembimbing:</p>
        <p>Endah Septa Sintya</p>
    </div>

    <flux:text>Anda bisa berkonsultasi terkait proses magang pada dosen pembimbing anda. Fitur konsultasi bisa diakses pada bagian <flux:link href="{{ route('mahasiswa.konsul-dospem') }}">Konsultasi</flux:link></flux:text>

    <flux:button icon="download" variant="primary" href="#" class="bg-magnet-sky-teal w-fit">
        Unduh surat pengajuan magang
    </flux:button>
</div>
