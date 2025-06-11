<x-layouts.guest.main>
    <div class="min-h-screen px-6 pt-6 flex flex-col gap-6 mb-12">
        <div>
            <flux:button variant="primary" class="bg-magnet-sky-teal m-2 sm:m-4" href="{{ route('guest.landing-page') }}"
                icon="arrow-big-left-dash" size="sm">Kembali</flux:button>
        </div>

        <!-- Main Container - Responsive padding -->
        <div class="space-y-6 px-4 sm:px-8 md:px-16 lg:px-28">

            <!-- Content Container - Responsive padding -->
            <div id="aturan-magang-content" class="bg-white rounded-lg shadow-sm border py-6 px-4 sm:py-8 sm:px-8 md:px-12 lg:px-20">

                <!-- Header Section - Responsive -->
                <div class="text-center mb-6 sm:mb-8 border-b pb-4 sm:pb-6">
                    <div class="mb-4">
                        <img src={{asset('img/logo/polinema.png')}} alt="Logo Polinema" class="mx-auto h-12 sm:h-16 mb-3" />
                    </div>
                    <h1 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">POLITEKNIK NEGERI MALANG</h1>
                    <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-1">JURUSAN TEKNOLOGI INFORMASI</h2>
                    <h3 class="text-sm sm:text-base font-medium text-gray-700">ATURAN MAGANG</h3>
                    <p class="text-xs sm:text-sm text-gray-600 mt-2">D4 TEKNIK INFORMATIKA</p>
                </div>

                <!-- Ketentuan Umum Section -->
                <section class="mb-6 sm:mb-8">
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 mb-3 sm:mb-4 border-l-4 border-magnet-sky-teal pl-3">
                        Ketentuan Umum
                    </h2>

                    <div class="space-y-4 text-xs sm:text-sm text-gray-700 leading-relaxed">
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Definisi</h3>
                            <ol class="list-decimal list-inside space-y-1 ml-2 sm:ml-4">
                                <li class="leading-relaxed pr-2">Magang adalah kegiatan belajar yang dilaksanakan di dunia kerja dalam jangka waktu
                                    tertentu secara berkesinambungan.</li>
                                <li class="leading-relaxed pr-2">Kerja Praktek adalah implementasi secara terpadu antara pengetahuan dan keterampilan
                                    yang diperoleh dalam bentuk kompetensi kerja nyata.</li>
                                <li class="leading-relaxed pr-2">Mahasiswa adalah peserta didik yang terdaftar di Program Studi D4 Teknik Informatika
                                    Jurusan Teknologi Informasi.</li>
                                <li class="leading-relaxed pr-2">Perusahaan Mitra adalah institusi/perusahaan yang bekerjasama dengan Jurusan dalam
                                    penyelenggaraan magang.</li>
                            </ol>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Tujuan</h3>
                            <p class="mb-2">Magang dan Kerja Praktek bertujuan untuk:</p>
                            <ol class="list-decimal list-inside space-y-1 ml-2 sm:ml-4">
                                <li class="leading-relaxed pr-2">Memberikan pengalaman nyata kepada mahasiswa dalam dunia kerja yang sesuai dengan bidang
                                    studinya.</li>
                                <li class="leading-relaxed pr-2">Meningkatkan keterampilan praktis dan profesionalisme mahasiswa.</li>
                                <li class="leading-relaxed pr-2">Mempersiapkan mahasiswa menghadapi tantangan dunia kerja setelah lulus.</li>
                                <li class="leading-relaxed pr-2">Membangun jejaring kerjasama antara institusi pendidikan dengan dunia industri.</li>
                            </ol>
                        </div>
                    </div>
                </section>

                <!-- Persyaratan Peserta Section -->
                <section class="mb-6 sm:mb-8">
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 mb-3 sm:mb-4 border-l-4 border-magnet-sky-teal pl-3">
                        Persyaratan Peserta
                    </h2>

                    <div class="space-y-4 text-xs sm:text-sm text-gray-700 leading-relaxed">
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Persyaratan Akademik</h3>
                            <ol class="list-decimal list-inside space-y-1 ml-2 sm:ml-4">
                                <li class="leading-relaxed pr-2">Mahasiswa telah menempuh minimal 100 SKS dengan IPK minimal 2.75.</li>
                                <li class="leading-relaxed pr-2">Telah lulus mata kuliah prasyarat yang ditetapkan oleh program studi.</li>
                                <li class="leading-relaxed pr-2">Tidak memiliki nilai D atau E pada mata kuliah inti program studi.</li>
                                <li class="leading-relaxed pr-2">Memiliki sertifikat kompetensi atau keahlian yang relevan (jika diperlukan).</li>
                            </ol>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Persyaratan Administratif</h3>
                            <ol class="list-decimal list-inside space-y-1 ml-2 sm:ml-4">
                                <li class="leading-relaxed pr-2">Mengisi formulir pendaftaran magang melalui sistem yang telah disediakan.</li>
                                <li class="leading-relaxed pr-2">Melengkapi profil akademik dan kompetensi dalam sistem.</li>
                                <li class="leading-relaxed pr-2">Mengunggah dokumen pendukung (CV, transkrip nilai, sertifikat).</li>
                                <li class="leading-relaxed pr-2">Mendapatkan persetujuan dari dosen pembimbing akademik.</li>
                            </ol>
                        </div>
                    </div>
                </section>

                <!-- Proses Pendaftaran dan Penempatan Section -->
                <section class="mb-6 sm:mb-8">
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 mb-3 sm:mb-4 border-l-4 border-magnet-sky-teal pl-3">
                        Proses Pendaftaran dan Penempatan
                    </h2>

                    <div class="space-y-4 text-xs sm:text-sm text-gray-700 leading-relaxed">
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Alur Pendaftaran</h3>
                            <ol class="list-decimal list-inside space-y-1 ml-2 sm:ml-4">
                                <li class="leading-relaxed pr-2">Mahasiswa login ke Sistem Rekomendasi Magang berbasis web.</li>
                                <li class="leading-relaxed pr-2">Melengkapi profil akademik, kompetensi, dan preferensi magang.</li>
                                <li class="leading-relaxed pr-2">Sistem memberikan rekomendasi tempat magang berdasarkan profil mahasiswa.</li>
                                <li class="leading-relaxed pr-2">Mahasiswa memilih dan mengajukan lamaran melalui sistem.</li>
                                <li class="leading-relaxed pr-2">Admin memverifikasi dan meneruskan lamaran ke perusahaan mitra.</li>
                                <li class="leading-relaxed pr-2">Perusahaan mitra melakukan seleksi dan memberikan keputusan.</li>
                                <li class="leading-relaxed pr-2">Admin mengkonfirmasi penempatan melalui sistem.</li>
                            </ol>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Sistem Rekomendasi</h3>
                            <ol class="list-decimal list-inside space-y-1 ml-2 sm:ml-4">
                                <li class="leading-relaxed pr-2">Sistem akan mencocokkan profil mahasiswa dengan kebutuhan perusahaan mitra.</li>
                                <li class="leading-relaxed pr-2">Rekomendasi didasarkan pada bidang studi, kompetensi, keahlian, dan preferensi lokasi.
                                </li>
                                <li class="leading-relaxed pr-2">Mahasiswa dapat melihat detail lowongan termasuk persyaratan dan deskripsi pekerjaan.
                                </li>
                                <li class="leading-relaxed pr-2">Sistem hanya memberikan rekomendasi, tidak menjamin penerimaan di perusahaan.</li>
                            </ol>
                        </div>
                    </div>
                </section>

                <!-- Pelaksanaan Magang Section -->
                <section class="mb-6 sm:mb-8">
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 mb-3 sm:mb-4 border-l-4 border-magnet-sky-teal pl-3">
                        Pelaksanaan Magang
                    </h2>

                    <div class="space-y-4 text-xs sm:text-sm text-gray-700 leading-relaxed">
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Durasi dan Waktu</h3>
                            <ol class="list-decimal list-inside space-y-1 ml-2 sm:ml-4">
                                <li class="leading-relaxed pr-2">Durasi magang minimal 4 bulan atau sesuai dengan ketentuan program studi.</li>
                                <li class="leading-relaxed pr-2">Jam kerja mengikuti ketentuan perusahaan mitra (minimal 8 jam per hari).</li>
                                <li class="leading-relaxed pr-2">Mahasiswa wajib mengikuti seluruh jadwal yang ditetapkan perusahaan.</li>
                                <li class="leading-relaxed pr-2">Perpanjangan waktu magang dapat dilakukan atas persetujuan semua pihak.</li>
                            </ol>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Kewajiban Mahasiswa</h3>
                            <ol class="list-decimal list-inside space-y-1 ml-2 sm:ml-4">
                                <li class="leading-relaxed pr-2">Mentaati semua peraturan dan tata tertib perusahaan mitra.</li>
                                <li class="leading-relaxed pr-2">Melaksanakan tugas dengan penuh tanggung jawab dan profesional.</li>
                                <li class="leading-relaxed pr-2">Mengisi log harian/mingguan kegiatan melalui sistem monitoring.</li>
                                <li class="leading-relaxed pr-2">Berkonsultasi secara berkala dengan dosen pembimbing.</li>
                                <li class="leading-relaxed pr-2">Menjaga nama baik institusi dan diri sendiri.</li>
                                <li class="leading-relaxed pr-2">Menyusun dan menyerahkan laporan magang sesuai format yang ditentukan.</li>
                            </ol>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Monitoring dan Evaluasi</h3>
                            <ol class="list-decimal list-inside space-y-1 ml-2 sm:ml-4">
                                <li class="leading-relaxed pr-2">Dosen pembimbing melakukan monitoring progres mahasiswa secara berkala.</li>
                                <li class="leading-relaxed pr-2">Mahasiswa wajib melaporkan kendala atau masalah yang dihadapi.</li>
                                <li class="leading-relaxed pr-2">Evaluasi dilakukan berdasarkan penilaian dari pembimbing lapangan dan dosen pembimbing.
                                </li>
                                <li class="leading-relaxed pr-2">Sistem akan mencatat seluruh aktivitas monitoring untuk keperluan evaluasi.</li>
                            </ol>
                        </div>
                    </div>
                </section>

                <!-- Penilaian dan Pelaporan Section -->
                <section class="mb-6 sm:mb-8">
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 mb-3 sm:mb-4 border-l-4 border-magnet-sky-teal pl-3">
                        Penilaian dan Pelaporan
                    </h2>

                    <div class="space-y-4 text-xs sm:text-sm text-gray-700 leading-relaxed">
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Komponen Penilaian</h3>
                            <ol class="list-decimal list-inside space-y-1 ml-2 sm:ml-4">
                                <li class="leading-relaxed pr-2">Penilaian dari pembimbing lapangan (40%)</li>
                                <li class="leading-relaxed pr-2">Penilaian laporan magang oleh dosen pembimbing (30%)</li>
                                <li class="leading-relaxed pr-2">Presentasi hasil magang (20%)</li>
                                <li class="leading-relaxed pr-2">Keaktifan monitoring dan log kegiatan (10%)</li>
                            </ol>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Dokumen Pelaporan</h3>
                            <ol class="list-decimal list-inside space-y-1 ml-2 sm:ml-4">
                                <li class="leading-relaxed pr-2">Laporan harian/mingguan kegiatan melalui sistem.</li>
                                <li class="leading-relaxed pr-2">Laporan akhir magang sesuai template yang disediakan.</li>
                                <li class="leading-relaxed pr-2">Sertifikat atau surat keterangan dari perusahaan mitra.</li>
                                <li class="leading-relaxed pr-2">Evaluasi dan feedback pengalaman magang.</li>
                            </ol>
                        </div>
                    </div>
                </section>

                <!-- Ketentuan Lain-lain Section -->
                <section class="mb-6">
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 mb-3 sm:mb-4 border-l-4 border-magnet-sky-teal pl-3">
                        Ketentuan Lain-lain
                    </h2>

                    <div class="space-y-4 text-xs sm:text-sm text-gray-700 leading-relaxed">
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Sanksi</h3>
                            <ol class="list-decimal list-inside space-y-1 ml-2 sm:ml-4">
                                <li class="leading-relaxed pr-2">Mahasiswa yang melanggar ketentuan dapat dikenai sanksi berupa teguran, peringatan, atau
                                    penghentian magang.</li>
                                <li class="leading-relaxed pr-2">Pelanggaran berat dapat berakibat pada kegagalan dalam mata kuliah magang.</li>
                            </ol>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Perubahan Aturan</h3>
                            <p class="pr-2">Aturan ini dapat diubah sewaktu-waktu sesuai kebutuhan dan perkembangan program studi dengan
                                persetujuan pimpinan jurusan.</p>
                        </div>
                    </div>
                </section>

                <!-- Footer Section - Responsive -->
                <div class="text-center pt-4 sm:pt-6 border-t">
                    <p class="text-xs sm:text-sm text-gray-600 px-2">
                        Ditetapkan di Malang<br>
                        Tanggal: {{ date('d F Y') }}<br><br>
                        <strong>Ketua Magnet</strong><br>
                        Politeknik Negeri Malang
                    </p>
                </div>
            </div>
        </div>
    </div>

    <x-guest.footer />
</x-layouts.guest.main>
