<?php

namespace App\Http\Controllers;

use App\Helpers\Auth\UserAuthenticationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
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
        $rules = $this->getValidationRules($currentRole);
        $request->validate($rules);

        try {
            $changes = [];

            switch ($currentRole) {
                case 'dosen':
                    $changes = $this->updateDosenProfile($request);
                    break;
                case 'mahasiswa':
                    $changes = $this->updateMahasiswaProfile($request);
                    break;
                case 'admin':
                    $changes = $this->updateAdminProfile($request);
                    break;
            }

            // Generate appropriate success message based on changes
            $message = $this->generateSuccessMessage($changes);

            return redirect()->route('profile')->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui profil: ' . $e->getMessage());
        }
    }

    private function updateDosenProfile(Request $request)
    {
        $dosen = auth('dosen')->user();
        $changes = [];

        // Track changes for basic information
        $fieldsToUpdate = [];

        if ($dosen->nama !== $request->nama) {
            $fieldsToUpdate['nama'] = $request->nama;
            $changes[] = 'nama';
        }

        if ($dosen->nidn !== $request->nidn) {
            $fieldsToUpdate['nidn'] = $request->nidn;
            $changes[] = 'nidn';
        }

        if ($dosen->jenis_kelamin !== $request->jenis_kelamin) {
            $fieldsToUpdate['jenis_kelamin'] = $request->jenis_kelamin;
            $changes[] = 'jenis_kelamin';
        }

        // Update basic information if there are changes
        if (!empty($fieldsToUpdate)) {
            $dosen->update($fieldsToUpdate);
        }

        // Handle password update if provided
        if ($request->filled('password')) {
            $dosen->update([
                'password' => Hash::make($request->password)
            ]);
            $changes[] = 'password';
        }

        // Handle photo upload
        if ($request->hasFile('foto')) {
            $this->handlePhotoUpload($request->file('foto'), $dosen, 'dosen');
            $changes[] = 'foto';
        }

        return $changes;
    }

    private function updateMahasiswaProfile(Request $request)
    {
        $mahasiswa = auth('mahasiswa')->user();
        $changes = [];

        // Track changes for basic information
        $fieldsToUpdate = [];

        if ($mahasiswa->nama !== $request->nama) {
            $fieldsToUpdate['nama'] = $request->nama;
            $changes[] = 'nama';
        }

        if ($mahasiswa->nim !== $request->nim) {
            $fieldsToUpdate['nim'] = $request->nim;
            $changes[] = 'nim';
        }

        if ($mahasiswa->jenis_kelamin !== $request->jenis_kelamin) {
            $fieldsToUpdate['jenis_kelamin'] = $request->jenis_kelamin;
            $changes[] = 'jenis_kelamin';
        }

        // Update basic information if there are changes
        if (!empty($fieldsToUpdate)) {
            $mahasiswa->update($fieldsToUpdate);
        }

        // Handle password update if provided
        if ($request->filled('password')) {
            $mahasiswa->update([
                'password' => Hash::make($request->password)
            ]);
            $changes[] = 'password';
        }

        // Handle photo upload
        if ($request->hasFile('foto')) {
            $this->handlePhotoUpload($request->file('foto'), $mahasiswa, 'mahasiswa');
            $changes[] = 'foto';
        }

        return $changes;
    }

    private function updateAdminProfile(Request $request)
    {
        $admin = auth('admin')->user();
        $changes = [];

        // Track changes for basic information
        $fieldsToUpdate = [];

        if ($admin->nama !== $request->nama) {
            $fieldsToUpdate['nama'] = $request->nama;
            $changes[] = 'nama';
        }

        if ($admin->username !== $request->username) {
            $fieldsToUpdate['username'] = $request->username;
            $changes[] = 'username';
        }

        // Update basic information if there are changes
        if (!empty($fieldsToUpdate)) {
            $admin->update($fieldsToUpdate);
        }

        // Handle password update if provided
        if ($request->filled('password')) {
            $admin->update([
                'password' => Hash::make($request->password)
            ]);
            $changes[] = 'password';
        }

        // Handle photo upload
        if ($request->hasFile('foto')) {
            $this->handlePhotoUpload($request->file('foto'), $admin, 'admin');
            $changes[] = 'foto';
        }

        return $changes;
    }

    private function generateSuccessMessage(array $changes)
    {
        if (empty($changes)) {
            return 'Tidak ada perubahan yang dilakukan pada profil Anda.';
        }

        $messages = [];
        $fieldNames = [
            'nama' => 'nama',
            'nidn' => 'NIDN',
            'nim' => 'NIM',
            'username' => 'username',
            'jenis_kelamin' => 'jenis kelamin',
            'password' => 'password',
            'foto' => 'foto profil'
        ];

        foreach ($changes as $field) {
            if (isset($fieldNames[$field])) {
                $messages[] = $fieldNames[$field];
            }
        }

        if (count($messages) === 1) {
            return 'Berhasil memperbarui ' . $messages[0] . '.';
        } elseif (count($messages) === 2) {
            return 'Berhasil memperbarui ' . $messages[0] . ' dan ' . $messages[1] . '.';
        } else {
            $lastItem = array_pop($messages);
            return 'Berhasil memperbarui ' . implode(', ', $messages) . ', dan ' . $lastItem . '.';
        }
    }

    private function getValidationRules($role)
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
        // Create directory path based on role and user name
        $userFolderName = $this->sanitizeFileName($user->nama);

        if ($role === 'dosen') {
            $directoryPath = public_path("foto_dosen/{$userFolderName}");
            $baseDir = 'foto_dosen/';
        } elseif ($role === 'mahasiswa') {
            $directoryPath = public_path("foto_mahasiswa/{$userFolderName}");
            $baseDir = 'foto_mahasiswa/';
        } else {
            $directoryPath = public_path("foto_admin/{$userFolderName}");
            $baseDir = 'foto_admin/';
        }

        // Create directory if it doesn't exist
        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        }

        // Delete old photo if exists
        if ($user->foto) {
            $oldPhotoPath = public_path($baseDir . $user->foto);
            if (File::exists($oldPhotoPath)) {
                File::delete($oldPhotoPath);

                // Also try to delete the old directory if it's empty
                $oldPhotoDir = dirname($oldPhotoPath);
                if (File::isDirectory($oldPhotoDir) && count(File::files($oldPhotoDir)) === 0) {
                    File::deleteDirectory($oldPhotoDir);
                }
            }
        }

        // Generate new filename
        $extension = $file->getClientOriginalExtension();
        $filename = 'profile_' . time() . '.' . $extension;

        // Move file to the directory
        $file->move($directoryPath, $filename);

        // Update user photo path (relative to the role directory)
        $relativePath = "{$userFolderName}/{$filename}";
        $user->update(['foto' => $relativePath]);
    }

    private function sanitizeFileName($name)
    {
        // Remove special characters and replace spaces with underscores
        $sanitized = preg_replace('/[^A-Za-z0-9\-_]/', '_', $name);
        $sanitized = preg_replace('/_+/', '_', $sanitized);
        $sanitized = trim($sanitized, '_');
        return $sanitized;
    }

    public function deletePhoto()
    {
        $currentRole = UserAuthenticationHelper::getUserRole();

        try {
            $user = null;
            switch ($currentRole) {
                case 'dosen':
                    $user = auth('dosen')->user();
                    $baseDir = 'foto_dosen/';
                    break;
                case 'mahasiswa':
                    $user = auth('mahasiswa')->user();
                    $baseDir = 'foto_mahasiswa/';
                    break;
                case 'admin':
                    $user = auth('admin')->user();
                    $baseDir = 'foto_admin/';
                    break;
            }

            if ($user && $user->foto) {
                $photoPath = public_path("{$baseDir}{$user->foto}");

                // Delete the photo file
                if (File::exists($photoPath)) {
                    File::delete($photoPath);
                }

                // Update database
                $user->update(['foto' => null]);

                // Optional: Remove empty directory if no other files
                $userFolder = dirname($photoPath);
                if (File::isDirectory($userFolder) && count(File::files($userFolder)) === 0) {
                    File::deleteDirectory($userFolder);
                }
            }

            return response()->json(['success' => true, 'message' => 'Foto profil berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus foto: ' . $e->getMessage()]);
        }
    }
}
