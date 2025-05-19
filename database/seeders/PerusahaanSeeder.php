<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerusahaanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('perusahaan')->insert([
            [
                'nama_perusahaan' => 'PT. Traveloka Indonesia',
                'alamat' => 'Jl. Mega Kuningan Barat III, Jakarta Selatan',
                'kota' => 'Jakarta',
                'provinsi' => 'DKI Jakarta',
                'bidang_industri' => 'Teknologi',
                'no_telp' => '021-5794-8888',
                'email' => 'hr@traveloka.com',
                'deskripsi' => 'Platform travel terkemuka di Asia Tenggara yang menyediakan layanan booking hotel, tiket pesawat, dan berbagai kebutuhan perjalanan.',
                'tahun_berdiri' => 2012,
                'logo_path' => 'logo/traveloka.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_perusahaan' => 'PT. Tokopedia',
                'alamat' => 'Jl. Prof. DR. Satrio Kav. 11, Jakarta Selatan',
                'kota' => 'Jakarta',
                'provinsi' => 'DKI Jakarta',
                'bidang_industri' => 'E-Commerce',
                'no_telp' => '021-8064-7000',
                'email' => 'career@tokopedia.com',
                'deskripsi' => 'Marketplace terbesar di Indonesia yang menghubungkan jutaan penjual dan pembeli.',
                'tahun_berdiri' => 2009,
                'logo_path' => 'logo/tokopedia.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_perusahaan' => 'PT. Bank Central Asia Tbk',
                'alamat' => 'Jl. Jend. Sudirman Kav. 22-23, Jakarta Pusat',
                'kota' => 'Jakarta',
                'provinsi' => 'DKI Jakarta',
                'bidang_industri' => 'Perbankan',
                'no_telp' => '021-2358-8000',
                'email' => 'hrd@bca.co.id',
                'deskripsi' => 'Bank swasta terkemuka di Indonesia dengan jaringan ATM terluas dan layanan digital banking terdepan.',
                'tahun_berdiri' => 1957,
                'logo_path' => 'logo/bca.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_perusahaan' => 'PT. Telkom Indonesia',
                'alamat' => 'Jl. Japati No. 1, Bandung',
                'kota' => 'Bandung',
                'provinsi' => 'Jawa Barat',
                'bidang_industri' => 'Telekomunikasi',
                'no_telp' => '022-4521-234',
                'email' => 'recruitment@telkom.co.id',
                'deskripsi' => 'BUMN penyedia layanan telekomunikasi terbesar di Indonesia dengan layanan fixed line, mobile, dan internet.',
                'tahun_berdiri' => 1961,
                'logo_path' => 'logo/telkom.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_perusahaan' => 'PT. Shopee Indonesia',
                'alamat' => 'District 8 - SCBD Lot 13, Jakarta Selatan',
                'kota' => 'Jakarta',
                'provinsi' => 'DKI Jakarta',
                'bidang_industri' => 'E-Commerce',
                'no_telp' => '021-8064-7500',
                'email' => 'careers@shopee.co.id',
                'deskripsi' => 'Platform e-commerce mobile terdepan di Asia Tenggara dengan fokus pada social commerce.',
                'tahun_berdiri' => 2015,
                'logo_path' => 'logo/shopee.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_perusahaan' => 'PT. Gojek Indonesia',
                'alamat' => 'Jl. Iskandarsyah II No. 2, Jakarta Selatan',
                'kota' => 'Jakarta',
                'provinsi' => 'DKI Jakarta',
                'bidang_industri' => 'Transportasi',
                'no_telp' => '021-5081-8000',
                'email' => 'careers@gojek.com',
                'deskripsi' => 'Super app penyedia layanan transportasi online, makanan, dan berbagai kebutuhan harian lainnya.',
                'tahun_berdiri' => 2010,
                'logo_path' => 'logo/gojek.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
