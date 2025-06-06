<x-layouts.guest.main>
    <flux:button variant="primary" class="bg-magnet-sky-teal m-4" href="{{ route('landing-page') }}"
        icon="arrow-big-left-dash" size="sm">Kembali</flux:button>
    <div class="space-y-6 px-28">


        <div id="aturan-magang-content" class="bg-white rounded-lg shadow-sm border py-8 px-20">

            <div class="text-center mb-8 border-b pb-6">
                <div class="mb-4">
                    <img src={{asset('polinema.png')}} alt="Logo Polinema" class="mx-auto h-16 mb-3" />
                </div>
                <h1 class="text-xl font-bold text-gray-900 mb-2">POLITEKNIK NEGERI MALANG</h1>
                <h2 class="text-lg font-semibold text-gray-800 mb-1">JURUSAN TEKNOLOGI INFORMASI</h2>
                <h3 class="text-base font-medium text-gray-700">ATURAN MAGANG</h3>
                <p class="text-sm text-gray-600 mt-2">D4 TEKNIK INFORMATIKA</p>
            </div>

            <section class="mb-8">
                <h2 class="text-lg font-bold text-gray-900 mb-4 border-l-4 border-magnet-sky-teal pl-3">
                    Ketentuan Umum
                </h2>

                <div class="space-y-4 text-sm text-gray-700 leading-relaxed">
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2">Definisi</h3>
                        <ol class="list-decimal list-inside space-y-1 ml-4">
                            <li>Magang adalah kegiatan belajar yang dilaksanakan di dunia kerja dalam jangka waktu
                                tertentu secara berkesinambungan.</li>
                            <li>Kerja Praktek adalah implementasi secara terpadu antara pengetahuan dan keterampilan
                                yang diperoleh dalam bentuk kompetensi kerja nyata.</li>
                            <li>Mahasiswa adalah peserta didik yang terdaftar di Program Studi D4 Teknik Informatika
                                Jurusan Teknologi Informasi.</li>
                            <li>Perusahaan Mitra adalah institusi/perusahaan yang bekerjasama dengan Jurusan dalam
                                penyelenggaraan magang.</li>
                        </ol>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2">Tujuan</h3>
                        <p class="mb-2">Magang dan Kerja Praktek bertujuan untuk:</p>
                        <ol class="list-decimal list-inside space-y-1 ml-4">
                            <li>Memberikan pengalaman nyata kepada mahasiswa dalam dunia kerja yang sesuai dengan bidang
                                studinya.</li>
                            <li>Meningkatkan keterampilan praktis dan profesionalisme mahasiswa.</li>
                            <li>Mempersiapkan mahasiswa menghadapi tantangan dunia kerja setelah lulus.</li>
                            <li>Membangun jejaring kerjasama antara institusi pendidikan dengan dunia industri.</li>
                        </ol>
                    </div>
                </div>
            </section>

            <section class="mb-8">
                <h2 class="text-lg font-bold text-gray-900 mb-4 border-l-4 border-magnet-sky-teal pl-3">
                    Persyaratan Peserta
                </h2>

                <div class="space-y-4 text-sm text-gray-700 leading-relaxed">
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2">Persyaratan Akademik</h3>
                        <ol class="list-decimal list-inside space-y-1 ml-4">
                            <li>Mahasiswa telah menempuh minimal 100 SKS dengan IPK minimal 2.75.</li>
                            <li>Telah lulus mata kuliah prasyarat yang ditetapkan oleh program studi.</li>
                            <li>Tidak memiliki nilai D atau E pada mata kuliah inti program studi.</li>
                            <li>Memiliki sertifikat kompetensi atau keahlian yang relevan (jika diperlukan).</li>
                        </ol>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2">Persyaratan Administratif</h3>
                        <ol class="list-decimal list-inside space-y-1 ml-4">
                            <li>Mengisi formulir pendaftaran magang melalui sistem yang telah disediakan.</li>
                            <li>Melengkapi profil akademik dan kompetensi dalam sistem.</li>
                            <li>Mengunggah dokumen pendukung (CV, transkrip nilai, sertifikat).</li>
                            <li>Mendapatkan persetujuan dari dosen pembimbing akademik.</li>
                        </ol>
                    </div>
                </div>
            </section>

            <section class="mb-8">
                <h2 class="text-lg font-bold text-gray-900 mb-4 border-l-4 border-magnet-sky-teal pl-3">
                    Proses Pendaftaran dan Penempatan
                </h2>

                <div class="space-y-4 text-sm text-gray-700 leading-relaxed">
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2">Alur Pendaftaran</h3>
                        <ol class="list-decimal list-inside space-y-1 ml-4">
                            <li>Mahasiswa login ke Sistem Rekomendasi Magang berbasis web.</li>
                            <li>Melengkapi profil akademik, kompetensi, dan preferensi magang.</li>
                            <li>Sistem memberikan rekomendasi tempat magang berdasarkan profil mahasiswa.</li>
                            <li>Mahasiswa memilih dan mengajukan lamaran melalui sistem.</li>
                            <li>Admin memverifikasi dan meneruskan lamaran ke perusahaan mitra.</li>
                            <li>Perusahaan mitra melakukan seleksi dan memberikan keputusan.</li>
                            <li>Admin mengkonfirmasi penempatan melalui sistem.</li>
                        </ol>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2">Sistem Rekomendasi</h3>
                        <ol class="list-decimal list-inside space-y-1 ml-4">
                            <li>Sistem akan mencocokkan profil mahasiswa dengan kebutuhan perusahaan mitra.</li>
                            <li>Rekomendasi didasarkan pada bidang studi, kompetensi, keahlian, dan preferensi lokasi.
                            </li>
                            <li>Mahasiswa dapat melihat detail lowongan termasuk persyaratan dan deskripsi pekerjaan.
                            </li>
                            <li>Sistem hanya memberikan rekomendasi, tidak menjamin penerimaan di perusahaan.</li>
                        </ol>
                    </div>
                </div>
            </section>

            <section class="mb-8">
                <h2 class="text-lg font-bold text-gray-900 mb-4 border-l-4 border-magnet-sky-teal pl-3">
                    Pelaksanaan Magang
                </h2>

                <div class="space-y-4 text-sm text-gray-700 leading-relaxed">
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2">Durasi dan Waktu</h3>
                        <ol class="list-decimal list-inside space-y-1 ml-4">
                            <li>Durasi magang minimal 4 bulan atau sesuai dengan ketentuan program studi.</li>
                            <li>Jam kerja mengikuti ketentuan perusahaan mitra (minimal 8 jam per hari).</li>
                            <li>Mahasiswa wajib mengikuti seluruh jadwal yang ditetapkan perusahaan.</li>
                            <li>Perpanjangan waktu magang dapat dilakukan atas persetujuan semua pihak.</li>
                        </ol>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2">Kewajiban Mahasiswa</h3>
                        <ol class="list-decimal list-inside space-y-1 ml-4">
                            <li>Mentaati semua peraturan dan tata tertib perusahaan mitra.</li>
                            <li>Melaksanakan tugas dengan penuh tanggung jawab dan profesional.</li>
                            <li>Mengisi log harian/mingguan kegiatan melalui sistem monitoring.</li>
                            <li>Berkonsultasi secara berkala dengan dosen pembimbing.</li>
                            <li>Menjaga nama baik institusi dan diri sendiri.</li>
                            <li>Menyusun dan menyerahkan laporan magang sesuai format yang ditentukan.</li>
                        </ol>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2">Monitoring dan Evaluasi</h3>
                        <ol class="list-decimal list-inside space-y-1 ml-4">
                            <li>Dosen pembimbing melakukan monitoring progres mahasiswa secara berkala.</li>
                            <li>Mahasiswa wajib melaporkan kendala atau masalah yang dihadapi.</li>
                            <li>Evaluasi dilakukan berdasarkan penilaian dari pembimbing lapangan dan dosen pembimbing.
                            </li>
                            <li>Sistem akan mencatat seluruh aktivitas monitoring untuk keperluan evaluasi.</li>
                        </ol>
                    </div>
                </div>
            </section>

            <section class="mb-8">
                <h2 class="text-lg font-bold text-gray-900 mb-4 border-l-4 border-magnet-sky-teal pl-3">
                    Penilaian dan Pelaporan
                </h2>

                <div class="space-y-4 text-sm text-gray-700 leading-relaxed">
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2">Komponen Penilaian</h3>
                        <ol class="list-decimal list-inside space-y-1 ml-4">
                            <li>Penilaian dari pembimbing lapangan (40%)</li>
                            <li>Penilaian laporan magang oleh dosen pembimbing (30%)</li>
                            <li>Presentasi hasil magang (20%)</li>
                            <li>Keaktifan monitoring dan log kegiatan (10%)</li>
                        </ol>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2">Dokumen Pelaporan</h3>
                        <ol class="list-decimal list-inside space-y-1 ml-4">
                            <li>Laporan harian/mingguan kegiatan melalui sistem.</li>
                            <li>Laporan akhir magang sesuai template yang disediakan.</li>
                            <li>Sertifikat atau surat keterangan dari perusahaan mitra.</li>
                            <li>Evaluasi dan feedback pengalaman magang.</li>
                        </ol>
                    </div>
                </div>
            </section>

            <section class="mb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4 border-l-4 border-magnet-sky-teal pl-3">
                    Ketentuan Lain-lain
                </h2>

                <div class="space-y-4 text-sm text-gray-700 leading-relaxed">
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2">Sanksi</h3>
                        <ol class="list-decimal list-inside space-y-1 ml-4">
                            <li>Mahasiswa yang melanggar ketentuan dapat dikenai sanksi berupa teguran, peringatan, atau
                                penghentian magang.</li>
                            <li>Pelanggaran berat dapat berakibat pada kegagalan dalam mata kuliah magang.</li>
                        </ol>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2">Perubahan Aturan</h3>
                        <p>Aturan ini dapat diubah sewaktu-waktu sesuai kebutuhan dan perkembangan program studi dengan
                            persetujuan pimpinan jurusan.</p>
                    </div>
                </div>
            </section>

            <div class="text-center pt-6 border-t">
                <p class="text-sm text-gray-600">
                    Ditetapkan di Malang<br>
                    Tanggal: {{ date('d F Y') }}<br><br>
                    <strong>Ketua Magnet</strong><br>
                    Politeknik Negeri Malang
                </p>
            </div>
        </div>
    </div>
</x-layouts.guest.main>