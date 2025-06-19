<?php

use App\Models\LogMagang;
use App\Models\KontrakMagang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

use function Livewire\Volt\{layout, state, mount, rules, updated};

layout('components.layouts.user.main');

state([
    'tanggal' => '',
    'jam_masuk' => '',
    'jam_keluar' => '',
    'kegiatan' => '',
    'kontrak_magang' => null,
    'mahasiswa' => null,
    'today_formatted' => '',
    'day_name' => '',
    'is_future_date' => false,
    'is_past_internship' => false,
    'is_before_internship' => false,
]);

rules([
    'tanggal' => 'required|date|before_or_equal:today',
    'jam_masuk' => 'required',
    'jam_keluar' => 'required|after:jam_masuk',
    'kegiatan' => 'required|min:10|max:1000',
]);

mount(function () {
    $this->mahasiswa = Auth::guard('mahasiswa')->user();

    // Set default date to today
    $this->tanggal = now()->format('Y-m-d');
    $this->today_formatted = now()->translatedFormat('d F Y');
    $this->day_name = now()->locale('id')->dayName;

    // Get active kontrak magang for the student
    $this->kontrak_magang = KontrakMagang::where('mahasiswa_id', $this->mahasiswa->id)
        ->whereDate('waktu_awal', '<=', now())
        ->whereDate('waktu_akhir', '>=', now())
        ->with(['lowonganMagang.perusahaan'])
        ->first();

    if (!$this->kontrak_magang) {
        session()->flash('error', 'Anda tidak memiliki kontrak magang aktif.');
    }
});

// Update day name and validations when date changes
// Perbaikan pada bagian updated() function
updated([
    'tanggal' => function ($value) {
        if ($value) {
            $selectedDate = Carbon::parse($value);
            $this->day_name = $selectedDate->locale('id')->dayName;
            $this->today_formatted = $selectedDate->translatedFormat('d F Y');

            // Check if date is in the future
            $this->is_future_date = $selectedDate->isFuture();

            // Check if date is within internship period
            if ($this->kontrak_magang) {
                $waktuAwal = Carbon::parse($this->kontrak_magang->waktu_awal)->startOfDay();
                $waktuAkhir = Carbon::parse($this->kontrak_magang->waktu_akhir)->startOfDay();

                // PERBAIKAN: Menggunakan startOfDay() untuk perbandingan tanggal yang akurat
                $this->is_before_internship = $selectedDate->startOfDay()->lt($waktuAwal);
                $this->is_past_internship = $selectedDate->startOfDay()->gt($waktuAkhir);
            }
        }
    },
]);

// Perbaikan pada bagian $save function
$save = function () {
    $this->validate();

    if (!$this->kontrak_magang) {
        throw ValidationException::withMessages([
            'general' => 'Tidak ada kontrak magang aktif.',
        ]);
    }

    // Check if log already exists for this date
    $existingLog = LogMagang::where('kontrak_magang_id', $this->kontrak_magang->id)->whereDate('tanggal', $this->tanggal)->first();

    if ($existingLog) {
        throw ValidationException::withMessages([
            'tanggal' => 'Log untuk tanggal ini sudah ada.',
        ]);
    }

    // Check if date is within internship period
    $tanggalLog = Carbon::parse($this->tanggal)->startOfDay();
    $waktuAwal = Carbon::parse($this->kontrak_magang->waktu_awal)->startOfDay();
    $waktuAkhir = Carbon::parse($this->kontrak_magang->waktu_akhir)->startOfDay();

    // PERBAIKAN: Menggunakan startOfDay() untuk perbandingan tanggal yang akurat
    if ($tanggalLog->lt($waktuAwal) || $tanggalLog->gt($waktuAkhir)) {
        throw ValidationException::withMessages([
            'tanggal' => 'Tanggal harus berada dalam periode magang Anda.',
        ]);
    }

    // Create new log
    LogMagang::create([
        'kontrak_magang_id' => $this->kontrak_magang->id,
        'tanggal' => $this->tanggal,
        'jam_masuk' => $this->jam_masuk,
        'jam_keluar' => $this->jam_keluar,
        'kegiatan' => $this->kegiatan,
    ]);

    session()->flash('success', 'Log magang berhasil disimpan!');

    // Reset form
    $this->reset(['jam_masuk', 'jam_keluar', 'kegiatan']);
    $this->tanggal = now()->format('Y-m-d');

    // Redirect back to log list
    return redirect()->route('mahasiswa.detail-log');
};

$cancel = function () {
    return redirect()->route('mahasiswa.detail-log');
};

