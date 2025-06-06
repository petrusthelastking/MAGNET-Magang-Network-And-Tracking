<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Mahasiswa;
use App\Models\KontrakMagang;
use App\Models\DosenPembimbing;
use function Livewire\Volt\{layout, state, mount, computed};

state([
    'perPage' => 10,
    'search' => '',
]);

layout('components.layouts.user.main');

mount(function () {
    // Pastikan user adalah dosen
    if (!Auth::guard('dosen')->check()) {
        abort(403, 'Unauthorized access');
    }
});

$mahasiswaBimbingan = computed(function () {
    $dosenId = Auth::guard('dosen')->id();

    return Mahasiswa::with(['kontrakMagang.lowonganMagang.perusahaan', 'kontrakMagang.logMagang', 'kontrakMagang.umpanBalikMagang'])
        ->whereHas('kontrakMagang', function ($query) use ($dosenId) {
            $query->where('dosen_id', $dosenId);
        })
        ->where('status_magang', '!=', 'belum magang')
        ->orderBy('nama')
        ->get()
        ->map(function ($mahasiswa) {
            $kontrak = $mahasiswa->kontrakMagang->first();

            // Check if log exists in the last 7 days
            $hasRecentLog = $kontrak
                ->logMagang()
                ->where('created_at', '>=', now()->subDays(7))
                ->exists();

            // Check if feedback exists (has comment)
            $hasFeedback = $kontrak->umpanBalikMagang()->whereNotNull('komentar')->where('komentar', '!=', '')->exists();

            return [
                'id' => $mahasiswa->id,
                'nama' => $mahasiswa->nama,
                'nim' => $mahasiswa->nim,
                'email' => $mahasiswa->email,
                'status_magang' => $mahasiswa->status_magang,
                'kontrak_id' => $kontrak->id,
                'waktu_awal' => $kontrak->waktu_awal,
                'waktu_akhir' => $kontrak->waktu_akhir,
                'perusahaan_nama' => $kontrak->lowonganMagang->perusahaan->nama ?? '-',
                'posisi_nama' => $kontrak->lowonganMagang->nama ?? '-',
                'status_log' => $hasRecentLog ? 'Sudah dibaca' : 'Belum dibaca',
                'status_feedback' => $hasFeedback ? 'Sudah diberikan' : 'Belum diberikan',
            ];
        });
});

$totalMahasiswa = computed(function () {
    $dosenId = Auth::guard('dosen')->id();

    return KontrakMagang::where('dosen_id', $dosenId)->join('mahasiswa', 'kontrak_magang.mahasiswa_id', '=', 'mahasiswa.id')->where('mahasiswa.status_magang', '!=', 'belum magang')->count();
});

$mahasiswaSelesai = computed(function () {
    $dosenId = Auth::guard('dosen')->id();

    return KontrakMagang::where('dosen_id', $dosenId)->join('mahasiswa', 'kontrak_magang.mahasiswa_id', '=', 'mahasiswa.id')->where('mahasiswa.status_magang', 'selesai magang')->count();
});

$feedbackDiberikan = computed(function () {
    $dosenId = Auth::guard('dosen')->id();

    return KontrakMagang::where('dosen_id', $dosenId)
        ->whereHas('mahasiswa', function ($query) {
            $query->where('status_magang', '!=', 'belum magang');
        })
        ->whereExists(function ($query) {
            $query
                ->select(DB::raw(1))
                ->from('umpan_balik_magang')
                ->whereRaw('umpan_balik_magang.kontrak_magang_id = kontrak_magang.id')
                ->where('umpan_balik_magang.created_at', '>=', now()->subDays(30))
                ->whereNotNull('umpan_balik_magang.komentar')
                ->where('umpan_balik_magang.komentar', '!=', '');
        })
        ->count();
});
$statusProfil = computed(function () {
    $dosen = Auth::guard('dosen')->user();
    return $dosen && $dosen->nama && $dosen->nidn ? 'Lengkap' : 'Belum Lengkap';
});

$lihatDetail = function ($mahasiswaId) {
    return redirect()->route('dosen.detail-mahasiswa-bimbingan', ['id' => $mahasiswaId]);
};

?>

