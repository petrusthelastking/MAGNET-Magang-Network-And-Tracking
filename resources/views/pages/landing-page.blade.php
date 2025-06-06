<x-layouts.guest.main>
    <!-- Hero Section -->
    <section class="lg:min-h-screen px-4 sm:px-6 lg:px-8 pt-6 mb-10 sm:mb-10 flex justify-around items-start">
        <div class="container mx-auto">
            <div
                class="bg-gradient-to-br from-magnet-deep-ocean-blue via-blue-900 to-magnet-deep-ocean-blue text-white rounded-2xl pb-32 sm:pb-48 lg:pb-72">
                <x-guest.navbar-new />
                <div class="text-center pt-6 sm:pt-8 px-4">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-medium mb-4 sm:mb-6 italic">
                        Langkah Awal Kariermu<br>Dimulai Di Sini!
                    </h1>
                    <p class="max-w-xs sm:max-w-md mx-auto text-center text-xs sm:text-sm text-white mb-4 sm:mb-6 px-2">
                        Magang nggak harus ribet. Cukup sesuaikan minatmu, dan kami bantu carikan yang paling cocok buat
                        kamu!
                    </p>
                    <flux:button
                        class="text-black! bg-white! rounded-full! hover:bg-gray-200 border-0 text-xs sm:text-sm px-4 py-2 sm:px-6 sm:py-3"
                        href="{{ route('login') }}">
                        <span class="hidden sm:inline">Cari tempat magang impianmu Sekarang</span>
                        <span class="sm:hidden">Cari Magang Sekarang</span>
                    </flux:button>
                </div>
                
            </div>

            <!-- Floating Cards -->
            <div
                class="bg-white rounded-lg p-4 sm:p-6 lg:p-8 shadow-lg -mt-24 sm:-mt-40 lg:-mt-64 relative z-10 mx-16 sm:mx-24 md:mx-32 lg:mx-72">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    <!-- Card 1 - Selalu tampil -->
                    <div
                        class="rounded-lg h-60 w-48 md:h-72 md:w-full flex justify-center items-center overflow-hidden mx-auto">
                        <img src="{{asset('img/card/man-1.png')}}" alt="Mobile Development"
                            class="object-cover w-full h-full">
                    </div>
                    <!-- Card 2 - Tampil mulai md -->
                    <div class="rounded-lg h-72 justify-center items-center overflow-hidden hidden md:flex">
                        <img src="{{asset('img/card/man-2.png')}}" alt="UI UX" class="object-cover w-full h-full">
                    </div>
                    <!-- Card 3 - Tampil mulai lg -->
                    <div class="rounded-lg h-72 justify-center items-center overflow-hidden hidden lg:flex">
                        <img src="{{asset('img/card/woman-1.png')}}" alt="Security Engineer"
                            class="object-cover w-full h-full">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partners Section -->
    <section class="min-h-screen p-4 sm:p-6 lg:p-10 pb-8 flex items-center justify-center" id="partner">
        <div class="w-full flex flex-col">
            <main class="container mx-auto p-2 sm:p-5">
                <div class="text-center mb-8 sm:mb-12 lg:mb-16">
                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold mb-4 sm:mb-6 text-slate-800 px-4">
                        Lebih dari 1.500++ perusahaan mitra bekerja sama dengan JTI POLINEMA
                    </h1>
                    <p class="font-medium text-slate-600 mb-6 sm:mb-8 text-sm sm:text-base px-4">
                        Bergabunglah dengan jaringan mitra kami yang terus berkembang
                    </p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-6 lg:gap-8">
                    @foreach(range(1, 15) as $index)
                        <div class="p-2 sm:p-4 flex items-center justify-center h-20 sm:h-24 lg:h-28">
                            <img src="{{ asset('BRI.png') }}" alt="Partner Logo"
                                class="max-w-full max-h-16 sm:max-h-20 lg:max-h-24 object-contain">
                        </div>
                    @endforeach
                </div>
            </main>
        </div>
    </section>

    <!-- Process Flow Section -->
    <section class="min-h-screen px-4 sm:px-8 lg:px-16 pt-8 sm:pt-12 lg:pt-16 pb-8 flex items-center justify-center"
        id="petunjuk">
        <div class="container mx-auto">
            <div class="text-center mb-8 sm:mb-10 lg:mb-12">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-2 sm:mb-4 text-slate-800">
                    Alur Magang di JTI POLINEMA
                </h1>
                <p class="text-base sm:text-lg text-slate-600 px-4">
                    Langkah mudah menuju pengalaman magang yang tepat sasaran
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                <!-- Step 1 -->
                <div class="flex flex-col items-center text-center">
                    <div
                        class="w-12 h-12 sm:w-16 sm:h-16 bg-blue-500 text-white rounded-full flex items-center justify-center text-lg sm:text-xl font-bold mb-4">
                        1
                    </div>
                    <div
                        class="bg-white rounded-lg p-4 sm:p-6 shadow-lg h-44 sm:h-48 flex flex-col justify-between w-full">
                        <div>
                            <h3 class="font-semibold text-base sm:text-lg mb-2 text-slate-800">Registrasi & Profil</h3>
                            <p class="text-xs sm:text-sm text-slate-600">
                                Daftar akun dan lengkapi profil akademik, kompetensi, serta preferensi lokasi magang
                                Anda
                            </p>
                        </div>
                        <div class="text-blue-500 text-xs font-medium">Login → Lengkapi Data</div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center text-center">
                    <div
                        class="w-12 h-12 sm:w-16 sm:h-16 bg-green-500 text-white rounded-full flex items-center justify-center text-lg sm:text-xl font-bold mb-4">
                        2
                    </div>
                    <div
                        class="bg-white rounded-lg p-4 sm:p-6 shadow-lg h-44 sm:h-48 flex flex-col justify-between w-full">
                        <div>
                            <h3 class="font-semibold text-base sm:text-lg mb-2 text-slate-800">Rekomendasi Cerdas</h3>
                            <p class="text-xs sm:text-sm text-slate-600">
                                Sistem SPK akan menganalisis profil Anda dan memberikan rekomendasi tempat magang yang
                                paling sesuai
                            </p>
                        </div>
                        <div class="text-green-500 text-xs font-medium">AI Matching System</div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center text-center">
                    <div
                        class="w-12 h-12 sm:w-16 sm:h-16 bg-yellow-500 text-white rounded-full flex items-center justify-center text-lg sm:text-xl font-bold mb-4">
                        3
                    </div>
                    <div
                        class="bg-white rounded-lg p-4 sm:p-6 shadow-lg h-44 sm:h-48 flex flex-col justify-between w-full">
                        <div>
                            <h3 class="font-semibold text-base sm:text-lg mb-2 text-slate-800">Pengajuan Magang</h3>
                            <p class="text-xs sm:text-sm text-slate-600">
                                Pilih tempat magang dari rekomendasi dan ajukan lamaran melalui sistem terintegrasi
                            </p>
                        </div>
                        <div class="text-yellow-500 text-xs font-medium">Submit Application</div>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="flex flex-col items-center text-center">
                    <div
                        class="w-12 h-12 sm:w-16 sm:h-16 bg-purple-500 text-white rounded-full flex items-center justify-center text-lg sm:text-xl font-bold mb-4">
                        4
                    </div>
                    <div
                        class="bg-white rounded-lg p-4 sm:p-6 shadow-lg h-44 sm:h-48 flex flex-col justify-between w-full">
                        <div>
                            <h3 class="font-semibold text-base sm:text-lg mb-2 text-slate-800">Monitoring & Evaluasi
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-600">
                                Pantau progres magang dengan dosen pembimbing dan dapatkan sertifikat setelah selesai
                            </p>
                        </div>
                        <div class="text-purple-500 text-xs font-medium">Track Progress</div>
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <div
                class="mt-8 sm:mt-10 lg:mt-12 bg-gradient-to-br from-magnet-deep-ocean-blue via-blue-900 to-magnet-deep-ocean-blue rounded-2xl p-4 sm:p-6">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="text-center md:text-left">
                        <h3 class="text-base sm:text-lg font-semibold text-white mb-1">
                            Fitur Unggulan SPK (Sistem Pendukung Keputusan)
                        </h3>
                        <p class="text-xs sm:text-sm text-white">
                            Algoritma cerdas yang mencocokkan profil mahasiswa dengan kebutuhan perusahaan mitra
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <div
                            class="w-12 h-12 sm:w-16 sm:h-16 bg-blue-100 rounded-full flex items-center justify-center">
                            <flux:icon.lightbulb class="w-6 h-6 sm:w-8 sm:h-8 text-blue-950" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About MAGNET Section -->
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

    <!-- FAQ Section -->
    <section class="min-h-screen px-4 sm:px-8 lg:px-16 pt-8 sm:pt-12 lg:pt-16 pb-8 mb-5 flex justify-center"
        id="kendala">
        <div class="flex flex-col items-center w-full max-w-4xl">
            <h1 class="text-xl sm:text-2xl font-bold mb-6 sm:mb-9 text-center px-4">
                Pertanyaan yang sering ditanyakan
            </h1>
            <div class="flex flex-col gap-4 w-full">
                <div class="collapse collapse-arrow bg-white rounded-2xl shadow">
                    <input type="radio" name="my-accordion-2" checked="checked" />
                    <div class="collapse-title font-semibold text-sm sm:text-base">
                        Apa saja persyaratan umum untuk mengikuti program magang?
                    </div>
                    <div class="collapse-content text-xs sm:text-sm">
                        Umumnya, program magang ditujukan untuk mahasiswa aktif atau lulusan baru (fresh graduate).
                        Persyaratan lain bisa meliputi Indeks Prestasi Kumulatif (IPK) minimum, kemampuan dasar yang
                        relevan dengan bidang magang, serta motivasi yang kuat untuk belajar dan berkembang. Terkadang,
                        ada juga persyaratan jurusan tertentu tergantung posisi yang ditawarkan.
                    </div>
                </div>

                <div class="collapse collapse-arrow bg-white rounded-2xl shadow">
                    <input type="radio" name="my-accordion-2" />
                    <div class="collapse-title font-semibold text-sm sm:text-base">
                        Bagaimana cara mendaftar program magang?
                    </div>
                    <div class="collapse-content text-xs sm:text-sm">
                        Proses pendaftaran magang biasanya dilakukan melalui platform karir online, website resmi
                        perusahaan, atau job fair. Anda perlu menyiapkan dokumen seperti Curriculum Vitae (CV), surat
                        lamaran, transkrip nilai, dan terkadang portofolio. Ikuti alur pendaftaran yang sudah ditentukan
                        oleh penyelenggara magang.
                    </div>
                </div>

                <div class="collapse collapse-arrow bg-white rounded-2xl shadow">
                    <input type="radio" name="my-accordion-2" />
                    <div class="collapse-title font-semibold text-sm sm:text-base">
                        Apakah program magang mendapatkan uang saku?
                    </div>
                    <div class="collapse-content text-xs sm:text-sm">
                        Kebijakan mengenai uang saku atau tunjangan dalam program magang sangat bervariasi. Beberapa
                        perusahaan atau instansi memberikan uang saku sebagai bentuk apresiasi atau bantuan biaya
                        transportasi dan makan, sementara yang lain mungkin tidak memberikannya namun fokus pada
                        pemberian pengalaman dan pembelajaran. Informasi ini biasanya disampaikan saat proses rekrutmen.
                    </div>
                </div>

                <div class="collapse collapse-arrow bg-white rounded-2xl shadow">
                    <input type="radio" name="my-accordion-2" />
                    <div class="collapse-title font-semibold text-sm sm:text-base">
                        Berapa lama durasi program magang pada umumnya?
                    </div>
                    <div class="collapse-content text-xs sm:text-sm">
                        Durasi program magang bisa berbeda-beda, namun umumnya berkisar antara 1 hingga 6 bulan. Ada
                        juga program magang jangka pendek atau yang disesuaikan dengan kalender akademik institusi
                        pendidikan. Durasi spesifik akan diinformasikan oleh pihak penyelenggara.
                    </div>
                </div>

                <div class="collapse collapse-arrow bg-white rounded-2xl shadow">
                    <input type="radio" name="my-accordion-2" />
                    <div class="collapse-title font-semibold text-sm sm:text-base">
                        Apa saja manfaat yang bisa didapatkan dari program magang?
                    </div>
                    <div class="collapse-content text-xs sm:text-sm">
                        Mengikuti program magang memberikan banyak manfaat, seperti mendapatkan pengalaman kerja praktis
                        di dunia profesional, kesempatan untuk menerapkan ilmu yang dipelajari di bangku kuliah,
                        mengembangkan keterampilan teknis (hard skills) dan non-teknis (soft skills), membangun jaringan
                        profesional, serta meningkatkan nilai tambah pada CV Anda.
                    </div>
                </div>

                <!-- Contact CTA -->
                <div
                    class="flex flex-col sm:flex-row justify-between items-center bg-gradient-to-br from-magnet-deep-ocean-blue via-blue-900 to-magnet-deep-ocean-blue! text-white w-full rounded-2xl p-4 sm:p-5 gap-4">
                    <div
                        class="flex flex-col sm:flex-row items-center sm:items-start gap-3 sm:gap-4 text-center sm:text-left">
                        <flux:icon.message-circle-question class="w-8 h-8 sm:w-9 sm:h-9 text-white! flex-shrink-0" />
                        <span class="text-white">
                            <p class="text-sm font-semibold mb-1">Masih memiliki pertanyaan?</p>
                            <p class="text-xs sm:text-sm">Ajukan pertanyaanmu di sini kami akan siap membantumu!</p>
                        </span>
                    </div>
                    <flux:button
                        class="text-magnet-deep-ocean-blue! bg-white! rounded-lg! hover:bg-gray-200 border-0 font-bold! px-4 py-2 text-sm whitespace-nowrap"
                        href="#">
                        Ajukan Pertanyaan
                    </flux:button>
                </div>
            </div>
        </div>
    </section>

    <x-guest.footer />
</x-layouts.guest.main>