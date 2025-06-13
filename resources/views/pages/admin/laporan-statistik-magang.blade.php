<x-layouts.user.main user="admin">
    <flux:breadcrumbs class="mb-5">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('admin.laporan-statistik-magang') }}" class="text-black">Laporan statistik
            magang
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div>
        <div class="max-w-7xl mx-auto ">
            <div
                class="flex justify-start items-center py-4 bg-white shadow-sm border-b border-gray-200 px-4 rounded-md">

                <h1 class="text-2xl font-bold text-gray-900">Monitoring dan analisis data magang mahasiswa</h1>


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
                    <p class="text-sm font-medium text-gray-600">Sudah Mendapat Magang</p>
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
                <h3 class="text-lg font-semibold text-gray-900">Tren Magang pada bidang Industri</h3>
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
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Rasio Dosen Pembimbing</h3>
            </div>


            <div class=" border-gray-200">

                <div class="grid grid-cols-1 gap-4">
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">1:22</div>
                        <div class="text-sm text-gray-600">D4 Teknik Informatika</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">1:20</div>
                        <div class="text-sm text-gray-600">D4 SIB</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">1:8</div>
                        <div class="text-sm text-gray-600">D4 SIB</div>
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
                labels: ['BE','FE','UI/UX','QA','Android','IOS'],
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