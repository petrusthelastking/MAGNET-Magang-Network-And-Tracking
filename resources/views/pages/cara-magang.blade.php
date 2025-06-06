<x-layouts.guest.main>
    <div class="min-h-screen px-10 pt-5 ">
        <!-- Header -->
        <header
            class="bg-gradient-to-br from-magnet-deep-ocean-blue via-blue-900 to-magnet-deep-ocean-blue text-white py-8 rounded-2xl flex items-center">
            <flux:button variant="primary" class="bg-white text-black ml-4" href="{{ route('landing-page') }}"
                icon="arrow-big-left-dash" size="sm" />
            <div class="container mx-auto px-4 flex flex-col items-center justify-center">
                <h1 class="text-2xl font-bold mb-2">Cara Mengajukan Magang</h1>
                <p class="text-base text-blue-100">Panduan lengkap untuk mahasiswa Jurusan Teknologi Informasi</p>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto py-6 text-sm">
            <!-- Pendahuluan -->
            <section class="mb-6">
                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-xl font-bold text-gray-800 mb-2">Pendahuluan</h2>
                    <p class="text-gray-600">
                        Sistem Rekomendasi Magang atau Kerja Praktek Berbasis Web telah dikembangkan khusus untuk
                        mahasiswa
                        Jurusan Teknologi Informasi Politeknik Negeri Malang. Sistem ini dirancang untuk mempermudah
                        Anda
                        dalam menemukan tempat magang yang sesuai dengan bidang studi, keterampilan, dan preferensi
                        Anda.
                    </p>
                </div>
            </section>

            <!-- Langkah-langkah -->
            <section class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Langkah-langkah Mengajukan Magang</h2>

                <!-- Langkah-langkah -->
                <!-- Ulangi blok berikut untuk setiap langkah -->
                <!-- Langkah 1 sampai 7 -->
                <div class="space-y-4">
                    <!-- Gunakan pengulangan langkah-langkah berikut ini -->
                    <!-- Step Template -->
                    <div class="bg-white rounded-lg shadow p-3">
                        <div class="flex items-start">
                            <div
                                class="bg-gradient-to-r from-magnet-deep-ocean-blue to-blue-800 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-3 text-sm flex-shrink-0">
                                1</div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-800 mb-1">Mendaftar dan Login ke Sistem
                                </h3>
                                <p class="text-gray-600 mb-1">
                                    Pastikan Anda telah memiliki akun di sistem rekomendasi magang. Jika belum, hubungi
                                    admin jurusan.
                                </p>
                                <ul class="text-gray-600 space-y-0.5 list-disc list-inside">
                                    <li>Buka halaman login sistem</li>
                                    <li>Masukkan username dan password</li>
                                    <li>Klik tombol "Masuk"</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="bg-white rounded-lg shadow p-3">
                        <div class="flex items-start">
                            <div
                                class="bg-gradient-to-r from-magnet-deep-ocean-blue to-blue-800 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-3 text-sm flex-shrink-0">
                                2</div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-800 mb-1">Lengkapi Profil Anda</h3>
                                <p class="text-gray-600 mb-1">
                                    Profil lengkap membantu sistem memberikan rekomendasi magang sesuai kompetensi Anda.
                                </p>
                                <ul class="text-gray-600 space-y-0.5 list-disc list-inside">
                                    <li>Data akademik (prodi, semester, IPK)</li>
                                    <li>Bidang keahlian, sertifikasi</li>
                                    <li>Pengalaman organisasi/proyek</li>
                                    <li>Preferensi lokasi dan jenis magang</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="bg-white rounded-lg shadow p-3">
                        <div class="flex items-start">
                            <div
                                class="bg-gradient-to-r from-magnet-deep-ocean-blue to-blue-800 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-3 text-sm flex-shrink-0">
                                3</div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-800 mb-1">Siapkan Dokumen Pendukung</h3>
                                <p class="text-gray-600 mb-1">Unggah dokumen-dokumen berikut:</p>
                                <ul class="text-gray-600 space-y-0.5 list-disc list-inside">
                                    <li>CV terbaru</li>
                                    <li>Surat pengantar</li>
                                    <li>Transkrip nilai</li>
                                    <li>Sertifikat kompetensi (jika ada)</li>
                                    <li>Portofolio proyek (jika ada)</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="bg-white rounded-lg shadow p-3">
                        <div class="flex items-start">
                            <div
                                class="bg-gradient-to-r from-magnet-deep-ocean-blue to-blue-800 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-3 text-sm flex-shrink-0">
                                4</div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-800 mb-1">Lihat Rekomendasi Magang</h3>
                                <p class="text-gray-600 mb-1">Sistem memberikan rekomendasi otomatis:</p>
                                <ul class="text-gray-600 space-y-0.5 list-disc list-inside">
                                    <li>Lihat daftar rekomendasi</li>
                                    <li>Baca detail lowongan</li>
                                    <li>Gunakan filter & pencarian</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Step 5 -->
                    <div class="bg-white rounded-lg shadow p-3">
                        <div class="flex items-start">
                            <div
                                class="bg-gradient-to-r from-magnet-deep-ocean-blue to-blue-800 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-3 text-sm flex-shrink-0">
                                5</div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-800 mb-1">Ajukan Lamaran Magang</h3>
                                <p class="text-gray-600 mb-1">Setelah menemukan lowongan:</p>
                                <ul class="text-gray-600 space-y-0.5 list-disc list-inside">
                                    <li>Klik "Ajukan Lamaran"</li>
                                    <li>Unggah dokumen & isi form</li>
                                    <li>Tulis motivation letter</li>
                                    <li>Submit dan tunggu konfirmasi</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Step 6 -->
                    <div class="bg-white rounded-lg shadow p-3">
                        <div class="flex items-start">
                            <div
                                class="bg-gradient-to-r from-magnet-deep-ocean-blue to-blue-800 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-3 text-sm flex-shrink-0">
                                6</div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-800 mb-1">Pantau Status Pengajuan</h3>
                                <p class="text-gray-600 mb-1">Periksa perkembangan lamaran Anda:</p>
                                <ul class="text-gray-600 space-y-0.5 list-disc list-inside">
                                    <li>Lihat dashboard</li>
                                    <li>Cek notifikasi</li>
                                    <li>Status: Dalam Proses / Diterima / Ditolak</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Step 7 -->
                    <div class="bg-white rounded-lg shadow p-3">
                        <div class="flex items-start">
                            <div
                                class="bg-gradient-to-r from-magnet-deep-ocean-blue to-blue-800  text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-3 text-sm flex-shrink-0">
                                7</div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-800 mb-1">Mulai Kegiatan Magang</h3>
                                <p class="text-gray-600 mb-1">Setelah diterima, ikuti langkah berikut:</p>
                                <ul class="text-gray-600 space-y-0.5 list-disc list-inside">
                                    <li>Dapatkan dosen pembimbing</li>
                                    <li>Koordinasi jadwal magang</li>
                                    <li>Isi log kegiatan di sistem</li>
                                    <li>Lakukan evaluasi rutin</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Catatan Penting -->
            <section class="mb-6">
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                    <h3 class="text-base font-semibold text-yellow-800 mb-2">Catatan Penting</h3>
                    <ul class="text-yellow-700 space-y-1 list-disc list-inside">
                        <li>Khusus mahasiswa TI Polinema</li>
                        <li>Rekomendasi tidak menjamin diterima</li>
                        <li>Pastikan data benar dan terbaru</li>
                        <li>Hubungi admin jika ada kendala</li>
                    </ul>
                </div>
            </section>

            <!-- Contact -->
            <section>
                <div class="bg-white rounded-lg p-4">
                    <h3 class="text-base font-semibold text-blue-800 mb-2">Butuh Bantuan?</h3>
                    <p class="text-blue-700">
                        Hubungi admin Jurusan Teknologi Informasi jika mengalami kesulitan dalam menggunakan sistem atau
                        memiliki pertanyaan.
                    </p>
                </div>
            </section>
        </main>

        <!-- Footer -->

    </div>
    <footer class="bg-magnet-deep-ocean-blue text-white py-8">
        <div class="container mx-auto px-6 text-center">
            <p class="mb-2">&copy; 2025 Jurusan Teknologi Informasi - Politeknik Negeri Malang</p>
            <p class="text-gray-400 text-sm">Sistem Rekomendasi Magang Berbasis Web</p>
        </div>
    </footer>

</x-layouts.guest.main>