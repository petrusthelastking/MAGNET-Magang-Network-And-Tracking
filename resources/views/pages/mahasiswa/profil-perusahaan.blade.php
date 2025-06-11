<?php
use function Livewire\Volt\{layout, state, mount, computed};
use App\Models\Perusahaan;
use App\Models\BidangIndustri;
use App\Models\UlasanMagang;
use App\Models\KontrakMagang;
use App\Models\LowonganMagang;

layout('components.layouts.user.main');

state([
    'perusahaan' => null,
    'lowonganId' => null,
    'perusahaanId' => null,
    'lowonganMagang' => null,
    'totalUlasan' => 0,
    'rataRating' => 0,
    'statusMitra' => '',
    'website' => '',
    'isLoading' => true,
    'error' => null,
]);

mount(function ($id = null) {
    try {
        $this->lowonganId = $id ?? (request()->route('id') ?? request()->get('id'));

        if (!$this->lowonganId) {
            $this->error = 'ID lowongan tidak ditemukan';
            $this->isLoading = false;
            return;
        }

        $this->loadPerusahaanFromLowongan();
    } catch (\Exception $e) {
        $this->error = 'Terjadi kesalahan saat memuat data';
        $this->isLoading = false;
    }
});

$loadPerusahaanFromLowongan = function () {
    try {
        $this->isLoading = true;

        if (!$this->lowonganId) {
            $this->error = 'ID lowongan tidak valid';
            $this->isLoading = false;
            return;
        }

        $this->lowonganMagang = LowonganMagang::with(['perusahaan.bidangIndustri', 'pekerjaan', 'lokasi_magang'])->find($this->lowonganId);

        if (!$this->lowonganMagang) {
            $this->error = 'Lowongan tidak ditemukan';
            $this->isLoading = false;
            return;
        }

        $this->perusahaan = $this->lowonganMagang->perusahaan;

        if (!$this->perusahaan) {
            $this->error = 'Data perusahaan tidak ditemukan';
            $this->isLoading = false;
            return;
        }

        $this->perusahaanId = $this->perusahaan->id;
        $this->calculateRatingStats();
        $this->statusMitra = $this->perusahaan->kategori === 'mitra' ? 'Mitra Resmi' : 'Perusahaan Umum';
        $this->website = $this->generateWebsiteUrl();
        $this->isLoading = false;
    } catch (\Exception $e) {
        $this->error = 'Gagal memuat data perusahaan';
        $this->isLoading = false;
    }
};

$calculateRatingStats = function () {
    try {
        $ulasanData = UlasanMagang::whereHas('kontrakMagang.lowonganMagang', function ($query) {
            $query->where('perusahaan_id', $this->perusahaanId);
        })->get();

        $this->totalUlasan = $ulasanData->count();

        if ($this->totalUlasan > 0) {
            $this->rataRating = round($ulasanData->avg('rating'), 1);
            $this->perusahaan->update(['rating' => $this->rataRating]);
        } else {
            $this->rataRating = 0;
        }
    } catch (\Exception $e) {
        $this->totalUlasan = 0;
        $this->rataRating = 0;
    }
};

$generateWebsiteUrl = function () {
    try {
        if ($this->perusahaan && isset($this->perusahaan->website) && $this->perusahaan->website) {
            return $this->perusahaan->website;
        }

        $companyName = strtolower(str_replace(' ', '', $this->perusahaan->nama));
        return "www.{$companyName}.co.id";
    } catch (\Exception $e) {
        return 'www.example.co.id';
    }
};

$logoUrl = computed(function () {
    try {
        if ($this->perusahaan && $this->perusahaan->logo) {
            return asset('storage/logos/' . $this->perusahaan->logo);
        }
        return asset('images/default-company-logo.png');
    } catch (\Exception $e) {
        return asset('images/default-company-logo.png');
    }
});

