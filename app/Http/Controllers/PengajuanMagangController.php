<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaProfiles;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanMagangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:mahasiswa');
    }

    /**
     * Menampilkan status magang mahasiswa yang sedang login.
     */
    public function index()
    {
        $user = Auth::user();

        $mahasiswa = MahasiswaProfiles::with('programStudi')
            ->where('user_id', $user->id)
            ->first();

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Profil mahasiswa tidak ditemukan.');
        }

        // Pastikan status_magang selalu ada, jika null gunakan 'Tidak magang'
        $statusMagang = $mahasiswa->status_magang ?? 'Tidak magang';

        // Kirim variable statusMagang ke view
        return view('pages.mahasiswa.pengajuan-magang', [
            'statusMagang' => $statusMagang
        ]);
    }

    /**
     * Menampilkan form pengajuan magang dengan data mahasiswa.
     */
    public function showForm()
    {
        $user = Auth::user();

        $mahasiswa = MahasiswaProfiles::with('programStudi')->where('user_id', $user->id)->first();

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Profil mahasiswa tidak ditemukan.');
        }

        // Add this code to fetch available internship opportunities
        $lowonganMagang = \App\Models\LowonganMagang::with('perusahaan')
            ->where('status', 'tersedia')
            ->where('tanggal_selesai', '>=', now())
            ->get()
            ->map(function ($lowongan) {
                return (object) [
                    'id' => $lowongan->id,
                    'judul' => $lowongan->judul,
                    'perusahaan' => $lowongan->perusahaan->nama_perusahaan
                ];
            });

        return view('pages.mahasiswa.form-pengajuan-magang', [
            'nama' => $user->name,
            'jurusan' => 'Teknologi Informasi', // hardcoded sesuai instruksi
            'programStudi' => $mahasiswa->programStudi->nama_program,
            'mahasiswa' => $mahasiswa,
            'lowonganMagang' => $lowonganMagang, // Add this line to pass data to view
        ]);
    }

    /**
     * Menyimpan data pengajuan magang baru.
     */
    public function storePengajuan(Request $request)
    {
        $request->validate([
            'lowongan_id' => 'required|exists:lowongan_magang,id', // Add this validation
            'cv' => 'required|file|mimes:pdf|max:2048',
            'transkrip_nilai' => 'required|file|mimes:pdf|max:2048',
        ], [
            'lowongan_id.required' => 'Pilihan perusahaan/lowongan magang wajib diisi.',
            'lowongan_id.exists' => 'Lowongan magang yang dipilih tidak valid.',
            'cv.required' => 'File CV wajib diunggah.',
            'cv.mimes' => 'File CV harus berformat PDF.',
            'cv.max' => 'Ukuran file CV tidak boleh lebih dari 2MB.',
            'transkrip_nilai.required' => 'File transkrip nilai wajib diunggah.',
            'transkrip_nilai.mimes' => 'File transkrip nilai harus berformat PDF.',
            'transkrip_nilai.max' => 'Ukuran transkrip nilai tidak boleh lebih dari 2MB.',
        ]);

        $user = Auth::user();
        $mahasiswa = MahasiswaProfiles::where('user_id', $user->id)->first();

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Profil mahasiswa tidak ditemukan.');
        }

        // Upload file
        $cvPath = $request->file('cv')->store('cv_magang', 'public');
        $transkripPath = $request->file('transkrip_nilai')->store('transkrip_magang', 'public');

        // Simpan pengajuan
        $pengajuan = $mahasiswa->pengajuanMagang()->create([
            'lowongan_id' => $request->lowongan_id, // Add this line to save the selected lowongan_id
            'cv' => $cvPath,
            'transkrip_nilai' => $transkripPath,
            'status' => 'pending', // Status awal: menunggu persetujuan admin
        ]);

        // Update status magang mahasiswa menjadi 'Menunggu Persetujuan'
        $mahasiswa->update(['status_magang' => 'Menunggu Persetujuan']);

        return redirect()->route('mahasiswa.pengajuan-magang')->with('success', 'Pengajuan magang berhasil diajukan. Menunggu persetujuan admin kampus.');
    }
}
