<?php

use App\Models\LogMagang;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

use function Livewire\Volt\{layout, state, mount};

layout('components.layouts.user.main');

state([
    'logMagang' => null,
    'logId' => null,
    'debug_info' => [],
]);

mount(function () {
    // Get the ID from the route parameter or request
    $this->logId = Request::route('id') ?? request('id');

    // Debug: Log the ID retrieval
    $this->debug_info['route_debug'] = [
        'route_id' => Request::route('id'),
        'request_id' => request('id'),
        'final_log_id' => $this->logId,
        'request_method' => request()->method(),
        'full_url' => request()->fullUrl(),
        'route_params' => Request::route() ? Request::route()->parameters() : 'No route',
    ];

    if (!$this->logId) {
        $this->debug_info['error'] = 'No ID provided';
        // If no ID is provided, redirect back to the list
        return redirect()->route('mahasiswa.detail-log');
    }

    try {
        // Debug: Check if record exists before loading relationships
        $basicLog = LogMagang::find($this->logId);
        $this->debug_info['basic_log_check'] = [
            'exists' => $basicLog ? 'Yes' : 'No',
            'raw_data' => $basicLog ? $basicLog->toArray() : 'Not found',
        ];

        if ($basicLog) {
            // Debug: Check each field individually
            $this->debug_info['field_values'] = [
                'tanggal' => $basicLog->tanggal,
                'tanggal_type' => gettype($basicLog->tanggal),
                'tanggal_is_null' => is_null($basicLog->tanggal),
                'tanggal_is_empty' => empty($basicLog->tanggal),
                'jam_masuk' => $basicLog->jam_masuk,
                'jam_masuk_type' => gettype($basicLog->jam_masuk),
                'jam_masuk_is_null' => is_null($basicLog->jam_masuk),
                'jam_masuk_is_empty' => empty($basicLog->jam_masuk),
                'jam_keluar' => $basicLog->jam_keluar,
                'jam_keluar_type' => gettype($basicLog->jam_keluar),
                'jam_keluar_is_null' => is_null($basicLog->jam_keluar),
                'jam_keluar_is_empty' => empty($basicLog->jam_keluar),
                'kegiatan' => $basicLog->kegiatan,
                'kegiatan_length' => strlen($basicLog->kegiatan ?? ''),
            ];

            // Debug: Check relationships
            $this->debug_info['relationship_debug'] = [
                'has_kontrak_magang' => $basicLog->kontrakMagang ? 'Yes' : 'No',
                'kontrak_magang_id' => $basicLog->kontrak_magang_id ?? 'No ID',
            ];

            if ($basicLog->kontrakMagang) {
                $this->debug_info['relationship_debug']['kontrak_data'] = [
                    'id' => $basicLog->kontrakMagang->id,
                    'has_mahasiswa' => $basicLog->kontrakMagang->mahasiswa ? 'Yes' : 'No',
                    'has_lowongan' => $basicLog->kontrakMagang->lowonganMagang ? 'Yes' : 'No',
                ];

                if ($basicLog->kontrakMagang->lowonganMagang) {
                    $this->debug_info['relationship_debug']['lowongan_data'] = [
                        'id' => $basicLog->kontrakMagang->lowonganMagang->id,
                        'nama' => $basicLog->kontrakMagang->lowonganMagang->nama,
                        'has_perusahaan' => $basicLog->kontrakMagang->lowonganMagang->perusahaan ? 'Yes' : 'No',
                    ];
                }
            }
        }

        // Load the full record with relationships
        $this->logMagang = LogMagang::with(['kontrakMagang.mahasiswa', 'kontrakMagang.lowonganMagang.perusahaan'])->findOrFail($this->logId);

        // Debug: Final loaded data
        $this->debug_info['final_loaded_data'] = [
            'log_id' => $this->logMagang->id,
            'tanggal_final' => $this->logMagang->tanggal,
            'jam_masuk_final' => $this->logMagang->jam_masuk,
            'jam_keluar_final' => $this->logMagang->jam_keluar,
            'kegiatan_final' => substr($this->logMagang->kegiatan ?? '', 0, 50) . '...',
        ];
    } catch (\Exception $e) {
        $this->debug_info['exception'] = [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ];
        throw $e;
    }
});

