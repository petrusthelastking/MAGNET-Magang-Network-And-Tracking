<?php

use function Livewire\Volt\{layout, state, computed, mount, with, uses};
use App\Models\LowonganMagang;
use App\Models\UlasanMagang;
use App\Models\Mahasiswa;

layout('components.layouts.user.main');

state([
    'lowonganId' => null,
    'isSaved' => false,
    'isLoading' => false,
]);

mount(function ($id = null) {
    try {
        $this->lowonganId = $id ?? (request()->route('id') ?? request()->get('id'));
    } catch (\Exception $e) {
        session()->flash('error', 'Terjadi kesalahan saat memuat halaman.');
    }
});

$lowongan = computed(function () {
    try {
        if (!$this->lowonganId) {
            return null;
        }
        return LowonganMagang::with(['perusahaan.bidangIndustri', 'pekerjaan', 'lokasi_magang'])->find($this->lowonganId);
    } catch (\Exception $e) {
        return null;
    }
});

$ulasanMagang = computed(function () {
    try {
        if (!$this->lowonganId) {
            return collect();
        }

        return UlasanMagang::with(['kontrakMagang.mahasiswa'])
            ->whereHas('kontrakMagang', function ($query) {
                $query->where('lowongan_magang_id', $this->lowonganId);
            })
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
    } catch (\Exception $e) {
        return collect();
    }
});

$lowonganSerupa = computed(function () {
    try {
        $currentLowongan = $this->lowongan;
        if (!$currentLowongan) {
            return collect();
        }

        return LowonganMagang::with(['perusahaan', 'pekerjaan'])
            ->where('id', '!=', $this->lowonganId)
            ->where('pekerjaan_id', $currentLowongan->pekerjaan_id)
            ->where('status', 'buka')
            ->limit(4)
            ->get();
    } catch (\Exception $e) {
        return collect();
    }
});

$saveJob = function () {
    $this->isLoading = true;

    try {
        if (!auth()->check()) {
            session()->flash('error', 'Silakan login terlebih dahulu.');
            return;
        }

        if (!$this->lowonganId) {
            session()->flash('error', 'Lowongan tidak valid.');
            return;
        }

        // Implement save job logic here
        $this->isSaved = !$this->isSaved;
        session()->flash('success', $this->isSaved ? 'Lowongan berhasil disimpan!' : 'Lowongan dihapus dari simpanan!');
    } catch (\Exception $e) {
        session()->flash('error', 'Terjadi kesalahan saat menyimpan lowongan.');
    } finally {
        $this->isLoading = false;
    }
};

$formatCurrency = function ($amount) {
    try {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    } catch (\Exception $e) {
        return 'Rp 0';
    }
};

$getJobTypeLabel = function ($type) {
    return $type === 'berbayar' ? 'Dibayar' : 'Tidak dibayar';
};

$getRemoteLabel = function ($remote) {
    return $remote === 'ya' ? 'Remote tersedia' : 'On-site';
};

?>

