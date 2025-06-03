<?php

use App\Models\{Perusahaan, KontrakMagang, Magang};
use Illuminate\Support\Facades\{Auth, Log};
use Livewire\WithFileUploads;
use function Livewire\Volt\{state, mount, rules, uses};

uses(WithFileUploads::class);

state([
    'company_type' => '',
    'selected_company_id' => '',
    'company_name' => '',
    'company_address' => '',
    'bidang_industri' => '',
    'lokasi_magang' => '',
    'surat_izin_magang' => null,
    'partner_companies' => [],
    'mahasiswa' => null,
]);

rules([
    'company_name' => 'required_if:company_type,non_partner|string|max:255',
    'company_address' => 'required_if:company_type,non_partner|string',
    'bidang_industri' => 'required_if:company_type,non_partner|string',
    'selected_company_id' => 'required_if:company_type,partner|exists:perusahaan,id',
    'lokasi_magang' => 'required|string|max:255',
    'surat_izin_magang' => 'required|file|mimes:pdf|max:2048',
]);

mount(function () {
    $this->mahasiswa = Auth::guard('mahasiswa')->user();

    if (!$this->mahasiswa) {
        session()->flash('error', 'Anda harus login sebagai mahasiswa.');
        return;
    }

    $this->partner_companies = Perusahaan::where('kategori', 'mitra')->get();
});

$save = function () {
    try {
        if (!$this->mahasiswa) {
            session()->flash('error', 'Data mahasiswa tidak ditemukan.');
            return;
        }

        $this->validate();

        // Check if student already has active internship
        if (KontrakMagang::where('mahasiswa_id', $this->mahasiswa->id)->exists()) {
            session()->flash('error', 'Anda sudah memiliki kontrak magang aktif.');
            return;
        }

        $magang_id = null;

        if ($this->company_type === 'partner') {
            // Handle partner company
            $selectedCompany = Perusahaan::find($this->selected_company_id);
            if (!$selectedCompany) {
                session()->flash('error', 'Perusahaan mitra tidak ditemukan.');
                return;
            }

            $magang = Magang::where('perusahaan_id', $selectedCompany->id)->first();
            if ($magang) {
                $magang_id = $magang->id;
            }
        } else {
            // Handle non-partner company - create new company and internship
            $newCompany = Perusahaan::create([
                'nama' => $this->company_name,
                'bidang_industri' => $this->bidang_industri,
                'lokasi' => $this->company_address,
                'kategori' => 'non_mitra',
                'rating' => 0,
            ]);

            $magang = Magang::create([
                'nama' => "Magang di {$this->company_name}",
                'deskripsi' => "Program magang di {$this->company_name}",
                'persyaratan' => 'Sesuai dengan persyaratan perusahaan',
                'perusahaan_id' => $newCompany->id,
            ]);

            $magang_id = $magang->id;
        }

        // Create internship contract
        KontrakMagang::create([
            'mahasiswa_id' => $this->mahasiswa->id,
            'magang_id' => $magang_id,
            'waktu_awal' => now(),
            'waktu_akhir' => now()->addMonths(3),
        ]);

        // Update student internship status
        $this->mahasiswa->update(['status_magang' => 'sedang magang']);

        // Get internship location info
        $internshipInfo = $this->getInternshipInfo();

        session()->flash('success', "Data magang berhasil disimpan! Anda sedang magang di: {$internshipInfo}");
        $this->resetForm();
    } catch (\Exception $e) {
        Log::error('Error saving internship data', [
            'mahasiswa_id' => $this->mahasiswa->id ?? null,
            'error' => $e->getMessage(),
        ]);

        session()->flash('error', 'Terjadi kesalahan. Silakan coba lagi.');
    }
};

$getInternshipInfo = function () {
    if (!$this->mahasiswa) {
        return 'Tidak diketahui';
    }

    $kontrak = KontrakMagang::with(['magang.perusahaan'])
        ->where('mahasiswa_id', $this->mahasiswa->id)
        ->latest()
        ->first();

    if ($kontrak && $kontrak->magang && $kontrak->magang->perusahaan) {
        $perusahaan = $kontrak->magang->perusahaan;
        return "{$perusahaan->nama} - {$perusahaan->lokasi}";
    }

    return 'Lokasi magang belum ditentukan';
};

$resetForm = function () {
    $this->reset(['company_type', 'selected_company_id', 'company_name', 'company_address', 'bidang_industri', 'lokasi_magang', 'surat_izin_magang']);
};

?>

