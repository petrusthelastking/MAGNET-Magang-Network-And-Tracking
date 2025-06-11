<section class="px-4 sm:px-8 lg:px-16 pt-12 pb-16" id="metode">
    <div class="container mx-auto">
        <div class="text-center mb-10">
            <h2 class="text-xl sm:text-xl lg:text-xl font-bold text-slate-800 mb-2">
                Metode Pengambilan Keputusan dalam Sistem Rekomendasi
            </h2>
            <p class="text-base sm:text-lg text-slate-600">
                Sistem kami menggunakan pendekatan ilmiah untuk hasil rekomendasi yang objektif dan tepat sasaran.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- ROC Box -->
            <div class="bg-white rounded-2xl shadow-md p-6">
                <h3 class="text-xl font-semibold text-blue-700 mb-3">ROC (Rank Order Centroid)</h3>
                <p class="text-sm text-slate-700 mb-4">
                    ROC adalah metode pembobotan berdasarkan urutan prioritas kriteria. Cocok digunakan saat
                    pengguna dapat menentukan ranking pentingnya kriteria.
                </p>
                <h4 class="font-medium text-slate-800 mb-2">Langkah-langkah:</h4>
                <ul class="list-decimal list-inside text-slate-600 text-sm space-y-1">
                    <li>Tentukan kriteria evaluasi magang (kriteria : Lokasi, Open remote, Jenis magang, Bidang
                        industri, Pekerjaan, Reputasi perusahaan).</li>
                    <li>Urutkan berdasarkan prioritas.</li>
                    <li>Hitung bobot menggunakan rumus ROC.</li>
                    <li>Gunakan bobot dalam sistem perhitungan rekomendasi.</li>
                </ul>
            </div>

            <!-- MULTIMOORA Box -->
            <div class="bg-white rounded-2xl shadow-md p-6">
                <h3 class="text-xl font-semibold text-green-700 mb-3">MULTIMOORA</h3>
                <p class="text-sm text-slate-700 mb-4">
                    MULTIMOORA adalah metode evaluasi multikriteria dengan pendekatan gabungan untuk memperoleh
                    peringkat alternatif secara menyeluruh.
                </p>
                <h4 class="font-medium text-slate-800 mb-2">Langkah-langkah:</h4>
                <ul class="list-decimal list-inside text-slate-600 text-sm space-y-1">
                    <li>Normalisasi nilai tiap alternatif.</li>
                    <li>Hitung skor Ratio System.</li>
                    <li>Tentukan titik referensi dan deviasi minimum.</li>
                    <li>Hitung Full Multiplicative Form.</li>
                    <li>Gabungkan hasil dan urutkan alternatif.</li>
                </ul>
            </div>
        </div>
    </div>
</section>
