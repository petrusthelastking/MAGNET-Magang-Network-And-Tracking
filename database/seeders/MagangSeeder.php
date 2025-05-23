<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MagangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('magang')->insert([
            [
                'nama' => 'Program Magang IT Support',
                'deskripsi' => 'Magang sebagai IT Support untuk memaintain sistem komputer dan jaringan perusahaan',
                'persyaratan' => 'Mahasiswa semester 6, IPK minimal 3.0, menguasai troubleshooting komputer',
                'perusahaan_id' => 1
            ],
            [
                'nama' => 'Magang Network Engineer',
                'deskripsi' => 'Pembelajaran praktis mengenai infrastruktur jaringan telekomunikasi',
                'persyaratan' => 'Jurusan Teknik Elektro/Informatika, IPK minimal 3.2, memahami konsep jaringan',
                'perusahaan_id' => 2
            ],
            [
                'nama' => 'Software Developer Intern',
                'deskripsi' => 'Pengembangan aplikasi mobile dan web untuk platform ride-hailing',
                'persyaratan' => 'Menguasai bahasa pemrograman (Java/Kotlin/JavaScript), portfolio project',
                'perusahaan_id' => 3
            ],
            [
                'nama' => 'E-Commerce Business Analyst',
                'deskripsi' => 'Analisis data bisnis dan tren penjualan online',
                'persyaratan' => 'Jurusan Ekonomi/Manajemen, kemampuan analisis data, Excel advanced',
                'perusahaan_id' => 4
            ],
            [
                'nama' => 'Medical Assistant Intern',
                'deskripsi' => 'Magang di rumah sakit untuk mendampingi kegiatan medis',
                'persyaratan' => 'Mahasiswa Kedokteran/Keperawatan, semester akhir, surat sehat',
                'perusahaan_id' => 5
            ],
            [
                'nama' => 'Energy Management Trainee',
                'deskripsi' => 'Program magang di bidang manajemen energi dan petroleum',
                'persyaratan' => 'Teknik Kimia/Perminyakan, IPK minimal 3.3, sertifikat K3',
                'perusahaan_id' => 6
            ],
            [
                'nama' => 'Manufacturing Process Intern',
                'deskripsi' => 'Magang di divisi produksi dan quality control',
                'persyaratan' => 'Teknik Industri/Mesin, memahami lean manufacturing, fisik sehat',
                'perusahaan_id' => 7
            ],
            [
                'nama' => 'Research Assistant',
                'deskripsi' => 'Asisten penelitian di laboratorium universitas',
                'persyaratan' => 'IPK minimal 3.5, kemampuan menulis ilmiah, komitmen waktu tinggi',
                'perusahaan_id' => 8
            ],
        ]);
    }
}
