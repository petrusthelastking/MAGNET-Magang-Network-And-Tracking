<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LogAktivitasMagangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('log_aktivitas_magang')->insert([
            [
                'dosen_id' => 1,
                'pengajuan_id' => 1,
                'tanggal' => '2025-06-03',
                'kegiatan' => 'Orientasi dan pengenalan lingkungan kerja. Mendapatkan penjelasan tentang proyek yang akan dikerjakan selama magang.',
                'catatan_dosen' => 'kegiatan sesuai dengan rencana pembelajaran.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dosen_id' => 1,
                'pengajuan_id' => 1,
                'tanggal' => '2025-06-10',
                'kegiatan' => 'Mempelajari codebase proyek dan mulai berkontribusi dengan memperbaiki bug kecil pada frontend aplikasi.',
                'catatan_dosen' => 'Progres yang baik, terus tingkatkan pemahaman tentang struktur kode.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dosen_id' => 1,
                'pengajuan_id' => 1,
                'tanggal' => '2025-06-17',
                'kegiatan' => 'Mengimplementasikan fitur login dan registrasi dengan Laravel Fortify.',
                'catatan_dosen' => 'Perlu menambahkan validasi yang lebih kuat pada form registrasi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dosen_id' => 2,
                'pengajuan_id' => 2,
                'tanggal' => '2025-06-05',
                'kegiatan' => 'Orientasi dan pengenalan tim marketing. Mempelajari strategi marketing perusahaan dan tools yang digunakan.',
                'catatan_dosen' => 'kegiatan sesuai dengan rencana pembelajaran.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dosen_id' => 2,
                'pengajuan_id' => 2,
                'tanggal' => '2025-06-12',
                'kegiatan' => 'Membantu pembuatan konten untuk media sosial dan menganalisis performa postingan sebelumnya.',
                'catatan_dosen' => 'Bagus, analisis yang dilakukan cukup detail.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dosen_id' => 3,
                'pengajuan_id' => 4,
                'tanggal' => '2025-06-02',
                'kegiatan' => 'Orientasi dan pengenalan tim data science. Penjelasan tentang dataset yang akan dianalisis.',
                'catatan_dosen' => 'kegiatan sesuai dengan rencana pembelajaran.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dosen_id' => 3,
                'pengajuan_id' => 4,
                'tanggal' => '2025-06-09',
                'kegiatan' => 'Melakukan exploratory data analysis pada dataset pelanggan dan membuat visualisasi awal.',
                'catatan_dosen' => 'Visualisasi yang dibuat sangat informatif. Teruskan pekerjaan yang baik.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dosen_id' => 4,
                'pengajuan_id' => 6,
                'tanggal' => '2025-06-16',
                'kegiatan' => 'Orientasi dan pengenalan tim desain. Mempelajari design system perusahaan.',
                'catatan_dosen' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
