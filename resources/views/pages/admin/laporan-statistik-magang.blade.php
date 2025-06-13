<?php

use function Livewire\Volt\{state, computed, mount, layout};
use App\Models\Mahasiswa;
use App\Models\KontrakMagang;
use App\Models\Perusahaan;
use App\Models\BidangIndustri;
use App\Models\DosenPembimbing;

layout('components.layouts.user.main');

// State variables - fokus pada fitur wajib
state([
    'totalMahasiswa' => 0,
    'mahasiswaSudahMagang' => 0,
    'totalPerusahaan' => 0,
    'totalDosenPembimbing' => 0,
    'trendBidangIndustri' => [],
    'rasioDosenData' => [],
]);

// Mount function untuk load data
mount(function () {
    $this->loadStatistikUtama();
    $this->loadTrendBidangIndustri();
    $this->loadRasioDosenPembimbing();
});

// Load statistik utama
$loadStatistikUtama = function () {
    $this->totalMahasiswa = Mahasiswa::count();
    $this->mahasiswaSudahMagang = KontrakMagang::distinct('mahasiswa_id')->count('mahasiswa_id');
    $this->totalPerusahaan = Perusahaan::count();
    $this->totalDosenPembimbing = DosenPembimbing::count();
};

// Load tren peminatan mahasiswa terhadap bidang industri
$loadTrendBidangIndustri = function () {
    $this->trendBidangIndustri = BidangIndustri::select('bidang_industri.nama')
        ->leftJoin('perusahaan', 'bidang_industri.id', '=', 'perusahaan.bidang_industri_id')
        ->leftJoin('lowongan_magang', 'perusahaan.id', '=', 'lowongan_magang.perusahaan_id')
        ->leftJoin('kontrak_magang', 'lowongan_magang.id', '=', 'kontrak_magang.lowongan_magang_id')
        ->groupBy('bidang_industri.id', 'bidang_industri.nama')
        ->selectRaw('bidang_industri.nama, COUNT(DISTINCT kontrak_magang.mahasiswa_id) as jumlah_mahasiswa')
        ->get()
        ->map(function ($item) {
            return [
                'nama' => $item->nama,
                'jumlah_mahasiswa' => (int) $item->jumlah_mahasiswa,
            ];
        })
        ->sortByDesc('jumlah_mahasiswa')
        ->values()
        ->toArray();
};

// Load data rasio dosen pembimbing terhadap peserta magang
$loadRasioDosenPembimbing = function () {
    $this->rasioDosenData = DosenPembimbing::select('dosen_pembimbing.nama', 'dosen_pembimbing.nidn')
        ->withCount(['kontrakMagang as jumlah_bimbingan'])
        ->get()
        ->map(function ($dosen) {
            return [
                'nama' => $dosen->nama,
                'nidn' => $dosen->nidn,
                'jumlah_bimbingan' => $dosen->jumlah_bimbingan,
                'rasio' => $dosen->jumlah_bimbingan > 0 ? "1:{$dosen->jumlah_bimbingan}" : "1:0",
            ];
        })
        ->sortByDesc('jumlah_bimbingan')
        ->values()
        ->toArray();
};

// Computed properties
$persentaseMahasiswaMagang = computed(function () {
    return $this->totalMahasiswa > 0
        ? round(($this->mahasiswaSudahMagang / $this->totalMahasiswa) * 100, 1)
        : 0;
});

$rataRataRasioDosenMahasiswa = computed(function () {
    return $this->totalDosenPembimbing > 0 && $this->mahasiswaSudahMagang > 0
        ? round($this->mahasiswaSudahMagang / $this->totalDosenPembimbing)
        : 0;
});

$pertumbuhanMahasiswaMagang = computed(function () {
    // Bisa dihitung berdasarkan periode sebelumnya jika ada data historis
    // Untuk saat ini menggunakan persentase yang sudah magang
    return $this->persentaseMahasiswaMagang;
});

?>

