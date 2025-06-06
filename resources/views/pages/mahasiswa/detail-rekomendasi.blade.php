<x-layouts.user.main user="mahasiswa">

    <div class="card bg-white shadow-md">
        <div class="card-body">
            <h2 class="text-base font-semibold">Kriteria yang anda pilih</h2>
            <p>Pemilihan kriteria menggunakan metode ROC</p>
            <table class="table-auto w-full ">
                <thead class="bg-white text-black">
                    <tr class="border-b bg-cyan-200">
                        <th class="text-center px-6 py-3">No</th>
                        <th class="text-center px-6 py-3">Kriteria</th>
                        <th class="text-center px-6 py-3">Rangking</th>
                        <th class="text-center px-6 py-3">Bobot</th>
                    </tr>
                </thead>
                <tbody class="bg-white text-black">
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3 text-center">1</td>
                        <td class="px-6 py-3 text-center">Lokasi</td>
                        <td class="px-6 py-3 text-right">1</td>
                        <td class="px-6 py-3 text-right">0.4083333333</td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3 text-center">2</td>
                        <td class="px-6 py-3 text-center">Pekerjaan</td>
                        <td class="px-6 py-3 text-right">2</td>
                        <td class="px-6 py-3 text-right">0.06111111111</td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3 text-center">3</td>
                        <td class="px-6 py-3 text-center">Bidang industri</td>
                        <td class="px-6 py-3 text-right">3</td>
                        <td class="px-6 py-3 text-right">0.1027777778</td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3 text-center">5</td>
                        <td class="px-6 py-3 text-center">Open remote</td>
                        <td class="px-6 py-3 text-right">5</td>
                        <td class="px-6 py-3 text-right">0.2416666667</td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3 text-center">6</td>
                        <td class="px-6 py-3 text-center">Jenis magang</td>
                        <td class="px-6 py-3 text-right">6</td>
                        <td class="px-6 py-3 text-right">0.1583333333</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card bg-white shadow-md p-5">
        <div>
            <h2 class="text-base font-semibold">Tabel Perhitungan Multimoora</h2>
        </div>

        <div class="p-3 pb-4">
            <div class="collapse border-base-300 border-2">
                <input type="checkbox" />
                <div class="collapse-title font-semibold">Tabel Detail Perhitungan</div>
                <div class="collapse-content text-sm">
                    <div class="pb-3">
                        <div class="font-bold text-lg mt-5">
                            <h2>Urutan Tabel DM 1</h2>
                        </div>
                        <table class="table-auto w-full">
                            <thead class="bg-white text-black">
                                <tr class="border-b bg-green-400">
                                    <th class="text-left px-6 py-3">Nama</th>
                                    <th class="text-center px-6 py-3">Urutan ranking</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white text-black">
                                <tr>
                                    <td class="px-6 py-3">Lokasi</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Pekerjaan</td>
                                    <td class="px-6 py-3 text-right">2</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Bidang industri</td>
                                    <td class="px-6 py-3 text-right">3</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Open remote</td>
                                    <td class="px-6 py-3 text-right">5</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Jenis magang</td>
                                    <td class="px-6 py-3 text-right">6</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div>
                        <div class="font-bold text-lg mt-10">
                            <h2>Pembobotan Kriteria DM 1</h2>
                        </div>
                        <table class="table-auto w-full">
                            <thead class="bg-white text-black">
                                <tr class="border-b bg-green-400">
                                    <th class="text-left px-6 py-3">Nama</th>
                                    <th class="text-center px-6 py-3">Nilai bobot</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white text-black">
                                <tr>
                                    <td class="px-6 py-3">Lokasi</td>
                                    <td class="px-6 py-3 text-right">0.4083333333</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Open remote</td>
                                    <td class="px-6 py-3 text-right">0.2416666667</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Jenis magang</td>
                                    <td class="px-6 py-3 text-right">0.1583333333</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Bidang industri</td>
                                    <td class="px-6 py-3 text-right">0.1027777778</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Pekerjaan</td>
                                    <td class="px-6 py-3 text-right">0.06111111111</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <div class="font-bold text-lg mt-10">
                            <h2>Preferensi Mahasiswa</h2>
                        </div>
                        <table class="table-auto w-full">
                            <thead class="bg-white text-black">
                                <tr class="border-b bg-green-400">
                                    <th class="text-left px-6 py-3">Kriteria</th>
                                    <th class="text-left px-6 py-3">Nilai</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white text-black">
                                <tr>
                                    <td class="px-6 py-3">Pekerjaan</td>
                                    <td class="px-6 py-3">Data engineer</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Bidang industri</td>
                                    <td class="px-6 py-3">Pariwisata</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Lokasi</td>
                                    <td class="px-6 py-3">Area Malang raya</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Jenis magang</td>
                                    <td class="px-6 py-3">Berbayar</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Open remote</td>
                                    <td class="px-6 py-3">Ya</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <div class="font-bold text-lg mt-10">
                            <h2>Tabel Awal</h2>
                        </div>
                        <div>
                            <table class="table-auto w-full">
                                <thead class="bg-white text-black">
                                    <tr class="border-b bg-green-400">
                                        <th class="text-left px-6 py-3">Nama</th>
                                        <th class="text-left px-6 py-3">Lokasi</th>
                                        <th class="text-left px-6 py-3">Perusahaan</th>
                                        <th class="text-left px-6 py-3">Open remote</th>
                                        <th class="text-left px-6 py-3">Jenis magang</th>
                                        <th class="text-left px-6 py-3">Bidang industri</th>
                                        <th class="text-left px-6 py-3">Pekerjaan</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white text-black">
                                    <tr>
                                        <td class="px-6 py-3">Frontend Web Developer Intern</td>
                                        <td class="px-6 py-3">Area Malang</td>
                                        <td class="px-6 py-3">PT Digital Aksara</td>
                                        <td class="px-6 py-3">Ya</td>
                                        <td class="px-6 py-3">Berbayar</td>
                                        <td class="px-6 py-3">Pariwisata</td>
                                        <td class="px-6 py-3">Frontend web developer</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-3">Machine Learning Intern</td>
                                        <td class="px-6 py-3">Luar provinsi Jawa Timur</td>
                                        <td class="px-6 py-3">PT VisionAI</td>
                                        <td class="px-6 py-3">Tidak</td>
                                        <td class="px-6 py-3">Berbayar</td>
                                        <td class="px-6 py-3">Teknologi</td>
                                        <td class="px-6 py-3">Machine learning engineer</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-3">Security Analyst Internship</td>
                                        <td class="px-6 py-3">Area Malang</td>
                                        <td class="px-6 py-3">CV Cipta Aman</td>
                                        <td class="px-6 py-3">Tidak</td>
                                        <td class="px-6 py-3">Non berbayar</td>
                                        <td class="px-6 py-3">Transportasi</td>
                                        <td class="px-6 py-3">Security analyst</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-3">Mobile Developer Intern</td>
                                        <td class="px-6 py-3">Luar negeri</td>
                                        <td class="px-6 py-3">PT Mobile Kreasi</td>
                                        <td class="px-6 py-3">Ya</td>
                                        <td class="px-6 py-3">Berbayar</td>
                                        <td class="px-6 py-3">Telekomunikasi</td>
                                        <td class="px-6 py-3">Mobile developer</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-3">Data Scientist Internship</td>
                                        <td class="px-6 py-3">Luar area Malang raya (dulu PT Data Kreasi Mandiri)</td>
                                        <td class="px-6 py-3">PT Data Kreasi Mandiri</td>
                                        <td class="px-6 py-3">Tidak</td>
                                        <td class="px-6 py-3">Non berbayar</td>
                                        <td class="px-6 py-3">Kesehatan</td>
                                        <td class="px-6 py-3">Data scientist</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-3">Backend Developer Internship</td>
                                        <td class="px-6 py-3">Area Malang</td>
                                        <td class="px-6 py-3">PT Kode Nusantara</td>
                                        <td class="px-6 py-3">Ya</td>
                                        <td class="px-6 py-3">Berbayar</td>
                                        <td class="px-6 py-3">Perbankan</td>
                                        <td class="px-6 py-3">Backend developer</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-3">Data Engineer Internship</td>
                                        <td class="px-6 py-3">Luar provinsi Jawa Timur</td>
                                        <td class="px-6 py-3">CV Teknologi Sejahtera</td>
                                        <td class="px-6 py-3">Tidak</td>
                                        <td class="px-6 py-3">Berbayar</td>
                                        <td class="px-6 py-3">Energi</td>
                                        <td class="px-6 py-3">Data engineer</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-3">Security Analyst Intern</td>
                                        <td class="px-6 py-3">Area Malang</td>
                                        <td class="px-6 py-3">PT Sandi Digital</td>
                                        <td class="px-6 py-3">Ya</td>
                                        <td class="px-6 py-3">Non berbayar</td>
                                        <td class="px-6 py-3">Teknologi inform</td>
                                        <td class="px-6 py-3">Security analyst</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-3">Machine Learning Intern</td>
                                        <td class="px-6 py-3">Luar negeri</td>
                                        <td class="px-6 py-3">PT Inovasi AI Global</td>
                                        <td class="px-6 py-3">Ya</td>
                                        <td class="px-6 py-3">Berbayar</td>
                                        <td class="px-6 py-3">Edukasi</td>
                                        <td class="px-6 py-3">Machine learning engineer</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-3">Mobile App Developer Intern</td>
                                        <td class="px-6 py-3">Luar area Malang raya (dulu PT Kreatif Apps)</td>
                                        <td class="px-6 py-3">PT Kreatif Apps</td>
                                        <td class="px-6 py-3">Tidak</td>
                                        <td class="px-6 py-3">Non berbayar</td>
                                        <td class="px-6 py-3">Pariwisata</td>
                                        <td class="px-6 py-3">Mobile developer</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                        <div class="font-bold text-lg mt-10">
                            <h2>Tabel Numerik DM 1</h2>
                        </div>
                        <table class="table-auto w-full">
                            <thead class="bg-white text-black">
                                <tr class="border-b bg-green-400">
                                    <th class="text-left px-6 py-3">Nama</th>
                                    <th class="text-center px-6 py-3">Lokasi</th>
                                    <th class="text-center px-6 py-3">Open remote</th>
                                    <th class="text-center px-6 py-3">Jenis magang</th>
                                    <th class="text-center px-6 py-3">Bidang industri</th>
                                    <th class="text-center px-6 py-3">Pekerjaan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white text-black">
                                <tr>
                                    <td class="px-6 py-3">Frontend Web Developer Intern</td>
                                    <td class="px-6 py-3 text-right">2</td>
                                    <td class="px-6 py-3 text-right">2</td>
                                    <td class="px-6 py-3 text-right">2</td>
                                    <td class="px-6 py-3 text-right">2</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Machine Learning Intern</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">2</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Security Analyst Internship</td>
                                    <td class="px-6 py-3 text-right">2</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Mobile Developer Intern</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">2</td>
                                    <td class="px-6 py-3 text-right">2</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Data Scientist Internship</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Backend Developer Internship</td>
                                    <td class="px-6 py-3 text-right">2</td>
                                    <td class="px-6 py-3 text-right">2</td>
                                    <td class="px-6 py-3 text-right">2</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Data Engineer Internship</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">2</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Security Analyst Intern</td>
                                    <td class="px-6 py-3 text-right">2</td>
                                    <td class="px-6 py-3 text-right">2</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Machine Learning Intern</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">2</td>
                                    <td class="px-6 py-3 text-right">2</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Mobile App Developer Intern</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">2</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <div class="font-bold text-lg mt-5">
                            <h2>Normalisasi Euclidean</h2>
                        </div>
                        <table class="table-auto w-full">
                            <thead class="bg-white text-black">
                                <tr class="border-b bg-green-400">
                                    <th class="text-left px-6 py-3">Nilai</th>
                                    <th class="text-left px-6 py-3">Lokasi</th>
                                    <th class="text-left px-6 py-3">Open Remot</th>
                                    <th class="text-left px-6 py-3">Jenis Magang</th>
                                    <th class="text-left px-6 py-3">Bidang Industri</th>
                                    <th class="text-left px-6 py-3">Pekerjaan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white text-black">
                                <tr>
                                    <td class="px-6 py-3">V2(x_j^i)</td>
                                    <td class="px-6 py-3 text-right">4.69041576</td>
                                    <td class="px-6 py-3 text-right">4.582575695</td>
                                    <td class="px-6 py-3 text-right">5.291502622</td>
                                    <td class="px-6 py-3 text-right">4</td>
                                    <td class="px-6 py-3 text-right">3.605551275</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <div class="font-bold text-lg mt-5">
                            <h2>Normalisasi Vektor</h2>
                        </div>
                        <table class="table-auto w-full">
                            <thead class="bg-white text-black">
                                <tr class="border-b bg-green-400">
                                    <th class="text-left px-6 py-3">Nama</th>
                                    <th class="text-center px-6 py-3">Lokasi</th>
                                    <th class="text-center px-6 py-3">Open remote</th>
                                    <th class="text-center px-6 py-3">Jenis magang</th>
                                    <th class="text-center px-6 py-3">Bidang industri</th>
                                    <th class="text-center px-6 py-3">Pekerjaan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white text-black">
                                <tr>
                                    <td class="px-6 py-3">Frontend Web Developer Intern</td>
                                    <td class="px-6 py-3 text-right">0.4264014327</td>
                                    <td class="px-6 py-3 text-right">0.4</td>
                                    <td class="px-6 py-3 text-right">0.377964473</td>
                                    <td class="px-6 py-3 text-right">0.5</td>
                                    <td class="px-6 py-3 text-right">0.2773500981</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Machine Learning Intern</td>
                                    <td class="px-6 py-3 text-right">0.2132007164</td>
                                    <td class="px-6 py-3 text-right">0.2</td>
                                    <td class="px-6 py-3 text-right">0.377964473</td>
                                    <td class="px-6 py-3 text-right">0.25</td>
                                    <td class="px-6 py-3 text-right">0.2773500981</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Security Analyst Internship</td>
                                    <td class="px-6 py-3 text-right">0.4264014327</td>
                                    <td class="px-6 py-3 text-right">0.2</td>
                                    <td class="px-6 py-3 text-right">0.1889822365</td>
                                    <td class="px-6 py-3 text-right">0.25</td>
                                    <td class="px-6 py-3 text-right">0.2773500981</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Mobile Developer Intern</td>
                                    <td class="px-6 py-3 text-right">0.2132007164</td>
                                    <td class="px-6 py-3 text-right">0.4</td>
                                    <td class="px-6 py-3 text-right">0.377964473</td>
                                    <td class="px-6 py-3 text-right">0.25</td>
                                    <td class="px-6 py-3 text-right">0.2773500981</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Data Scientist Internship</td>
                                    <td class="px-6 py-3 text-right">0.2132007164</td>
                                    <td class="px-6 py-3 text-right">0.2</td>
                                    <td class="px-6 py-3 text-right">0.1889822365</td>
                                    <td class="px-6 py-3 text-right">0.25</td>
                                    <td class="px-6 py-3 text-right">0.2773500981</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Backend Developer Internship</td>
                                    <td class="px-6 py-3 text-right">0.4264014327</td>
                                    <td class="px-6 py-3 text-right">0.4</td>
                                    <td class="px-6 py-3 text-right">0.377964473</td>
                                    <td class="px-6 py-3 text-right">0.25</td>
                                    <td class="px-6 py-3 text-right">0.2773500981</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Data Engineer Internship</td>
                                    <td class="px-6 py-3 text-right">0.2132007164</td>
                                    <td class="px-6 py-3 text-right">0.2</td>
                                    <td class="px-6 py-3 text-right">0.377964473</td>
                                    <td class="px-6 py-3 text-right">0.25</td>
                                    <td class="px-6 py-3 text-right">0.5547001962</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Security Analyst Intern</td>
                                    <td class="px-6 py-3 text-right">0.4264014327</td>
                                    <td class="px-6 py-3 text-right">0.4</td>
                                    <td class="px-6 py-3 text-right">0.1889822365</td>
                                    <td class="px-6 py-3 text-right">0.25</td>
                                    <td class="px-6 py-3 text-right">0.2773500981</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Machine Learning Intern</td>
                                    <td class="px-6 py-3 text-right">0.2132007164</td>
                                    <td class="px-6 py-3 text-right">0.4</td>
                                    <td class="px-6 py-3 text-right">0.377964473</td>
                                    <td class="px-6 py-3 text-right">0.25</td>
                                    <td class="px-6 py-3 text-right">0.2773500981</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Mobile App Developer Intern</td>
                                    <td class="px-6 py-3 text-right">0.2132007164</td>
                                    <td class="px-6 py-3 text-right">0.2</td>
                                    <td class="px-6 py-3 text-right">0.1889822365</td>
                                    <td class="px-6 py-3 text-right">0.5</td>
                                    <td class="px-6 py-3 text-right">0.2773500981</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="p-3 pb-4">
            <div class="collapse border-base-300 border-2">
                <input type="checkbox" />
                <div class="collapse-title font-semibold">Tabel Perangkingan</div>
                <div class="collapse-content text-sm">
                    <div>
                        <div class="font-bold text-lg mt-5">
                            <h2>Tabel Hasil Metode Ratio System (RS)</h3>
                        </div>
                        <table class="table-auto w-full">
                            <thead class="bg-white text-black">
                                <tr class="border-b bg-green-400">
                                    <th class="text-left px-6 py-3">Alternatif</th>
                                    <th class="text-center px-6 py-3">Nilai</th>
                                    <th class="text-center px-6 py-3">Rank</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white text-black">
                                <tr>
                                    <td class="px-6 py-3">Frontend Web Developer Intern</td>
                                    <td class="px-6 py-3 text-right">0.4048852636</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Machine Learning Intern</td>
                                    <td class="px-6 py-3 text-right">0.2438005266</td>
                                    <td class="px-6 py-3 text-right">9</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Security Analyst Internship</td>
                                    <td class="px-6 py-3 text-right">0.3068575405</td>
                                    <td class="px-6 py-3 text-right">4</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Mobile Developer Intern</td>
                                    <td class="px-6 py-3 text-right">0.29213386</td>
                                    <td class="px-6 py-3 text-right">5</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Data Scientist Internship</td>
                                    <td class="px-6 py-3 text-right">0.2198005813</td>
                                    <td class="px-6 py-3 text-right">10</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Backend Developer Internship</td>
                                    <td class="px-6 py-3 text-right">0.3791908191</td>
                                    <td class="px-6 py-3 text-right">2</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Data Engineer Internship</td>
                                    <td class="px-6 py-3 text-right">0.2666719414</td>
                                    <td class="px-6 py-3 text-right">7</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Security Analyst Intern</td>
                                    <td class="px-6 py-3 text-right">0.3492686317</td>
                                    <td class="px-6 py-3 text-right">3</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Machine Learning Intern</td>
                                    <td class="px-6 py-3 text-right">0.29213386</td>
                                    <td class="px-6 py-3 text-right">5</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Mobile App Developer Intern</td>
                                    <td class="px-6 py-3 text-right">0.2454950258</td>
                                    <td class="px-6 py-3 text-right">8</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div>
                        <div class="font-bold text-lg mt-5">
                            <h2>Tabel Hasil Metode Reference Point (RP)</h2>
                        </div>
                        <table class="table-auto w-full">
                            <thead class="bg-white text-black">
                                <tr class="border-b bg-green-400">
                                    <th class="text-left px-6 py-3">Alternatif</th>
                                    <th class="text-center px-6 py-3">Nilai</th>
                                    <th class="text-center px-6 py-3">Rank (asc)</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white text-black">
                                <tr>
                                    <td class="px-6 py-3">Frontend Web Developer Intern</td>
                                    <td class="px-6 py-3 text-right">0.3258860816</td>
                                    <td class="px-6 py-3 text-right">5</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Machine Learning Intern</td>
                                    <td class="px-6 py-3 text-right">0.2909075138</td>
                                    <td class="px-6 py-3 text-right">2</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Security Analyst Internship</td>
                                    <td class="px-6 py-3 text-right">0.2522875144</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Mobile Developer Intern</td>
                                    <td class="px-6 py-3 text-right">0.3129430408</td>
                                    <td class="px-6 py-3 text-right">4</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Data Scientist Internship</td>
                                    <td class="px-6 py-3 text-right">0.3393444735</td>
                                    <td class="px-6 py-3 text-right">6</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Backend Developer Internship</td>
                                    <td class="px-6 py-3 text-right">0.2522875144</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Data Engineer Internship</td>
                                    <td class="px-6 py-3 text-right">0.467643237</td>
                                    <td class="px-6 py-3 text-right">8</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Security Analyst Intern</td>
                                    <td class="px-6 py-3 text-right">0.2522875144</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Machine Learning Intern</td>
                                    <td class="px-6 py-3 text-right">0.3129430408</td>
                                    <td class="px-6 py-3 text-right">3</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Mobile App Developer Intern</td>
                                    <td class="px-6 py-3 text-right">0.4129430408</td>
                                    <td class="px-6 py-3 text-right">7</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <div class="font-bold text-lg mt-5">
                            <h2>Tabel Hasil Metode Full Multiplicative Form (FMF)</h3>
                        </div>
                        <table class="table-auto w-full">
                            <thead class="bg-white text-black">
                                <tr class="border-b bg-green-400">
                                    <th class="text-left px-6 py-3">Alternatif</th>
                                    <th class="text-center px-6 py-3">Nilai</th>
                                    <th class="text-center px-6 py-3">Rank</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white text-black">
                                <tr>
                                    <td class="px-6 py-3">Frontend Web Developer Intern</td>
                                    <td class="px-6 py-3 text-right">0.4000820583</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Machine Learning Intern</td>
                                    <td class="px-6 py-3 text-right">0.2374326199</td>
                                    <td class="px-6 py-3 text-right">8</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Security Analyst Internship</td>
                                    <td class="px-6 py-3 text-right">0.2878457542</td>
                                    <td class="px-6 py-3 text-right">4</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Mobile Developer Intern</td>
                                    <td class="px-6 py-3 text-right">0.2807303068</td>
                                    <td class="px-6 py-3 text-right">5</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Data Scientist Internship</td>
                                    <td class="px-6 py-3 text-right">0.216889859</td>
                                    <td class="px-6 py-3 text-right">10</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Backend Developer Internship</td>
                                    <td class="px-6 py-3 text-right">0.3725717158</td>
                                    <td class="px-6 py-3 text-right">2</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Data Engineer Internship</td>
                                    <td class="px-6 py-3 text-right">0.2525216431</td>
                                    <td class="px-6 py-3 text-right">7</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Security Analyst Intern</td>
                                    <td class="px-6 py-3 text-right">0.3338464782</td>
                                    <td class="px-6 py-3 text-right">3</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Machine Learning Intern</td>
                                    <td class="px-6 py-3 text-right">0.2807303068</td>
                                    <td class="px-6 py-3 text-right">5</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Mobile App Developer Intern</td>
                                    <td class="px-6 py-3 text-right">0.2329048007</td>
                                    <td class="px-6 py-3 text-right">9</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <div class="font-bold text-lg mt-5">
                            <h2>Tabel Hasil Perankingan Global</h3>
                        </div>
                        <table class="table-auto w-full">
                            <thead class="bg-white text-black">
                                <tr class="border-b bg-orange-400">
                                    <th class="text-left px-6 py-3">Alternatif</th>
                                    <th class="text-center px-6 py-3">RS</th>
                                    <th class="text-center px-6 py-3">RP</th>
                                    <th class="text-center px-6 py-3">FMF</th>
                                    <th class="text-center px-6 py-3">Rata-Rata Ranking</th>
                                    <th class="text-center px-6 py-3">Final Ranking</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white text-black">
                                <tr>
                                    <td class="px-6 py-3">Frontend Web Developer Intern</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">5</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">2.333333333</td>
                                    <td class="px-6 py-3 text-right">2</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Machine Learning Intern</td>
                                    <td class="px-6 py-3 text-right">9</td>
                                    <td class="px-6 py-3 text-right">2</td>
                                    <td class="px-6 py-3 text-right">8</td>
                                    <td class="px-6 py-3 text-right">6.333333333</td>
                                    <td class="px-6 py-3 text-right">6</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Security Analyst Internship</td>
                                    <td class="px-6 py-3 text-right">4</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">4</td>
                                    <td class="px-6 py-3 text-right">3</td>
                                    <td class="px-6 py-3 text-right">3</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Mobile Developer Intern</td>
                                    <td class="px-6 py-3 text-right">5</td>
                                    <td class="px-6 py-3 text-right">4</td>
                                    <td class="px-6 py-3 text-right">5</td>
                                    <td class="px-6 py-3 text-right">4.666666667</td>
                                    <td class="px-6 py-3 text-right">5</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Data Scientist Internship</td>
                                    <td class="px-6 py-3 text-right">10</td>
                                    <td class="px-6 py-3 text-right">6</td>
                                    <td class="px-6 py-3 text-right">10</td>
                                    <td class="px-6 py-3 text-right">8.666666667</td>
                                    <td class="px-6 py-3 text-right">9</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Backend Developer Internship</td>
                                    <td class="px-6 py-3 text-right">2</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">2</td>
                                    <td class="px-6 py-3 text-right">1.666666667</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Data Engineer Internship</td>
                                    <td class="px-6 py-3 text-right">7</td>
                                    <td class="px-6 py-3 text-right">8</td>
                                    <td class="px-6 py-3 text-right">7</td>
                                    <td class="px-6 py-3 text-right">7.333333333</td>
                                    <td class="px-6 py-3 text-right">7</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Security Analyst Intern</td>
                                    <td class="px-6 py-3 text-right">3</td>
                                    <td class="px-6 py-3 text-right">1</td>
                                    <td class="px-6 py-3 text-right">3</td>
                                    <td class="px-6 py-3 text-right">2.333333333</td>
                                    <td class="px-6 py-3 text-right">2</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Machine Learning Intern</td>
                                    <td class="px-6 py-3 text-right">5</td>
                                    <td class="px-6 py-3 text-right">3</td>
                                    <td class="px-6 py-3 text-right">5</td>
                                    <td class="px-6 py-3 text-right">4.333333333</td>
                                    <td class="px-6 py-3 text-right">4</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3">Mobile App Developer Intern</td>
                                    <td class="px-6 py-3 text-right">8</td>
                                    <td class="px-6 py-3 text-right">7</td>
                                    <td class="px-6 py-3 text-right">9</td>
                                    <td class="px-6 py-3 text-right">8</td>
                                    <td class="px-6 py-3 text-right">8</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    <div class="pt-7">
        <h2 class="text-base font-semibold">Top 10 Perusahaan Hasil Rekomendasi Magang</h2>
        <div class="pb-3">
            <p>Pemilihan Rekomendasi menggunakan metode Multimoora</p>
        </div>
        <table class="table-auto w-full ">
            <thead class="bg-white text-black">
                <tr class="border-b bg-yellow-200">
                    <th class="text-center px-6 py-3">Rank</th>
                    <th class="text-center px-6 py-3">Lowongan</th>
                    <th class="text-center px-6 py-3">Rata-Rata Rangking</th>
                </tr>
            </thead>
            <tbody class="bg-white text-black">
                <tr>
                    <td class="px-6 py-3 text-right">1</td>
                    <td class="px-6 py-3">Backend Developer Internship</td>
                    <td class="px-6 py-3 text-right">1.666666667</td>
                </tr>
                <tr>
                    <td class="px-6 py-3 text-right">2</td>
                    <td class="px-6 py-3">Frontend Web Developer Intern</td>
                    <td class="px-6 py-3 text-right">2.333333333</td>
                </tr>
                <tr>
                    <td class="px-6 py-3 text-right">2</td>
                    <td class="px-6 py-3">Security Analyst Intern</td>
                    <td class="px-6 py-3 text-right">2.333333333</td>
                </tr>
                <tr>
                    <td class="px-6 py-3 text-right">3</td>
                    <td class="px-6 py-3">Security Analyst Internship</td>
                    <td class="px-6 py-3 text-right">3</td>
                </tr>
                <tr>
                    <td class="px-6 py-3 text-right">4</td>
                    <td class="px-6 py-3">Machine Learning Intern</td>
                    <td class="px-6 py-3 text-right">4.333333333</td>
                </tr>
                <tr>
                    <td class="px-6 py-3 text-right">5</td>
                    <td class="px-6 py-3">Mobile Developer Intern</td>
                    <td class="px-6 py-3 text-right">4.666666667</td>
                </tr>
                <tr>
                    <td class="px-6 py-3 text-right">6</td>
                    <td class="px-6 py-3">Machine Learning Intern</td>
                    <td class="px-6 py-3 text-right">6.333333333</td>
                </tr>
                <tr>
                    <td class="px-6 py-3 text-right">7</td>
                    <td class="px-6 py-3">Data Engineer Internship</td>
                    <td class="px-6 py-3 text-right">7.333333333</td>
                </tr>
                <tr>
                    <td class="px-6 py-3 text-right">8</td>
                    <td class="px-6 py-3">Mobile App Developer Intern</td>
                    <td class="px-6 py-3 text-right">8</td>
                </tr>
                <tr>
                    <td class="px-6 py-3 text-right">9</td>
                    <td class="px-6 py-3">Data Scientist Internship</td>
                    <td class="px-6 py-3 text-right">8.666666667</td>
                </tr>
            </tbody>
        </table>
    </div>

</x-layouts.user.main>
