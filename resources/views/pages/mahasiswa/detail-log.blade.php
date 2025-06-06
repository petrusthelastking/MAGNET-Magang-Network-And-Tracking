<?php

use App\Models\LogMagang;
use Illuminate\Support\Facades\Auth;

use function Livewire\Volt\{layout, state, mount};

state([
    'logs' => [],
    'debug_info' => [],
]);

mount(function () {
    $this->mahasiswa = Auth::guard('mahasiswa')->user();
    $this->debug_info['mahasiswa_id'] = $this->mahasiswa->id ?? 'null';

    // Cek jumlah kontrak magang mahasiswa ini
    $kontrakQuery = \App\Models\KontrakMagang::where('mahasiswa_id', $this->mahasiswa->id);
    $this->debug_info['jumlah_kontrak_magang'] = $kontrakQuery->count();

    // Ambil log berdasarkan kontrak magang mahasiswa
    $this->logs = LogMagang::whereHas('kontrakMagang', function ($query) {
        $query->where('mahasiswa_id', $this->mahasiswa->id);
    })
        ->orderBy('tanggal', 'desc')
        ->get();

    $this->debug_info['jumlah_log_ditemukan'] = $this->logs->count();
});

// Add methods to handle redirects
$redirectToLogMagang = function ($logId) {
    return redirect()->route('mahasiswa.log-magang', ['id' => $logId]);
};

$redirectToTambahLog = function () {
    return redirect()->route('mahasiswa.tambah-log');
};

layout('components.layouts.user.main');
?>

<div>
    <x-slot:user>mahasiswa</x-slot:user>
    <h2 class="text-xl font-bold text-gray-800 mb-6">Log Magang</h2>
    <p class="text-gray-600 mb-4">Berikut adalah daftar log magang yang telah Anda buat. Klik pada salah satu log untuk
        melihat detailnya.</p>
    <div class="flex justify-between mt-4">
        <div class="flex gap-3"></div>
        <div class="flex gap-3">
            <!-- Fixed: Use the correct method name -->
            <flux:button variant="primary" class="bg-magnet-sky-teal" icon="plus" wire:click="redirectToTambahLog">
                Buat laporan log magang baru
            </flux:button>
        </div>
    </div>

    <div class="overflow-y-auto flex flex-col items-center mt-4 rounded-lg shadow bg-white">
        <table class="table-auto w-full">
            <thead class="bg-white text-black">
                <tr class="border-b">
                    <th class="text-center px-6 py-3">No</th>
                    <!-- Added Hari column -->
                    <th class="text-left px-6 py-3">Hari</th>
                    <th class="text-left px-6 py-3">Tanggal</th>
                    <th class="text-left px-6 py-3">Kegiatan</th>
                </tr>
            </thead>
            <tbody class="bg-white text-black">
                @foreach ($logs as $index => $log)
                    <!-- Fixed: Use wire:click instead of onclick -->
                    <tr wire:click="redirectToLogMagang({{ $log->id }})"
                        class="border-b hover:bg-gray-50 cursor-pointer">
                        <td class="px-6 py-3 text-center">{{ $index + 1 }}</td>
                        <!-- Added day column using Carbon -->
                        <td class="px-6 py-3">{{ \Carbon\Carbon::parse($log->tanggal)->locale('id')->dayName }}</td>
                        <td class="px-6 py-3">{{ \Carbon\Carbon::parse($log->tanggal)->translatedFormat('d F Y') }}</td>
                        <td class="px-6 py-3">{{ $log->kegiatan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex items-center justify-between w-full p-3">
            <div class="text-black mt-6">
                <p>Menampilkan {{ count($logs) }} data</p>
            </div>

            <div class="flex mt-6">
                <flux:button icon="chevron-left" variant="ghost" />
                <flux:button variant="ghost">1</flux:button>
                <flux:button icon="chevron-right" variant="ghost" />
            </div>

            <div class="flex gap-3 items-center text-black mt-6">
                <p>Baris per halaman</p>
                <flux:select placeholder="10" class="w-20!">
                    <flux:select.option>10</flux:select.option>
                    <flux:select.option>25</flux:select.option>
                    <flux:select.option>50</flux:select.option>
                    <flux:select.option>100</flux:select.option>
                </flux:select>
            </div>
        </div>
    </div>
</div>
