<?php

use App\Models\FormPengajuanMagang;
use App\Models\KontrakMagang;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use function Livewire\Volt\{state};

$mahasiswa = Auth::user()->mahasiswa;

// // Ambil status pengajuan
// $formPengajuan = FormPengajuanMagang::with('berkasPengajuanMagang')->whereHas('berkasPengajuanMagang', fn($q) => $q->where('mahasiswa_id', $mahasiswa->id))->latest()->first();

// $status = $formPengajuan?->status ?? 'diproses';

// // Tentukan warna badge berdasarkan status
// $badgeColor = match ($status) {
//     'diterima' => 'green',
//     'diproses' => 'yellow',
//     'ditolak' => 'red',
//     default => 'gray',
// };

// // Ambil dosen pembimbing dari kontrak magang
// $kontrak = KontrakMagang::with('dosen')->where('mahasiswa_id', $mahasiswa->id)->latest()->first();

// $dosenPembimbing = $kontrak?->dosen?->nama ?? '-';

// // Ambil file CV atau surat (opsional)
// $suratPath = $formPengajuan?->pengajuan?->cv ?? null;

// state([
//     'status' => $this->status,
//     'dosenPembimbing' => $this->dosenPembimbing,
//     'suratPath' => $this->suratPath,
// ]);

?>

<div class="card bg-white shadow-md p-5 text-black flex flex-col gap-5">
    <div class="flex gap-5">
        <p>Status pengajuan magang:</p>
        <flux:badge variant="solid" color="green">
            diterima
            {{-- {{ ucfirst($status) }} --}}
        </flux:badge>
    </div>

    <flux:text>
        Anda bisa berkonsultasi terkait proses magang pada dosen pembimbing anda.
        Fitur konsultasi bisa diakses pada bagian
        <flux:link href="{{ route('mahasiswa.konsul-dospem') }}">Konsultasi</flux:link>
    </flux:text>

    {{-- @if ($suratPath)
        <flux:button icon="download" variant="primary" href="{{ asset('storage/' . $suratPath) }}"
            class="bg-magnet-sky-teal w-fit">
            Unduh surat pengajuan magang
        </flux:button>
    @endif --}}
</div>
