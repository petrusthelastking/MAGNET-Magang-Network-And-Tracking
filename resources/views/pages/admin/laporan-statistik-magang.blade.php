<x-layouts.user.main user="admin">
    <flux:breadcrumbs class="mb-5">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('admin.laporan-statistik-magang') }}" class="text-black">Laporan statistik
            magang
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div>
        <div class="max-w-7xl mx-auto  sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4 bg-white shadow-sm border-b border-gray-200 px-4 rounded-md">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Laporan Statistik Magang</h1>
                    <p class="text-sm text-gray-600 mt-1">Monitoring dan analisis data magang mahasiswa</p>
                </div>
                <div class="flex items-center space-x-3">
                    <button
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <i class="fas fa-download mr-2"></i>
                        Export PDF
                    </button>
                    <button
                        class="inline-flex items-center px-4 py-2 bg-cyan-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <i class="fas fa-file-excel mr-2"></i>
                        Export Excel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filter Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Filter Laporan</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Periode</label>
                        <select
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                            <option value="">Semua Periode</option>
                            <option value="2024-1">Semester 1 2024/2025</option>
                            <option value="2024-2">Semester 2 2024/2025</option>
                            <option value="2023-1">Semester 1 2023/2024</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Program Studi</label>
                        <select
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                            <option value="">Semua Program Studi</option>
                            <option value="ti">D4 Teknik Informatika</option>
                            <option value="sib">D4 Sistem Informasi Bisnis</option>
                            <option value="tik">D2 Pengembangan Piranti Lunak Situs</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                            <option value="">Semua Status</option>
                            <option value="selesai">Selesai</option>
                            <option value="berlangsung">Sedang Berlangsung</option>
                            <option value="belum">Belum Magang</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button
                            class="w-full px-4 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            <i class="fas fa-filter mr-2"></i>
                            Terapkan Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Mahasiswa</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">1,247</p>
                        <p class="text-sm text-green-600 mt-1">
                            <span class="inline-flex items-center">
                                <i class="fas fa-arrow-up text-xs mr-1"></i>
                                +12% dari periode lalu
                            </span>
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Sudah Magang</p>
                        <p class="text-3xl font-bold text-green-600 mt-2">1,089</p>
                        <p class="text-sm text-gray-500 mt-1">87.3% dari total mahasiswa</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Perusahaan Mitra</p>
                        <p class="text-3xl font-bold text-purple-600 mt-2">184</p>
                        <p class="text-sm text-green-600 mt-1">
                            <span class="inline-flex items-center">
                                <i class="fas fa-arrow-up text-xs mr-1"></i>
                                +8 perusahaan baru
                            </span>
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-building text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Dosen Pembimbing</p>
                        <p class="text-3xl font-bold text-orange-600 mt-2">42</p>
                        <p class="text-sm text-gray-500 mt-1">Rasio 1:26 per mahasiswa</p>
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
                    <h3 class="text-lg font-semibold text-gray-900">Tren Magang per Semester</h3>
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

            <!-- Distribution Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Distribusi Bidang Magang</h3>
                </div>
                <div class="h-64">
                    <canvas id="distributionChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Detailed Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Top Companies -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Top 10 Perusahaan Mitra</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <span class="text-sm font-semibold text-blue-600">1</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">PT Telkom Indonesia</p>
                                    <p class="text-sm text-gray-500">Teknologi Informasi</p>
                                </div>
                            </div>
                            <span class="text-sm font-semibold text-gray-900">127 mahasiswa</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <span class="text-sm font-semibold text-blue-600">2</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Bank Mandiri</p>
                                    <p class="text-sm text-gray-500">Perbankan & Fintech</p>
                                </div>
                            </div>
                            <span class="text-sm font-semibold text-gray-900">98 mahasiswa</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <span class="text-sm font-semibold text-blue-600">3</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Gojek Indonesia</p>
                                    <p class="text-sm text-gray-500">Startup & E-commerce</p>
                                </div>
                            </div>
                            <span class="text-sm font-semibold text-gray-900">76 mahasiswa</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <span class="text-sm font-semibold text-blue-600">4</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Shopee Indonesia</p>
                                    <p class="text-sm text-gray-500">E-commerce</p>
                                </div>
                            </div>
                            <span class="text-sm font-semibold text-gray-900">65 mahasiswa</span>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <span class="text-sm font-semibold text-blue-600">5</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Tokopedia</p>
                                    <p class="text-sm text-gray-500">E-commerce</p>
                                </div>
                            </div>
                            <span class="text-sm font-semibold text-gray-900">54 mahasiswa</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Program Study Stats -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Statistik per Program Studi</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-6">
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">D4 Teknik Informatika</span>
                                <span class="text-sm text-gray-500">542/620 (87.4%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: 87.4%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">D4 Sistem Informasi Bisnis</span>
                                <span class="text-sm text-gray-500">398/456 (87.3%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full" style="width: 87.3%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">D2 Pengembangan Piranti Lunak Situs</span>
                                <span class="text-sm text-gray-500">149/171 (87.1%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-600 h-2 rounded-full" style="width: 87.1%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-semibold text-gray-900 mb-4">Rasio Dosen Pembimbing</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center p-4 bg-gray-50 rounded-lg">
                                <div class="text-2xl font-bold text-blue-600">1:26</div>
                                <div class="text-sm text-gray-600">D4 Teknik Informatika</div>
                            </div>
                            <div class="text-center p-4 bg-gray-50 rounded-lg">
                                <div class="text-2xl font-bold text-green-600">1:24</div>
                                <div class="text-sm text-gray-600">D4 SIB</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Trend Chart
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: ['2022/1', '2022/2', '2023/1', '2023/2', '2024/1', '2024/2'],
                datasets: [{
                    label: 'Mahasiswa Magang',
                    data: [856, 923, 987, 1024, 1089, 1156],
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

        // Distribution Chart
        const distributionCtx = document.getElementById('distributionChart').getContext('2d');
        new Chart(distributionCtx, {
            type: 'doughnut',
            data: {
                labels: ['Software Development', 'Data Science', 'Cybersecurity', 'UI/UX Design', 'System Administration', 'Lainnya'],
                datasets: [{
                    data: [35, 25, 15, 12, 8, 5],
                    backgroundColor: [
                        '#0891b2',
                        '#059669',
                        '#7c3aed',
                        '#dc2626',
                        '#ea580c',
                        '#6b7280'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    </script>
</x-layouts.user.main>