<div class="flex flex-col gap-5">
    <x-slot:user>admin</x-slot:user>
    <flux:breadcrumbs class="mb-5">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('admin.laporan-statistik-magang') }}" class="text-black">
            Laporan statistik magang
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div>
        <div class="max-w-7xl mx-auto">
            <div
                class="flex justify-start items-center py-4 bg-white shadow-sm border-b border-gray-200 px-4 rounded-md">
                <h1 class="text-2xl font-bold text-gray-900">Monitoring dan analisis data magang mahasiswa</h1>
            </div>
        </div>
    </div>

    <!-- Summary Cards - Fitur Wajib -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Mahasiswa -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Mahasiswa</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalMahasiswa) }}</p>
                    <p class="text-sm text-gray-500 mt-1">Terdaftar di sistem</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Mahasiswa Sudah Magang -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Sudah Mendapat Magang</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ number_format($mahasiswaSudahMagang) }}
                    </p>
                    <p class="text-sm text-green-600 mt-1">{{ $this->persentaseMahasiswaMagang }}% dari total
                        mahasiswa</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Dosen Pembimbing -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Dosen Pembimbing</p>
                    <p class="text-3xl font-bold text-orange-600 mt-2">
                        {{ number_format($totalDosenPembimbing) }}
                    </p>
                    <p class="text-sm text-gray-500 mt-1">Pembimbing aktif</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chalkboard-teacher text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Rasio Dosen : Mahasiswa -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Rasio Pembimbingan</p>
                    <p class="text-3xl font-bold text-purple-600 mt-2">
                        1:{{ $this->rataRataRasioDosenMahasiswa }}</p>
                    <p class="text-sm text-gray-500 mt-1">Dosen : Mahasiswa</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-balance-scale text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section - Fitur Wajib -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Tren Peminatan Bidang Industri -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Tren Peminatan Bidang Industri</h3>
                <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <span class="inline-flex items-center">
                        <span class="w-3 h-3 bg-cyan-500 rounded-full mr-2"></span>
                        Jumlah Mahasiswa
                    </span>
                </div>
            </div>
            <div class="h-64">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        <!-- Rasio Dosen Pembimbing -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Rasio Dosen Pembimbing</h3>
            </div>
            <div class="p-6 max-h-80 overflow-y-auto">
                <div class="grid grid-cols-1 gap-3">
                    @forelse($rasioDosenData as $dosen)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <div>
                                <div class="font-medium text-gray-900 text-sm">{{ $dosen['nama'] }}</div>
                                <div class="text-xs text-gray-600">NIDN: {{ $dosen['nidn'] }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold text-blue-600">{{ $dosen['rasio'] }}</div>
                                <div class="text-xs text-gray-600">{{ $dosen['jumlah_bimbingan'] }} mahasiswa</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center p-4 text-gray-500">
                            Data rasio dosen tidak tersedia
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Statistics Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Detail Statistik Bidang Industri</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Bidang Industri
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jumlah Mahasiswa
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Persentase
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Popularitas
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($trendBidangIndustri as $index => $bidang)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $bidang['nama'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ number_format($bidang['jumlah_mahasiswa']) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $mahasiswaSudahMagang > 0 ? round(($bidang['jumlah_mahasiswa'] / $mahasiswaSudahMagang) * 100, 1) : 0 }}%
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($index === 0)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Tertinggi
                                    </span>
                                @elseif($index < 3)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Populer
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Normal
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                Data bidang industri tidak tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <script>
        // Trend Chart untuk Peminatan Bidang Industri
        const trendCtx = document.getElementById('trendChart').getContext('2d');

        // Data dari Livewire
        const trendData = @json($trendBidangIndustri);
        const labels = trendData.length > 0 ? trendData.map(item => item.nama) : ['Belum ada data'];
        const data = trendData.length > 0 ? trendData.map(item => item.jumlah_mahasiswa) : [0];

        new Chart(trendCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Mahasiswa',
                    data: data,
                    backgroundColor: '#0891b2',
                    borderColor: '#0891b2',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Distribusi Mahasiswa per Bidang Industri'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6'
                        },
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        grid: {
                            color: '#f3f4f6'
                        }
                    }
                }
            }
        });
    </script>

</div>
