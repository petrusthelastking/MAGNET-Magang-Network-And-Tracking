<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\MahasiswaProfiles;
use App\Models\PreferensiMagang;


class MahasiswaController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');              // Hanya user yang login
        $this->middleware('role:mahasiswa');    // Hanya role mahasiswa yang boleh masuk
    }

    /**
     * Display mahasiswa dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $user = auth()->user();
        $mahasiswa = MahasiswaProfiles::where('user_id', $user->id)->first();

        return view('mahasiswa.dashboard', compact('user', 'mahasiswa'));
    }

    /**
     * Display mahasiswa profile.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        $user = auth()->user();
        $mahasiswa = MahasiswaProfiles::where('user_id', $user->id)
            ->with('programStudi')
            ->first();

        return view('mahasiswa.profile', compact('user', 'mahasiswa'));
    }

    /**
     * Show the form for editing mahasiswa profile.
     *
     * @return \Illuminate\View\View
     */
    public function editProfile()
    {
        $user = auth()->user();
        $mahasiswa = MahasiswaProfiles::where('user_id', $user->id)->first();

        return view('mahasiswa.edit-profile', compact('user', 'mahasiswa'));
    }

    /**
     * Update the user and mahasiswa profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $user = auth()->user();

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update user
        $user->name = $validated['name'];

        // Update password jika diisi
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        // Upload dan update foto jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            $mahasiswa = MahasiswaProfiles::where('user_id', $user->id)->first();
            if ($mahasiswa && $mahasiswa->foto_path) {
                Storage::disk('public')->delete($mahasiswa->foto_path);
            }

            // Upload foto baru
            $fotoPath = $request->file('foto')->store('profile-photos', 'public');

            // Update path foto di database
            if ($mahasiswa) {
                $mahasiswa->foto_path = $fotoPath;
                $mahasiswa->alamat = $validated['alamat'];
                $mahasiswa->save();
            }
        } else if (isset($validated['alamat'])) {
            // Update alamat tanpa foto
            $mahasiswa = MahasiswaProfiles::where('user_id', $user->id)->first();
            if ($mahasiswa) {
                $mahasiswa->alamat = $validated['alamat'];
                $mahasiswa->save();
            }
        }

        $user->save();

        return redirect()->route('mahasiswa.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Show the form for creating or editing preferensi magang.
     *
     * @return \Illuminate\View\View
     */
    public function editPreferensiMagang()
    {
        $user = auth()->user();
        $mahasiswa = MahasiswaProfiles::where('user_id', $user->id)->first();
        $preferensi = PreferensiMagang::where('mahasiswa_id', $mahasiswa->id)->first();

        // List untuk dropdown
        $keahlianList = [
            'Frontend',
            'Backend',
            'Software',
            'DevOps',
            'Data Scientist',
            'Data Engineer',
            'UI/UX Designer',
            'Cyber Security',
            'Mobile'
        ];

        $pekerjaanList = [
            'Frontend Developer',
            'Backend Developer',
            'Fullstack Developer',
            'Mobile Developer',
            'DevOps Engineer',
            'Data Scientist',
            'Data Engineer',
            'UI/UX Designer',
            'Cyber Security Specialist',
            'Game Developer',
            'AI Engineer',
            'Software Architect',
            'Product Manager',
            'QA Engineer',
            'System Analyst'
        ];

        $lokasiList = [
            'Malang',
            'Surabaya',
            'Jakarta',
            'Bandung',
            'Yogyakarta',
            'Semarang',
            'Denpasar',
            'Makassar',
            'Balikpapan',
            'Medan',
            'Remote'
        ];

        $industriList = [
            'Teknologi Informasi dan Komunikasi',
            'E-Commerce',
            'Pendidikan dan Pelatihan IT',
            'Konsultan IT',
            'Fintech',
            'Pemerintahan',
            'Startup Teknologi',
            'Telekomunikasi',
            'Manufaktur berbasis Teknologi',
            'Perbankan dan Keuangan Digital',
            'Media dan Kreatif Digital',
            'Game dan Hiburan Digital',
            'Kesehatan Berbasis Teknologi (Healthtech)',
            'Transportasi dan Logistik Digital',
            'Pertahanan dan Keamanan Siber'
        ];

        return view('mahasiswa.edit-preferensi-magang', compact(
            'user',
            'mahasiswa',
            'preferensi',
            'keahlianList',
            'pekerjaanList',
            'lokasiList',
            'industriList'
        ));
    }

    /**
     * Create or update preferensi magang.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePreferensiMagang(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $mahasiswa = MahasiswaProfiles::where('user_id', $user->id)->first();

        // Validasi input
        $validated = $request->validate([
            'keahlian' => 'required|string',
            'pekerjaan_impian' => 'required|string',
            'lokasi_magang' => 'required|string',
            'bidang_industri' => 'required|string',
            'upah_minimum' => 'nullable|numeric|min:0',
        ]);

        // Cari atau buat preferensi magang
        $preferensi = PreferensiMagang::firstOrNew(['mahasiswa_id' => $mahasiswa->id]);

        // Update data preferensi
        $preferensi->keahlian = $validated['keahlian'];
        $preferensi->pekerjaan_impian = $validated['pekerjaan_impian'];
        $preferensi->lokasi_magang = $validated['lokasi_magang'];
        $preferensi->bidang_inustri = $validated['bidang_industri']; // Perhatikan typo di skema DB

        // Update upah minimum jika ada
        if (isset($validated['upah_minimum'])) {
            $preferensi->upah_minimum = $validated['upah_minimum'];
        }

        $preferensi->save();

        return redirect()->route('mahasiswa.preference')
            ->with('success', 'Preferensi magang berhasil diperbarui.');
    }

    /**
     * Display preferensi magang.
     *
     * @return \Illuminate\View\View
     */
    public function showPreferensiMagang()
    {
        $user = auth()->user();
        $mahasiswa = MahasiswaProfiles::where('user_id', $user->id)->first();
        $preferensi = PreferensiMagang::where('mahasiswa_id', $mahasiswa->id)->first();

        return view('mahasiswa.preferensi-magang', compact('user', 'mahasiswa', 'preferensi'));
    }

    /**
     * Delete preferensi magang.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deletePreferensiMagang(): RedirectResponse
    {
        $user = auth()->user();
        $mahasiswa = MahasiswaProfiles::where('user_id', $user->id)->first();
        $preferensi = PreferensiMagang::where('mahasiswa_id', $mahasiswa->id)->first();

        if ($preferensi) {
            $preferensi->delete();
            return redirect()->route('mahasiswa.preference')
                ->with('success', 'Preferensi magang berhasil dihapus.');
        }

        return redirect()->route('mahasiswa.preference')
            ->with('info', 'Tidak ada preferensi magang untuk dihapus.');
    }

    /**
     * Show setting profile page.
     *
     * @return \Illuminate\View\View
     */
    public function settingProfile()
    {
        $user = auth()->user();
        $mahasiswa = MahasiswaProfiles::where('user_id', $user->id)
            ->with('programStudi')
            ->first();
        $preferensi = PreferensiMagang::where('mahasiswa_id', $mahasiswa->id)->first();

        return view('pages.mahasiswa.setting-profile', compact('user', 'mahasiswa', 'preferensi'));
    }
}
