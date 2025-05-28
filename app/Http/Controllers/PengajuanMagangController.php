<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Magang;
use App\Models\BerkasPengajuanMagang;
use App\Models\FormPengajuanMagang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengajuanMagangController extends Controller
{
    /**
     * Buat direktori jika belum ada
     */
    private function ensureDirectoryExists($path)
    {
        $fullPath = storage_path('app/public/' . $path);

        if (!is_dir($fullPath)) {
            mkdir($fullPath, 0755, true);
            Log::info('Directory created: ' . $fullPath);
        }

        return $fullPath;
    }

    /**
     * Generate nama file yang aman
     */
    private function generateFileName($mahasiswa, $type, $extension = 'pdf')
    {
        $date = now()->format('Y-m-d');
        $name = preg_replace('/[^a-z0-9_]/', '', str_replace(' ', '_', strtolower($mahasiswa->nama)));

        return "{$type}_{$date}_{$name}.{$extension}";
    }

    /**
     * Update status pengajuan magang ke 'menunggu'
     */
    private function updateStatusPengajuan($mahasiswaId)
    {
        try {
            // Cari berkas pengajuan mahasiswa
            $berkas = BerkasPengajuanMagang::where('mahasiswa_id', $mahasiswaId)->latest()->first();

            if ($berkas) {
                // Update status form pengajuan menjadi 'menunggu'
                FormPengajuanMagang::where('pengajuan_id', $berkas->id)
                    ->update([
                        'status' => 'menunggu',
                        'keterangan' => 'Dokumen telah dikirim, menunggu review admin',
                        'updated_at' => now()
                    ]);

                Log::info('Status pengajuan updated to menunggu', [
                    'mahasiswa_id' => $mahasiswaId,
                    'berkas_id' => $berkas->id
                ]);

                return true;
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Error updating status pengajuan', [
                'mahasiswa_id' => $mahasiswaId,
                'message' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Public method untuk mengubah status ke menunggu
     */
    public function setStatusMenunggu($mahasiswaId)
    {
        return $this->updateStatusPengajuan($mahasiswaId);
    }

    public function storePengajuan(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'cv' => 'required|file|mimes:pdf|max:2048',
                'transkrip_nilai' => 'required|file|mimes:pdf|max:2048',
                'portfolio' => 'nullable|file|mimes:pdf|max:2048',
            ], [
                'cv.required' => 'CV wajib diupload.',
                'cv.file' => 'CV harus berupa file.',
                'cv.mimes' => 'CV harus berupa file PDF.',
                'cv.max' => 'Ukuran file CV maksimal 2 MB.',
                'transkrip_nilai.required' => 'Transkrip nilai wajib diupload.',
                'transkrip_nilai.file' => 'Transkrip nilai harus berupa file.',
                'transkrip_nilai.mimes' => 'Transkrip nilai harus berupa file PDF.',
                'transkrip_nilai.max' => 'Ukuran file transkrip maksimal 2 MB.',
                'portfolio.file' => 'Portofolio harus berupa file.',
                'portfolio.mimes' => 'Portofolio harus berupa file PDF.',
                'portfolio.max' => 'Ukuran file portofolio maksimal 2 MB.',
            ]);

            // Ambil data mahasiswa
            $mahasiswaId = Session::get('user_id') ?? auth('mahasiswa')->id();
            $mahasiswa = Mahasiswa::find($mahasiswaId);

            if (!$mahasiswa) {
                return back()->with('error', 'Data mahasiswa tidak ditemukan. Silakan login ulang.');
            }

            // Cek dan hapus berkas lama jika ada
            $existing = BerkasPengajuanMagang::where('mahasiswa_id', $mahasiswa->id)->first();
            if ($existing) {
                // Hapus form pengajuan yang terkait
                FormPengajuanMagang::where('pengajuan_id', $existing->id)->delete();

                // Hapus file-file lama
                foreach (['cv', 'transkrip_nilai', 'portfolio'] as $file) {
                    if ($existing->$file && Storage::disk('public')->exists($existing->$file)) {
                        Storage::disk('public')->delete($existing->$file);
                    }
                }
                $existing->delete();
            }

            // Pastikan direktori penyimpanan ada
            $this->ensureDirectoryExists('pengajuan-magang/cv');
            $this->ensureDirectoryExists('pengajuan-magang/transkrip');
            $this->ensureDirectoryExists('pengajuan-magang/portfolio');

            // Simpan file dengan nama yang terstruktur
            $cvFileName = $this->generateFileName($mahasiswa, 'cv');
            $transkripFileName = $this->generateFileName($mahasiswa, 'transkrip');

            $cvPath = $request->file('cv')->storeAs('pengajuan-magang/cv', $cvFileName, 'public');
            $transkripPath = $request->file('transkrip_nilai')->storeAs('pengajuan-magang/transkrip', $transkripFileName, 'public');

            $portfolioPath = null;
            if ($request->hasFile('portfolio')) {
                $portfolioFileName = $this->generateFileName($mahasiswa, 'portfolio');
                $portfolioPath = $request->file('portfolio')->storeAs('pengajuan-magang/portfolio', $portfolioFileName, 'public');
            }

            // Simpan data ke database dalam transaksi
            DB::transaction(function () use ($mahasiswa, $cvPath, $transkripPath, $portfolioPath) {
                // Buat berkas pengajuan
                $berkas = BerkasPengajuanMagang::create([
                    'mahasiswa_id' => $mahasiswa->id,
                    'cv' => $cvPath,
                    'transkrip_nilai' => $transkripPath,
                    'portfolio' => $portfolioPath
                ]);

                // Buat form pengajuan dengan status 'menunggu'
                FormPengajuanMagang::create([
                    'pengajuan_id' => $berkas->id,
                    'status' => 'menunggu',
                    'keterangan' => 'Dokumen telah dikirim, menunggu review admin'
                ]);

                // Update status pengajuan ke menunggu
                $this->updateStatusPengajuan($mahasiswa->id);
            });

            return redirect()->route('mahasiswa.pengajuan-magang')
                ->with('success', 'Pengajuan magang berhasil dikirim! Status pengajuan telah diubah menjadi menunggu review.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Terdapat kesalahan dalam pengisian form. Silakan periksa kembali.');
        } catch (\Exception $e) {
            Log::error('Error pengajuan magang', [
                'mahasiswa_id' => Session::get('user_id') ?? auth('mahasiswa')->id(),
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi admin.');
        }
    }
}