<div class="space-y-4 border-t pt-4 mt-4">
    <h3 class="text-md font-semibold text-gray-700">Informasi Magang</h3>

    @if (!$mahasiswa)
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50">
            Anda harus login sebagai mahasiswa untuk mengakses fitur ini.
        </div>
    @else
        @if (session()->has('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50">
                {{ session('error') }}
            </div>
        @endif

        <!-- Student info with internship location -->
        <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50">
            <strong>Mahasiswa:</strong> {{ $mahasiswa->nama }} ({{ $mahasiswa->nim }}) <br>
            <strong>Status:</strong> {{ ucwords(str_replace('_', ' ', $mahasiswa->status_magang)) }} <br>
            @if ($mahasiswa->status_magang === 'sedang magang')
                <strong>Lokasi Magang:</strong> {{ $getInternshipInfo() }}
            @endif
        </div>

        <!-- Company Type Selection -->
        <div>
            <x-flux::field>
                <x-flux::label>Jenis Perusahaan</x-flux::label>
                <x-flux::select wire:model.live="company_type" placeholder="Pilih jenis perusahaan">
                    <option value="">Pilih jenis perusahaan</option>
                    <option value="partner">Perusahaan Mitra</option>
                    <option value="non_partner">Perusahaan Non-Mitra</option>
                </x-flux::select>
                <x-flux::error for="company_type" />
            </x-flux::field>
        </div>

        <!-- Partner Company Selection -->
        @if ($company_type == 'partner')
            <div>
                <x-flux::field>
                    <x-flux::label>Pilih Perusahaan Mitra</x-flux::label>
                    <x-flux::select wire:model="selected_company_id" placeholder="Pilih perusahaan">
                        <option value="">Pilih perusahaan</option>
                        @foreach ($partner_companies as $company)
                            <option value="{{ $company->id }}">
                                {{ $company->nama }} - {{ $company->lokasi }}
                            </option>
                        @endforeach
                    </x-flux::select>
                    <x-flux::error for="selected_company_id" />
                </x-flux::field>
            </div>
        @endif

        <!-- Non-Partner Company Form -->
        @if ($company_type == 'non_partner')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-flux::field>
                        <x-flux::label>Nama Perusahaan</x-flux::label>
                        <x-flux::input wire:model="company_name" placeholder="Masukkan nama perusahaan" />
                        <x-flux::error for="company_name" />
                    </x-flux::field>
                </div>

                <div>
                    <x-flux::field>
                        <x-flux::label>Bidang Industri</x-flux::label>
                        <x-flux::select wire:model="bidang_industri" placeholder="Pilih bidang industri">
                            <option value="">Pilih bidang industri</option>
                            <option value="Perbankan">Perbankan</option>
                            <option value="Kesehatan">Kesehatan</option>
                            <option value="Pendidikan">Pendidikan</option>
                            <option value="E-Commerce">E-Commerce</option>
                            <option value="Telekomunikasi">Telekomunikasi</option>
                            <option value="Transportasi">Transportasi</option>
                            <option value="Pemerintahan">Pemerintahan</option>
                            <option value="Manufaktur">Manufaktur</option>
                            <option value="Energi">Energi</option>
                            <option value="Media">Media</option>
                            <option value="Teknologi">Teknologi</option>
                            <option value="Agrikultur">Agrikultur</option>
                            <option value="Pariwisata">Pariwisata</option>
                            <option value="Keamanan">Keamanan</option>
                        </x-flux::select>
                        <x-flux::error for="bidang_industri" />
                    </x-flux::field>
                </div>

                <div class="md:col-span-2">
                    <x-flux::field>
                        <x-flux::label>Alamat Perusahaan</x-flux::label>
                        <x-flux::textarea wire:model="company_address" placeholder="Masukkan alamat lengkap perusahaan"
                            rows="3" />
                        <x-flux::error for="company_address" />
                    </x-flux::field>
                </div>
            </div>
        @endif

        <!-- Common fields for both company types -->
        @if ($company_type)
            <div>
                <x-flux::field>
                    <x-flux::label>Lokasi Magang</x-flux::label>
                    <x-flux::input wire:model="lokasi_magang" placeholder="Lokasi tempat magang" />
                    <x-flux::error for="lokasi_magang" />
                </x-flux::field>
            </div>

            <div>
                <x-flux::field>
                    <x-flux::label>Surat Izin Magang (PDF)</x-flux::label>
                    <x-flux::input type="file" wire:model="surat_izin_magang" accept=".pdf" />
                    <x-flux::description>Upload file PDF maksimal 2MB</x-flux::description>

                    @if ($surat_izin_magang && !$errors->has('surat_izin_magang'))
                        <div class="mt-2 text-sm text-green-600">
                            File terpilih: {{ $surat_izin_magang->getClientOriginalName() }}
                        </div>
                    @endif

                    <div wire:loading wire:target="surat_izin_magang" class="text-sm text-blue-600 mt-2">
                        Mengunggah file...
                    </div>
                    <x-flux::error for="surat_izin_magang" />
                </x-flux::field>
            </div>

            <div class="flex justify-end space-x-2 pt-4">
                <x-flux::button variant="ghost" wire:click="resetForm">
                    Reset Form
                </x-flux::button>
                <x-flux::button wire:click="save" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="save">Simpan Data Magang</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </x-flux::button>
            </div>
        @endif
    @endif
</div>
