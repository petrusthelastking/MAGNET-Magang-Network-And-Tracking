<?php

namespace App\Http\Controllers;

use App\Helpers\Auth\UserAuthenticationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function showDashboard()
    {
        $currentRole = UserAuthenticationHelper::getUserRole();
        return view("pages.user.dashboard", [
            "role" => $currentRole
        ]);
    }

    public function showProfile()
    {
        $currentRole = UserAuthenticationHelper::getUserRole();
        return view("pages.user.profile", [
            "role" => $currentRole
        ]);
    }

    public function showEditProfile()
    {
        $currentRole = UserAuthenticationHelper::getUserRole();
        $user = null;

        // Get authenticated user based on role
        switch ($currentRole) {
            case 'dosen':
                $user = auth('dosen')->user();
                break;
            case 'mahasiswa':
                $user = auth('mahasiswa')->user();
                break;
            case 'admin':
                $user = auth('admin')->user();
                break;
        }

        return view("pages.user.edit-profile", [
            "role" => $currentRole,
            "user" => $user
        ]);
    }

    public function updateProfile(Request $request)
    {
        $currentRole = UserAuthenticationHelper::getUserRole();

        // Validate based on role
        $rules = $this->getValidationRules($currentRole, $request);
        $request->validate($rules);

        try {
            switch ($currentRole) {
                case 'dosen':
                    $this->updateDosenProfile($request);
                    break;
                case 'mahasiswa':
                    $this->updateMahasiswaProfile($request);
                    break;
                case 'admin':
                    $this->updateAdminProfile($request);
                    break;
            }

            return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui profil: ' . $e->getMessage());
        }
    }

    private function updateDosenProfile(Request $request)
    {
        $dosen = auth('dosen')->user();

        // Update basic information
        $dosen->update([
            'nama' => $request->nama,
            'nidn' => $request->nidn,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        // Handle password update if provided
        if ($request->filled('password')) {
            $dosen->update([
                'password' => Hash::make($request->password)
            ]);
        }

        // Handle photo upload
        if ($request->hasFile('foto')) {
            $this->handlePhotoUpload($request->file('foto'), $dosen, 'dosen');
        }
    }

    private function updateMahasiswaProfile(Request $request)
    {
        $mahasiswa = auth('mahasiswa')->user();

        $mahasiswa->update([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        if ($request->filled('password')) {
            $mahasiswa->update([
                'password' => Hash::make($request->password)
            ]);
        }

        if ($request->hasFile('foto')) {
            $this->handlePhotoUpload($request->file('foto'), $mahasiswa, 'mahasiswa');
        }
    }

    private function updateAdminProfile(Request $request)
    {
        $admin = auth('admin')->user();

        $admin->update([
            'nama' => $request->nama,
            'username' => $request->username,
        ]);

        if ($request->filled('password')) {
            $admin->update([
                'password' => Hash::make($request->password)
            ]);
        }

        if ($request->hasFile('foto')) {
            $this->handlePhotoUpload($request->file('foto'), $admin, 'admin');
        }
    }

    private function getValidationRules($role, $request)
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'password' => 'nullable|string|min:6|confirmed',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        switch ($role) {
            case 'dosen':
                $rules['nidn'] = [
                    'required',
                    'string',
                    'max:20',
                    Rule::unique('dosen_pembimbing', 'nidn')->ignore(auth('dosen')->id())
                ];
                break;

            case 'mahasiswa':
                $rules['nim'] = [
                    'required',
                    'string',
                    'max:20',
                    Rule::unique('mahasiswa', 'nim')->ignore(auth('mahasiswa')->id())
                ];
                break;

            case 'admin':
                $rules['username'] = [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('admin', 'username')->ignore(auth('admin')->id())
                ];
                unset($rules['jenis_kelamin']); // Admin might not have gender field
                break;
        }

        return $rules;
    }

    private function handlePhotoUpload($file, $user, $role)
    {
        // Delete old photo if exists
        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }

        // Store new photo
        $filename = $role . '_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs("photos/{$role}", $filename, 'public');

        $user->update(['foto' => $path]);
    }

    public function deletePhoto(Request $request)
    {
        $currentRole = UserAuthenticationHelper::getUserRole();

        try {
            switch ($currentRole) {
                case 'dosen':
                    $user = auth('dosen')->user();
                    break;
                case 'mahasiswa':
                    $user = auth('mahasiswa')->user();
                    break;
                case 'admin':
                    $user = auth('admin')->user();
                    break;
            }

            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
                $user->update(['foto' => null]);
            }

            return response()->json(['success' => true, 'message' => 'Foto berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus foto']);
        }
    }
}
