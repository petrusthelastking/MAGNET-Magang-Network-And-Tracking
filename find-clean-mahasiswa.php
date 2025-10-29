<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "====================================\n";
    echo "Mencari Mahasiswa Bersih untuk Testing\n";
    echo "====================================\n\n";
    
    // Get all mahasiswa
    $allMahasiswa = DB::table('mahasiswa')
        ->select('id', 'nim', 'nama', 'status_magang')
        ->orderBy('id')
        ->get();
    
    echo "Total mahasiswa di database: " . $allMahasiswa->count() . "\n\n";
    
    $cleanMahasiswa = [];
    
    foreach ($allMahasiswa as $mhs) {
        // Check if has any berkas pengajuan
        $hasBerkas = DB::table('berkas_pengajuan_magang')
            ->where('mahasiswa_id', $mhs->id)
            ->exists();
        
        // Check if has any kontrak magang
        $hasKontrak = DB::table('kontrak_magang')
            ->where('mahasiswa_id', $mhs->id)
            ->exists();
        
        // Check if has any log magang (via kontrak)
        $hasLogMagang = DB::table('log_magang')
            ->whereIn('kontrak_magang_id', function($query) use ($mhs) {
                $query->select('id')
                    ->from('kontrak_magang')
                    ->where('mahasiswa_id', $mhs->id);
            })
            ->exists();
        
        // Check if has any ulasan
        $hasUlasan = DB::table('ulasan_magang')
            ->whereIn('kontrak_magang_id', function($query) use ($mhs) {
                $query->select('id')
                    ->from('kontrak_magang')
                    ->where('mahasiswa_id', $mhs->id);
            })
            ->exists();
        
        if (!$hasBerkas && !$hasKontrak && !$hasLogMagang && !$hasUlasan && $mhs->status_magang == 'belum magang') {
            $cleanMahasiswa[] = [
                'id' => $mhs->id,
                'nim' => $mhs->nim,
                'nama' => $mhs->nama,
                'status_magang' => $mhs->status_magang
            ];
        }
    }
    
    if (empty($cleanMahasiswa)) {
        echo "❌ Tidak ada mahasiswa yang benar-benar bersih!\n\n";
        echo "Menampilkan mahasiswa dengan status 'belum magang':\n";
        echo str_repeat("-", 80) . "\n";
        
        foreach ($allMahasiswa as $mhs) {
            if ($mhs->status_magang == 'belum magang') {
                $hasBerkas = DB::table('berkas_pengajuan_magang')->where('mahasiswa_id', $mhs->id)->exists();
                $hasKontrak = DB::table('kontrak_magang')->where('mahasiswa_id', $mhs->id)->exists();
                $hasLog = DB::table('log_magang')
                    ->whereIn('kontrak_magang_id', function($query) use ($mhs) {
                        $query->select('id')->from('kontrak_magang')->where('mahasiswa_id', $mhs->id);
                    })
                    ->exists();
                
                echo sprintf("ID: %d | NIM: %s | Nama: %s\n", $mhs->id, $mhs->nim, $mhs->nama);
                echo sprintf("  - Berkas: %s | Kontrak: %s | Log: %s\n", 
                    $hasBerkas ? 'Ada' : 'Kosong',
                    $hasKontrak ? 'Ada' : 'Kosong',
                    $hasLog ? 'Ada' : 'Kosong'
                );
                echo "\n";
            }
        }
    } else {
        echo "✅ Ditemukan " . count($cleanMahasiswa) . " mahasiswa BERSIH untuk testing:\n";
        echo str_repeat("=", 80) . "\n\n";
        
        foreach ($cleanMahasiswa as $idx => $mhs) {
            echo ($idx + 1) . ". NIM: {$mhs['nim']}\n";
            echo "   Nama: {$mhs['nama']}\n";
            echo "   Status: {$mhs['status_magang']}\n";
            echo "   ID: {$mhs['id']}\n\n";
        }
        
        // Get password hint
        echo str_repeat("=", 80) . "\n";
        echo "📝 Untuk mendapatkan password, coba:\n";
        echo "   1. Gunakan password default seperti: mahasiswa123, diana123, password\n";
        echo "   2. Atau buat password baru dengan: \n";
        echo "      php artisan tinker\n";
        echo "      DB::table('mahasiswa')->where('nim', 'NIM_MAHASISWA')->update(['password' => bcrypt('password123')]);\n\n";
    }
    
    echo "\n====================================\n";
    echo "Selesai\n";
    echo "====================================\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
