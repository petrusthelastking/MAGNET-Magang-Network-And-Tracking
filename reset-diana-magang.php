<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    // Get mahasiswa ID
    $mahasiswaId = DB::table('mahasiswa')
        ->where('nim', '2341720228')
        ->value('id');
    
    if (!$mahasiswaId) {
        echo "Mahasiswa dengan NIM 2341720228 tidak ditemukan!\n";
        exit(1);
    }
    
    echo "Mahasiswa ID: {$mahasiswaId}\n";
    
    // Get berkas IDs
    $berkasIds = DB::table('berkas_pengajuan_magang')
        ->where('mahasiswa_id', $mahasiswaId)
        ->pluck('id')
        ->toArray();
    
    echo "Jumlah berkas yang akan dihapus: " . count($berkasIds) . "\n";
    
    // Delete from form_pengajuan_magang first (child table)
    $deletedForms = DB::table('form_pengajuan_magang')
        ->whereIn('pengajuan_id', $berkasIds)
        ->delete();
    
    echo "Deleted {$deletedForms} records from form_pengajuan_magang\n";
    
    // Delete from berkas_pengajuan_magang
    $deletedBerkas = DB::table('berkas_pengajuan_magang')
        ->where('mahasiswa_id', $mahasiswaId)
        ->delete();
    
    echo "Deleted {$deletedBerkas} records from berkas_pengajuan_magang\n";
    
    echo "\n✅ Reset pengajuan magang Diana (NIM: 2341720228) berhasil!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
