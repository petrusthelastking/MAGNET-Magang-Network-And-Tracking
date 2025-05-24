<div class="card bg-white shadow-md p-5 text-black flex flex-col gap-5">
    <div class="flex gap-5">
        <p>Status pengajuan magang: </p>
        <flux:badge variant="solid" color="red">Ditolak</flux:badge>
    </div>

    <div>
        <p class="font-semibold">Alasan penolakan:</p>
        <flux:text>Berkas CV yang dikirimkan sudah kadaluarsa. Silakan kirimkan berkas terbaru yang sesuai.</flux:text>
    </div>

    <flux:button variant="primary" href="{{ route('mahasiswa.form-pengajuan-magang') }}" class="bg-magnet-sky-teal w-fit">
        Ajukan Pengajuan Magang Kembali
    </flux:button>
</div>
