<?php

use Flux\Flux;
use function Livewire\Volt\{state, mount};
use App\Helpers\DecisionMaking\RecommendationSystem;
use Illuminate\Support\Facades\Hash;

state([
    'mahasiswa',

    // Personal data fields
    'nama',
    'nim',
    'jurusan',
    'program_studi',
    'jenis_kelamin',
    'alamat',

    // Preference fields
    'bidang_industri',
    'jenis_magang',
    'lokasi_magang',
    'pekerjaan',
    'open_remote',

    // Password fields
    'current_password',
    'new_password',
    'new_password_confirmation',

    // Options for dropdowns
    'program_studi_options' => \App\Models\Mahasiswa::distinct('program_studi')->pluck('program_studi', 'program_studi')->toArray(),
    'bidang_industri_options' => \App\Models\BidangIndustri::pluck('nama', 'id')->toArray(),
    'jenis_magang_options' => [
        'berbayar' => 'Magang Berbayar (Paid Internship)',
        'tidak berbayar' => 'Magang Tidak Berbayar (Unpaid Internship)',
    ],
    'lokasi_magang_options' => \App\Models\LokasiMagang::pluck('kategori_lokasi', 'id')->toArray(),
    'pekerjaan_options' => \App\Models\Pekerjaan::pluck('nama', 'id')->toArray(),
    'open_remote_options' => [
        'ya' => 'Ya',
        'tidak' => 'Tidak',
    ],
    'jenis_kelamin_options' => [
        'L' => 'Laki-laki',
        'P' => 'Perempuan',
    ],

    // Edit states
    'isUpdatePersonalData' => false,
    'isUpdatePreference' => false,
    'isUpdatePassword' => false,

    // Modal states
    'modalType' => '', // 'success' or 'error'
    'modalTitle' => '',
    'modalMessage' => '',
]);

mount(function () {
    $this->mahasiswa = auth('mahasiswa')->user();

    // Load personal data
    $this->nama = $this->mahasiswa->nama;
    $this->nim = $this->mahasiswa->nim;
    $this->jurusan = $this->mahasiswa->jurusan;
    $this->program_studi = $this->mahasiswa->program_studi;
    $this->jenis_kelamin = $this->mahasiswa->jenis_kelamin;
    $this->alamat = $this->mahasiswa->alamat;

    // Load preference data
    $this->bidang_industri = $this->mahasiswa->kriteriaBidangIndustri->bidangIndustri->nama;
    $this->jenis_magang = $this->mahasiswa->kriteriaJenisMagang->jenis_magang;
    $this->lokasi_magang = $this->mahasiswa->kriteriaLokasiMagang->lokasiMagang->kategori_lokasi;
    $this->pekerjaan = $this->mahasiswa->kriteriaPekerjaan->pekerjaan->nama;
    $this->open_remote = $this->mahasiswa->kriteriaOpenRemote->open_remote;

    // Load dropdown options
    $this->bidang_industri_options = \App\Models\BidangIndustri::pluck('nama', 'nama')->toArray();
    $this->jenis_magang_options = [
        'berbayar' => 'Magang Berbayar (Paid Internship)',
        'tidak berbayar' => 'Magang Tidak Berbayar (Unpaid Internship)',
    ];
    $this->lokasi_magang_options = \App\Models\LokasiMagang::pluck('kategori_lokasi', 'kategori_lokasi')->toArray();
    $this->pekerjaan_options = \App\Models\Pekerjaan::pluck('nama', 'nama')->toArray();
    $this->open_remote_options = [
        'ya' => 'Ya',
        'tidak' => 'Tidak',
    ];
});

// Personal Data Functions
$updatePersonalData = function () {
    $this->isUpdatePersonalData = true;
};

