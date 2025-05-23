<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Magang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PengajuanMagangController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Session::get('user_role') !== 'mahasiswa') {
                return redirect()->route('login')->with('error', 'Akses ditolak.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $mahasiswaId = Session::get('user_id');
        $mahasiswa = Mahasiswa::find($mahasiswaId);

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Profil mahasiswa tidak ditemukan.');
        }

        // Ubah default value menjadi 'belum magang' sesuai dengan enum di database
        $statusMagang = $mahasiswa->status_magang ?? 'belum magang';

        return view('pages.mahasiswa.pengajuan-magang', [
            'statusMagang' => $statusMagang
        ]);
    }

    public function showForm()
    {
        $mahasiswaId = Session::get('user_id');
        $mahasiswa = Mahasiswa::find($mahasiswaId);

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Profil mahasiswa tidak ditemukan.');
        }

        $lowonganMagang = Magang::with('perusahaan')->get();

        return view('pages.mahasiswa.form-pengajuan-magang', [
            'nama' => $mahasiswa->nama,
            'jurusan' => $mahasiswa->jurusan,
            'programStudi' => $mahasiswa->program_studi,
            'mahasiswa' => $mahasiswa,
            'lowonganMagang' => $lowonganMagang,
        ]);
    }

    public function storePengajuan(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'lowongan_id' => 'nullable|exists:magang,id',
                'cv' => 'required|file|mimes:pdf|max:2048',
                'transkrip_nilai' => 'required|file|mimes:pdf|max:2048',
                'portfolio' => 'nullable|file|mimes:pdf|max:2048',
            ], [
                'cv.required' => 'CV wajib diupload.',
                'cv.mimes' => 'CV harus berupa file PDF.',
                'cv.max' => 'Ukuran file CV maksimal 2 MB.',
                'transkrip_nilai.required' => 'Transkrip nilai wajib diupload.',
                'transkrip_nilai.mimes' => 'Transkrip nilai harus berupa file PDF.',
                'transkrip_nilai.max' => 'Ukuran file transkrip maksimal 2 MB.',
                'portfolio.mimes' => 'Portofolio harus berupa file PDF.',
                'portfolio.max' => 'Ukuran file portofolio maksimal 2 MB.',
            ]);

            // Ambil data mahasiswa
            $mahasiswaId = Session::get('user_id');
            $mahasiswa = Mahasiswa::find($mahasiswaId);

            if (!$mahasiswa) {
                return back()->with('error', 'Data mahasiswa tidak ditemukan. Silakan login ulang.');
            }

            // Cek dan hapus berkas lama jika ada
            $existing = \App\Models\BerkasPengajuanMagang::where('mahasiswa_id', $mahasiswa->id)->first();
            if ($existing) {
                foreach (['cv', 'transkrip_nilai', 'portfolio'] as $file) {
                    if ($existing->$file && \Storage::disk('public')->exists($existing->$file)) {
                        \Storage::disk('public')->delete($existing->$file);
                    }
                }
                $existing->delete();
            }

            // Format nama file
            $date = now()->format('Y-m-d');
            $name = preg_replace('/[^a-z0-9_]/', '', str_replace(' ', '_', strtolower($mahasiswa->nama)));

            // Simpan file
            $cvPath = $request->file('cv')->storeAs('cv', "cv_{$date}_{$name}.pdf", 'public');
            $transkripPath = $request->file('transkrip_nilai')->storeAs('transkrip', "transkrip_{$date}_{$name}.pdf", 'public');
            $portfolioPath = $request->hasFile('portfolio')
                ? $request->file('portfolio')->storeAs('portfolio', "portfolio_{$date}_{$name}.pdf", 'public')
                : null;

            // Simpan data ke database
            \DB::transaction(function () use ($mahasiswa, $cvPath, $transkripPath, $portfolioPath) {
                $berkas = \App\Models\BerkasPengajuanMagang::create([
                    'mahasiswa_id' => $mahasiswa->id,
                    'cv' => $cvPath,
                    'transkrip_nilai' => $transkripPath,
                    'portfolio' => $portfolioPath
                ]);

                \App\Models\FormPengajuanMagang::create([
                    'pengajuan_id' => $berkas->id,
                    'status' => 'menunggu',
                    'keterangan' => null,
                    'tanggal_pengajuan' => now()
                ]);
            });

            return redirect()->route('mahasiswa.pengajuan-magang')
                ->with('success', 'Pengajuan magang berhasil dikirim! Silakan cek riwayat pengajuan.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Terdapat kesalahan dalam pengisian form. Silakan periksa kembali.');
        } catch (\Exception $e) {
            \Log::error('Error pengajuan magang', [
                'mahasiswa_id' => Session::get('user_id'),
                'message' => $e->getMessage()
            ]);

            return back()->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi admin.');
        }
    }
}
