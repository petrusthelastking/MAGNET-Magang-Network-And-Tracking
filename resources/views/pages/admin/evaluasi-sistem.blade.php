<x-layouts.user.main user="admin">
    <x-slot:topScript>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </x-slot:topScript>
    
    <flux:breadcrumbs class="mb-5">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('admin.evaluasi-sistem-rekomendasi') }}" class="text-black">Evaluasi
            sistem
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="flex justify-between items-center py-4 bg-white shadow-sm border-b border-gray-200 px-4 rounded-md">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Evaluasi Sistem Rekomendasi</h1>
                    <p class="text-sm text-gray-600 mt-1">Analisis performa dan efektivitas algoritma rekomendasi</p>
                </div>
                <div class="flex items-center space-x-3">
                    <button
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <i class="fas fa-sync-alt mr-2"></i>
                        Refresh Data
                    </button>
                    {{-- <button
                        class="inline-flex items-center px-4 py-2 bg-cyan-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <i class="fas fa-cog mr-2"></i>
                        Konfigurasi
                    </button> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Performance Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Akurasi Rekomendasi</p>
                        <p class="text-3xl font-bold text-green-600 mt-2">87.3%</p>
                        <p class="text-sm text-green-600 mt-1">
                            <span class="inline-flex items-center">
                                <i class="fas fa-arrow-up text-xs mr-1"></i>
                                +2.1% dari bulan lalu
                            </span>
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-bullseye text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Tingkat Kepuasan</p>
                        <p class="text-3xl font-bold text-blue-600 mt-2">4.2/5</p>
                        <p class="text-sm text-gray-500 mt-1">Berdasarkan 1,089 feedback</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-star text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Success Rate</p>
                        <p class="text-3xl font-bold text-purple-600 mt-2">91.7%</p>
                        <p class="text-sm text-purple-600 mt-1">
                            <span class="inline-flex items-center">
                                <i class="fas fa-arrow-up text-xs mr-1"></i>
                                +4.3% dari periode lalu
                            </span>
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Waktu Respons</p>
                        <p class="text-3xl font-bold text-orange-600 mt-2">0.8s</p>
                        <p class="text-sm text-green-600 mt-1">
                            <span class="inline-flex items-center">
                                <i class="fas fa-arrow-down text-xs mr-1"></i>
                                -0.2s lebih cepat
                            </span>
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-orange-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Algorithm Performance -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Accuracy Trend -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Tren Akurasi Rekomendasi</h3>
                    <div class="flex items-center space-x-2 text-sm text-gray-500">
                        <span class="inline-flex items-center">
                            <span class="w-3 h-3 bg-cyan-500 rounded-full mr-2"></span>
                            Akurasi (%)
                        </span>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="accuracyChart"></canvas>
                </div>
            </div>

            <!-- User Satisfaction -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Distribusi Rating Kepuasan</h3>
                </div>
                <div class="h-64">
                    <canvas id="satisfactionChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Algorithm Metrics -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Metrik Algoritma Rekomendasi</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-sm font-semibold text-blue-900">Precision</h4>
                            <i class="fas fa-crosshairs text-blue-600"></i>
                        </div>
                        <div class="text-3xl font-bold text-blue-900 mb-2">89.4%</div>
                        <p class="text-sm text-blue-700">Relevansi rekomendasi yang diberikan</p>
                        <div class="w-full bg-blue-200 rounded-full h-2 mt-3">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 89.4%"></div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-sm font-semibold text-green-900">Recall</h4>
                            <i class="fas fa-search text-green-600"></i>
                        </div>
                        <div class="text-3xl font-bold text-green-900 mb-2">85.2%</div>
                        <p class="text-sm text-green-700">Kemampuan menemukan semua item relevan</p>
                        <div class="w-full bg-green-200 rounded-full h-2 mt-3">
                            <div class="bg-green-600 h-2 rounded-full" style="width: 85.2%"></div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-sm font-semibold text-purple-900">F1-Score</h4>
                            <i class="fas fa-balance-scale text-purple-600"></i>
                        </div>
                        <div class="text-3xl font-bold text-purple-900 mb-2">87.3%</div>
                        <p class="text-sm text-purple-700">Harmonic mean dari Precision & Recall</p>
                        <div class="w-full bg-purple-200 rounded-full h-2 mt-3">
                            <div class="bg-purple-600 h-2 rounded-full" style="width: 87.3%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Analysis -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Algorithm Comparison -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Perbandingan Algoritma</h3>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-3 px-4 font-semibold text-gray-900">Algoritma</th>
                                    <th class="text-center py-3 px-4 font-semibold text-gray-900">Akurasi</th>
                                    <th class="text-center py-3 px-4 font-semibold text-gray-900">Precision</th>
                                    <th class="text-center py-3 px-4 font-semibold text-gray-900">Recall</th>
                                    <th class="text-center py-3 px-4 font-semibold text-gray-900">F1-Score</th>
                                    <th class="text-center py-3 px-4 font-semibold text-gray-900">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                            <span class="font-medium">Collaborative Filtering</span>
                                        </div>
                                    </td>
                                    <td class="text-center py-4 px-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            87.3%
                                        </span>
                                    </td>
                                    <td class="text-center py-4 px-4">89.4%</td>
                                    <td class="text-center py-4 px-4">85.2%</td>
                                    <td class="text-center py-4 px-4">87.3%</td>
                                    <td class="text-center py-4 px-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Aktif
                                        </span>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                                            <span class="font-medium">Content-Based</span>
                                        </div>
                                    </td>
                                    <td class="text-center py-4 px-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            84.7%
                                        </span>
                                    </td>
                                    <td class="text-center py-4 px-4">86.1%</td>
                                    <td class="text-center py-4 px-4">83.4%</td>
                                    <td class="text-center py-4 px-4">84.7%</td>
                                    <td class="text-center py-4 px-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Backup
                                        </span>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-purple-500 rounded-full mr-3"></div>
                                            <span class="font-medium">Hybrid Method</span>
                                        </div>
                                    </td>
                                    <td class="text-center py-4 px-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            91.2%
                                        </span>
                                    </td>
                                    <td class="text-center py-4 px-4">92.8%</td>
                                    <td class="text-center py-4 px-4">89.7%</td>
                                    <td class="text-center py-4 px-4">91.2%</td>
                                    <td class="text-center py-4 px-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Testing
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recommendations Quality -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Kualitas Rekomendasi</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-6">
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">Sangat Relevan</span>
                                <span class="text-sm font-semibold text-green-600">43.2%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 43.2%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">Relevan</span>
                                <span class="text-sm font-semibold text-blue-600">38.5%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: 38.5%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">Cukup Relevan</span>
                                <span class="text-sm font-semibold text-yellow-600">12.8%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-yellow-500 h-2 rounded-full" style="width: 12.8%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">Kurang Relevan</span>
                                <span class="text-sm font-semibold text-red-600">5.5%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-red-500 h-2 rounded-full" style="width: 5.5%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-semibold text-gray-900 mb-3">Faktor Penentu</h4>
                        <div class="space-y-3 text-sm text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Kesesuaian skill (35%)</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Lokasi magang (25%)</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Bidang industri (20%)</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                <span>Durasi magang (20%)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Feedback Analysis -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Analisis Feedback Pengguna</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-thumbs-up text-2xl text-green-600"></i>
                        </div>
                        <div class="text-2xl font-bold text-green-600">847</div>
                        <div class="text-sm text-gray-600">Feedback Positif</div>
                        <div class="text-xs text-green-600 mt-1">77.8% dari total</div>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-meh text-2xl text-yellow-600"></i>
                        </div>
                        <div class="text-2xl font-bold text-yellow-600">184</div>
                        <div class="text-sm text-gray-600">Feedback Netral</div>
                        <div class="text-xs text-yellow-600 mt-1">16.9% dari total</div>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-thumbs-down text-2xl text-red-600"></i>
                        </div>
                        <div class="text-2xl font-bold text-red-600">58</div>
                        <div class="text-sm text-gray-600">Feedback Negatif</div>
                        <div class="text-xs text-red-600 mt-1">5.3% dari total</div>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-comments text-2xl text-blue-600"></i>
                        </div>
                        <div class="text-2xl font-bold text-blue-600">1,089</div>
                        <div class="text-sm text-gray-600">Total Feedback</div>
                        <div class="text-xs text-blue-600 mt-1">100% mahasiswa</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Improvement Recommendations -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Rekomendasi Perbaikan</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <h4 class="font-semibold text-gray-900">Prioritas Tinggi</h4>
                        <div class="space-y-3">
                            <div class="flex items-start p-4 border border-red-200 rounded-lg bg-red-50">
                                <div class="w-2 h-2 bg-red-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                                <div>
                                    <p class="font-medium text-red-900">Tingkatkan Akurasi untuk Bidang Tertentu</p>
                                    <p class="text-sm text-red-700 mt-1">Data Science dan Cybersecurity memiliki akurasi
                                        lebih rendah (82%) dibanding rata-rata.</p>
                                </div>
                            </div>

                            <div class="flex items-start p-4 border border-orange-200 rounded-lg bg-orange-50">
                                <div class="w-2 h-2 bg-orange-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                                <div>
                                    <p class="font-medium text-orange-900">Optimalisasi Cold Start Problem</p>
                                    <p class="text-sm text-orange-700 mt-1">Mahasiswa baru dengan profil terbatas
                                        mendapat rekomendasi kurang akurat.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="font-semibold text-gray-900">Prioritas Sedang</h4>
                        <div class="space-y-3">
                            <div class="flex items-start p-4 border border-yellow-200 rounded-lg bg-yellow-50">
                                <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                                <div>
                                    <p class="font-medium text-yellow-900">Implementasi Hybrid Algorithm</p>
                                    <p class="text-sm text-yellow-700 mt-1">Testing menunjukkan peningkatan akurasi 3.9%
                                        dengan metode hybrid.</p>
                                </div>
                            </div>

                            <div class="flex items-start p-4 border border-blue-200 rounded-lg bg-blue-50">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                                <div>
                                    <p class="font-medium text-blue-900">Enhanced User Profiling</p>
                                    <p class="text-sm text-blue-700 mt-1">Tambahkan faktor soft skills dan minat
                                        personal dalam algoritma.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-semibold text-gray-900">Status Update Terakhir</h4>
                            <p class="text-sm text-gray-600">Evaluasi sistem dilakukan setiap minggu dengan data
                                real-time</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">Update Terakhir</p>
                            <p class="text-sm text-gray-600">3 Juni 2025, 14:30 WIB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


      <script>
        // Accuracy Trend Chart
        const accuracyCtx = document.getElementById('accuracyChart').getContext('2d');
        new Chart(accuracyCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [{
                    label: 'Akurasi (%)',
                    data: [82.1, 83.5, 84.8, 86.2, 87.1, 87.3],
                    borderColor: '#0891b2',
                    backgroundColor: 'rgba(8, 145, 178, 0.1)',
                    fill: true,
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
                        beginAtZero: false,
                        min: 80,
                        max: 90,
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

        // Satisfaction Chart
        const satisfactionCtx = document.getElementById('satisfactionChart').getContext('2d');
        new Chart(satisfactionCtx, {
            type: 'bar',
            data: {
                labels: ['⭐', '⭐⭐', '⭐⭐⭐', '⭐⭐⭐⭐', '⭐⭐⭐⭐⭐'],
                datasets: [{
                    label: 'Jumlah Rating',
                    data: [12, 34, 156, 487, 400],
                    backgroundColor: [
                        '#ef4444',
                        '#f97316',
                        '#eab308',
                        '#22c55e',
                        '#059669'
                    ]
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
                            display: false
                        }
                    }
                }
            }
        });
    </script>


</x-layouts.user.main>
