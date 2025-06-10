<?php

use function Livewire\Volt\{computed, layout};
use Illuminate\Support\Facades\DB;
use App\Models\FinalRankRecommendation;
use App\Models\LowonganMagang;
use App\Models\Perusahaan;
use App\Models\Pekerjaan;
use App\Models\BidangIndustri;
use Carbon\Carbon;

layout('components.layouts.user.main');

$riwayat = computed(function () {
    $mahasiswaId = auth('mahasiswa')->user()->id;

    return FinalRankRecommendation::where('mahasiswa_id', $mahasiswaId)
        ->with(['lowonganMagang.perusahaan.bidangIndustri', 'lowonganMagang.pekerjaan', 'ratioSystem', 'referencePoint', 'fullMultiplicativeForm'])
        ->select('id', 'lowongan_magang_id', 'mahasiswa_id', 'avg_rank', 'rank', 'created_at', DB::raw('DATE(created_at) as tanggal'), DB::raw('HOUR(created_at) as jam'), DB::raw('MINUTE(created_at) as menit'))
        ->orderBy('created_at', 'desc')
        ->orderBy('rank', 'asc')
        ->get()
        ->groupBy('tanggal');
});

$statistikRekomendasi = computed(function () {
    $mahasiswaId = auth('mahasiswa')->user()->id;

    return [
        'total_rekomendasi' => FinalRankRecommendation::where('mahasiswa_id', $mahasiswaId)->count(),
        'rekomendasi_terbaik' => FinalRankRecommendation::where('mahasiswa_id', $mahasiswaId)->min('rank'),
        'rata_rata_rank' => FinalRankRecommendation::where('mahasiswa_id', $mahasiswaId)->avg('avg_rank'),
        'perusahaan_unik' => FinalRankRecommendation::where('mahasiswa_id', $mahasiswaId)->join('lowongan_magang', 'final_rank_recommendation.lowongan_magang_id', '=', 'lowongan_magang.id')->distinct('lowongan_magang.perusahaan_id')->count(),
    ];
});

?>

<div class="font-sans">
    <x-slot:user>mahasiswa</x-slot:user>

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Riwayat Rekomendasi Magang</h1>
        <p class="text-gray-500 mt-1">Daftar riwayat rekomendasi magang yang dikelompokkan berdasarkan tanggal dengan
            waktu spesifik berdasarkan algoritma MULTIMOORA.</p>
    </div>

    <!-- Statistics Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $this->statistikRekomendasi['total_rekomendasi'] }}
                    </p>
                    <p class="text-sm text-gray-500">Total Rekomendasi</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ $this->statistikRekomendasi['rekomendasi_terbaik'] ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-500">Ranking Terbaik</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ number_format($this->statistikRekomendasi['rata_rata_rank'], 1) }}</p>
                    <p class="text-sm text-gray-500">Rata-rata Skor</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $this->statistikRekomendasi['perusahaan_unik'] }}</p>
                    <p class="text-sm text-gray-500">Perusahaan Unik</p>
                </div>
            </div>
        </div>
    </div>

    @if ($this->riwayat->count() > 0)
        <!-- History grouped by date only -->
        <div class="space-y-8">
            @foreach ($this->riwayat as $tanggal => $itemsPerTanggal)
                @php
                    $carbonDate = Carbon::parse($tanggal);
                    // Group items by distinct time (hour:minute)
                    $itemsByTime = $itemsPerTanggal->groupBy(function ($item) {
                        return str_pad($item->jam, 2, '0', STR_PAD_LEFT) .
                            ':' .
                            str_pad($item->menit, 2, '0', STR_PAD_LEFT);
                    });
                @endphp

                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <!-- Date Header -->
                    <div class="bg-gradient-to-r from-magnet-sky-teal to-teal-600 p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-2xl font-bold">
                                    {{ $carbonDate->locale('id')->isoFormat('dddd') }}
                                </h2>
                                <p class="text-teal-100 text-lg">
                                    {{ $carbonDate->locale('id')->isoFormat('D MMMM YYYY') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <div class="bg-white/20 rounded-lg px-4 py-2">
                                    <p class="text-sm text-teal-100">Total Waktu</p>
                                    <p class="text-2xl font-bold">{{ $itemsByTime->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Time entries for this date -->
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach ($itemsByTime as $waktu => $itemsAtTime)
                                @php
                                    $firstItem = $itemsAtTime->first();
                                    $carbonTime = Carbon::parse($firstItem->created_at);
                                    $hour = $carbonTime->hour;

                                    // Determine time period
                                    if ($hour >= 6 && $hour < 12) {
                                        $periode = 'Pagi';
                                        $bgColor = 'bg-amber-50 border-amber-200';
                                        $textColor = 'text-amber-700';
                                        $iconColor = 'text-amber-600';
                                    } elseif ($hour >= 12 && $hour < 17) {
                                        $periode = 'Siang';
                                        $bgColor = 'bg-orange-50 border-orange-200';
                                        $textColor = 'text-orange-700';
                                        $iconColor = 'text-orange-600';
                                    } elseif ($hour >= 17 && $hour < 21) {
                                        $periode = 'Sore';
                                        $bgColor = 'bg-purple-50 border-purple-200';
                                        $textColor = 'text-purple-700';
                                        $iconColor = 'text-purple-600';
                                    } else {
                                        $periode = 'Malam';
                                        $bgColor = 'bg-blue-50 border-blue-200';
                                        $textColor = 'text-blue-700';
                                        $iconColor = 'text-blue-600';
                                    }
                                @endphp

                                <a
                                    href="{{ route('mahasiswa.detail-rekomendasi', ['tanggal' => $tanggal, 'waktu' => $waktu]) }}">

                                    <div
                                        class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all duration-300">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="w-12 h-12 {{ $bgColor }} rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 {{ $iconColor }}" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-xl font-bold text-gray-800">{{ $waktu }}</p>
                                                    <p class="text-sm {{ $textColor }} font-medium">
                                                        {{ $periode }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-lg font-bold text-gray-800">{{ $itemsAtTime->count() }}
                                                </p>
                                                <p class="text-sm text-gray-500">rekomendasi</p>
                                            </div>
                                        </div>
                                    </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="mt-10 p-8 bg-white border border-gray-200 rounded-xl shadow-sm text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Rekomendasi</h3>
            <p class="text-gray-500 text-sm mb-4">
                Belum ada rekomendasi magang yang tersedia untuk ditampilkan. Mulai pencarian untuk mendapatkan
                rekomendasi berbasis algoritma MULTIMOORA.
            </p>
        </div>
    @endif
</div>