<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50/20">
    <x-slot:user>mahasiswa</x-slot:user>

    <div class="max-w-6xl mx-auto px-4 py-8 space-y-8">
        @if ($this->lowongan)
            <!-- Header with Breadcrumb -->
            <div class="flex items-center gap-2 text-sm text-gray-600 mb-6">
                <button onclick="history.back()" class="hover:text-blue-600 transition-colors cursor-pointer">
                    Kembali
                </button>
                <flux:icon.chevron-right class="size-4 text-gray-400" />
                <span
                    class="text-gray-800 font-medium">{{ Str::limit($this->lowongan->nama ?? 'Detail Lowongan', 40) }}</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Job Header Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-start gap-4">
                                @php
                                    $logoUrl = $this->lowongan->perusahaan->logo
                                        ? asset('storage/' . $this->lowongan->perusahaan->logo)
                                        : asset('img/company-default.png');
                                @endphp

                                <div class="flex-shrink-0">
                                    <img src="{{ $logoUrl }}"
                                        alt="Logo {{ $this->lowongan->perusahaan->nama ?? 'Perusahaan' }}"
                                        class="w-20 h-20 object-contain rounded-xl border border-gray-100 bg-white p-2">
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h1 class="text-2xl font-bold text-gray-900 mb-3">
                                        {{ $this->lowongan->nama ?? 'Nama lowongan tidak tersedia' }}
                                    </h1>

                                    <div class="space-y-2">
                                        <div class="flex items-center text-gray-600 gap-2">
                                            <flux:icon.building-2 class="size-5 text-gray-400" />
                                            <span
                                                class="font-medium">{{ $this->lowongan->perusahaan->nama ?? 'Nama perusahaan tidak tersedia' }}</span>
                                        </div>

                                        @if (isset($this->lowongan->lokasi_magang->lokasi))
                                            <div class="flex items-center text-gray-600 gap-2">
                                                <flux:icon.map-pin class="size-5 text-gray-400" />
                                                <span>{{ $this->lowongan->lokasi_magang->lokasi }}</span>
                                            </div>
                                        @endif

                                        <div class="flex flex-wrap gap-3 mt-4">
                                            <div
                                                class="flex items-center bg-green-50 text-green-700 px-3 py-1 rounded-full text-sm font-medium gap-2">
                                                <flux:icon.banknote class="size-4" />
                                                {{ $this->getJobTypeLabel($this->lowongan->jenis_magang ?? '') }}
                                            </div>

                                            @if (isset($this->lowongan->kuota))
                                                <div
                                                    class="flex items-center bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-sm font-medium gap-2">
                                                    <flux:icon.users class="size-4" />
                                                    {{ $this->lowongan->kuota }} kuota
                                                </div>
                                            @endif

                                            @if (($this->lowongan->open_remote ?? '') === 'ya')
                                                <div
                                                    class="flex items-center bg-purple-50 text-purple-700 px-3 py-1 rounded-full text-sm font-medium gap-2">
                                                    <flux:icon.wifi class="size-4" />
                                                    Remote tersedia
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    @if (isset($this->lowongan->perusahaan->id))
                                        <div class="mt-4">
                                            <flux:link
                                                href="{{ route('mahasiswa.profil-perusahaan', $this->lowongan->perusahaan->id) }}"
                                                class="inline-flex items-center text-sm text-blue-600 hover:text-blue-700 font-medium transition-colors">
                                                Lihat profil perusahaan
                                                <flux:icon.arrow-top-right-on-square class="ml-1 size-4" />
                                            </flux:link>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Job Description -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <flux:icon.document-text class="size-6 text-blue-600" />
                                Deskripsi Magang
                            </h2>
                            <div class="prose prose-gray max-w-none">
                                <div class="text-gray-700 leading-relaxed whitespace-pre-line">
                                    {{ $this->lowongan->deskripsi ?? 'Deskripsi tidak tersedia' }}
                                </div>
                            </div>

                            @if ($this->lowongan->persyaratan)
                                <div class="mt-8 pt-6 border-t border-gray-100">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                        <flux:icon.clipboard-document-check class="size-5 text-green-600" />
                                        Persyaratan
                                    </h3>
                                    <div class="text-gray-700 leading-relaxed whitespace-pre-line">
                                        {{ $this->lowongan->persyaratan }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Reviews Section -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                                <flux:icon.star class="size-6 text-yellow-500" />
                                Ulasan Magang
                            </h2>

                            @if ($this->ulasanMagang->count() > 0)
                                <div class="space-y-4">
                                    @foreach ($this->ulasanMagang as $ulasan)
                                        @php
                                            $fotoUrl = $ulasan->kontrakMagang->mahasiswa->foto
                                                ? asset('storage/' . $ulasan->kontrakMagang->mahasiswa->foto)
                                                : 'https://unavatar.io/' .
                                                    urlencode($ulasan->kontrakMagang->mahasiswa->nama ?? 'Unknown');
                                        @endphp

                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <div class="flex gap-4">
                                                <img src="{{ $fotoUrl }}"
                                                    class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm"
                                                    alt="Foto {{ $ulasan->kontrakMagang->mahasiswa->nama ?? 'Unknown' }}">

                                                <div class="flex-1">
                                                    <div class="flex items-center justify-between mb-2">
                                                        <h4 class="font-semibold text-gray-900">
                                                            {{ $ulasan->kontrakMagang->mahasiswa->nama ?? 'Nama tidak tersedia' }}
                                                        </h4>
                                                        <div class="flex items-center gap-1">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <flux:icon.star
                                                                    class="size-4 {{ $i <= ($ulasan->rating ?? 0) ? 'text-yellow-400' : 'text-gray-300' }}" />
                                                            @endfor
                                                            <span class="text-sm text-gray-600 ml-1 font-medium">
                                                                {{ $ulasan->rating ?? 0 }}/5
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <p class="text-gray-700 mb-2 leading-relaxed">
                                                        {{ $ulasan->komentar ?? 'Tidak ada komentar' }}
                                                    </p>

                                                    <span class="text-xs text-gray-500">
                                                        {{ $ulasan->created_at ? $ulasan->created_at->format('d F Y') : 'Tanggal tidak tersedia' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <div
                                        class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                        <flux:icon.chat-bubble-oval-left-ellipsis class="size-8 text-gray-400" />
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada ulasan</h3>
                                    <p class="text-gray-500">Jadilah yang pertama memberikan ulasan untuk magang ini</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Action Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 sticky top-6">
                        <div class="p-6">
                            <div class="space-y-4">
                                <flux:button wire:click="saveJob" :disabled="$isLoading" variant="ghost"
                                    class="w-full justify-center border-2 border-dashed border-gray-300 hover:border-blue-400 hover:bg-blue-50 text-gray-700 hover:text-blue-700 transition-all duration-200"
                                    icon="{{ $isSaved ? 'bookmark-check' : 'bookmark-plus' }}">
                                    {{ $isSaved ? 'Tersimpan' : 'Simpan Lowongan' }}
                                </flux:button>

                                <flux:button variant="primary"
                                    class="w-full justify-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3"
                                    icon="paper-airplane">
                                    Lamar Sekarang
                                </flux:button>
                            </div>

                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <h3 class="font-semibold text-gray-900 mb-3">Informasi Tambahan</h3>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Status:</span>
                                        <span class="font-medium text-green-600 capitalize">
                                            {{ $this->lowongan->status ?? 'Tidak diketahui' }}
                                        </span>
                                    </div>
                                    @if ($this->lowongan->tanggal_mulai)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Mulai:</span>
                                            <span class="font-medium">
                                                {{ \Carbon\Carbon::parse($this->lowongan->tanggal_mulai)->format('d M Y') }}
                                            </span>
                                        </div>
                                    @endif
                                    @if ($this->lowongan->tanggal_selesai)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Selesai:</span>
                                            <span class="font-medium">
                                                {{ \Carbon\Carbon::parse($this->lowongan->tanggal_selesai)->format('d M Y') }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Similar Jobs -->
                    @if ($this->lowonganSerupa->count() > 0)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <flux:icon.squares-2x2 class="size-5 text-blue-600" />
                                    Lowongan Serupa
                                </h3>
                                <div class="space-y-3">
                                    @foreach ($this->lowonganSerupa as $item)
                                        @php
                                            $itemLogoUrl = $item->perusahaan->logo
                                                ? asset('storage/' . $item->perusahaan->logo)
                                                : asset('img/company-default.png');
                                        @endphp

                                        {{-- <a href="{{ route('mahasiswa.lowongan.detail', $item->id) }}"
                                            class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors group"> --}}
                                        <img src="{{ $itemLogoUrl }}"
                                            alt="Logo {{ $item->perusahaan->nama ?? 'Perusahaan' }}"
                                            class="w-12 h-12 object-contain rounded-lg border border-gray-100 bg-white p-1">

                                        <div class="flex-1 min-w-0">
                                            <h4
                                                class="font-medium text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-1">
                                                {{ $item->nama ?? 'Nama lowongan tidak tersedia' }}
                                            </h4>
                                            <p class="text-sm text-gray-600 line-clamp-1">
                                                {{ $item->perusahaan->nama ?? 'Nama perusahaan tidak tersedia' }}
                                            </p>
                                            <div class="flex items-center justify-between mt-1">
                                                <span class="text-xs text-gray-500">
                                                    {{ $item->perusahaan->lokasi ?? 'Lokasi tidak tersedia' }}
                                                </span>
                                                @if ($item->perusahaan->rating)
                                                    <div class="flex items-center gap-1 text-xs">
                                                        <flux:icon.star class="size-3 text-yellow-400" />
                                                        <span
                                                            class="text-gray-600">{{ number_format($item->perusahaan->rating, 1) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <!-- Not Found State -->
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="text-center py-16 px-6">
                        <div class="bg-red-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                            <flux:icon.exclamation-triangle class="size-10 text-red-600" />
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-3">Lowongan Tidak Ditemukan</h1>
                        <p class="text-gray-600 mb-8 leading-relaxed">
                            Maaf, lowongan yang Anda cari tidak tersedia atau mungkin telah dihapus.
                            Silakan kembali ke halaman utama untuk melihat lowongan lainnya.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 justify-center">
                            <flux:button variant="primary" href="{{ route('mahasiswa.lowongan') }}"
                                icon="arrow-left">
                                Kembali ke Lowongan
                            </flux:button>
                            <flux:button variant="ghost" onclick="history.back()" icon="arrow-uturn-left">
                                Halaman Sebelumnya
                            </flux:button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Toast Notifications -->
    <div x-data="{ show: false, message: '', type: 'success' }"
        x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => show = false, 5000)"
        x-show="show" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-2" class="fixed bottom-6 right-6 z-50 max-w-sm">
        <div :class="type === 'success' ? 'bg-green-500' : 'bg-red-500'"
            class="text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3">
            <flux:icon.check-circle x-show="type === 'success'" class="size-5 flex-shrink-0" />
            <flux:icon.exclamation-circle x-show="type === 'error'" class="size-5 flex-shrink-0" />
            <span x-text="message" class="text-sm font-medium"></span>
        </div>
    </div>

    @if (session()->has('success'))
        <script>
            window.dispatchEvent(new CustomEvent('notify', {
                detail: {
                    message: '{{ session('success') }}',
                    type: 'success'
                }
            }));
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            window.dispatchEvent(new CustomEvent('notify', {
                detail: {
                    message: '{{ session('error') }}',
                    type: 'error'
                }
            }));
        </script>
    @endif
</div>
