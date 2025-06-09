<?php

use function Livewire\Volt\{layout, rules, state, protect};

layout('components.layouts.user.main');

$mahasiswa = auth('mahasiswa')->user();
$berkas = $mahasiswa->berkasPengajuanMagang()->latest('updated_at')->first();
$formPengajuan = $berkas?->formPengajuanMagang()->first();

state([
    'mahasiswa' => $mahasiswa,
    'status' => $mahasiswa->status_magang,
    'pengajuanMagang' => $formPengajuan?->status, // bisa null jika belum pernah ajukan
    'alasanDitolak' => $formPengajuan?->keterangan, // jika kamu simpan alasan di field ini
]);

?>

<div class="text-black flex flex-col gap-6">
    <x-slot:user>mahasiswa</x-slot:user>

    <h2 class="text-base leading-6 font-bold">Pengajuan Magang</h2>

    @if ($status == 'belum magang')
        @if (is_null($pengajuanMagang))
            {{-- Belum pernah mengajukan --}}
            <x-mahasiswa.pengajuan-magang.belum-diajukan />
        @elseif ($pengajuanMagang == 'diproses' || $pengajuanMagang == 'diterima')
            {{-- Sedang diproses --}}
            <x-mahasiswa.pengajuan-magang.sedang-diproses />
        @elseif ($pengajuanMagang == 'diterima')
            {{-- Sudah diterima --}}
            <x-mahasiswa.pengajuan-magang.pengajuan-diterima /> {{-- Sudah mengajukan, tunggu proses selanjutnya --}}
        @elseif ($pengajuanMagang == 'ditolak')
            {{-- Ditolak, tampilkan alasan dan form ulang --}} <div class="bg-red-100 p-4 rounded shadow">
                <p class="text-red-600 font-semibold">Pengajuan Anda ditolak.</p>
                <p class="text-sm mt-1">Alasan: {{ $alasanDitolak ?? 'Tidak ada alasan yang diberikan.' }}</p>
            </div>
            <x-mahasiswa.pengajuan-magang.belum-diajukan />
        @endif
    @elseif (
        $status == 'sedang magang' ||
            $status == 'selesai magang' ||
            !in_array($status, ['belum magang', 'sedang magang', 'selesai magang']))
        <div class="card bg-white shadow-md p-6 text-black rounded-2xl border border-gray-200">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-briefcase"></i>
                </div>
                <div class="flex flex-col">
                    <p class="text-sm text-gray-500 font-medium">Status Magang</p>
                    <p class="text-lg font-semibold capitalize">
                        {{ match ($status) {
                            'sedang magang' => 'Sedang Menjalani Magang',
                            'selesai magang' => 'Magang Telah Selesai',
                            default => 'Status Tidak Dikenali',
                        } }}
                    </p>
                </div>
            </div>
            <div class="text-sm text-gray-600 leading-relaxed">
                {{ match ($status) {
                    'sedang magang' => 'Anda sedang menjalani magang saat ini. Tidak perlu mengajukan kembali.',
                    'selesai magang' => 'Anda telah menyelesaikan magang. Terima kasih atas partisipasi Anda.',
                    default => 'Silakan hubungi admin jika informasi status magang Anda tidak sesuai.',
                } }}
            </div>
        </div>
    @endif
</div>