?>

<x-slot:user>mahasiswa</x-slot:user>

<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Tambah Log Magang</h1>
                    <p class="text-sm text-gray-600 mt-1">Catat kegiatan magang Anda hari ini</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Hari ini</p>
                    <p class="text-lg font-semibold text-gray-900">{{ now()->translatedFormat('d F Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if (session()->has('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-green-800 font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-red-800 font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Internship Info Card -->
        @if ($kontrak_magang)
            <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-blue-50 border-b border-blue-100">
                    <h3 class="text-lg font-semibold text-blue-900 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        Informasi Magang Aktif
                    </h3>
                </div>
                <div class="px-6 py-4">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Perusahaan</p>
                            <p class="font-semibold text-gray-900">
                                {{ $kontrak_magang->lowonganMagang->perusahaan->nama }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Periode Magang</p>
                            <p class="font-semibold text-gray-900">
                                {{ Carbon::parse($kontrak_magang->waktu_awal)->format('d M Y') }} -
                                {{ Carbon::parse($kontrak_magang->waktu_akhir)->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Form -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Form Log Magang</h2>
            </div>

            <form wire:submit="save" class="p-6">
                <div class="space-y-6">
                    <!-- Date Field -->
                    <flux:field>
                        <flux:label class="text-base font-medium">Tanggal</flux:label>
                        <flux:input wire:model.live="tanggal" type="date" class="mt-1"
                            min="{{ $kontrak_magang ? Carbon::parse($kontrak_magang->waktu_awal)->format('Y-m-d') : '' }}"
                            max="{{ now()->format('Y-m-d') }}" />

                        @if ($day_name)
                            <div class="mt-2 flex items-center text-sm">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span class="text-gray-700 font-medium">{{ $day_name }},
                                    {{ $today_formatted }}</span>
                            </div>
                        @endif

                        <!-- Date Validation Warnings -->
                        @if ($is_future_date)
                            <div class="mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded-md">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-yellow-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-yellow-800 text-sm">Tidak dapat membuat log untuk tanggal yang
                                        akan datang</span>
                                </div>
                            </div>
                        @endif

                        @if ($is_before_internship)
                            <div class="mt-2 p-3 bg-red-50 border border-red-200 rounded-md">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-red-800 text-sm">Tanggal ini sebelum periode magang Anda
                                        dimulai</span>
                                </div>
                            </div>
                        @endif

                        @if ($is_past_internship)
                            <div class="mt-2 p-3 bg-red-50 border border-red-200 rounded-md">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-red-800 text-sm">Tanggal ini setelah periode magang Anda
                                        berakhir</span>
                                </div>
                            </div>
                        @endif

                        <flux:error name="tanggal" />
                    </flux:field>

                    <!-- Time Fields -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <flux:field>
                            <flux:label class="text-base font-medium">Jam Masuk</flux:label>
                            <flux:input wire:model="jam_masuk" type="time" class="mt-1" />
                            <flux:error name="jam_masuk" />
                        </flux:field>

                        <flux:field>
                            <flux:label class="text-base font-medium">Jam Keluar</flux:label>
                            <flux:input wire:model="jam_keluar" type="time" class="mt-1" />
                            <flux:error name="jam_keluar" />
                        </flux:field>
                    </div>

                    <!-- Activity Field -->
                    <flux:field>
                        <flux:label class="text-base font-medium">Kegiatan Magang</flux:label>
                        <flux:textarea wire:model.live="kegiatan"
                            placeholder="Jelaskan kegiatan yang Anda lakukan hari ini secara detail..." rows="5"
                            class="mt-1 resize-none" />

                        <div class="mt-2 flex justify-between items-center">
                            <div class="flex items-center text-xs text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Minimal 10 karakter, maksimal 1000 karakter
                            </div>
                            <span class="text-xs {{ strlen($kegiatan) > 1000 ? 'text-red-500' : 'text-gray-500' }}">
                                {{ strlen($kegiatan) }}/1000
                            </span>
                        </div>

                        <flux:error name="kegiatan" />
                    </flux:field>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-between items-center pt-6 mt-6 border-t border-gray-200">
                    <flux:button type="button" wire:click="cancel" variant="ghost" class="text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Batal
                    </flux:button>

                    <flux:button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6"
                        :disabled="!$kontrak_magang || $is_future_date || $is_before_internship || $is_past_internship">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        <span wire:loading.remove wire:target="save">Simpan Log Magang</span>
                        <span wire:loading wire:target="save">Menyimpan...</span>
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</div>