$savePersonalData = function () {
    try {
        $this->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:mahasiswa,nim,' . $this->mahasiswa->id,
            'jurusan' => 'required|string|max:255',
            'program_studi' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string|max:500',
        ]);

        $this->mahasiswa->update([
            'nama' => $this->nama,
            'nim' => $this->nim,
            'jurusan' => $this->jurusan,
            'program_studi' => $this->program_studi,
            'jenis_kelamin' => $this->jenis_kelamin,
            'alamat' => $this->alamat,
            'updated_at' => now(),
        ]);

        $this->showModal('success', 'Data Personal Berhasil Diperbarui', 'Data personal Anda telah berhasil diperbarui.');
        $this->isUpdatePersonalData = false;
    } catch (\Illuminate\Validation\ValidationException $e) {
        $this->showModal('error', 'Gagal Memperbarui Data Personal', 'Terjadi kesalahan validasi. Silakan periksa kembali data Anda.');
    } catch (\Exception $e) {
        $this->showModal('error', 'Gagal Memperbarui Data Personal', 'Terjadi kesalahan sistem. Silakan coba lagi.');
    }
};

$cancelUpdatePersonalData = function () {
    // Reset ke nilai asli
    $this->nama = $this->mahasiswa->nama;
    $this->nim = $this->mahasiswa->nim;
    $this->jurusan = $this->mahasiswa->jurusan;
    $this->program_studi = $this->mahasiswa->program_studi;
    $this->jenis_kelamin = $this->mahasiswa->jenis_kelamin;
    $this->alamat = $this->mahasiswa->alamat;

    $this->isUpdatePersonalData = false;
};

// Preference Functions
$updatePreference = function () {
    $this->isUpdatePreference = true;
};

$saveNewPreference = function () {
    try {
        $this->validate([
            'bidang_industri' => 'required|string',
            'jenis_magang' => 'required|string',
            'lokasi_magang' => 'required|string',
            'pekerjaan' => 'required|string',
            'open_remote' => 'required|string',
        ]);

        // Mencari ID berdasarkan nama untuk foreign key
        $bidangIndustriId = \App\Models\BidangIndustri::where('nama', $this->bidang_industri)->first()?->id;
        $lokasiMagangId = \App\Models\LokasiMagang::where('kategori_lokasi', $this->lokasi_magang)->first()?->id;
        $pekerjaanId = \App\Models\Pekerjaan::where('nama', $this->pekerjaan)->first()?->id;

        // Update dengan foreign key yang benar
        $this->mahasiswa->kriteriaBidangIndustri()->update(['bidang_industri_id' => $bidangIndustriId]);
        $this->mahasiswa->kriteriaJenisMagang()->update(['jenis_magang' => $this->jenis_magang]);
        $this->mahasiswa->kriteriaLokasiMagang()->update(['lokasi_magang_id' => $lokasiMagangId]);
        $this->mahasiswa->kriteriaPekerjaan()->update(['pekerjaan_id' => $pekerjaanId]);
        $this->mahasiswa->kriteriaOpenRemote()->update(['open_remote' => $this->open_remote]);

        // Update timestamp mahasiswa
        $this->mahasiswa->touch();

        $recommendationSystem = new RecommendationSystem($this->mahasiswa);
        $recommendationSystem->runRecommendationSystem();

        $this->showModal('success', 'Preferensi Magang Berhasil Diperbarui', 'Preferensi magang Anda telah berhasil diperbarui dan sistem rekomendasi telah dijalankan ulang.');
        $this->isUpdatePreference = false;
    } catch (\Exception $e) {
        $this->showModal('error', 'Gagal Memperbarui Preferensi', 'Terjadi kesalahan saat memperbarui preferensi magang. Silakan coba lagi.');
    }
};

