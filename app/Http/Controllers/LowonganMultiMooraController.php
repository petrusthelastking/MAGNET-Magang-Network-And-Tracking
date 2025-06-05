<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class LowonganMultiMooraController extends Controller
{
    public function process()
    {
        // Step 1: Ambil data lowongan
        $data = DB::table('lowongan_magang')
            ->join('lokasi_magang', 'lowongan_magang.lokasi_magang_id', '=', 'lokasi_magang.id')
            ->join('pekerjaan', 'lowongan_magang.pekerjaan_id', '=', 'pekerjaan.id')
            ->join('perusahaan', 'lowongan_magang.perusahaan_id', '=', 'perusahaan.id')
            ->join('bidang_industri', 'perusahaan.bidang_industri_id', '=', 'bidang_industri.id')
            ->select(
                'lowongan_magang.id as lowongan_id',
                'lokasi_magang.lokasi',
                'lowongan_magang.open_remote',
                'lowongan_magang.jenis_magang',
                'pekerjaan.nama as pekerjaan',
                'bidang_industri.nama as bidang_industri'
            )
            ->get();

        // Step 2: Simpan JSON asli (opsional)
        Storage::disk('public')->put('json/lowongan_data_original.json', $data->toJson(JSON_PRETTY_PRINT));

        // Step 3: Kategorisasi lokasi sebelum matching dengan preferensi
        $categorizedData = $data->map(function ($item) {
            return [
                'lowongan_id' => $item->lowongan_id,
                'lokasi_original' => $item->lokasi,
                'lokasi_kategori' => $this->kategorisasiLokasi($item->lokasi),
                'open_remote' => $item->open_remote,
                'jenis_magang' => $item->jenis_magang,
                'pekerjaan' => $item->pekerjaan,
                'bidang_industri' => $item->bidang_industri
            ];
        });

        // Step 4: Simpan hasil kategorisasi ke JSON
        Storage::disk('public')->put('json/lowongan_data_categorized.json', $categorizedData->toJson(JSON_PRETTY_PRINT));

        // Step 5: Ambil preferensi mahasiswa
        $preferensi = $this->preferensiMahasiswa();

        // Step 6: Bandingkan dengan preferensi → Skor 2 jika cocok, 1 jika tidak
        $numericData = $categorizedData->map(function ($item) use ($preferensi) {
            return [
                'lowongan_id' => $item['lowongan_id'],
                'lokasi_score' => strtolower($item['lokasi_kategori']) === strtolower($preferensi['lokasi_kategori']) ? 2 : 1,
                'remote_score' => strtolower($item['open_remote']) === strtolower($preferensi['open_remote']) ? 2 : 1,
                'jenis_magang_score' => strtolower($item['jenis_magang']) === strtolower($preferensi['jenis_magang']) ? 2 : 1,
                'pekerjaan_score' => strtolower($item['pekerjaan']) === strtolower($preferensi['pekerjaan']) ? 2 : 1,
                'industri_score' => strtolower($item['bidang_industri']) === strtolower($preferensi['bidang_industri']) ? 2 : 1,
            ];
        });

        // Step 7: Simpan hasil numeric ke JSON
        Storage::disk('public')->put('json/lowongan_data_numeric.json', $numericData->toJson(JSON_PRETTY_PRINT));

        // Step 8: MULTIMOORA (pakai fungsi sebelumnya)
        $results = $this->multiMoora($numericData->toArray());

        // Step 9: Simpan hasil ranking ke JSON
        Storage::disk('public')->put('json/lowongan_ranking_results.json', json_encode($results, JSON_PRETTY_PRINT));

        return response()->json([
            'original' => $data,
            'categorized' => $categorizedData,
            'numeric' => $numericData,
            'ranking' => $results,
        ]);
    }

    // Fungsi kategorisasi lokasi
    private function kategorisasiLokasi($lokasi)
    {
        $lokasi = strtolower(trim($lokasi));

        // Area Malang
        $areaMalang = ['malang', 'malang kota', 'kota malang', 'malang raya', 'batu', 'kabupaten malang'];

        // Luar area Malang Raya (dalam provinsi Jawa Timur)
        $jawaTimur = [
            'surabaya',
            'sidoarjo',
            'gresik',
            'lamongan',
            'tuban',
            'bojonegoro',
            'ngawi',
            'madiun',
            'ponorogo',
            'pacitan',
            'trenggalek',
            'tulungagung',
            'kediri',
            'blitar',
            'jombang',
            'mojokerto',
            'pasuruan',
            'probolinggo',
            'lumajang',
            'jember',
            'bondowoso',
            'situbondo',
            'banyuwangi',
            'sampang',
            'pamekasan',
            'sumenep',
            'bangkalan'
        ];

        // Luar negeri
        $luarNegeri = [
            'singapore',
            'singapura',
            'malaysia',
            'thailand',
            'vietnam',
            'philippines',
            'filipina',
            'japan',
            'jepang',
            'korea',
            'china',
            'taiwan',
            'hong kong',
            'australia',
            'new zealand',
            'usa',
            'america',
            'united states',
            'canada',
            'uk',
            'england',
            'germany',
            'france',
            'netherlands',
            'belanda',
            'dubai',
            'saudi arabia'
        ];

        // Remote
        if (strpos($lokasi, 'remote') !== false || strpos($lokasi, 'work from home') !== false || strpos($lokasi, 'wfh') !== false) {
            return 'Remote';
        }

        // Cek Area Malang
        foreach ($areaMalang as $area) {
            if (strpos($lokasi, $area) !== false) {
                return 'Area Malang';
            }
        }

        // Cek Luar Negeri
        foreach ($luarNegeri as $negara) {
            if (strpos($lokasi, $negara) !== false) {
                return 'Luar Negeri';
            }
        }

        // Cek Jawa Timur (luar area Malang Raya)
        foreach ($jawaTimur as $kota) {
            if (strpos($lokasi, $kota) !== false) {
                return 'Luar Area Malang Raya (dalam provinsi)';
            }
        }

        // Default: Luar provinsi Jawa Timur (untuk kota-kota Indonesia lainnya)
        return 'Luar Provinsi Jawa Timur';
    }

    // Preferensi Mahasiswa bisa didapat dari DB / auth user
    private function preferensiMahasiswa()
    {
        // Contoh preferensi mahasiswa — nanti bisa dari tabel preferensi_mahasiswa
        return [
            'lokasi_kategori' => 'Remote', // Sekarang menggunakan kategori lokasi
            'open_remote' => 'ya',
            'jenis_magang' => 'berbayar',
            'pekerjaan' => 'Backend Developer',
            'bidang_industri' => 'Teknologi'
        ];
    }

    // Fungsi MultiMoora (implementasi sesuai kebutuhan)
    private function multiMoora($data)
    {
        // Implementasi algoritma MultiMoora
        // Ini adalah placeholder - sesuaikan dengan implementasi MultiMoora yang sudah ada

        // Contoh sederhana ranking berdasarkan total score
        $ranked = collect($data)->map(function ($item) {
            $totalScore = $item['lokasi_score'] + $item['remote_score'] +
                $item['jenis_magang_score'] + $item['pekerjaan_score'] +
                $item['industri_score'];
            return array_merge($item, ['total_score' => $totalScore]);
        })->sortByDesc('total_score')->values();

        return $ranked->toArray();
    }
}
