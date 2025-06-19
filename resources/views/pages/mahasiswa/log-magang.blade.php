<?php

use App\Models\LogMagang;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

use function Livewire\Volt\{layout, state, mount, rules, computed};

layout('components.layouts.user.main');

state([
    'logMagang' => null,
    'logId' => null,
    'isEditing' => false,
    'canEdit' => false,
    'editData' => [
        'tanggal' => null,
        'jam_masuk' => null,
        'jam_keluar' => null,
        'kegiatan' => null,
    ],
    'showSuccessMessage' => false,
    'errors' => [],
]);

rules([
    'editData.tanggal' => 'required|date',
    'editData.jam_masuk' => 'required|date_format:H:i',
    'editData.jam_keluar' => 'required|date_format:H:i|after:editData.jam_masuk',
    'editData.kegiatan' => 'required|string|min:10|max:1000',
]);

mount(function () {
    $this->logId = Request::route('id') ?? request('id');

    if (!$this->logId) {
        return redirect()->route('mahasiswa.detail-log');
    }

    try {
        $this->logMagang = LogMagang::with(['kontrakMagang.mahasiswa', 'kontrakMagang.lowonganMagang.perusahaan'])->findOrFail($this->logId);

        // Check if student can edit (status must be "sedang magang")
        $this->canEdit = $this->logMagang->kontrakMagang?->status === 'sedang magang';

        // Initialize edit data
        $this->resetEditData();
    } catch (\Exception $e) {
        session()->flash('error', 'Log magang tidak ditemukan.');
        return redirect()->route('mahasiswa.detail-log');
    }
});

$resetEditData = function () {
    $this->editData = [
        'tanggal' => $this->logMagang->tanggal?->format('Y-m-d'),
        'jam_masuk' => $this->logMagang->jam_masuk?->format('H:i'),
        'jam_keluar' => $this->logMagang->jam_keluar?->format('H:i'),
        'kegiatan' => $this->logMagang->kegiatan,
    ];
};

$startEdit = function () {
    if (!$this->canEdit) {
        session()->flash('error', 'Tidak dapat mengedit log. Status magang harus "sedang magang".');
        return;
    }

    $this->isEditing = true;
    $this->resetEditData();
    $this->showSuccessMessage = false;
    $this->resetValidation();
};

$cancelEdit = function () {
    $this->isEditing = false;
    $this->resetEditData();
    $this->resetValidation();
};

$saveEdit = function () {
    if (!$this->canEdit) {
        session()->flash('error', 'Tidak dapat menyimpan perubahan. Status magang harus "sedang magang".');
        return;
    }

    $this->validate();

    try {
        $this->logMagang->update([
            'tanggal' => $this->editData['tanggal'],
            'jam_masuk' => $this->editData['jam_masuk'],
            'jam_keluar' => $this->editData['jam_keluar'],
            'kegiatan' => $this->editData['kegiatan'],
        ]);

        // Refresh the model to get updated data
        $this->logMagang->refresh();

        $this->isEditing = false;
        $this->showSuccessMessage = true;

        // Auto-hide success message after 3 seconds
        $this->dispatch('hide-success-message');
    } catch (\Exception $e) {
        session()->flash('error', 'Terjadi kesalahan saat menyimpan data.');
    }
};

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

$formatJam = function ($jam) {
    if (!$jam) {
        return '-';
    }

    try {
        return Carbon::parse($jam)->format('H:i');
    } catch (\Exception $e) {
        return $jam;
    }
};

$calculateDuration = computed(function () {
    if (!$this->logMagang?->jam_masuk || !$this->logMagang?->jam_keluar) {
        return null;
    }

    try {
        $masuk = Carbon::parse($this->logMagang->jam_masuk);
        $keluar = Carbon::parse($this->logMagang->jam_keluar);
        $duration = $masuk->diff($keluar);

        return $duration->format('%h jam %i menit');
    } catch (\Exception $e) {
        return null;
    }
});

?>