$deskripsiPerusahaan = computed(function () {
    try {
        if (!$this->perusahaan) {
            return '';
        }

        if (isset($this->perusahaan->deskripsi) && $this->perusahaan->deskripsi) {
            return $this->perusahaan->deskripsi;
        }

        $bidangIndustri = $this->perusahaan->bidangIndustri ? $this->perusahaan->bidangIndustri->nama : 'berbagai bidang';

        return "Perusahaan {$this->perusahaan->nama} merupakan perusahaan yang bergerak di bidang {$bidangIndustri} yang berlokasi di {$this->perusahaan->lokasi}. " . 'Sebagai perusahaan ' . ($this->perusahaan->kategori === 'mitra' ? 'mitra resmi' : 'non-mitra') . ', ' . 'kami berkomitmen untuk memberikan pengalaman magang terbaik bagi mahasiswa dan mengembangkan kemampuan serta keahlian di bidang teknologi informasi.';
    } catch (\Exception $e) {
        return 'Deskripsi perusahaan sedang dalam pembaruan.';
    }
});

$reloadData = function () {
    $this->loadPerusahaanFromLowongan();
};

$lowonganLainnya = computed(function () {
    try {
        if (!$this->perusahaan) {
            return collect();
        }

        return $this->perusahaan
            ->lowonganMagang()
            ->with(['pekerjaan', 'lokasiMagang'])
            ->where('status', 'buka')
            ->where('id', '!=', $this->lowonganId)
            ->take(3)
            ->get();
    } catch (\Exception $e) {
        return collect();
    }
});
?>