$goBack = function () {
    return redirect()->route('mahasiswa.detail-log');
};

$formatTanggal = function ($tanggal) {
    if (!$tanggal) {
        return 'Tanggal tidak tersedia';
    }

    try {
        return Carbon::parse($tanggal)->locale('id')->translatedFormat('l, d F Y');
    } catch (\Exception $e) {
        return "Error formatting date: {$tanggal}";
    }
};

$testQuery = function () {
    $this->debug_info['test_query'] = [
        'total_logs' => LogMagang::count(),
        'logs_with_kontrak' => LogMagang::whereHas('kontrakMagang')->count(),
        'sample_log_ids' => LogMagang::take(5)->pluck('id')->toArray(),
        'sample_logs_with_data' => LogMagang::take(3)
            ->get(['id', 'tanggal', 'jam_masuk', 'jam_keluar'])
            ->toArray(),
    ];
};

$toggleDebug = function () {
    $this->debug_info['show_debug'] = !($this->debug_info['show_debug'] ?? false);
};

?>

<div class="flex flex-col gap-5">
    <x-slot:user>mahasiswa</x-slot:user>

    @if ($logMagang)
        <!-- Header with Back Button -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800">
                Detail Log Magang
            </h2>
        </div>

        <div class="bg-white rounded-lg shadow-md p-5 mx-auto">
            <div class="space-y-6">

                <flux:field>
                    <flux:label>Hari, Tanggal</flux:label>
                    <flux:input readonly type="text"
                        value="{{ $logMagang->tanggal->locale('id')->translatedFormat('l, d F Y') }}"
                        class="bg-gray-50!" />
                </flux:field>

                <flux:field>
                    <flux:label>Jam Masuk</flux:label>
                    <flux:input readonly type="time" value="{{ $logMagang->jam_masuk->format('H:i') }}"
                        class="bg-gray-50!" />
                </flux:field>

                <flux:field>
                    <flux:label>Jam Pulang</flux:label>
                    <flux:input readonly type="time" value="{{ $logMagang->jam_keluar->format('H:i') }}"
                        class="bg-gray-50!" />
                </flux:field>

                <flux:field>
                    <flux:label>Kegiatan</flux:label>
                    <flux:textarea readonly rows="6" class="bg-gray-50!">{{ $logMagang->kegiatan }}
                    </flux:textarea>
                </flux:field>

                <!-- Additional Information -->
                <div class="border-t pt-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Tambahan</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <flux:field>
                            <flux:label>Perusahaan</flux:label>
                            <flux:input readonly
                                value="{{ $logMagang->kontrakMagang->lowonganMagang->perusahaan->nama ?? '-' }}"
                                class="bg-gray-50!" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Posisi Magang</flux:label>
                            <flux:input readonly value="{{ $logMagang->kontrakMagang->lowonganMagang->nama ?? '-' }}"
                                class="bg-gray-50!" />
                        </flux:field>
                    </div>

                    <div class="mt-4">
                        <flux:field>
                            <flux:label>Mahasiswa</flux:label>
                            <flux:input readonly value="{{ $logMagang->kontrakMagang->mahasiswa->nama ?? '-' }}"
                                class="bg-gray-50!" />
                        </flux:field>
                    </div>
                </div>

            </div>

            <!-- Back Button at Bottom -->
            <div class="flex justify-start mt-8">
                <flux:button wire:click="goBack" variant="outline" icon="arrow-left">
                    Kembali ke Daftar Log
                </flux:button>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-5 text-center">
            <p class="text-gray-600">Log magang tidak ditemukan.</p>
            <flux:button wire:click="goBack" variant="outline" class="mt-4">
                Kembali ke Daftar Log
            </flux:button>
        </div>
    @endif
</div>