<div class="min-h-screen bg-gray-50 py-6 rounded-lg shadow-md">
    <x-slot:user>mahasiswa</x-slot:user>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Success Message -->
        @if ($showSuccessMessage)
            <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-2" x-init="setTimeout(() => show = false, 3000)"
                @hide-success-message.window="show = false"
                class="mb-6 bg-green-50 border border-green-200 rounded-2xl p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <flux:icon.check-circle class="h-5 w-5 text-green-400" />
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            Data log magang berhasil diperbarui!
                        </p>
                    </div>
                    <div class="ml-auto pl-3">
                        <button @click="show = false"
                            class="text-green-400 hover:text-green-600 rounded-full p-1 hover:bg-green-100">
                            <flux:icon.x-mark class="h-4 w-4" />
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @if ($logMagang)
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Detail Log Magang</h1>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ $this->formatTanggal($logMagang->tanggal) }}
                        </p>
                    </div>

                    @if (!$isEditing)
                        <div class="flex space-x-3">
                            @if ($canEdit)
                                <flux:button wire:click="startEdit" variant="primary" icon="pencil-square"
                                    class="rounded-full">
                                    Edit Log
                                </flux:button>
                            @else
                                <flux:button disabled variant="outline" icon="lock-closed" class="rounded-full">
                                    Edit Tidak Tersedia
                                </flux:button>
                            @endif
                            <flux:button onclick="history.back()" variant="outline" icon="arrow-left"
                                class="rounded-full">
                                Kembali
                            </flux:button>
                        </div>
                    @else
                        <div class="flex space-x-3">
                            <flux:button wire:click="saveEdit" variant="primary" icon="check" class="rounded-full">
                                Simpan
                            </flux:button>
                            <flux:button wire:click="cancelEdit" variant="outline" icon="x-mark" class="rounded-full">
                                Batal
                            </flux:button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Edit Restriction Notice -->
            @if (!$canEdit && !$isEditing)
                <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-2xl p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <flux:icon.exclamation-triangle class="h-5 w-5 text-yellow-400" />
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-yellow-800">
                                Log tidak dapat diedit karena status magang:
                                {{ $logMagang->kontrakMagang?->mahasiswa?->status_magang ?? 'Tidak diketahui' }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Time Information Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <flux:icon.clock class="h-5 w-5 mr-2 text-blue-600" />
                                Waktu Kehadiran
                            </h3>
                        </div>

                        <div class="p-6">
                            @if (!$isEditing)
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                                    <div class="text-center p-4 bg-green-50 rounded-2xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="h-8 w-8 mx-auto mb-2 text-green-600">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                        </svg>
                                        <p class="text-sm font-medium text-gray-600">Jam Masuk</p>
                                        <p class="text-xl font-bold text-green-700">
                                            {{ $this->formatJam($logMagang->jam_masuk) }}
                                        </p>
                                    </div>

                                    <div class="text-center p-4 bg-red-50 rounded-2xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="h-8 w-8 mx-auto mb-2 text-green-600">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                                        </svg>
                                        <p class="text-sm font-medium text-gray-600">Jam Keluar</p>
                                        <p class="text-xl font-bold text-red-700">
                                            {{ $this->formatJam($logMagang->jam_keluar) }}
                                        </p>
                                    </div>

                                    @if ($this->calculateDuration)
                                        <div class="text-center p-4 bg-blue-50 rounded-2xl">
                                            <flux:icon.clock class="h-8 w-8 mx-auto mb-2 text-blue-600" />
                                            <p class="text-sm font-medium text-gray-600">Total Durasi</p>
                                            <p class="text-xl font-bold text-blue-700">
                                                {{ $this->calculateDuration }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="space-y-4">
                                    <flux:field>
                                        <flux:label>Tanggal</flux:label>
                                        <flux:input wire:model="editData.tanggal" type="date" class="rounded-xl" />
                                        <flux:error name="editData.tanggal" />
                                    </flux:field>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <flux:field>
                                            <flux:label>Jam Masuk</flux:label>
                                            <flux:input wire:model="editData.jam_masuk" type="time"
                                                class="rounded-xl" />
                                            <flux:error name="editData.jam_masuk" />
                                        </flux:field>

                                        <flux:field>
                                            <flux:label>Jam Keluar</flux:label>
                                            <flux:input wire:model="editData.jam_keluar" type="time"
                                                class="rounded-xl" />
                                            <flux:error name="editData.jam_keluar" />
                                        </flux:field>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Activities Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-pink-50 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <flux:icon.document-text class="h-5 w-5 mr-2 text-purple-600" />
                                Kegiatan yang Dilakukan
                            </h3>
                        </div>

                        <div class="p-6">
                            @if (!$isEditing)
                                <div class="prose max-w-none">
                                    <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">
                                        {{ $logMagang->kegiatan ?: 'Tidak ada kegiatan yang dicatat.' }}</p>
                                </div>
                            @else
                                <flux:field>
                                    <flux:label>Deskripsi Kegiatan</flux:label>
                                    <flux:textarea wire:model="editData.kegiatan" rows="8"
                                        placeholder="Tuliskan kegiatan yang dilakukan selama magang..."
                                        class="resize-none rounded-xl" />
                                    <flux:description>Minimal 10 karakter, maksimal 1000 karakter</flux:description>
                                    <flux:error name="editData.kegiatan" />
                                </flux:field>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">

                    <!-- Company Information -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-amber-50 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <flux:icon.building-office class="h-5 w-5 mr-2 text-orange-600" />
                                Informasi Magang
                            </h3>
                        </div>

                        <div class="p-6 space-y-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Perusahaan</label>
                                <p class="mt-1 text-sm font-semibold text-gray-900">
                                    {{ $logMagang->kontrakMagang->lowonganMagang->perusahaan->nama ?? '-' }}
                                </p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-500">Posisi</label>
                                <p class="mt-1 text-sm font-semibold text-gray-900">
                                    {{ $logMagang->kontrakMagang->lowonganMagang->pekerjaan->nama ?? '-' }}
                                </p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-500">Mahasiswa</label>
                                <p class="mt-1 text-sm font-semibold text-gray-900">
                                    {{ $logMagang->kontrakMagang->mahasiswa->nama ?? '-' }}
                                </p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-500">Status Magang</label>
                                <p
                                    class="mt-1 text-sm font-semibold {{ $canEdit ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $logMagang->kontrakMagang?->status ?? 'Tidak diketahui' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-teal-50 to-cyan-50 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <flux:icon.chart-bar class="h-5 w-5 mr-2 text-teal-600" />
                                Statistik
                            </h3>
                        </div>

                        <div class="p-6">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-teal-600">
                                    {{ $this->calculateDuration ?: '0 jam 0 menit' }}
                                </div>
                                <div class="text-sm text-gray-500">Total jam hari ini</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Error State -->
            <div class="text-center py-12">
                <flux:icon.exclamation-triangle class="mx-auto h-12 w-12 text-gray-400" />
                <h3 class="mt-2 text-sm font-medium text-gray-900">Log tidak ditemukan</h3>
                <p class="mt-1 text-sm text-gray-500">Log magang yang Anda cari tidak dapat ditemukan.</p>
                <div class="mt-6">
                    <flux:button wire:click="goBack" variant="primary" class="rounded-full">
                        Kembali ke Daftar Log
                    </flux:button>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('hide-success-message', () => {
            setTimeout(() => {
                @this.set('showSuccessMessage', false);
            }, 3000);
        });
    });
</script>
