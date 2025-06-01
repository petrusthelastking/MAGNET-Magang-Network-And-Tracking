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
                        <img src="{{asset('Mobdev.png')}}" alt="Mobile Development" class="object-cover w-full h-full">
                    </div>
                    <div class="rounded-lg h-72 flex justify-center items-center overflow-hidden">
                        <img src="{{asset('UI UX.png')}}" alt="UI UX" class="object-cover w-full h-full">
                    </div>
                    <div class="rounded-lg h-72 flex justify-center items-center overflow-hidden">
                        <img src="{{asset('sectr.png')}}" alt="Security Engineer" class="object-cover w-full h-full">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="h-screen p-10 pb-8 flex items-center justify-center" id="alur">
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

    <section class="h-screen px-16 pt-16 pb-8 flex items-center justify-center" id="tata-tertib">


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
                <div class="flex justify-between bg-magnet-deep-ocean-blue text-white w-full rounded-2xl p-5">
                    <div class="flex items-center gap-4">
                        <flux:icon.message-circle-question class="w-9 h-9 text-white!" />
                        <span class="text-white">
                            <p class="text-sm font-semibold mb-1">Masih memiliki pertanyaan ?</p>
                            <p class="text-sm">Ajukan pertanyaanmu di sini kami akan siap membantumu!</p>
                        </span>
                    </div>
                    <flux:button class="text-black! bg-white! rounded-lg! hover:bg-gray-200 border-0 font-bold!"
                        href="#">Ajukan
                        Pertanyaan</flux:button>
                </div>
            </div>
        </div>
    </section>

    <x-guest.footer />
</x-layouts.guest.main>