$cancelUpdatePreference = function () {
    // Reset ke nilai asli
    $this->bidang_industri = $this->mahasiswa->kriteriaBidangIndustri->bidangIndustri->nama;
    $this->jenis_magang = $this->mahasiswa->kriteriaJenisMagang->jenis_magang;
    $this->lokasi_magang = $this->mahasiswa->kriteriaLokasiMagang->lokasiMagang->kategori_lokasi;
    $this->pekerjaan = $this->mahasiswa->kriteriaPekerjaan->pekerjaan->nama;
    $this->open_remote = $this->mahasiswa->kriteriaOpenRemote->open_remote;

    $this->isUpdatePreference = false;
};

// Password Functions
$updatePassword = function () {
    $this->isUpdatePassword = true;
    $this->current_password = '';
    $this->new_password = '';
    $this->new_password_confirmation = '';
};

$saveNewPassword = function () {
    try {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
            'new_password_confirmation' => 'required',
        ]);

        // Verify current password
        if (!Hash::check($this->current_password, $this->mahasiswa->password)) {
            $this->showModal('error', 'Password Lama Salah', 'Password lama yang Anda masukkan tidak sesuai.');
            return;
        }

        // Update password
        $this->mahasiswa->update([
            'password' => Hash::make($this->new_password),
            'updated_at' => now(),
        ]);

        $this->showModal('success', 'Password Berhasil Diubah', 'Password Anda telah berhasil diubah.');
        $this->isUpdatePassword = false;

        // Clear password fields
        $this->current_password = '';
        $this->new_password = '';
        $this->new_password_confirmation = '';
    } catch (\Illuminate\Validation\ValidationException $e) {
        $this->showModal('error', 'Gagal Mengubah Password', 'Silakan periksa kembali password yang Anda masukkan.');
    } catch (\Exception $e) {
        $this->showModal('error', 'Gagal Mengubah Password', 'Terjadi kesalahan sistem. Silakan coba lagi.');
    }
};

$cancelUpdatePassword = function () {
    $this->current_password = '';
    $this->new_password = '';
    $this->new_password_confirmation = '';
    $this->isUpdatePassword = false;
};

// Modal Function
$showModal = function ($type, $title, $message) {
    $this->modalType = $type;
    $this->modalTitle = $title;
    $this->modalMessage = $message;
    Flux::modal('response-modal')->show();
};

?>

