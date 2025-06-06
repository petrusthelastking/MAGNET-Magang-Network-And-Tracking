<x-layouts.guest.main>
    <div class="min-h-screen px-10 pt-5">
        <!-- Header -->
        <header
            class="bg-gradient-to-br from-magnet-deep-ocean-blue via-blue-900 to-magnet-deep-ocean-blue text-white py-8 rounded-2xl flex items-center">
            <flux:button variant="primary" class="bg-white text-black ml-4" href="{{ route('landing-page') }}"
                icon="arrow-big-left-dash" size="sm" />
            <div class="container mx-auto px-4 flex flex-col items-center justify-center">
                <h1 class="text-2xl font-bold mb-2">Tips Memilih Tempat Magang Terbaik</h1>
                <p class="text-base text-green-100">Panduan strategis untuk mahasiswa Teknologi Informasi</p>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto py-6 text-sm">
            <!-- Pendahuluan -->
            <section class="mb-6">
                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-xl font-bold text-gray-800 mb-2">Mengapa Pemilihan Tempat Magang Penting?</h2>
                    <p class="text-gray-600 mb-2">
                        Magang atau kerja praktek merupakan bagian integral dari proses pendidikan tinggi yang
                        memberikan
                        pengalaman nyata di dunia industri. Pemilihan tempat magang yang tepat akan sangat berpengaruh
                        terhadap pengembangan keterampilan, jaringan profesional, dan kesiapan Anda dalam memasuki dunia
                        kerja.
                    </p>
                    <p class="text-gray-600">
                        Dengan memanfaatkan Sistem Rekomendasi Magang berbasis web, Anda dapat menemukan tempat magang
                        yang sesuai dengan profil akademik, keterampilan, dan preferensi pribadi Anda.
                    </p>
                </div>
            </section>

            <!-- Tips Utama -->
            <section class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Tips Strategis Memilih Tempat Magang</h2>

                <div class="space-y-4">
                    <!-- Tip 1 -->
                    <div class="bg-white rounded-lg shadow p-3">
                        <div class="flex items-start">
                            <div
                                class="bg-gradient-to-r from-magnet-deep-ocean-blue to-blue-800 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-3 text-sm flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-800 mb-1">Sesuaikan dengan Bidang Studi dan
                                    Minat</h3>
                                <p class="text-gray-600 mb-1">
                                    Pilih tempat magang yang sejalan dengan program studi dan minat karir Anda di bidang
                                    Teknologi Informasi.
                                </p>
                                <div class="bg-gray-50 p-2 rounded">
                                    <h4 class="font-semibold text-gray-700 mb-1">Bidang yang dapat Anda pilih:</h4>
                                    <ul class="text-gray-600 space-y-0.5 list-disc list-inside">
                                        <li>Pengembangan Web (Frontend/Backend/Full-stack)</li>
                                        <li>Pengembangan Aplikasi Mobile (Android/iOS)</li>
                                        <li>Data Science dan Analytics</li>
                                        <li>Network dan Cyber Security</li>
                                        <li>UI/UX Design</li>
                                        <li>Database Administration</li>
                                        <li>DevOps dan Cloud Computing</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tip 2 -->
                    <div class="bg-white rounded-lg shadow p-3">
                        <div class="flex items-start">
                            <div
                                class="bg-gradient-to-r from-magnet-deep-ocean-blue to-blue-800  text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-3 text-sm flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-800 mb-1">Pertimbangkan Reputasi dan
                                    Kredibilitas Perusahaan</h3>
                                <p class="text-gray-600 mb-1">
                                    Pilih perusahaan mitra yang memiliki reputasi baik dan terdaftar dalam sistem
                                    rekomendasi jurusan.
                                </p>
                                <div class="bg-gray-50 p-2 rounded">
                                    <h4 class="font-semibold text-gray-700 mb-1">Yang perlu diperhatikan:</h4>
                                    <ul class="text-gray-600 space-y-0.5 list-disc list-inside">
                                        <li>Status perusahaan (startup, UMKM, korporasi)</li>
                                        <li>Track record dalam membimbing mahasiswa magang</li>
                                        <li>Testimoni dari mahasiswa sebelumnya</li>
                                        <li>Legalitas dan kredibilitas bisnis</li>
                                        <li>Kemitraan resmi dengan Politeknik Negeri Malang</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tip 3 -->
                    <div class="bg-white rounded-lg shadow p-3">
                        <div class="flex items-start">
                            <div
                                class="bg-gradient-to-r from-magnet-deep-ocean-blue to-blue-800 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-3 text-sm flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-800 mb-1">Evaluasi Lokasi dan Aksesibilitas
                                </h3>
                                <p class="text-gray-600 mb-1">
                                    Pertimbangkan lokasi magang yang mudah diakses dan sesuai dengan preferensi Anda.
                                </p>
                                <div class="bg-gray-50 p-2 rounded">
                                    <h4 class="font-semibold text-gray-700 mb-1">Faktor lokasi yang perlu
                                        dipertimbangkan:</h4>
                                    <ul class="text-gray-600 space-y-0.5 list-disc list-inside">
                                        <li>Jarak dari tempat tinggal atau kampus</li>
                                        <li>Ketersediaan transportasi umum</li>
                                        <li>Biaya transportasi harian</li>
                                        <li>Keamanan lingkungan sekitar</li>
                                        <li>Fasilitas pendukung (kantin, ATM, dll)</li>
                                        <li>Opsi magang remote/hybrid jika tersedia</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tip 4 -->
                    <div class="bg-white rounded-lg shadow p-3">
                        <div class="flex items-start">
                            <div
                                class="bg-gradient-to-r from-magnet-deep-ocean-blue to-blue-800 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-3 text-sm flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-800 mb-1">Analisis Peluang Pengembangan
                                    Skill</h3>
                                <p class="text-gray-600 mb-1">
                                    Pilih tempat magang yang menawarkan kesempatan belajar teknologi dan tools terbaru.
                                </p>
                                <div class="bg-gray-50 p-2 rounded">
                                    <h4 class="font-semibold text-gray-700 mb-1">Aspek pengembangan skill:</h4>
                                    <ul class="text-gray-600 space-y-0.5 list-disc list-inside">
                                        <li>Teknologi dan programming language yang digunakan</li>
                                        <li>Kesempatan mengerjakan proyek real</li>
                                        <li>Mentoring dari senior developer</li>
                                        <li>Training dan workshop internal</li>
                                        <li>Sertifikasi yang bisa didapatkan</li>
                                        <li>Exposure ke best practices industri</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tip 5 -->
                    <div class="bg-white rounded-lg shadow p-3">
                        <div class="flex items-start">
                            <div
                                class="bg-gradient-to-r from-magnet-deep-ocean-blue to-blue-800 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-3 text-sm flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-800 mb-1">Pertimbangkan Aspek Kompensasi
                                    dan Benefit</h3>
                                <p class="text-gray-600 mb-1">
                                    Walaupun bukan faktor utama, kompensasi dan benefit dapat menjadi pertimbangan
                                    tambahan.
                                </p>
                                <div class="bg-gray-50 p-2 rounded">
                                    <h4 class="font-semibold text-gray-700 mb-1">Benefit yang mungkin didapatkan:</h4>
                                    <ul class="text-gray-600 space-y-0.5 list-disc list-inside">
                                        <li>Uang saku atau allowance harian</li>
                                        <li>Reimbursement transportasi</li>
                                        <li>Makan siang gratis</li>
                                        <li>Akses ke fasilitas perusahaan</li>
                                        <li>Sertifikat dan surat rekomendasi</li>
                                        <li>Peluang job offer setelah lulus</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tip 6 -->
                    <div class="bg-white rounded-lg shadow p-3">
                        <div class="flex items-start">
                            <div
                                class="bg-gradient-to-r from-magnet-deep-ocean-blue to-blue-800 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-3 text-sm flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-800 mb-1">Evaluasi Budaya dan Lingkungan
                                    Kerja</h3>
                                <p class="text-gray-600 mb-1">
                                    Cari informasi tentang budaya perusahaan dan lingkungan kerja yang kondusif untuk
                                    pembelajaran.
                                </p>
                                <div class="bg-gray-50 p-2 rounded">
                                    <h4 class="font-semibold text-gray-700 mb-1">Indikator lingkungan kerja yang baik:
                                    </h4>
                                    <ul class="text-gray-600 space-y-0.5 list-disc list-inside">
                                        <li>Tim yang collaborative dan supportive</li>
                                        <li>Work-life balance yang sehat</li>
                                        <li>Keterbukaan untuk bertanya dan belajar</li>
                                        <li>Diversity dan inclusion</li>
                                        <li>Komunikasi yang transparan</li>
                                        <li>Fleksibilitas jam kerja</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tip 7 -->
                    <div class="bg-white rounded-lg shadow p-3">
                        <div class="flex items-start">
                            <div
                                class="bg-gradient-to-r from-magnet-deep-ocean-blue to-blue-800 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-3 text-sm flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-800 mb-1">Riset Mendalam tentang Perusahaan
                                </h3>
                                <p class="text-gray-600 mb-1">
                                    Lakukan riset mendalam tentang perusahaan sebelum mengajukan lamaran magang.
                                </p>
                                <div class="bg-gray-50 p-2 rounded">
                                    <h4 class="font-semibold text-gray-700 mb-1">Aspek yang perlu diriset:</h4>
                                    <ul class="text-gray-600 space-y-0.5 list-disc list-inside">
                                        <li>Visi, misi, dan nilai perusahaan</li>
                                        <li>Portofolio produk dan layanan</li>
                                        <li>Teknologi dan tools yang digunakan</li>
                                        <li>Tim dan struktur organisasi</li>
                                        <li>Pencapaian dan penghargaan terbaru</li>
                                        <li>Review dari karyawan di platform seperti Glassdoor</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <footer class="bg-magnet-deep-ocean-blue text-white py-8">
        <div class="container mx-auto px-6 text-center">
            <p class="mb-2">&copy; 2025 Jurusan Teknologi Informasi - Politeknik Negeri Malang</p>
            <p class="text-gray-400 text-sm">Sistem Rekomendasi Magang Berbasis Web</p>
        </div>
    </footer>
</x-layouts.guest.main>