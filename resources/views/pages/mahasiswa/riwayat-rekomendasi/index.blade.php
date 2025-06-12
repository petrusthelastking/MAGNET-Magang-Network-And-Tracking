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

    // Get the latest recommendation for each unique lowongan_magang_id per minute
    $latestRecommendations = FinalRankRecommendation::where('mahasiswa_id', $mahasiswaId)
        ->select([
            'id',
            'lowongan_magang_id',
            'mahasiswa_id',
            'avg_rank',
            'rank',
            'created_at',
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('TIME(created_at) as waktu_lengkap'),
            DB::raw('HOUR(created_at) as jam'),
            DB::raw('MINUTE(created_at) as menit'),
            DB::raw('CONCAT(LPAD(HOUR(created_at), 2, "0"), ":", LPAD(MINUTE(created_at), 2, "0")) as waktu_formatted'),
            DB::raw('CASE
                WHEN HOUR(created_at) >= 6 AND HOUR(created_at) < 12 THEN "Pagi"
                WHEN HOUR(created_at) >= 12 AND HOUR(created_at) < 17 THEN "Siang"
                WHEN HOUR(created_at) >= 17 AND HOUR(created_at) < 21 THEN "Sore"
                ELSE "Malam"
            END as periode'),
            // ROW_NUMBER partitioned by lowongan_magang_id AND minute to get latest per minute
            DB::raw('ROW_NUMBER() OVER (PARTITION BY lowongan_magang_id, DATE(created_at), HOUR(created_at), MINUTE(created_at) ORDER BY created_at DESC) as rn_minute'),
        ])
        ->with(['lowonganMagang.perusahaan.bidangIndustri', 'lowonganMagang.pekerjaan', 'ratioSystem', 'referencePoint', 'fullMultiplicativeForm'])
        ->havingRaw('rn_minute = 1') // Only get the latest record for each lowongan_magang_id per minute
        ->orderBy('created_at', 'desc')
        ->orderBy('rank', 'asc')
        ->get()
        ->groupBy(['tanggal', 'waktu_formatted']);

    return $latestRecommendations;
});