<div>
    <div class="gap-3 flex flex-col">
        <!-- Personal Data Section -->
        <div class="card bg-white shadow-md">
            <div class="card-body p-5">
                <flux:avatar circle src="https://unavatar.io/x/{{ $nama }}" class="w-24 h-24 mb-4" />

                <div class="grid grid-cols-2 gap-3">
                    @if (!$isUpdatePersonalData)
                        <flux:input readonly value="{{ $nama }}" type="text" label="Nama Lengkap" />
                        <flux:input readonly value="{{ $nim }}" type="text" label="NIM" />
                        <flux:input readonly value="{{ $jurusan }}" type="text" label="Jurusan" />
                        <flux:input readonly value="{{ $program_studi }}" type="text" label="Program Studi" />
                        <flux:input readonly value="{{ $jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}"
                            type="text" label="Jenis Kelamin" />
                        <flux:input readonly value="{{ $alamat }}" type="text" label="Alamat" />
                    @else
                        <flux:input wire:model="nama" type="text" label="Nama Lengkap" />
                        <flux:input wire:model="nim" type="text" label="NIM" />
                        <flux:input wire:model="jurusan" type="text" label="Jurusan" />
                        <flux:select wire:model="program_studi" label="Program Studi" placeholder="Pilih program studi">
                            @foreach ($program_studi_options as $value => $label)
                                <flux:select.option value="{{ $value }}">{{ $label }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>
                        <div class="form-control">
                            <flux:select wire:model="jenis_kelamin" label="Jenis Kelamin"
                                placeholder="Pilih jenis kelamin">
                                @foreach ($jenis_kelamin_options as $value => $label)
                                    <flux:select.option value="{{ $value }}">{{ $label }}
                                    </flux:select.option>
                                @endforeach
                            </flux:select>
                        </div>

                        <flux:input wire:model="alamat" type="text" label="Alamat" />
                    @endif
                </div>

                @if ($mahasiswa->updated_at)
                    <div class="mt-4 text-sm text-gray-500">
                        <p>Terakhir diperbarui: {{ $mahasiswa->updated_at->format('d M Y, H:i:s') }}</p>
                    </div>
                @endif
            </div>

            <div class="card-actions flex justify-end p-5">
                <div wire:show="!isUpdatePersonalData">
                    <flux:button wire:click="updatePersonalData" class="bg-magnet-sky-teal! text-white!" icon="pencil">
                        Edit Data Personal
                    </flux:button>
                </div>
                <div wire:show="isUpdatePersonalData">
                    <flux:button wire:click="cancelUpdatePersonalData"
                        class="bg-gray-700! text-white! hover:bg-gray-400!" icon="x">
                        Batalkan
                    </flux:button>
                    <flux:button wire:click="savePersonalData"
                        class="bg-magnet-sky-teal! text-white! hover:bg-emerald-400!" icon="check">
                        Simpan Data Personal
                    </flux:button>
                </div>
            </div>
        </div>

        <!-- Preference Section -->
        <div class="card bg-white shadow-md">
            <div class="card-body p-5">
                <h3 class="text-lg font-semibold mb-4">Preferensi Magang</h3>

                <div class="grid grid-cols-2 gap-3">
                    @if (!$isUpdatePreference)
                        <flux:input readonly value="{{ $pekerjaan }}" type="text" label="Pekerjaan" />
                        <flux:input readonly value="{{ $bidang_industri }}" type="text" label="Bidang industri" />
                        <flux:input readonly value="{{ $lokasi_magang }}" type="text" label="Lokasi magang" />
                        <flux:input readonly
                            value="{{ $jenis_magang == 'berbayar' ? 'Magang Berbayar (Paid)' : 'Magang Tidak Berbayar (Unpaid)' }}"
                            type="text" label="Jenis magang" />
                        <flux:input readonly value="{{ ucfirst($open_remote) }}" type="text" label="Open remote" />
                    @else
                        <div class="form-control">
                            <flux:select wire:model="pekerjaan" label="Pekerjaan" placeholder="Pilih pekerjaan">
                                @foreach ($pekerjaan_options as $value => $label)
                                    <flux:select.option value="{{ $value }}">{{ $label }}
                                    </flux:select.option>
                                @endforeach
                            </flux:select>
                        </div>

                        <div class="form-control">
                            <flux:select wire:model="bidang_industri" label="Bidang Industri"
                                placeholder="Pilih bidang industri">
                                @foreach ($bidang_industri_options as $value => $label)
                                    <flux:select.option value="{{ $value }}">{{ $label }}
                                    </flux:select.option>
                                @endforeach
                            </flux:select>
                        </div>

                        <div class="form-control">
                            <flux:select wire:model="lokasi_magang" label="Lokasi Magang"
                                placeholder="Pilih lokasi magang">
                                @foreach ($lokasi_magang_options as $value => $label)
                                    <flux:select.option value="{{ $value }}">{{ $label }}
                                    </flux:select.option>
                                @endforeach
                            </flux:select>
                        </div>

                        <div class="form-control">
                            <flux:select wire:model="jenis_magang" label="Jenis Magang"
                                placeholder="Pilih jenis magang">
                                @foreach ($jenis_magang_options as $value => $label)
                                    <flux:select.option value="{{ $value }}">{{ $label }}
                                    </flux:select.option>
                                @endforeach
                            </flux:select>
                        </div>

                        <div class="form-control">
                            <flux:select wire:model="open_remote" label="Open Remote" placeholder="Pilih opsi remote">
                                @foreach ($open_remote_options as $value => $label)
                                    <flux:select.option value="{{ $value }}">{{ $label }}
                                    </flux:select.option>
                                @endforeach
                            </flux:select>
                        </div>
                    @endif
                </div>

                @if ($mahasiswa->updated_at)
                    <div class="mt-4 text-sm text-gray-500">
                        <p>Preferensi terakhir diperbarui: {{ $mahasiswa->updated_at->format('d M Y, H:i:s') }}</p>
                    </div>
                @endif
            </div>

            <div class="card-actions flex justify-end p-5">
                <div wire:show="!isUpdatePreference">
                    <flux:button wire:click="updatePreference"
                        class="bg-magnet-sky-teal! text-white! hover:bg-emerald-400!" icon="pencil">
                        Edit Preferensi Magang
                    </flux:button>
                </div>
                <div wire:show="isUpdatePreference">
                    <flux:button wire:click="cancelUpdatePreference"
                        class="bg-gray-700! text-white! hover:bg-gray-400!" icon="x">
                        Batalkan
                    </flux:button>
                    <flux:button wire:click="saveNewPreference"
                        class="bg-magnet-sky-teal! text-white! hover:bg-emerald-400!" icon="check">
                        Perbarui Preferensi
                    </flux:button>
                </div>
            </div>
        </div>

        <!-- Password Section -->
        <div class="card bg-white shadow-md">
            <div class="card-body p-5">
                <h3 class="text-lg font-semibold mb-4">Keamanan Akun</h3>

                @if (!$isUpdatePassword)
                    <div class="grid grid-cols-1 gap-3">
                        <flux:input readonly value="••••••••" type="password" label="Password" />
                        <p class="text-sm text-gray-600">Klik tombol di bawah untuk mengubah password Anda</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-3">
                        <flux:input wire:model="current_password" type="password" label="Password Lama"
                            placeholder="Masukkan password lama" />
                        <flux:input wire:model="new_password" type="password" label="Password Baru"
                            placeholder="Masukkan password baru (min. 8 karakter)" />
                        <flux:input wire:model="new_password_confirmation" type="password"
                            label="Konfirmasi Password Baru" placeholder="Konfirmasi password baru" />
                    </div>
                @endif
            </div>

            <div class="card-actions flex justify-end p-5">
                <div wire:show="!isUpdatePassword">
                    <flux:button wire:click="updatePassword" class="bg-orange-500! text-white! hover:bg-orange-600!"
                        icon="lock-closed">
                        Ubah Password
                    </flux:button>
                </div>
                <div wire:show="isUpdatePassword">
                    <flux:button wire:click="cancelUpdatePassword" class="bg-gray-700! text-white! hover:bg-gray-400!"
                        icon="x">
                        Batalkan
                    </flux:button>
                    <flux:button wire:click="saveNewPassword" class="bg-orange-500! text-white! hover:bg-orange-600!"
                        icon="check">
                        Simpan Password Baru
                    </flux:button>
                </div>
            </div>
        </div>
    </div>

    <!-- Response Modal -->
    <flux:modal name="response-modal" class="min-w-[24rem]">
        <div class="space-y-6">
            <div class="text-center">
                <div
                    class="w-16 h-16 {{ $modalType === 'success' ? 'bg-green-100' : 'bg-red-100' }} rounded-full flex items-center justify-center mx-auto mb-4">
                    @if ($modalType === 'success')
                        <flux:icon.check class="w-8 h-8 text-green-600" />
                    @else
                        <flux:icon.x-mark class="w-8 h-8 text-red-600" />
                    @endif
                </div>
                <flux:heading size="lg">{{ $modalTitle }}</flux:heading>
                <flux:text class="mt-2 text-gray-600">
                    <p>{{ $modalMessage }}</p>
                </flux:text>
            </div>
            <div class="flex gap-2 justify-center">
                <flux:modal.close>
                    <flux:button type="submit" variant="primary"
                        class="{{ $modalType === 'success' ? 'bg-magnet-sky-teal' : 'bg-red-500' }} px-8 py-2">
                        Oke
                    </flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>
</div>
