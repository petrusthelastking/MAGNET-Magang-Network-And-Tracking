<?php
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use function Livewire\Volt\{layout, state, mount, computed};

state([
    'perPage' => 20,
]);

layout('components.layouts.user.main');

$mahasiswa = computed(function () {
    $dosenId = Auth::guard('dosen')->id();

    return Mahasiswa::query()
        ->select(['mahasiswa.*', 'perusahaan.nama as perusahaan_nama', 'lowongan_magang.nama as posisi_nama', 'kontrak_magang.id as kontrak_id', 'kontrak_magang.waktu_awal', 'kontrak_magang.waktu_akhir'])
        ->join('kontrak_magang', 'mahasiswa.id', '=', 'kontrak_magang.mahasiswa_id')
        ->join('lowongan_magang', 'kontrak_magang.lowongan_magang_id', '=', 'lowongan_magang.id')
        ->join('perusahaan', 'lowongan_magang.perusahaan_id', '=', 'perusahaan.id')
        ->where('kontrak_magang.dosen_id', $dosenId)
        ->where('mahasiswa.status_magang', '!=', 'belum magang') // Tambahkan kondisi ini untuk konsistensi
        ->orderBy('mahasiswa.nama', 'asc')
        ->get();
});

?>
<div>
    <x-slot:user>dosen</x-slot:user>

    <div class="bg-magnet-frost-mist min-h-screen flex flex-col gap-5 p-4">
        <flux:breadcrumbs class="mb-5">
            <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
            <flux:breadcrumbs.item href="{{ route('dosen.mahasiswa-bimbingan') }}" class="text-black">Mahasiswa Bimbingan
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <h2 class="text-lg font-semibold text-black">Mahasiswa Bimbingan Aktif</h2>
        <p class="text-black">Kelola dan pantau perkembangan mahasiswa yang sedang magang</p>

        <div class="w-full bg-white p-6 rounded-lg shadow-md">
            <!-- Debug Panel (can be hidden in production) -->
            <div id="debugPanel" class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg"
                style="display: none;">
                <h4 class="font-semibold text-yellow-800 mb-2">Debug Information</h4>
                <div id="debugInfo" class="text-sm text-yellow-700"></div>
            </div>

            <!-- Toggle Debug Button - HIDDEN AND DISABLED -->
            <div class="mb-4" style="display: none;">
                <button id="toggleDebug" class="px-3 py-1 bg-yellow-500 text-white rounded text-sm" disabled>
                    Show Debug Info
                </button>
            </div>

            <!-- Dynamic Search Form -->
            <div class="flex gap-3 mb-6">
                <flux:input id="searchInput" class="rounded-3xl!" placeholder="Cari Nama, NIM, Perusahaan, atau Posisi"
                    icon="magnifying-glass" />

                <flux:button id="clearSearch" variant="outline" class="px-4 rounded-full!" style="display: none;">
                    Reset
                </flux:button>
            </div>

            <!-- Search Results Info -->
            <div id="searchInfo" class="mb-4" style="display: none;">
                <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50">
                    Hasil pencarian untuk: <strong id="searchTerm"></strong>
                    (<span id="searchCount">0</span> data ditemukan)
                </div>
            </div>

            <!-- Sorting Controls -->
            <div class="flex items-center gap-2 mb-6 p-4 bg-gray-50 rounded-lg">
                <span class="text-sm font-medium text-gray-700 mr-2">Urutkan berdasarkan:</span>

                <button data-sort="nama" class="sort-btn text-xs px-3 py-1 bg-blue-500 text-white rounded">
                    Nama
                    <span class="sort-icon ml-1">↑</span>
                </button>

                <button data-sort="nim" class="sort-btn text-xs px-3 py-1 bg-gray-200 text-gray-700 rounded">
                    NIM
                    <span class="sort-icon ml-1"></span>
                </button>

                <button data-sort="perusahaan" class="sort-btn text-xs px-3 py-1 bg-gray-200 text-gray-700 rounded">
                    Perusahaan
                    <span class="sort-icon ml-1"></span>
                </button>

                <div class="ml-auto text-xs text-gray-500">
                    <span id="totalCount">{{ $this->mahasiswa->count() }}</span> mahasiswa aktif
                </div>
            </div>

            <!-- Loading State -->
            <div id="loading" class="text-center py-4" style="display: none;">
                <div class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm text-blue-500">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Memuat data...
                </div>
            </div>

            <!-- Mahasiswa Cards -->
            <div id="mahasiswaContainer">
                @if ($this->mahasiswa->count() > 0)
                    <div id="mahasiswaGrid"
                        class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-6">
                        @foreach ($this->mahasiswa as $mhs)
                            <div class="mahasiswa-card bg-white card py-4 hover:shadow-lg transition-shadow border rounded-lg"
                                data-nama="{{ strtolower($mhs->nama) }}" data-nim="{{ strtolower($mhs->nim) }}"
                                data-perusahaan="{{ strtolower($mhs->perusahaan_nama ?? '') }}"
                                data-posisi="{{ strtolower($mhs->posisi_nama ?? '') }}"
                                data-original-order="{{ $loop->index }}">
                                <a href="{{ route('dosen.detail-mahasiswa-bimbingan', $mhs->id) }}">
                                    <div class="p-4">
                                        <img src="{{ $mhs->foto_profil ? asset('storage/' . $mhs->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode($mhs->nama) . '&background=e5e7eb&color=374151' }}"
                                            class="rounded-full w-32 h-32 object-cover mx-auto"
                                            alt="Foto {{ $mhs->nama }}" />
                                    </div>
                                    <div class="px-4">
                                        <p
                                            class="text-base leading-6 font-bold text-black text-center mb-2 student-nama">
                                            {{ $mhs->nama }}
                                        </p>
                                        <p class="text-sm text-gray-600 text-center mb-1 student-nim">
                                            NIM: {{ $mhs->nim }}
                                        </p>
                                        <!-- Status Badge -->
                                        <div class="flex items-center justify-center mb-2">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <span class="w-2 h-2 bg-green-400 rounded-full mr-1.5"></span>
                                                Sedang Magang
                                            </span>
                                        </div>
                                        <div class="flex items-center justify-center mb-2">
                                            <flux:button icon="user-round" variant="ghost"
                                                class="text-gray-500! text-sm student-posisi">
                                                {{ $mhs->posisi_nama ?? 'Belum ada posisi' }}
                                            </flux:button>
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <flux:button icon="building-2" variant="ghost"
                                                class="text-gray-500! text-sm student-perusahaan">
                                                {{ $mhs->perusahaan_nama ?? 'Belum ada perusahaan' }}
                                            </flux:button>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination (will be handled by JS) -->
                    <div id="pagination" class="flex justify-center">
                        <!-- Pagination buttons will be generated by JS -->
                    </div>
                @else
                    <div id="emptyState" class="text-center py-12">
                        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">
                            Belum ada mahasiswa yang sedang magang
                        </h3>
                        <p class="text-gray-500 mb-4">
                            Mahasiswa yang sedang magang akan muncul di sini.
                        </p>
                    </div>
                @endif
            </div>

            <!-- No Results State (hidden by default) -->
            <div id="noResults" class="text-center py-12" style="display: none;">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">
                    Tidak ada hasil yang ditemukan
                </h3>
                <p class="text-gray-500 mb-4">
                    Coba gunakan kata kunci yang berbeda atau ubah filter pencarian.
                </p>
                <button id="clearSearchFromNoResults"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                    Hapus Filter
                </button>
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
                const totalCount = document.getElementById('totalCount');
                const mahasiswaContainer = document.getElementById('mahasiswaContainer');
                const mahasiswaGrid = document.getElementById('mahasiswaGrid');
                const noResults = document.getElementById('noResults');
                const loading = document.getElementById('loading');
                const sortButtons = document.querySelectorAll('.sort-btn');
                const debugPanel = document.getElementById('debugPanel');
                const debugInfo = document.getElementById('debugInfo');
                const toggleDebugBtn = document.getElementById('toggleDebug');

                // State variables
                let allCards = [];
                let filteredCards = [];
                let currentSort = 'nama';
                let sortDirection = 'asc';
                let currentPage = 1;
                const itemsPerPage = {{ $perPage }};
                let debugMode = false; // Debug mode disabled by default

                // Debug functions (kept for potential future use)
                function debug(message, data = null) {
                    if (debugMode) {
                        console.log(`[DEBUG] ${message}`, data);
                        updateDebugPanel(message, data);
                    }
                }

                function updateDebugPanel(message, data = null) {
                    const timestamp = new Date().toLocaleTimeString();
                    let debugHTML = debugInfo.innerHTML;
                    debugHTML += `<div class="mb-1"><strong>[${timestamp}]</strong> ${message}`;
                    if (data) {
                        debugHTML += `<br><code class="text-xs">${JSON.stringify(data, null, 2)}</code>`;
                    }
                    debugHTML += '</div>';
                    debugInfo.innerHTML = debugHTML;
                    debugInfo.scrollTop = debugInfo.scrollHeight;
                }

                // Initialize cards array
                function initializeCards() {
                    allCards = Array.from(document.querySelectorAll('.mahasiswa-card'));
                    filteredCards = [...allCards];

                    debug('Cards initialized', {
                        totalCards: allCards.length,
                        sampleCard: allCards[0] ? {
                            nama: allCards[0].dataset.nama,
                            nim: allCards[0].dataset.nim,
                            perusahaan: allCards[0].dataset.perusahaan,
                            posisi: allCards[0].dataset.posisi
                        } : 'No cards found'
                    });
                }

                // Search functionality
                function performSearch(query) {
                    debug('Performing search', {
                        query
                    });

                    const searchQuery = query.toLowerCase().trim();

                    if (searchQuery === '') {
                        filteredCards = [...allCards];
                        searchInfo.style.display = 'none';
                        clearSearchBtn.style.display = 'none';
                        debug('Search cleared, showing all cards');
                    } else {
                        filteredCards = allCards.filter(card => {
                            const nama = card.dataset.nama || '';
                            const nim = card.dataset.nim || '';
                            const perusahaan = card.dataset.perusahaan || '';
                            const posisi = card.dataset.posisi || '';

                            const matches = nama.includes(searchQuery) ||
                                nim.includes(searchQuery) ||
                                perusahaan.includes(searchQuery) ||
                                posisi.includes(searchQuery);

                            return matches;
                        });

                        debug('Search completed', {
                            query: searchQuery,
                            matches: filteredCards.length,
                            totalCards: allCards.length
                        });

                        searchTerm.textContent = query;
                        searchCount.textContent = filteredCards.length;
                        searchInfo.style.display = 'block';
                        clearSearchBtn.style.display = 'block';
                    }

                    currentPage = 1;
                    displayResults();
                }

                // Sort functionality
                function performSort(sortBy, direction) {
                    debug('Performing sort', {
                        sortBy,
                        direction,
                        cardsCount: filteredCards.length
                    });

                    // Store original order before sorting for debugging
                    const originalOrder = filteredCards.map((card, index) => ({
                        index,
                        nama: card.dataset.nama,
                        nim: card.dataset.nim,
                        perusahaan: card.dataset.perusahaan
                    }));

                    filteredCards.sort((a, b) => {
                        let aValue = '';
                        let bValue = '';

                        switch (sortBy) {
                            case 'nama':
                                aValue = a.dataset.nama || '';
                                bValue = b.dataset.nama || '';
                                break;
                            case 'nim':
                                aValue = a.dataset.nim || '';
                                bValue = b.dataset.nim || '';
                                break;
                            case 'perusahaan':
                                aValue = a.dataset.perusahaan || '';
                                bValue = b.dataset.perusahaan || '';
                                break;
                            default:
                                aValue = a.dataset.nama || '';
                                bValue = b.dataset.nama || '';
                        }

                        debug('Comparing values', {
                            aValue,
                            bValue,
                            sortBy
                        });

                        if (direction === 'asc') {
                            return aValue.localeCompare(bValue);
                        } else {
                            return bValue.localeCompare(aValue);
                        }
                    });

                    // Debug sorted order
                    const sortedOrder = filteredCards.map((card, index) => ({
                        index,
                        nama: card.dataset.nama,
                        nim: card.dataset.nim,
                        perusahaan: card.dataset.perusahaan
                    }));

                    debug('Sort completed', {
                        originalOrder: originalOrder.slice(0, 3),
                        sortedOrder: sortedOrder.slice(0, 3),
                        totalSorted: filteredCards.length
                    });

                    displayResults();
                }

                // Display results with pagination
                function displayResults() {
                    debug('Displaying results', {
                        filteredCount: filteredCards.length,
                        currentPage,
                        itemsPerPage
                    });

                    // Show loading
                    loading.style.display = 'block';
                    mahasiswaContainer.style.display = 'none';
                    noResults.style.display = 'none';

                    setTimeout(() => {
                        // Hide all cards first
                        allCards.forEach(card => {
                            card.style.display = 'none';
                            card.style.order = 'initial';
                        });

                        if (filteredCards.length === 0) {
                            debug('No results to display');
                            mahasiswaContainer.style.display = 'none';
                            noResults.style.display = 'block';
                        } else {
                            // Calculate pagination
                            const startIndex = (currentPage - 1) * itemsPerPage;
                            const endIndex = startIndex + itemsPerPage;
                            const pageCards = filteredCards.slice(startIndex, endIndex);

                            debug('Displaying page cards', {
                                startIndex,
                                endIndex,
                                pageCardsCount: pageCards.length
                            });

                            // Reorder and show current page cards
                            pageCards.forEach((card, index) => {
                                card.style.display = 'block';
                                card.style.order = index;

                                // Move card to correct position in the grid
                                if (mahasiswaGrid && card.parentNode !== mahasiswaGrid) {
                                    mahasiswaGrid.appendChild(card);
                                }
                            });

                            // Update total count
                            totalCount.textContent = filteredCards.length;

                            mahasiswaContainer.style.display = 'block';
                            noResults.style.display = 'none';

                            // Update pagination
                            updatePagination();
                        }

                        loading.style.display = 'none';
                    }, 300);
                }

                // Update pagination
                function updatePagination() {
                    const totalPages = Math.ceil(filteredCards.length / itemsPerPage);
                    const pagination = document.getElementById('pagination');

                    debug('Updating pagination', {
                        totalPages,
                        currentPage
                    });

                    if (totalPages <= 1) {
                        pagination.innerHTML = '';
                        return;
                    }

                    let paginationHTML = '<div class="flex items-center space-x-2">';

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

                    paginationHTML += '</div>';
                    pagination.innerHTML = paginationHTML;

                    // Add event listeners to pagination buttons
                    document.querySelectorAll('.pagination-btn').forEach(btn => {
                        btn.addEventListener('click', function() {
                            currentPage = parseInt(this.dataset.page);
                            debug('Page changed', {
                                newPage: currentPage
                            });
                            displayResults();
                        });
                    });
                }

                // Event listeners
                // Debug button event listener (kept but won't be triggered since button is hidden)
                if (toggleDebugBtn) {
                    toggleDebugBtn.addEventListener('click', function() {
                        debugMode = !debugMode;
                        if (debugMode) {
                            debugPanel.style.display = 'block';
                            this.textContent = 'Hide Debug Info';
                            debugInfo.innerHTML = '<div class="text-sm">Debug mode enabled</div>';
                        } else {
                            debugPanel.style.display = 'none';
                            this.textContent = 'Show Debug Info';
                        }
                    });
                }

                searchInput.addEventListener('input', function() {
                    debug('Search input changed', {
                        value: this.value
                    });
                    performSearch(this.value);
                });

                clearSearchBtn.addEventListener('click', function() {
                    debug('Clear search clicked');
                    searchInput.value = '';
                    performSearch('');
                });

                clearSearchFromNoResults.addEventListener('click', function() {
                    debug('Clear search from no results clicked');
                    searchInput.value = '';
                    performSearch('');
                });

                // Sort button event listeners
                sortButtons.forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();

                        const sortBy = this.dataset.sort;
                        debug('Sort button clicked', {
                            sortBy,
                            currentSort,
                            sortDirection
                        });

                        if (currentSort === sortBy) {
                            // Toggle direction
                            sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
                        } else {
                            // New sort field
                            currentSort = sortBy;
                            sortDirection = 'asc';
                        }

                        // Update button styles
                        sortButtons.forEach(b => {
                            b.classList.remove('bg-blue-500', 'text-white');
                            b.classList.add('bg-gray-200', 'text-gray-700');
                            const icon = b.querySelector('.sort-icon');
                            if (icon) icon.textContent = '';
                        });

                        this.classList.remove('bg-gray-200', 'text-gray-700');
                        this.classList.add('bg-blue-500', 'text-white');
                        const thisIcon = this.querySelector('.sort-icon');
                        if (thisIcon) {
                            thisIcon.textContent = sortDirection === 'asc' ? '↑' : '↓';
                        }

                        performSort(currentSort, sortDirection);
                    });
                });

                // Initialize
                debug('Initializing application');
                initializeCards();
                displayResults();
            });
        </script>
    </div>
</div>
