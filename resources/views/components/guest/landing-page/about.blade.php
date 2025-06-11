<section class="min-h-screen px-4 sm:px-8 lg:px-16 pt-8 sm:pt-12 lg:pt-16 pb-8 flex items-center justify-center"
    id="about">
    <div class="container mx-auto">
        <div class="text-center mb-6 sm:mb-8">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold mb-2 text-slate-800">MAGNET</h1>
            <p class="text-sm sm:text-base md:text-lg text-blue-600 font-semibold mb-1">
                Magang Network And Tracking
            </p>
            <p class="text-xs sm:text-sm md:text-base text-slate-600 max-w-2xl mx-auto px-4">
                Sistem rekomendasi magang berbasis web yang menghubungkan mahasiswa JTI POLINEMA dengan perusahaan
                mitra terpercaya
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
            <!-- Left Side - Features -->
            <div class="space-y-4 sm:space-y-5">
                <div class="bg-white rounded-xl p-4 sm:p-6 shadow-lg border-l-4 border-blue-500">
                    <div class="flex items-start gap-3 sm:gap-4">
                        <div
                            class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <flux:icon.zap class="w-4 h-4 sm:w-6 sm:h-6 text-blue-600" />
                        </div>
                        <div>
                            <h3 class="font-semibold text-base sm:text-lg text-slate-800 mb-2">Rekomendasi Berbasis
                                SPK</h3>
                            <p class="text-xs sm:text-sm text-slate-600">
                                Sistem cerdas yang menganalisis kompetensi, keahlian, dan preferensi untuk
                                memberikan rekomendasi tempat magang yang paling sesuai
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-4 sm:p-6 shadow-lg border-l-4 border-green-500">
                    <div class="flex items-start gap-3 sm:gap-4">
                        <div
                            class="w-8 h-8 sm:w-10 sm:h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <flux:icon.handshake class="w-4 h-4 sm:w-6 sm:h-6 text-green-600" />
                        </div>
                        <div>
                            <h3 class="font-semibold text-base sm:text-lg text-slate-800 mb-2">Network Perusahaan
                                Mitra</h3>
                            <p class="text-xs sm:text-sm text-slate-600">
                                Terhubung dengan 1.500++ perusahaan mitra yang siap menerima mahasiswa magang dari
                                berbagai bidang teknologi informasi
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-4 sm:p-6 shadow-lg border-l-4 border-purple-500">
                    <div class="flex items-start gap-3 sm:gap-4">
                        <div
                            class="w-8 h-8 sm:w-10 sm:h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <flux:icon.chart-no-axes-combined class="w-4 h-4 sm:w-6 sm:h-6 text-purple-600" />
                        </div>
                        <div>
                            <h3 class="font-semibold text-base sm:text-lg text-slate-800 mb-2">Real-time Tracking
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-600">
                                Monitor progres magang secara real-time dengan sistem pelaporan terintegrasi antara
                                mahasiswa, dosen pembimbing, dan admin
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Stats & CTA -->
            <div class="space-y-4 sm:space-y-6">
                <div class="bg-white rounded-xl p-4 sm:p-6 shadow">
                    <h3 class="text-lg sm:text-xl font-bold text-slate-800 mb-4 text-center">MAGNET dalam Angka</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <div class="text-xl sm:text-2xl font-bold text-blue-600 mb-1">1.500+</div>
                            <div class="text-xs text-slate-600">Perusahaan Mitra</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl sm:text-2xl font-bold text-green-600 mb-1">95%</div>
                            <div class="text-xs text-slate-600">Tingkat Kecocokan</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl sm:text-2xl font-bold text-purple-600 mb-1">3</div>
                            <div class="text-xs text-slate-600">Jenis Pengguna</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl sm:text-2xl font-bold text-orange-600 mb-1">6</div>
                            <div class="text-xs text-slate-600">Bulan Durasi</div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-r from-magnet-deep-ocean-blue to-blue-800 text-white rounded-xl p-4 sm:p-6 text-center">
                    <h3 class="text-sm sm:text-base font-semibold mb-2">Siap Memulai Perjalanan Magang?</h3>
                    <p class="text-xs sm:text-sm text-blue-100 mb-4">
                        Bergabunglah dengan MAGNET dan temukan tempat magang impianmu dengan teknologi SPK terdepan
                    </p>
                    <div class="space-y-2">
                        <flux:button
                            class="w-full bg-white text-blue-600! font-semibold! py-2 px-4 rounded hover:bg-gray-100! transition duration-200!"
                            href="{{ route('login') }}">Mulai Sekarang</flux:button>
                        <p class="text-xs text-blue-200">*Khusus mahasiswa JTI POLINEMA</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
