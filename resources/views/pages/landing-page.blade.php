<x-layouts.guest.main>
    <section class="h-screen px-6 pt-6 flex justify-around items-start">
        <div class="container mx-auto">
            <div class="bg-magnet-deep-ocean-blue text-white rounded-2xl pb-72">
                <x-guest.navbar-new />
                <div class="text-center pt-8">
                    <h1 class="text-3xl font-medium mb-6 italic">Langkah Awal Kariermu<br>Dimulai Di Sini!</h1>

                    <p class="max-w-md mx-auto text-center text-sm text-white mb-6">
                        Magang nggak harus ribet. Cukup sesuaikan minatmu, dan kami bantu carikan yang paling cocok buat
                        kamu!
                    </p>
                    <flux:button class="text-black! bg-white! rounded-full! hover:bg-gray-200 border-0"
                        href="{{ route('login') }}">Cari
                        tempat magang impianmu Sekarang</flux:button>
                </div>
            </div>

            <div class="bg-white rounded-lg p-8 shadow-lg -mt-64 relative z-10 mx-20 md:mx-72">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="rounded-lg h-72 flex justify-center items-center overflow-hidden">
                        <img src="{{asset('img/card/man-1.png')}}" alt="Mobile Development" class="object-cover w-full h-full">
                    </div>
                    <div class="rounded-lg h-72 flex justify-center items-center overflow-hidden">
                        <img src="{{asset('img/card/man-2.png')}}" alt="UI UX designer" class="object-cover w-full h-full">
                    </div>
                    <div class="rounded-lg h-72 flex justify-center items-center overflow-hidden">
                        <img src="{{asset('img/card/woman-1.png')}}" alt="Security Engineer" class="object-cover w-full h-full">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="h-screen p-10 pb-8 flex items-center justify-center" id="partner">
        <div class="w-full flex flex-col">

            <main class="container mx-auto p-5">
                <div class="text-center mb-16">
                    <h1 class="text-2xl font-bold mb-6 text-slate-800">Lebih dari 1.500++ perusahaan mitra
                        bekerja sama dengan JTI POLINEMA</h1>
                    <p class=" font-medium text-slate-600 mb-8">Bergabunglah dengan jaringan mitra
                        kami yang terus berkembang</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                    @foreach(range(1, 15) as $index)
                        <div class="p-4  flex items-center justify-center h-28">
                            <img src="{{ asset('BRI.png') }}" alt="Partner Logo" class="max-w-full max-h-24 object-contain">
                        </div>
                    @endforeach
                </div>
            </main>
        </div>
    </section>

    <section class="h-screen px-16 pt-16 pb-8 flex items-center justify-center" id="petunjuk">
        <div class="container mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-3xl font-bold mb-4 text-slate-800">Alur Magang di JTI POLINEMA</h1>
                <p class="text-lg text-slate-600">Langkah mudah menuju pengalaman magang yang tepat sasaran</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Step 1 -->
                <div class="flex flex-col items-center text-center">
                    <div
                        class="w-16 h-16 bg-blue-500 text-white rounded-full flex items-center justify-center text-xl font-bold mb-4">
                        1
                    </div>
                    <div class="bg-white rounded-lg p-6 shadow-lg h-48 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-lg mb-2 text-slate-800">Registrasi & Profil</h3>
                            <p class="text-sm text-slate-600">Daftar akun dan lengkapi profil akademik, kompetensi,
                                serta preferensi lokasi magang Anda</p>
                        </div>
                        <div class="text-blue-500 text-xs font-medium">Login → Lengkapi Data</div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center text-center">
                    <div
                        class="w-16 h-16 bg-green-500 text-white rounded-full flex items-center justify-center text-xl font-bold mb-4">
                        2
                    </div>
                    <div class="bg-white rounded-lg p-6 shadow-lg h-48 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-lg mb-2 text-slate-800">Rekomendasi Cerdas</h3>
                            <p class="text-sm text-slate-600">Sistem SPK akan menganalisis profil Anda dan memberikan
                                rekomendasi tempat magang yang paling sesuai</p>
                        </div>
                        <div class="text-green-500 text-xs font-medium">AI Matching System</div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center text-center">
                    <div
                        class="w-16 h-16 bg-yellow-500 text-white rounded-full flex items-center justify-center text-xl font-bold mb-4">
                        3
                    </div>
                    <div class="bg-white rounded-lg p-6 shadow-lg h-48 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-lg mb-2 text-slate-800">Pengajuan Magang</h3>
                            <p class="text-sm text-slate-600">Pilih tempat magang dari rekomendasi dan ajukan lamaran
                                melalui sistem terintegrasi</p>
                        </div>
                        <div class="text-yellow-500 text-xs font-medium">Submit Application</div>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="flex flex-col items-center text-center">
                    <div
                        class="w-16 h-16 bg-purple-500 text-white rounded-full flex items-center justify-center text-xl font-bold mb-4">
                        4
                    </div>
                    <div class="bg-white rounded-lg p-6 shadow-lg h-48 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-lg mb-2 text-slate-800">Monitoring & Evaluasi</h3>
                            <p class="text-sm text-slate-600">Pantau progres magang dengan dosen pembimbing dan dapatkan
                                sertifikat setelah selesai</p>
                        </div>
                        <div class="text-purple-500 text-xs font-medium">Track Progress</div>
                    </div>
                </div>
            </div>
            <!-- Additional Info -->
            <div class="mt-12 bg-gradient-to-r from-magnet-deep-ocean-blue to-magnet-def-indigo-300 rounded-2xl p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-1">Fitur Unggulan SPK (Sistem Pendukung
                            Keputusan)</h3>
                        <p class="text-sm text-white">Algoritma cerdas yang mencocokkan profil mahasiswa dengan
                            kebutuhan perusahaan mitra</p>
                    </div>
                    <div class="hidden md:block">
                        <div
                            class="w-16 h-16 bg-indigo-800 rounded-full flex items-center justify-center">
                            <flux:icon.lightbulb class="w-8 h-8 text-white" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="h-screen px-16 pt-16 pb-8 flex items-center justify-center" id="about">
        <div class="container mx-auto">
            <div class="text-center mb-8">
                <h1 class="text-2xl md:text-3xl font-bold mb-2 text-slate-800">MAGNET</h1>
                <p class="text-base md:text-lg text-blue-600 font-semibold mb-1">Magang Network And Tracking</p>
                <p class="text-sm md:text-base text-slate-600 max-w-2xl mx-auto">
                    Sistem rekomendasi magang berbasis web yang menghubungkan mahasiswa JTI POLINEMA dengan perusahaan
                    mitra terpercaya
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                <!-- Left Side - Features -->
                <div class="space-y-5">
                    <div class="bg-white rounded-xl p-6 shadow-lg border-l-4 border-blue-500">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">                                
                                <flux:icon.zap class="w-6 h-6 text-blue-600" />
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg text-slate-800 mb-2">Rekomendasi Berbasis SPK</h3>
                                <p class="text-slate-600">Sistem cerdas yang menganalisis kompetensi, keahlian, dan
                                    preferensi untuk memberikan rekomendasi tempat magang yang paling sesuai</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-lg border-l-4 border-green-500">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <flux:icon.handshake class="w-6 h-6 text-green-600" />
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg text-slate-800 mb-2">Network Perusahaan Mitra</h3>
                                <p class="text-slate-600">Terhubung dengan 1.500++ perusahaan mitra yang siap menerima
                                    mahasiswa magang dari berbagai bidang teknologi informasi</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-lg border-l-4 border-purple-500">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                {{-- <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg> --}}
                                <flux:icon.chart-no-axes-combined class="w-6 h-6 text-purple-600" />
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg text-slate-800 mb-2">Real-time Tracking</h3>
                                <p class="text-slate-600">Monitor progres magang secara real-time dengan sistem
                                    pelaporan terintegrasi antara mahasiswa, dosen pembimbing, dan admin</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Stats & CTA -->
                <div class="space-y-6">
                    <div class="bg-white rounded-xl p-6 shadow">
                        <h3 class="text-xl font-bold text-slate-800 mb-4 text-center">MAGNET dalam Angka</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600 mb-1">1.500+</div>
                                <div class="text-xs text-slate-600">Perusahaan Mitra</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600 mb-1">95%</div>
                                <div class="text-xs text-slate-600">Tingkat Kecocokan</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-purple-600 mb-1">3</div>
                                <div class="text-xs text-slate-600">Jenis Pengguna</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-orange-600 mb-1">6</div>
                                <div class="text-xs text-slate-600">Bulan Durasi</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-magnet-deep-ocean-blue to-indigo-800 text-white rounded-xl p-6 text-center">
                        <h3 class="text-base font-semibold mb-2">Siap Memulai Perjalanan Magang?</h3>
                        <p class="text-sm text-blue-100 mb-4">
                            Bergabunglah dengan MAGNET dan temukan tempat magang impianmu dengan teknologi SPK terdepan
                        </p>
                        <div class="space-y-2">
                            <flux:button class="w-full bg-white text-blue-600! font-semibold! py-2 px-4 rounded hover:bg-gray-100! transition duration-200!"
                                href="{{ route('login') }}">Mulai Sekarang</flux:button>
                            {{-- <button
                                class="w-full bg-white text-blue-600 font-semibold py-2 px-4 rounded hover:bg-gray-100 transition duration-200">
                                Mulai Sekarang
                            </button> --}}
                            <p class="text-xs text-blue-200">*Khusus mahasiswa JTI POLINEMA</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="h-screen px-16 pt-16 pb-8 flex justify-center" id="kendala">
        <div class="flex flex-col items-center w-full">
            <h1 class="text-2xl font-bold mb-9">Pertanyaan yang sering ditanyakan</h1>
            <div class="flex flex-col gap-4 w-full">
                <div class="collapse collapse-arrow bg-white rounded-2xl shadow">
                    <input type="radio" name="my-accordion-2" checked="checked" />
                    <div class="collapse-title font-semibold">Apa saja persyaratan umum untuk mengikuti program magang?
                    </div>
                    <div class="collapse-content text-sm">Umumnya, program magang ditujukan untuk mahasiswa aktif atau
                        lulusan baru (fresh graduate). Persyaratan lain bisa meliputi Indeks Prestasi Kumulatif (IPK)
                        minimum, kemampuan dasar yang relevan dengan bidang magang, serta motivasi yang kuat untuk
                        belajar dan berkembang. Terkadang, ada juga persyaratan jurusan tertentu tergantung posisi yang
                        ditawarkan.
                    </div>
                </div>
                <div class="collapse collapse-arrow bg-white rounded-2xl shadow">
                    <input type="radio" name="my-accordion-2" />
                    <div class="collapse-title font-semibold">Bagaimana cara mendaftar program magang?</div>
                    <div class="collapse-content text-sm">Proses pendaftaran magang biasanya dilakukan melalui platform
                        karir online, website resmi perusahaan, atau job fair. Anda perlu menyiapkan dokumen seperti
                        Curriculum Vitae (CV), surat lamaran, transkrip nilai, dan terkadang portofolio. Ikuti alur
                        pendaftaran yang sudah ditentukan oleh penyelenggara magang.</div>
                </div>
                <div class="collapse collapse-arrow bg-white rounded-2xl shadow">
                    <input type="radio" name="my-accordion-2" />
                    <div class="collapse-title font-semibold">Apakah program magang mendapatkan uang saku?</div>
                    <div class="collapse-content text-sm">Kebijakan mengenai uang saku atau tunjangan dalam program
                        magang sangat bervariasi. Beberapa perusahaan atau instansi memberikan uang saku sebagai bentuk
                        apresiasi atau bantuan biaya transportasi dan makan, sementara yang lain mungkin tidak
                        memberikannya namun fokus pada pemberian pengalaman dan pembelajaran. Informasi ini biasanya
                        disampaikan saat proses rekrutmen.</div>
                </div>
                <div class="collapse collapse-arrow bg-white rounded-2xl shadow">
                    <input type="radio" name="my-accordion-2" />
                    <div class="collapse-title font-semibold">Berapa lama durasi program magang pada umumnya?</div>
                    <div class="collapse-content text-sm">Durasi program magang bisa berbeda-beda, namun umumnya
                        berkisar antara 1 hingga 6 bulan. Ada juga program magang jangka pendek atau yang disesuaikan
                        dengan kalender akademik institusi pendidikan. Durasi spesifik akan diinformasikan oleh pihak
                        penyelenggara.</div>
                </div>
                <div class="collapse collapse-arrow bg-white rounded-2xl shadow">
                    <input type="radio" name="my-accordion-2" />
                    <div class="collapse-title font-semibold">Apa saja manfaat yang bisa didapatkan dari program magang?
                    </div>
                    <div class="collapse-content text-sm">Mengikuti program magang memberikan banyak manfaat, seperti
                        mendapatkan pengalaman kerja praktis di dunia profesional, kesempatan untuk menerapkan ilmu yang
                        dipelajari di bangku kuliah, mengembangkan keterampilan teknis (hard skills) dan non-teknis
                        (soft skills), membangun jaringan profesional, serta meningkatkan nilai tambah pada CV Anda.
                    </div>
                </div>
                <div class="flex justify-between bg-gradient-to-r from-magnet-deep-ocean-blue to-indigo-800! text-white w-full rounded-2xl p-5">
                    <div class="flex items-center gap-4">
                        <flux:icon.message-circle-question class="w-9 h-9 text-white!" />
                        <span class="text-white">
                            <p class="text-sm font-semibold mb-1">Masih memiliki pertanyaan ?</p>
                            <p class="text-sm">Ajukan pertanyaanmu di sini kami akan siap membantumu!</p>
                        </span>
                    </div>
                    <flux:button class="text-magnet-deep-ocean-blue! bg-white! rounded-lg! hover:bg-gray-200 border-0 font-bold!"
                        href="#">Ajukan
                        Pertanyaan</flux:button>
                </div>
            </div>
        </div>
    </section>

    <x-guest.footer />
</x-layouts.guest.main>
