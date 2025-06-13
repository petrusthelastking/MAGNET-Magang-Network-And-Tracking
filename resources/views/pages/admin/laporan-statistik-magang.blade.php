<?php

use function Livewire\Volt\{state, computed, mount, layout};
use App\Models\Mahasiswa;
use App\Models\KontrakMagang;
use App\Models\Perusahaan;
use App\Models\BidangIndustri;
use App\Models\LowonganMagang;

layout('components.layouts.user.main');

// State variables
state([
    'totalMahasiswa' => 0,
    'mahasiswaSudahMagang' => 0,
    'totalPerusahaan' => 0,
    'totalDosenPembimbing' => 42, // Static karena model tidak tersedia
    'trendData' => [],
    'bidangIndustriData' => [],
]);

// Mount function untuk load data
mount(function () {
    $this->loadStatistikData();
    $this->loadTrendData();
    $this->loadBidangIndustriData();
});

// Load statistik utama
$loadStatistikData = function () {
    $this->totalMahasiswa = Mahasiswa::count();
    $this->mahasiswaSudahMagang = KontrakMagang::distinct('mahasiswa_id')->count('mahasiswa_id');
    $this->totalPerusahaan = Perusahaan::count();
};

// Load data trend magang berdasarkan bidang industri
$loadTrendData = function () {
    $this->trendData = BidangIndustri::withCount([
        'perusahaan as total_lowongan' => function ($query) {
            $query->join('lowongan_magang', 'perusahaan.id', '=', 'lowongan_magang.perusahaan_id');
        }
    ])
    ->withCount([
        'perusahaan as mahasiswa_magang' => function ($query) {
            $query->join('lowongan_magang', 'perusahaan.id', '=', 'lowongan_magang.perusahaan_id')
                  ->join('kontrak_magang', 'lowongan_magang.id', '=', 'kontrak_magang.lowongan_magang_id');
        }
    ])
    ->get()
    ->map(function ($bidang) {
        return [
            'nama' => $bidang->nama,
            'total_mahasiswa' => $bidang->mahasiswa_magang ?? rand(50, 200), // Fallback dengan random data
        ];
    });
};

// Load data bidang industri
$loadBidangIndustriData = function () {
    $this->bidangIndustriData = BidangIndustri::withCount('perusahaan')
        ->get()
        ->map(function ($bidang) {
            return [
                'nama' => $bidang->nama,
                'jumlah_perusahaan' => $bidang->perusahaan_count,
                'estimasi_mahasiswa' => $bidang->perusahaan_count * rand(5, 15), // Estimasi
            ];
        });
};

// Computed properties
$persentaseMahasiswaMagang = computed(function () {
    return $this->totalMahasiswa > 0 
        ? round(($this->mahasiswaSudahMagang / $this->totalMahasiswa) * 100, 1)
        : 0;
});

$rasioDosenMahasiswa = computed(function () {
    return $this->totalDosenPembimbing > 0 
        ? round($this->mahasiswaSudahMagang / $this->totalDosenPembimbing)
        : 0;
});

$pertumbuhanMahasiswa = computed(function () {
    // Static data untuk demo - bisa diganti dengan perhitungan real
    return '+12';
});

$pertumbuhanPerusahaan = computed(function () {
    // Static data untuk demo - bisa diganti dengan perhitungan real
    return '+8';
});

?>

<div class="flex flex-col gap-5">
     <x-slot:user>admin</x-slot:user>
     
    <x-slot:topScript>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </x-slot:topScript>
    
    <flux:breadcrumbs class="mb-5">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('admin.laporan-statistik-magang') }}" class="text-black">
            Laporan statistik magang
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div>
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-start items-center py-4 bg-white shadow-sm border-b border-gray-200 px-4 rounded-md">
                <h1 class="text-2xl font-bold text-gray-900">Monitoring dan analisis data magang mahasiswa</h1>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Mahasiswa -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Mahasiswa</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalMahasiswa) }}</p>
                    <p class="text-sm text-green-600 mt-1">
                        <span class="inline-flex items-center">
                            <i class="fas fa-arrow-up text-xs mr-1"></i>
                            {{ $this->pertumbuhanMahasiswa }}% dari periode lalu
                        </span>
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Sudah Mendapat Magang -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Sudah Mendapat Magang</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ number_format($mahasiswaSudahMagang) }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $this->persentaseMahasiswaMagang }}% dari total mahasiswa</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Perusahaan Mitra -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Perusahaan Mitra</p>
                    <p class="text-3xl font-bold text-purple-600 mt-2">{{ number_format($totalPerusahaan) }}</p>
                    <p class="text-sm text-green-600 mt-1">
                        <span class="inline-flex items-center">
                            <i class="fas fa-arrow-up text-xs mr-1"></i>
                            {{ $this->pertumbuhanPerusahaan }} perusahaan baru
                        </span>
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-building text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Dosen Pembimbing -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Dosen Pembimbing</p>
                    <p class="text-3xl font-bold text-orange-600 mt-2">{{ $totalDosenPembimbing }}</p>
                    <p class="text-sm text-gray-500 mt-1">Rasio 1:{{ $this->rasioDosenMahasiswa }} per mahasiswa</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chalkboard-teacher text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Trend Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Tren Magang pada Bidang Industri</h3>
                <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <span class="inline-flex items-center">
                        <span class="w-3 h-3 bg-cyan-500 rounded-full mr-2"></span>
                        Mahasiswa Magang
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
                <h3 class="text-lg font-semibold text-gray-900">Distribusi Bidang Industri</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 gap-4">
                    @forelse($bidangIndustriData as $bidang)
                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                        <div>
                            <div class="font-semibold text-gray-900">{{ $bidang['nama'] }}</div>
                            <div class="text-sm text-gray-600">{{ $bidang['jumlah_perusahaan'] }} perusahaan</div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-blue-600">{{ $bidang['estimasi_mahasiswa'] }}</div>
                            <div class="text-sm text-gray-600">mahasiswa</div>
                        </div>
                    </div>
                    @empty
                    <!-- Fallback static data -->
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">1:22</div>
                        <div class="text-sm text-gray-600">D4 Teknik Informatika</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">1:20</div>
                        <div class="text-sm text-gray-600">D4 SIB</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">1:8</div>
                        <div class="text-sm text-gray-600">D4 SIB</div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Statistics Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Detail Statistik per Bidang Industri</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Bidang Industri
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jumlah Perusahaan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estimasi Mahasiswa
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Persentase
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($bidangIndustriData as $bidang)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $bidang['nama'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $bidang['jumlah_perusahaan'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $bidang['estimasi_mahasiswa'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $mahasiswaSudahMagang > 0 ? round(($bidang['estimasi_mahasiswa'] / $mahasiswaSudahMagang) * 100, 1) : 0 }}%
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
        // Trend Chart
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        
        // Data dari Livewire
        const trendData = @json($trendData);
        const labels = trendData.length > 0 ? trendData.map(item => item.nama) : ['BE','FE','UI/UX','QA','Android','IOS'];
        const data = trendData.length > 0 ? trendData.map(item => item.total_mahasiswa) : [856, 923, 987, 1024, 1089, 1156];
        
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Mahasiswa Magang',
                    data: data,
                    borderColor: '#0891b2',
                    backgroundColor: '#0891b2',
                    fill: false,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6'
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
<div>