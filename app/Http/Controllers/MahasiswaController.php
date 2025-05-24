<?php

namespace App\Http\Controllers;

use App\Models\PreferensiMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\mahasiswa;

class MahasiswaController extends Controller
{
    /**
     * Get current authenticated mahasiswa
     */
    private function getCurrentMahasiswa()
    {
        $userId = Session::get('user_id');
        $userRole = Session::get('user_role');

        if (!$userId || $userRole !== 'mahasiswa') {
            return null;
        }

        return mahasiswa::find($userId);
    }

    /**
     * Display mahasiswa dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $mahasiswa = $this->getCurrentMahasiswa();

        if (!$mahasiswa) {
            return redirect()->route('login');
        }

        return view('mahasiswa.dashboard', compact('mahasiswa'));
    }

    /**
     * Display mahasiswa profile.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        $mahasiswa = $this->getCurrentMahasiswa();

        if (!$mahasiswa) {
            return redirect()->route('login');
        }

        $preferensi = PreferensiMahasiswa::where('mahasiswa_id', $mahasiswa->id)->first();

        return view('pages.mahasiswa.setting-profile', compact('mahasiswa', 'preferensi'));
    }

    /**
     * Show the form for editing mahasiswa profile.
     *
     * @return \Illuminate\View\View
     */
    public function editProfile()
    {
        $mahasiswa = $this->getCurrentMahasiswa();

        if (!$mahasiswa) {
            return redirect()->route('login');
        }

        return view('mahasiswa.edit-profile', compact('mahasiswa'));
    }

    /**
     * Update the user and mahasiswa profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $mahasiswa = $this->getCurrentMahasiswa();

        if (!$mahasiswa) {
            return redirect()->route('login');
        }

        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update mahasiswa
        $mahasiswa->nama = $validated['nama'];
        $mahasiswa->alamat = $validated['alamat'] ?? $mahasiswa->alamat;

        // Update password jika diisi
        if (!empty($validated['password'])) {
            $mahasiswa->password = Hash::make($validated['password']);
        }

        // Upload dan update foto jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($mahasiswa->foto_path) {
                Storage::disk('public')->delete($mahasiswa->foto_path);
            }

            // Upload foto baru
            $fotoPath = $request->file('foto')->store('profile-photos', 'public');
            $mahasiswa->foto_path = $fotoPath;
        }

        $mahasiswa->save();

        // Update session data
        Session::put('user_data', [
            'id' => $mahasiswa->id,
            'nama' => $mahasiswa->nama,
            'role' => 'mahasiswa',
            'identifier' => $mahasiswa->nim
        ]);

        return redirect()->route('mahasiswa.setting-profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Show the form for creating or editing preferensi magang.
     *
     * @return \Illuminate\View\View
     */
    public function editPreferensiMahasiswa()
    {
        $mahasiswa = $this->getCurrentMahasiswa();

        if (!$mahasiswa) {
            return redirect()->route('login');
        }

        $preferensi = PreferensiMahasiswa::where('mahasiswa_id', $mahasiswa->id)->first();

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
    public function updatePreferensiMahasiswa(Request $request): RedirectResponse
    {
        $mahasiswa = $this->getCurrentMahasiswa();

        if (!$mahasiswa) {
            return redirect()->route('login');
        }

        // Validasi input
        $validated = $request->validate([
            'keahlian' => 'required|string',
            'pekerjaan_impian' => 'required|string',
            'lokasi_magang' => 'required|string',
            'bidang_industri' => 'required|string',
            'upah_minimum' => 'nullable|numeric|min:0',
        ]);

        // Cari atau buat preferensi magang
        $preferensi = PreferensiMahasiswa::firstOrNew(['mahasiswa_id' => $mahasiswa->id]);

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
     * Show setting profile page.
     *
     * @return \Illuminate\View\View
     */
    public function settingProfile()
    {
        $mahasiswa = $this->getCurrentMahasiswa();

        if (!$mahasiswa) {
            return redirect()->route('login');
        }

        $preferensi = PreferensiMahasiswa::where('mahasiswa_id', $mahasiswa->id)->first();

        return view('pages.mahasiswa.setting-profile', compact('mahasiswa', 'preferensi'));
    }
}
