<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\KontrakMagang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PembaruanStatusController extends Controller
{
    public function index()
    {
        $mahasiswaId = Session::get('user_id');
        $mahasiswa = Mahasiswa::find($mahasiswaId);

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Profil mahasiswa tidak ditemukan.');
        }

        $kontrakMagang = null;
        $perusahaan = null;

        // Jika status magang adalah 'sedang magang', ambil data perusahaan tempat magang
        if ($mahasiswa->status_magang === 'sedang magang') {
            $kontrakMagang = KontrakMagang::with(['magang.perusahaan'])
                ->where('mahasiswa_id', $mahasiswaId)
                ->first();

            if ($kontrakMagang && $kontrakMagang->magang && $kontrakMagang->magang->perusahaan) {
                $perusahaan = $kontrakMagang->magang->perusahaan;
            }
        }

        return view('pages.mahasiswa.pembaruan-status', [
            'mahasiswa' => $mahasiswa,
            'kontrakMagang' => $kontrakMagang,
            'perusahaan' => $perusahaan
        ]);
    }

    public function updateStatus(Request $request)
    {
        try {
            $mahasiswaId = Session::get('user_id');
            $mahasiswa = Mahasiswa::find($mahasiswaId);

            if (!$mahasiswa) {
                return back()->with('error', 'Data mahasiswa tidak ditemukan.');
            }

            $newStatus = $request->input('status_magang');

            // Validasi status yang diizinkan
            $allowedStatuses = ['belum magang', 'sedang magang', 'selesai magang'];
            if (!in_array($newStatus, $allowedStatuses)) {
                return back()->with('error', 'Status magang tidak valid.');
            }

            // Validasi hanya jika status magang adalah 'sedang magang'
            if ($newStatus === 'sedang magang') {
                $validated = $request->validate([
                    'nama_perusahaan_magang' => 'required|string|max:255',
                    'lokasi_magang' => 'required|string|max:255',
                    'surat_izin_magang' => 'required|file|mimes:pdf|max:2048'
                ], [
                    'lokasi_magang.required' => 'Lokasi magang wajib diisi.',
                    'lokasi_magang.max' => 'Lokasi magang maksimal 255 karakter.',
                    'surat_izin_magang.required' => 'Surat izin magang wajib diupload.',
                    'surat_izin_magang.mimes' => 'Surat izin magang harus berupa file PDF.',
                    'surat_izin_magang.max' => 'Ukuran file maksimal 2 MB.'
                ]);

                // Cari kontrak magang mahasiswa
                $kontrakMagang = KontrakMagang::where('mahasiswa_id', $mahasiswaId)->first();

                if (!$kontrakMagang) {
                    return back()->with('error', 'Data kontrak magang tidak ditemukan.');
                }

                // Hapus file lama jika ada
                if ($kontrakMagang->surat_izin_magang && Storage::disk('public')->exists($kontrakMagang->surat_izin_magang)) {
                    Storage::disk('public')->delete($kontrakMagang->surat_izin_magang);
                }

                // Format nama file
                $date = now()->format('Y-m-d');
                $name = preg_replace('/[^a-z0-9_]/', '', str_replace(' ', '_', strtolower($mahasiswa->nama)));

                // Simpan file surat izin magang
                $suratPath = $request->file('surat_izin_magang')
                    ->storeAs('surat_izin_magang', "surat_izin_{$date}_{$name}.pdf", 'public');

                // Update data kontrak magang
                $kontrakMagang->update([
                    'nama_perusahaan_magang' => $validated['nama_perusahaan_magang'],
                    'lokasi_magang' => $validated['lokasi_magang'],
                    'surat_izin_magang' => $suratPath
                ]);
            }

            // Validasi untuk status 'selesai magang'
            if ($newStatus === 'selesai magang') {
                $validated = $request->validate([
                    'bukti_surat_selesai_magang' => 'required|file|mimes:pdf|max:2048', // 2 MB
                ], [
                    'bukti_surat_selesai_magang.required' => 'Bukti selesai magang wajib diupload.',
                    'bukti_surat_selesai_magang.mimes' => 'Bukti selesai magang harus berupa file PDF.',
                    'bukti_surat_selesai_magang.max' => 'Ukuran file maksimal 2 MB.',
                ]);

                $kontrakMagang = KontrakMagang::where('mahasiswa_id', $mahasiswaId)->first();

                if (!$kontrakMagang) {
                    return back()->with('error', 'Data kontrak magang tidak ditemukan.');
                }

                // Format nama file
                $date = now()->format('Y-m-d');
                $name = preg_replace('/[^a-z0-9_]/', '', str_replace(' ', '_', strtolower($mahasiswa->nama)));

                // Simpan laporan magang
                $laporanPath = $request->file('bukti_surat_selesai_magang')
                    ->storeAs('bukti_surat_selesai_magang', "laporan_{$date}_{$name}.pdf", 'public');

                $updateData = ['bukti_surat_selesai_magang' => $laporanPath];

                // Update data kontrak magang
                $kontrakMagang->update($updateData);
            }

            // Update status magang mahasiswa
            $mahasiswa->update(['status_magang' => $newStatus]);

            $statusLabel = [
                'belum magang' => 'Belum Magang',
                'sedang magang' => 'Sedang Magang',
                'selesai magang' => 'Selesai Magang'
            ];

            return redirect()->back()->with(
                'success',
                "Status magang berhasil diperbarui menjadi: {$statusLabel[$newStatus]}"
            );

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Terdapat kesalahan dalam pengisian form.');
        } catch (\Exception $e) {
            \Log::error('Error update pembaruan status magang', [
                'mahasiswa_id' => Session::get('user_id'),
                'message' => $e->getMessage()
            ]);

            return back()->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }

    //ambil data perusahaan yang mitra dengan kampus
    public function getPerusahaanMitra()
    {
        $mahasiswaId = Session::get('user_id');
        $mahasiswa = Mahasiswa::find($mahasiswaId);

        if (!$mahasiswa) {
            return response()->json(['error' => 'Mahasiswa tidak ditemukan'], 404);
        }

        $perusahaanMitra = $mahasiswa->perusahaanMitra()->get();

        return view('pages.mahasiswa.pembaruan-status-sedang-magang', [
            'mahasiswa' => $mahasiswa,
            'perusahaanMitra' => $perusahaanMitra
        ]);
    }

    //tambah perusahaan jika non mitra
    public function tambahPerusahaan(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255|unique:perusahaan,nama',
                'bidang_industri' => 'required|in:Perbankan,Kesehatan,Pendidikan,E-Commerce,Telekomunikasi,Transportasi,Pemerintahan,Manufaktur,Energi,Media,Teknologi,Agrikultur,Pariwisata,Keamanan',
                'lokasi' => 'required|string|max:255',
                'rating' => 'nullable|numeric|min:0|max:5',
            ], [
                'nama.required' => 'Nama perusahaan wajib diisi.',
                'nama.unique' => 'Perusahaan dengan nama ini sudah terdaftar.',
                'bidang_industri.required' => 'Bidang industri wajib dipilih.',
                'lokasi.required' => 'Lokasi perusahaan wajib diisi.',
                'rating.numeric' => 'Rating harus berupa angka.',
                'rating.min' => 'Rating minimal 0.',
                'rating.max' => 'Rating maksimal 5.',
            ]);

            // Simpan perusahaan baru dengan kategori non_mitra
            $perusahaanId = DB::table('perusahaan')->insertGetId([
                'nama' => $validated['nama'],
                'bidang_industri' => $validated['bidang_industri'],
                'lokasi' => $validated['lokasi'],
                'kategori' => 'non_mitra',
                'rating' => $validated['rating'] ?? null
            ]);

            return response()->json([
                'message' => 'Perusahaan non mitra berhasil ditambahkan.',
                'perusahaan' => $perusahaanId
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
                'message' => 'Terdapat kesalahan pada input data.'
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error tambah perusahaan', ['message' => $e->getMessage()]);

            return response()->json([
                'message' => 'Terjadi kesalahan sistem. Perusahaan gagal ditambahkan.'
            ], 500);
        }
    }
}