<div class="min-h-screen bg-gray-50">
    <x-slot:user>mahasiswa</x-slot:user>

    <div class="max-w-6xl mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Profil Perusahaan</h1>
            <p class="text-gray-600">Informasi lengkap tentang perusahaan dan lowongan magang</p>
        </div>

        @if ($isLoading)
            <!-- Enhanced Loading State -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <div class="animate-pulse">
                        <div class="flex items-start gap-6">
                            <div class="w-20 h-20 bg-gray-200 rounded-xl flex-shrink-0"></div>
                            <div class="flex-1 space-y-4">
                                <div class="h-8 bg-gray-200 rounded-lg w-3/4"></div>
                                <div class="space-y-2">
                                    <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                                    <div class="h-4 bg-gray-200 rounded w-2/3"></div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
                            <div class="h-16 bg-gray-200 rounded-xl"></div>
                            <div class="h-16 bg-gray-200 rounded-xl"></div>
                            <div class="h-16 bg-gray-200 rounded-xl"></div>
                        </div>
                    </div>
                </div>
                <div class="text-center py-8">
                    <div class="inline-flex items-center gap-2 text-blue-600">
                        <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4" fill="none"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span class="font-medium">Memuat data perusahaan...</span>
                    </div>
                </div>
            </div>
        @elseif ($error)
            <!-- Enhanced Error State -->
            <div class="bg-white rounded-2xl shadow-sm border border-red-200 p-8">
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                        <flux:icon.exclamation-triangle class="h-8 w-8 text-red-500" />
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Data Tidak Ditemukan</h3>
                    <p class="text-gray-600 mb-6">{{ $error }}</p>
                    <button wire:click="reloadData"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <flux:icon.arrow-path class="h-4 w-4" />
                        Coba Lagi
                    </button>
                </div>
            </div>
        @elseif ($perusahaan)
            <div class="space-y-6">

                <!-- Main Company Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Company Header -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-8">
                        <div class="flex items-start gap-6">
                            <div class="relative">
                                <img src="{{ $this->logoUrl ?: asset('img/user/unknown.jpeg') }}"
                                    alt="Logo {{ $perusahaan->nama }}"
                                    class="w-20 h-20 object-contain rounded-xl border-2 border-white shadow-sm bg-white">
                                <div
                                    class="absolute -bottom-2 -right-2 w-6 h-6 bg-green-500 rounded-full border-2 border-white">
                                </div>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $perusahaan->nama }}</h2>
                                <div class="space-y-2">
                                    <div class="flex items-center text-gray-600">
                                        <flux:icon.map-pin class="mr-2 h-4 w-4" />
                                        <span>{{ $perusahaan->lokasi }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <flux:icon.building class="mr-2 h-4 w-4" />
                                        <span>{{ $perusahaan->bidangIndustri ? $perusahaan->bidangIndustri->nama : 'Tidak tersedia' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Company Stats -->
                    <div class="p-6 border-b border-gray-100">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Status -->
                            <div class="text-center">
                                <div
                                    class="w-12 h-12 mx-auto mb-3 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <flux:icon.handshake class="h-6 w-6 text-blue-600" />
                                </div>
                                <h4 class="font-semibold text-gray-900">{{ $statusMitra }}</h4>
                                <p class="text-sm text-gray-500 mt-1">Status Kemitraan</p>
                            </div>

                            <!-- Rating -->
                            <div class="text-center">
                                <div
                                    class="w-12 h-12 mx-auto mb-3 bg-yellow-100 rounded-xl flex items-center justify-center">
                                    <flux:icon.star class="h-6 w-6 text-yellow-600" />
                                </div>
                                <h4 class="font-semibold text-gray-900">
                                    @if ($totalUlasan > 0)
                                        {{ $rataRating }}/5
                                    @else
                                        Belum ada
                                    @endif
                                </h4>
                                <p class="text-sm text-gray-500 mt-1">
                                    @if ($totalUlasan > 0)
                                        {{ $totalUlasan }} ulasan
                                    @else
                                        Penilaian
                                    @endif
                                </p>
                            </div>

                            <!-- Website -->
                            <div class="text-center">
                                <div
                                    class="w-12 h-12 mx-auto mb-3 bg-green-100 rounded-xl flex items-center justify-center">
                                    <flux:icon.globe class="h-6 w-6 text-green-600" />
                                </div>
                                <a href="http://{{ $website }}" target="_blank"
                                    class="font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                                    {{ $website }}
                                </a>
                                <p class="text-sm text-gray-500 mt-1">Website Resmi</p>
                            </div>
                        </div>
                    </div>

                    <!-- Company Description -->
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Tentang Kami</h3>
                        <div class="prose prose-gray max-w-none">
                            <p class="text-gray-700 leading-relaxed">
                                {{ $this->deskripsiPerusahaan }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Other Job Openings -->
                @if ($this->lowonganLainnya->count() > 0)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-semibold text-gray-900">Lowongan Magang Lainnya</h3>
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                {{ $this->lowonganLainnya->count() }} tersedia
                            </span>
                        </div>

                        <div class="grid gap-4">
                            @foreach ($this->lowonganLainnya as $lowongan)
                                <div
                                    class="border border-gray-200 rounded-xl p-5 hover:border-blue-300 hover:bg-blue-50/50 transition-all duration-200 group">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900 group-hover:text-blue-900 mb-2">
                                                {{ $lowongan->nama }}
                                            </h4>
                                            <p class="text-gray-600 mb-3">
                                                {{ $lowongan->pekerjaan ? $lowongan->pekerjaan->nama : 'Posisi tidak tersedia' }}
                                            </p>

                                            <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                                                <span class="flex items-center gap-1">
                                                    <flux:icon.users class="h-4 w-4" />
                                                    {{ $lowongan->kuota ?? 0 }} posisi
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <flux:icon.map-pin class="h-4 w-4" />
                                                    {{ $lowongan->lokasiMagang ? $lowongan->lokasiMagang->lokasi : 'Lokasi fleksibel' }}
                                                </span>
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                    {{ ($lowongan->jenis_magang ?? '') === 'berbayar' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                    {{ ucfirst(str_replace('_', ' ', $lowongan->jenis_magang ?? 'tidak berbayar')) }}
                                                </span>
                                            </div>
                                        </div>
                                        <a href="{{ url('/profil-perusahaan?id=' . $lowongan->id) }}"
                                            class="ml-4 inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                            Lihat Detail
                                            <flux:icon.arrow-right class="h-4 w-4" />
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @php
                            $totalLowonganAktif = $perusahaan->lowonganMagang()->where('status', 'buka')->count();
                        @endphp
                        @if ($totalLowonganAktif > 3)
                            <div class="text-center mt-6 pt-6 border-t border-gray-200">
                                <button
                                    class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-medium">
                                    <span>Lihat Semua Lowongan ({{ $totalLowonganAktif }})</span>
                                    <flux:icon.arrow-right class="h-4 w-4" />
                                </button>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        @else
            <!-- Enhanced Fallback State -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                        <flux:icon.building class="h-8 w-8 text-gray-400" />
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Data Perusahaan Tidak Tersedia</h3>
                    <p class="text-gray-600 mb-6">Silakan coba lagi atau hubungi administrator jika masalah berlanjut.
                    </p>
                    <button wire:click="reloadData"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <flux:icon.arrow-path class="h-4 w-4" />
                        Muat Ulang
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