// Alternative approach using subquery for better performance
$riwayatAlternative = computed(function () {
    $mahasiswaId = auth('mahasiswa')->user()->id;

    // First, get the latest created_at for each lowongan_magang_id per minute
    $latestDates = FinalRankRecommendation::where('mahasiswa_id', $mahasiswaId)
        ->select(['lowongan_magang_id', DB::raw('DATE(created_at) as tanggal'), DB::raw('HOUR(created_at) as jam'), DB::raw('MINUTE(created_at) as menit'), DB::raw('MAX(created_at) as latest_date')])
        ->groupBy(['lowongan_magang_id', 'tanggal', 'jam', 'menit']);

    // Then get the full records for those latest dates
    return FinalRankRecommendation::where('mahasiswa_id', $mahasiswaId)
        ->joinSub($latestDates, 'latest', function ($join) {
            $join->on('final_rank_recommendation.lowongan_magang_id', '=', 'latest.lowongan_magang_id')->on('final_rank_recommendation.created_at', '=', 'latest.latest_date');
        })
        ->with(['lowonganMagang.perusahaan.bidangIndustri', 'lowonganMagang.pekerjaan', 'ratioSystem', 'referencePoint', 'fullMultiplicativeForm'])
        ->select([
            'final_rank_recommendation.id',
            'final_rank_recommendation.lowongan_magang_id',
            'final_rank_recommendation.mahasiswa_id',
            'final_rank_recommendation.avg_rank',
            'final_rank_recommendation.rank',
            'final_rank_recommendation.created_at',
            DB::raw('DATE(final_rank_recommendation.created_at) as tanggal'),
            DB::raw('TIME(final_rank_recommendation.created_at) as waktu_lengkap'),
            DB::raw('HOUR(final_rank_recommendation.created_at) as jam'),
            DB::raw('MINUTE(final_rank_recommendation.created_at) as menit'),
            DB::raw('CONCAT(LPAD(HOUR(final_rank_recommendation.created_at), 2, "0"), ":", LPAD(MINUTE(final_rank_recommendation.created_at), 2, "0")) as waktu_formatted'),
            DB::raw('CASE
                WHEN HOUR(final_rank_recommendation.created_at) >= 6 AND HOUR(final_rank_recommendation.created_at) < 12 THEN "Pagi"
                WHEN HOUR(final_rank_recommendation.created_at) >= 12 AND HOUR(final_rank_recommendation.created_at) < 17 THEN "Siang"
                WHEN HOUR(final_rank_recommendation.created_at) >= 17 AND HOUR(final_rank_recommendation.created_at) < 21 THEN "Sore"
                ELSE "Malam"
            END as periode'),
        ])
        ->orderBy('final_rank_recommendation.created_at', 'desc')
        ->orderBy('final_rank_recommendation.rank', 'asc')
        ->get()
        ->groupBy(['tanggal', 'waktu_formatted']);
});

$statistikRekomendasi = computed(function () {
    $mahasiswaId = auth('mahasiswa')->user()->id;

    // Updated statistics to reflect unique lowongan count per minute
    $latestDates = FinalRankRecommendation::where('mahasiswa_id', $mahasiswaId)
        ->select(['lowongan_magang_id', DB::raw('DATE(created_at) as tanggal'), DB::raw('HOUR(created_at) as jam'), DB::raw('MINUTE(created_at) as menit'), DB::raw('MAX(created_at) as latest_date')])
        ->groupBy(['lowongan_magang_id', 'tanggal', 'jam', 'menit']);

    $uniqueRecommendations = FinalRankRecommendation::where('mahasiswa_id', $mahasiswaId)->joinSub($latestDates, 'latest', function ($join) {
        $join->on('final_rank_recommendation.lowongan_magang_id', '=', 'latest.lowongan_magang_id')->on('final_rank_recommendation.created_at', '=', 'latest.latest_date');
    });

    return [
        'total_rekomendasi' => $uniqueRecommendations->count(),
        'rekomendasi_terbaik' => $uniqueRecommendations->min('final_rank_recommendation.rank'),
        'rata_rata_rank' => round($uniqueRecommendations->avg('final_rank_recommendation.avg_rank'), 1),
        'perusahaan_unik' => $uniqueRecommendations->join('lowongan_magang', 'final_rank_recommendation.lowongan_magang_id', '=', 'lowongan_magang.id')->distinct('lowongan_magang.perusahaan_id')->count('lowongan_magang.perusahaan_id'),
    ];
});

// Helper function for time period styling
function getTimePeriodStyle($periode)
{
    switch ($periode) {
        case 'Pagi':
            return [
                'bgColor' => 'bg-amber-50 border-amber-200',
                'textColor' => 'text-amber-700',
                'iconColor' => 'text-amber-600',
            ];
        case 'Siang':
            return [
                'bgColor' => 'bg-orange-50 border-orange-200',
                'textColor' => 'text-orange-700',
                'iconColor' => 'text-orange-600',
            ];
        case 'Sore':
            return [
                'bgColor' => 'bg-purple-50 border-purple-200',
                'textColor' => 'text-purple-700',
                'iconColor' => 'text-purple-600',
            ];
        default:
            // Malam
            return [
                'bgColor' => 'bg-blue-50 border-blue-200',
                'textColor' => 'text-blue-700',
                'iconColor' => 'text-blue-600',
            ];
    }
}

?>

<div class="font-sans">
    <x-slot:user>mahasiswa</x-slot:user>

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Riwayat Rekomendasi Magang</h1>
        <p class="text-gray-500 mt-1">Daftar riwayat rekomendasi magang terbaru untuk setiap lowongan yang dikelompokkan
            berdasarkan tanggal dan waktu (menit) dengan data terbaru per menit berdasarkan algoritma MULTIMOORA.</p>
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
                        {{ $this->statistikRekomendasi['rata_rata_rank'] }}</p>
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

    @if ($this->riwayatAlternative->count() > 0)
        <!-- History grouped by date -->
        <div class="space-y-8">
            @foreach ($this->riwayatAlternative as $tanggal => $itemsPerTanggal)
                @php
                    $carbonDate = Carbon::parse($tanggal);
                    $totalWaktuCount = $itemsPerTanggal->count();
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
                                    <p class="text-2xl font-bold">{{ $totalWaktuCount }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Time entries for this date -->
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach ($itemsPerTanggal as $waktu => $itemsAtTime)
                                @php
                                    $firstItem = $itemsAtTime->first();
                                    $periode = $firstItem->periode;
                                    $styles = getTimePeriodStyle($periode);
                                    $actualCount = $itemsAtTime->count();
                                @endphp

                                <a
                                    href="{{ route('mahasiswa.detail-rekomendasi', ['tanggal' => $tanggal, 'waktu' => $waktu]) }}">
                                    <div
                                        class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all duration-300">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="w-12 h-12 {{ $styles['bgColor'] }} rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 {{ $styles['iconColor'] }}" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-xl font-bold text-gray-800">{{ $waktu }}</p>
                                                    <p class="text-sm {{ $styles['textColor'] }} font-medium">
                                                        {{ $periode }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-lg font-bold text-gray-800">{{ $actualCount }}</p>
                                                <p class="text-sm text-gray-500">rekomendasi</p>
                                            </div>
                                        </div>
                                        <!-- Show lowongan details preview -->
                                        <div class="mt-3 pt-3 border-t border-gray-100">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-gray-600">
                                                @foreach ($itemsAtTime->take(3) as $item)
                                                    <div class="flex items-center gap-2">
                                                        <span
                                                            class="w-2 h-2 bg-{{ $item->rank <= 3 ? 'green' : 'blue' }}-400 rounded-full"></span>
                                                        <span class="truncate">
                                                            {{ $item->lowonganMagang->perusahaan->nama ?? 'N/A' }} -
                                                            {{ $item->lowonganMagang->pekerjaan->nama ?? 'N/A' }}
                                                            (Rank: {{ $item->rank }})
                                                        </span>
                                                    </div>
                                                @endforeach
                                                @if ($itemsAtTime->count() > 3)
                                                    <div class="text-gray-400 text-xs">
                                                        +{{ $itemsAtTime->count() - 3 }} rekomendasi lainnya
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
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
