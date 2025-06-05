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
]);

rules([
    'tanggal' => 'required|date',
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

// Update day name when date changes
updated([
    'tanggal' => function ($value) {
        if ($value) {
            $this->day_name = Carbon::parse($value)->locale('id')->dayName;
            $this->today_formatted = Carbon::parse($value)->translatedFormat('d F Y');
        }
    },
]);

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
    $tanggalLog = Carbon::parse($this->tanggal);
    $waktuAwal = Carbon::parse($this->kontrak_magang->waktu_awal);
    $waktuAkhir = Carbon::parse($this->kontrak_magang->waktu_akhir);

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

<div class="min-h-screen">
    <h2 class="text-xl font-bold text-gray-800 mb-6">
        Log Magang {{ $day_name }}, {{ $today_formatted }}
    </h2>

    <!-- Show success/error messages -->
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Show internship info if available -->
    @if ($kontrak_magang)
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <h3 class="font-semibold text-blue-800">Informasi Magang</h3>
            <p class="text-blue-600">
                <strong>Perusahaan:</strong> {{ $kontrak_magang->lowonganMagang->perusahaan->nama }}<br>
                <strong>Periode:</strong>
                {{ Carbon::parse($kontrak_magang->waktu_awal)->format('d M Y') }} -
                {{ Carbon::parse($kontrak_magang->waktu_akhir)->format('d M Y') }}
            </p>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-5 mx-auto">
        <form wire:submit="save">
            <div class="space-y-6">

                <flux:field>
                    <flux:label>Hari, Tanggal</flux:label>
                    <flux:input wire:model.live="tanggal" type="date" class="bg-gray-50!"
                        min="{{ $kontrak_magang ? Carbon::parse($kontrak_magang->waktu_awal)->format('Y-m-d') : '' }}"
                        max="{{ $kontrak_magang ? Carbon::parse($kontrak_magang->waktu_akhir)->format('Y-m-d') : '' }}" />
                    <flux:error name="tanggal" />
                    @if ($day_name)
                        <p class="text-sm text-gray-600 mt-1">{{ $day_name }}</p>
                    @endif
                </flux:field>

                <flux:field>
                    <flux:label>Jam Masuk</flux:label>
                    <flux:input wire:model="jam_masuk" type="time" class="bg-gray-50!" />
                    <flux:error name="jam_masuk" />
                </flux:field>

                <flux:field>
                    <flux:label>Jam Pulang</flux:label>
                    <flux:input wire:model="jam_keluar" type="time" class="bg-gray-50!" />
                    <flux:error name="jam_keluar" />
                </flux:field>

                <flux:field>
                    <flux:label>Kegiatan</flux:label>
                    <flux:textarea wire:model="kegiatan" placeholder="Isi kegiatan anda hari ini (minimal 10 karakter)"
                        rows="4" class="bg-gray-50!"></flux:textarea>
                    <flux:error name="kegiatan" />
                    <p class="text-sm text-gray-500 mt-1">
                        {{ strlen($kegiatan) }}/1000 karakter
                    </p>
                </flux:field>

            </div>

            <div class="flex justify-between mt-8">
                <flux:button type="button" wire:click="cancel" variant="ghost" class="text-gray-600">
                    Batal
                </flux:button>

                <flux:button type="submit" class="bg-magnet-sky-teal! text-white!" :disabled="!$kontrak_magang">
                    Simpan Log Magang
                </flux:button>
            </div>
        </form>
    </div>
</div>