<div>
    <x-slot:user>dosen</x-slot:user>

    <flux:breadcrumbs class="mb-5">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" class="text-black">Dashboard</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex justify-center">
                <div class="grid grid-cols-1 gap-6 w-full max-w-7xl">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Mahasiswa Bimbingan Magang</p>
                                    <p class="text-xl font-semibold text-green-600 mt-2">{{ $this->totalMahasiswa }}
                                        Mahasiswa</p>
                                </div>
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-users text-green-600 text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Mahasiswa Selesai Magang</p>
                                    <p class="text-xl font-semibold text-blue-600 mt-2">{{ $this->mahasiswaSelesai }}
                                        Mahasiswa</p>
                                </div>
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-graduation-cap text-blue-600 text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Feedback Diberikan</p>
                                    <p class="text-xl font-semibold text-purple-600 mt-2">{{ $this->feedbackDiberikan }}
                                        Mahasiswa</p>
                                </div>
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-comment-dots text-purple-600 text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Status Profil</p>
                                    <p class="text-xl font-semibold text-yellow-600 mt-2">{{ $this->statusProfil }}</p>
                                </div>
                                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-user-cog text-yellow-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 mb-6">
        <!-- Judul -->
        <div class="mb-4">
            <h1 class="text-lg font-semibold text-gray-800">Daftar Mahasiswa Bimbingan</h1>
        </div>

        <!-- Form Pencarian -->
        <div class="flex gap-3 items-center w-full md:w-auto bg-white rounded-lg shadow-sm p-4">
            <input type="text" id="searchInput" placeholder="Cari mahasiswa..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200" />
            <button id="clearSearch"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200"
                style="display: none;">
                Reset
            </button>
        </div>
    </div>


    <!-- Search Results Info -->
    <div id="searchInfo" class="mb-4" style="display: none;">
        <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50">
            Hasil pencarian untuk: <strong id="searchTerm"></strong>
            (<span id="searchCount">0</span> data ditemukan)
        </div>
    </div>

    <!-- Loading State -->
    <div id="loading" class="text-center py-4" style="display: none;">
        <div class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm text-blue-500">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            Memuat data...
        </div>
    </div>

    <div class="overflow-x-auto flex flex-col items-center mt-0 rounded-lg shadow bg-white min-h-[250px]">
        <table class="table-fixed w-full min-w-[900px]">
            <thead class="bg-white text-black">
                <tr class="border-b">
                    <th class="text-center px-6 py-3 w-16">No</th>
                    <th class="text-left px-6 py-3 w-64">Nama Mahasiswa</th>
                    <th class="text-left px-6 py-3 w-32">NIM</th>
                    <th class="text-left px-6 py-3 w-40">Status Magang</th>
                    <th class="text-left px-6 py-3 w-36">Feedback</th>
                    <th class="text-left px-6 py-3 w-32">Aksi</th>
                </tr>
            </thead>
            <tbody id="mahasiswaTableBody" class="bg-white text-black">
                @foreach ($this->mahasiswaBimbingan as $index => $mahasiswa)
                    <tr class="mahasiswa-row border-b hover:bg-gray-50" data-nama="{{ strtolower($mahasiswa['nama']) }}"
                        data-nim="{{ strtolower($mahasiswa['nim']) }}"
                        data-email="{{ strtolower($mahasiswa['email']) }}" data-index="{{ $index }}">
                        <td class="px-6 py-4 text-center row-number">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 truncate" title="{{ $mahasiswa['nama'] }}">{{ $mahasiswa['nama'] }}</td>
                        <td class="px-6 py-4">{{ $mahasiswa['nim'] }}</td>
                        <td class="px-6 py-4">
                            <span
                                class="px-2 py-1 text-xs rounded-full whitespace-nowrap
                            @if ($mahasiswa['status_magang'] === 'sedang magang') bg-blue-100 text-blue-800
                            @elseif($mahasiswa['status_magang'] === 'selesai magang') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800 @endif">
                                {{ ucwords(str_replace('_', ' ', $mahasiswa['status_magang'])) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="px-2 py-1 text-xs rounded-full whitespace-nowrap
                            @if ($mahasiswa['status_feedback'] === 'Sudah diberikan') bg-green-100 text-green-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                                {{ $mahasiswa['status_feedback'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <button
                                onclick="window.location.href='{{ route('dosen.detail-mahasiswa-bimbingan', ['id' => $mahasiswa['id']]) }}'"
                                class="px-3 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600 whitespace-nowrap">
                                Lihat Detail
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- No Results State -->
    <div id="noResults" class="text-center py-12 bg-white rounded-lg shadow" style="display: none;">
        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada hasil yang ditemukan</h3>
        <p class="text-gray-500 mb-4">Coba gunakan kata kunci yang berbeda atau ubah filter pencarian.</p>
        <button id="clearSearchFromNoResults" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
            Hapus Filter
        </button>
    </div>

    <div class="flex items-center justify-between w-full p-3">
        <div class="text-black mt-6">
            <p id="paginationInfo">Menampilkan <span id="showingFrom">1</span> sampai <span
                    id="showingTo">{{ min(10, $this->mahasiswaBimbingan->count()) }}</span> dari <span
                    id="totalData">{{ $this->mahasiswaBimbingan->count() }}</span> data</p>
        </div>

        <div class="flex mt-6">
            <div id="pagination" class="flex items-center space-x-2">
                <!-- Pagination buttons will be generated by JS -->
            </div>
        </div>

        <div class="flex gap-3 items-center text-black mt-6">
            <p>Baris per halaman</p>
            <select id="perPageSelect" class="w-20 px-2 py-1 border border-gray-300 rounded">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all DOM elements
        const searchInput = document.getElementById('searchInput');
        const clearSearchBtn = document.getElementById('clearSearch');
        const clearSearchFromNoResults = document.getElementById('clearSearchFromNoResults');
        const searchInfo = document.getElementById('searchInfo');
        const searchTerm = document.getElementById('searchTerm');
        const searchCount = document.getElementById('searchCount');
        const mahasiswaTableBody = document.getElementById('mahasiswaTableBody');
        const noResults = document.getElementById('noResults');
        const loading = document.getElementById('loading');
        const perPageSelect = document.getElementById('perPageSelect');
        const paginationInfo = document.getElementById('paginationInfo');
        const showingFrom = document.getElementById('showingFrom');
        const showingTo = document.getElementById('showingTo');
        const totalData = document.getElementById('totalData');
        const pagination = document.getElementById('pagination');

        // State variables
        let allRows = [];
        let filteredRows = [];
        let currentPage = 1;
        let itemsPerPage = 10;

        // Initialize rows array
        function initializeRows() {
            allRows = Array.from(document.querySelectorAll('.mahasiswa-row'));
            filteredRows = [...allRows];
            totalData.textContent = allRows.length;
        }

        // Search functionality
        function performSearch(query) {
            const searchQuery = query.toLowerCase().trim();

            if (searchQuery === '') {
                filteredRows = [...allRows];
                searchInfo.style.display = 'none';
                clearSearchBtn.style.display = 'none';
            } else {
                filteredRows = allRows.filter(row => {
                    const nama = row.dataset.nama || '';
                    const nim = row.dataset.nim || '';
                    const email = row.dataset.email || '';

                    return nama.includes(searchQuery) ||
                        nim.includes(searchQuery) ||
                        email.includes(searchQuery);
                });

                searchTerm.textContent = query;
                searchCount.textContent = filteredRows.length;
                searchInfo.style.display = 'block';
                clearSearchBtn.style.display = 'block';
            }

            currentPage = 1;
            displayResults();
        }

        // Display results with pagination
        function displayResults() {
            // Show loading
            loading.style.display = 'block';
            mahasiswaTableBody.style.display = 'none';
            noResults.style.display = 'none';

            setTimeout(() => {
                // Hide all rows first
                allRows.forEach(row => {
                    row.style.display = 'none';
                });

                if (filteredRows.length === 0) {
                    mahasiswaTableBody.style.display = 'none';
                    noResults.style.display = 'block';
                    updatePaginationInfo(0, 0, 0);
                    pagination.innerHTML = '';
                } else {
                    // Calculate pagination
                    const startIndex = (currentPage - 1) * itemsPerPage;
                    const endIndex = startIndex + itemsPerPage;
                    const pageRows = filteredRows.slice(startIndex, endIndex);

                    // Show current page rows and update row numbers
                    pageRows.forEach((row, index) => {
                        row.style.display = '';
                        const rowNumber = row.querySelector('.row-number');
                        if (rowNumber) {
                            rowNumber.textContent = startIndex + index + 1;
                        }
                    });

                    mahasiswaTableBody.style.display = '';
                    noResults.style.display = 'none';

                    // Update pagination info
                    updatePaginationInfo(startIndex + 1, Math.min(endIndex, filteredRows.length),
                        filteredRows.length);

                    // Update pagination
                    updatePagination();
                }

                loading.style.display = 'none';
            }, 300);
        }

        // Update pagination info
        function updatePaginationInfo(from, to, total) {
            showingFrom.textContent = from;
            showingTo.textContent = to;
            totalData.textContent = total;
        }

        // Update pagination
        function updatePagination() {
            const totalPages = Math.ceil(filteredRows.length / itemsPerPage);

            if (totalPages <= 1) {
                pagination.innerHTML = '';
                return;
            }

            let paginationHTML = '';

            // Previous button
            if (currentPage > 1) {
                paginationHTML +=
                    `<button class="pagination-btn px-3 py-2 text-sm bg-gray-200 text-gray-700 rounded hover:bg-gray-300" data-page="${currentPage - 1}">←</button>`;
            }

            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                if (i === currentPage) {
                    paginationHTML +=
                        `<button class="pagination-btn px-3 py-2 text-sm bg-blue-500 text-white rounded" data-page="${i}">${i}</button>`;
                } else {
                    paginationHTML +=
                        `<button class="pagination-btn px-3 py-2 text-sm bg-gray-200 text-gray-700 rounded hover:bg-gray-300" data-page="${i}">${i}</button>`;
                }
            }

            // Next button
            if (currentPage < totalPages) {
                paginationHTML +=
                    `<button class="pagination-btn px-3 py-2 text-sm bg-gray-200 text-gray-700 rounded hover:bg-gray-300" data-page="${currentPage + 1}">→</button>`;
            }

            pagination.innerHTML = paginationHTML;

            // Add event listeners to pagination buttons
            document.querySelectorAll('.pagination-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    currentPage = parseInt(this.dataset.page);
                    displayResults();
                });
            });
        }

        // Event listeners
        searchInput.addEventListener('input', function() {
            performSearch(this.value);
        });

        clearSearchBtn.addEventListener('click', function() {
            searchInput.value = '';
            performSearch('');
        });

        clearSearchFromNoResults.addEventListener('click', function() {
            searchInput.value = '';
            performSearch('');
        });

        perPageSelect.addEventListener('change', function() {
            itemsPerPage = parseInt(this.value);
            currentPage = 1;
            displayResults();
        });

        // Initialize
        initializeRows();
        displayResults();
    });
</script>
</div>
