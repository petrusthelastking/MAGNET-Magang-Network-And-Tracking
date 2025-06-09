<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Statistik Magang</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background: white;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #0891b2;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
            color: #0891b2;
            margin-bottom: 5px;
        }

        .header h2 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .header p {
            font-size: 12px;
            color: #666;
        }

        .meta-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 11px;
        }

        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            background: #f8f9fa;
            padding: 8px 12px;
            border-left: 4px solid #0891b2;
            margin-bottom: 15px;
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .card {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            background: #f9fafb;
        }

        .card-header {
            font-weight: bold;
            font-size: 13px;
            color: #374151;
            margin-bottom: 8px;
        }

        .card-value {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .card-description {
            font-size: 10px;
            color: #6b7280;
        }

        .blue {
            color: #2563eb;
        }

        .green {
            color: #059669;
        }

        .purple {
            color: #7c3aed;
        }

        .orange {
            color: #ea580c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 11px;
        }

        th,
        td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #f3f4f6;
            font-weight: bold;
            font-size: 12px;
        }

        .rank {
            text-align: center;
            font-weight: bold;
            color: #0891b2;
        }

        .progress-bar {
            background: #e5e7eb;
            border-radius: 4px;
            height: 8px;
            margin-top: 5px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 4px;
        }

        .progress-blue {
            background: #2563eb;
        }

        .progress-green {
            background: #059669;
        }

        .progress-purple {
            background: #7c3aed;
        }

        .chart-placeholder {
            border: 2px dashed #d1d5db;
            border-radius: 8px;
            padding: 40px;
            text-align: center;
            color: #6b7280;
            margin: 15px 0;
            background: #f9fafb;
        }

        .two-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            font-size: 10px;
            text-align: center;
            color: #6b7280;
        }

        .signature-section {
            margin-top: 30px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
        }

        .signature-box {
            text-align: center;
        }

        .signature-line {
            border-bottom: 1px solid #333;
            margin: 40px 0 10px 0;
        }

        @media print {
            body {
                font-size: 11px;
            }

            .section {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>POLITEKNIK NEGERI MALANG</h2>
        <h2>JURUSAN TEKNOLOGI INFORMASI</h2>
        <h1>LAPORAN STATISTIK MAGANG</h1>
        <p>Periode: Semester Genap 2024/2025</p>
    </div>

    <div class="meta-info">
        <div>
            <strong>Tanggal Cetak:</strong> {{ date('d F Y H:i') }}
        </div>
        <div>
            <strong>Dicetak oleh:</strong> Administrator
        </div>
    </div>

    <!-- Ringkasan Umum -->
    <div class="section">
        <div class="section-title">RINGKASAN UMUM</div>
        <div class="summary-cards">
            <div class="card">
                <div class="card-header">Total Mahasiswa</div>
                <div class="card-value blue">1,247</div>
                <div class="card-description">+12% dari periode lalu</div>
            </div>
            <div class="card">
                <div class="card-header">Sudah Magang</div>
                <div class="card-value green">1,089</div>
                <div class="card-description">87.3% dari total mahasiswa</div>
            </div>
            <div class="card">
                <div class="card-header">Perusahaan Mitra</div>
                <div class="card-value purple">184</div>
                <div class="card-description">+8 perusahaan baru</div>
            </div>
            <div class="card">
                <div class="card-header">Dosen Pembimbing</div>
                <div class="card-value orange">42</div>
                <div class="card-description">Rasio 1:26 per mahasiswa</div>
            </div>
        </div>
    </div>

    <!-- Statistik per Program Studi -->
    <div class="section">
        <div class="section-title">STATISTIK PER PROGRAM STUDI</div>
        <table>
            <thead>
                <tr>
                    <th>Program Studi</th>
                    <th>Total Mahasiswa</th>
                    <th>Sudah Magang</th>
                    <th>Persentase</th>
                    <th>Progress</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>D4 Teknik Informatika</td>
                    <td>620</td>
                    <td>542</td>
                    <td>87.4%</td>
                    <td>
                        <div class="progress-bar">
                            <div class="progress-fill progress-blue" style="width: 87.4%"></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>D4 Sistem Informasi Bisnis</td>
                    <td>456</td>
                    <td>398</td>
                    <td>87.3%</td>
                    <td>
                        <div class="progress-bar">
                            <div class="progress-fill progress-green" style="width: 87.3%"></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>D2 Pengembangan Piranti Lunak Situs</td>
                    <td>171</td>
                    <td>149</td>
                    <td>87.1%</td>
                    <td>
                        <div class="progress-bar">
                            <div class="progress-fill progress-purple" style="width: 87.1%"></div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Top 10 Perusahaan Mitra -->
    <div class="section">
        <div class="section-title">TOP 10 PERUSAHAAN MITRA</div>
        <table>
            <thead>
                <tr>
                    <th width="8%">Rank</th>
                    <th width="40%">Nama Perusahaan</th>
                    <th width="30%">Bidang Industri</th>
                    <th width="22%">Jumlah Mahasiswa</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="rank">1</td>
                    <td>PT Telkom Indonesia</td>
                    <td>Teknologi Informasi</td>
                    <td>127 mahasiswa</td>
                </tr>
                <tr>
                    <td class="rank">2</td>
                    <td>Bank Mandiri</td>
                    <td>Perbankan & Fintech</td>
                    <td>98 mahasiswa</td>
                </tr>
                <tr>
                    <td class="rank">3</td>
                    <td>Gojek Indonesia</td>
                    <td>Startup & E-commerce</td>
                    <td>76 mahasiswa</td>
                </tr>
                <tr>
                    <td class="rank">4</td>
                    <td>Shopee Indonesia</td>
                    <td>E-commerce</td>
                    <td>65 mahasiswa</td>
                </tr>
                <tr>
                    <td class="rank">5</td>
                    <td>Tokopedia</td>
                    <td>E-commerce</td>
                    <td>54 mahasiswa</td>
                </tr>
                <tr>
                    <td class="rank">6</td>
                    <td>PT Bank Central Asia</td>
                    <td>Perbankan</td>
                    <td>48 mahasiswa</td>
                </tr>
                <tr>
                    <td class="rank">7</td>
                    <td>Traveloka</td>
                    <td>Travel Technology</td>
                    <td>42 mahasiswa</td>
                </tr>
                <tr>
                    <td class="rank">8</td>
                    <td>Bukalapak</td>
                    <td>E-commerce</td>
                    <td>39 mahasiswa</td>
                </tr>
                <tr>
                    <td class="rank">9</td>
                    <td>OVO</td>
                    <td>Financial Technology</td>
                    <td>35 mahasiswa</td>
                </tr>
                <tr>
                    <td class="rank">10</td>
                    <td>Blibli</td>
                    <td>E-commerce</td>
                    <td>31 mahasiswa</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="two-column">
        <!-- Distribusi Bidang Magang -->
        <div class="section">
            <div class="section-title">DISTRIBUSI BIDANG MAGANG</div>
            <table>
                <thead>
                    <tr>
                        <th>Bidang</th>
                        <th>Persentase</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Software Development</td>
                        <td>35%</td>
                        <td>381 mahasiswa</td>
                    </tr>
                    <tr>
                        <td>Data Science</td>
                        <td>25%</td>
                        <td>272 mahasiswa</td>
                    </tr>
                    <tr>
                        <td>Cybersecurity</td>
                        <td>15%</td>
                        <td>163 mahasiswa</td>
                    </tr>
                    <tr>
                        <td>UI/UX Design</td>
                        <td>12%</td>
                        <td>131 mahasiswa</td>
                    </tr>
                    <tr>
                        <td>System Administration</td>
                        <td>8%</td>
                        <td>87 mahasiswa</td>
                    </tr>
                    <tr>
                        <td>Lainnya</td>
                        <td>5%</td>
                        <td>55 mahasiswa</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Rasio Dosen Pembimbing -->
        <div class="section">
            <div class="section-title">RASIO DOSEN PEMBIMBING</div>
            <table>
                <thead>
                    <tr>
                        <th>Program Studi</th>
                        <th>Dosen</th>
                        <th>Mahasiswa</th>
                        <th>Rasio</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>D4 Teknik Informatika</td>
                        <td>21</td>
                        <td>542</td>
                        <td>1:26</td>
                    </tr>
                    <tr>
                        <td>D4 Sistem Informasi Bisnis</td>
                        <td>16</td>
                        <td>398</td>
                        <td>1:25</td>
                    </tr>
                    <tr>
                        <td>D2 PPLS</td>
                        <td>5</td>
                        <td>149</td>
                        <td>1:30</td>
                    </tr>
                </tbody>
            </table>

            <div style="margin-top: 15px; padding: 10px; background: #f3f4f6; border-radius: 6px;">
                <strong>Rata-rata Rasio Keseluruhan: 1:26</strong><br>
                <small>Total 42 dosen membimbing 1,089 mahasiswa</small>
            </div>
        </div>
    </div>

    <!-- Tren Magang per Semester -->
    <div class="section">
        <div class="section-title">TREN MAGANG PER SEMESTER</div>
        <table>
            <thead>
                <tr>
                    <th>Periode</th>
                    <th>Jumlah Mahasiswa Magang</th>
                    <th>Pertumbuhan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>2022/1</td>
                    <td>856</td>
                    <td>-</td>
                    <td>Baseline</td>
                </tr>
                <tr>
                    <td>2022/2</td>
                    <td>923</td>
                    <td>+7.8%</td>
                    <td>Peningkatan stabil</td>
                </tr>
                <tr>
                    <td>2023/1</td>
                    <td>987</td>
                    <td>+6.9%</td>
                    <td>Tren positif berlanjut</td>
                </tr>
                <tr>
                    <td>2023/2</td>
                    <td>1,024</td>
                    <td>+3.7%</td>
                    <td>Pertumbuhan melambat</td>
                </tr>
                <tr>
                    <td>2024/1</td>
                    <td>1,089</td>
                    <td>+6.4%</td>
                    <td>Kembali meningkat</td>
                </tr>
                <tr>
                    <td>2024/2</td>
                    <td>1,156</td>
                    <td>+6.2%</td>
                    <td>Proyeksi (dalam proses)</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Status Magang -->
    <div class="section">
        <div class="section-title">STATUS MAGANG MAHASISWA</div>
        <div class="summary-cards">
            <div class="card">
                <div class="card-header">Selesai Magang</div>
                <div class="card-value green">892</div>
                <div class="card-description">81.9% dari yang sudah magang</div>
            </div>
            <div class="card">
                <div class="card-header">Sedang Magang</div>
                <div class="card-value blue">197</div>
                <div class="card-description">18.1% masih berlangsung</div>
            </div>
            <div class="card">
                <div class="card-header">Belum Magang</div>
                <div class="card-value orange">158</div>
                <div class="card-description">12.7% dari total mahasiswa</div>
            </div>
            <div class="card">
                <div class="card-header">Total Keseluruhan</div>
                <div class="card-value purple">1,247</div>
                <div class="card-description">100% mahasiswa aktif</div>
            </div>
        </div>
    </div>

    <!-- Analisis dan Rekomendasi -->
    <div class="section">
        <div class="section-title">ANALISIS DAN REKOMENDASI</div>
        <div style="font-size: 11px; line-height: 1.6;">
            <h4 style="margin-bottom: 10px; color: #0891b2;">Pencapaian Positif:</h4>
            <ul style="margin-left: 20px; margin-bottom: 15px;">
                <li>Tingkat partisipasi magang mencapai 87.3%, melampaui target minimum 85%</li>
                <li>Pertumbuhan jumlah perusahaan mitra sebesar 8 perusahaan baru</li>
                <li>Distribusi mahasiswa cukup merata di berbagai bidang teknologi</li>
                <li>Rasio dosen pembimbing masih dalam batas wajar (1:26)</li>
            </ul>

            <h4 style="margin-bottom: 10px; color: #dc2626;">Area yang Perlu Perhatian:</h4>
            <ul style="margin-left: 20px; margin-bottom: 15px;">
                <li>158 mahasiswa (12.7%) belum mendapatkan tempat magang</li>
                <li>Rasio dosen pembimbing untuk D2 PPLS cukup tinggi (1:30)</li>
                <li>Konsentrasi mahasiswa terlalu tinggi di bidang Software Development (35%)</li>
            </ul>

            <h4 style="margin-bottom: 10px; color: #059669;">Rekomendasi Tindak Lanjut:</h4>
            <ul style="margin-left: 20px;">
                <li>Intensifkan kerjasama dengan perusahaan untuk meningkatkan kuota magang</li>
                <li>Pertimbangkan penambahan dosen pembimbing untuk program D2 PPLS</li>
                <li>Diversifikasi bidang magang untuk mengurangi konsentrasi berlebih</li>
                <li>Program mentoring khusus untuk mahasiswa yang belum mendapat tempat magang</li>
            </ul>
        </div>
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <div>Mengetahui,</div>
            <div style="font-weight: bold;">Ketua Jurusan Teknologi Informasi</div>
            <div class="signature-line"></div>
            <div style="font-weight: bold;">Dr. Eng. [Nama Ketua Jurusan]</div>
            <div>NIP. [NIP Ketua Jurusan]</div>
        </div>
        <div class="signature-box">
            <div>Malang, {{ date('d F Y') }}</div>
            <div style="font-weight: bold;">Koordinator Magang</div>
            <div class="signature-line"></div>
            <div style="font-weight: bold;">Moch Zawaruddin Abdullah</div>
            <div>NIP. [NIP Koordinator]</div>
        </div>
    </div>

    <div class="footer">
        <p>Laporan ini digenerate secara otomatis dari Sistem Informasi Magang - Jurusan Teknologi Informasi Politeknik
            Negeri Malang</p>
        <p>Halaman 1 dari 1 | Dicetak pada {{ date('d/m/Y H:i:s') }} WIB</p>
    </div>
</body>

</html>