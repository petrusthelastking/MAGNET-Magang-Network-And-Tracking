<?php

use App\Models\{Perusahaan, KontrakMagang, LowonganMagang};
use Illuminate\Support\Facades\{Auth, Log, Storage};
use Livewire\WithFileUploads;
use function Livewire\Volt\{state, mount, rules, uses, computed, updated};

uses(WithFileUploads::class);

state([
    'company_type' => '',
    'selected_company_id' => '',
    'selected_lowongan_id' => '',
    'company_name' => '',
    'company_address' => '',
    'bidang_industri' => '',
    'lokasi_magang' => '',
    'surat_izin_magang' => null,
    'partner_companies' => [],
    'available_lowongan' => [],
    'mahasiswa' => null,
]);

rules([
    'company_name' => 'required_if:company_type,non_partner|string|max:255',
    'company_address' => 'required_if:company_type,non_partner|string',
    'bidang_industri' => 'required_if:company_type,non_partner|string',
    'selected_company_id' => 'required_if:company_type,partner|exists:perusahaan,id',
    'selected_lowongan_id' => 'required_if:company_type,partner|exists:lowongan_magang,id',
    'lokasi_magang' => 'required|string|max:255',
    'surat_izin_magang' => 'required|file|mimes:pdf|max:2048',
]);

mount(function () {
    try {
        // Check authentication
        $this->mahasiswa = Auth::guard('mahasiswa')->user();

        if (!$this->mahasiswa) {
            session()->flash('error', 'Anda harus login sebagai mahasiswa.');
            return;
        }

        // Check existing contract
        $existingContract = KontrakMagang::where('mahasiswa_id', $this->mahasiswa->id)->exists();
        if ($existingContract) {
            session()->flash('info', 'Anda sudah memiliki kontrak magang aktif.');
        }

        // Load partner companies with active job openings
        $this->partner_companies = Perusahaan::where('kategori', 'mitra')
            ->whereHas('lowongan_magang', function ($query) {
                $query->where('status', 'buka');
            })
            ->get();
    } catch (\Exception $e) {
        Log::error('Error in mount function', [
            'mahasiswa_id' => $this->mahasiswa->id ?? null,
            'error' => $e->getMessage(),
        ]);
        session()->flash('error', 'Terjadi kesalahan saat memuat data.');
    }
});

// Use updated() for watching property changes
updated([
    'selected_company_id' => function ($value) {
        $this->loadLowongan();
    },
]);

$loadLowongan = function () {
    try {
        if (!$this->selected_company_id) {
            $this->available_lowongan = [];
            $this->selected_lowongan_id = '';
            return;
        }

        // Load active job openings for selected company
        $this->available_lowongan = LowonganMagang::where('perusahaan_id', $this->selected_company_id)
            ->where('status', 'buka')
            ->with(['pekerjaan', 'lokasiMagang'])
            ->get();

        // Reset selected lowongan when company changes
        $this->selected_lowongan_id = '';
    } catch (\Exception $e) {
        Log::error('Error loading lowongan', [
            'company_id' => $this->selected_company_id,
            'error' => $e->getMessage(),
        ]);
        $this->available_lowongan = [];
        $this->selected_lowongan_id = '';
    }
};

$save = function () {
    try {
        if (!$this->mahasiswa) {
            session()->flash('error', 'Data mahasiswa tidak ditemukan.');
            return;
        }

        $this->validate();

        // Check if student already has active internship
        $existingContract = KontrakMagang::where('mahasiswa_id', $this->mahasiswa->id)->exists();
        if ($existingContract) {
            session()->flash('error', 'Anda sudah memiliki kontrak magang aktif.');
            return;
        }

        $lowongan_magang_id = null;

        if ($this->company_type === 'partner') {
            // Validate selected company and lowongan
            $selectedLowongan = LowonganMagang::where('id', $this->selected_lowongan_id)->where('perusahaan_id', $this->selected_company_id)->first();

            if (!$selectedLowongan) {
                session()->flash('error', 'Lowongan magang tidak ditemukan atau tidak valid.');
                return;
            }

            $lowongan_magang_id = $selectedLowongan->id;
        } else {
            // Handle file upload
            $suratPath = null;
            if ($this->surat_izin_magang) {
                $suratPath = $this->surat_izin_magang->store('surat-izin-magang', 'public');
            }

            // Create bidang_industri first, then use its ID
            $bidangIndustri = \App\Models\BidangIndustri::firstOrCreate(['nama' => $this->bidang_industri]);

            // Create new company
            $newCompany = Perusahaan::create([
                'nama' => $this->company_name,
                'bidang_industri_id' => $bidangIndustri->id,
                'lokasi' => $this->company_address,
                'kategori' => 'non_mitra',
                'rating' => 0,
            ]);

            // Create supporting records
            $pekerjaan = \App\Models\Pekerjaan::firstOrCreate(['nama' => 'Magang Umum']);
            $lokasiMagang = \App\Models\LokasiMagang::firstOrCreate([
                'kategori_lokasi' => 'Onsite',
                'lokasi' => $this->lokasi_magang,
            ]);

            // Create new lowongan
            $magang = LowonganMagang::create([
                'nama' => "Magang di {$this->company_name}",
                'kuota' => 1,
                'pekerjaan_id' => $pekerjaan->id,
                'deskripsi' => "Program magang di {$this->company_name}",
                'persyaratan' => 'Sesuai dengan persyaratan perusahaan',
                'jenis_magang' => 'tidak berbayar',
                'open_remote' => 'tidak',
                'perusahaan_id' => $newCompany->id,
                'lokasi_magang_id' => $lokasiMagang->id,
                'status' => 'buka',
            ]);

            $lowongan_magang_id = $magang->id;
        }

        // Get random dosen for assignment
        $dosen = \App\Models\DosenPembimbing::inRandomOrder()->first();
        if (!$dosen) {
            session()->flash('error', 'Tidak ada dosen pembimbing yang tersedia.');
            return;
        }

        // Create internship contract
        $kontrak = KontrakMagang::create([
            'mahasiswa_id' => $this->mahasiswa->id,
            'dosen_id' => $dosen->id,
            'lowongan_magang_id' => $lowongan_magang_id,
            'waktu_awal' => now(),
            'waktu_akhir' => now()->addMonths(3),
        ]);

        // Update student internship status
        $this->mahasiswa->update(['status_magang' => 'sedang magang']);

        // Get internship location info
        $internshipInfo = $this->getInternshipInfo();

        session()->flash('success', "Data magang berhasil disimpan! Anda sedang magang di: {$internshipInfo}");
        $this->resetForm();
    } catch (\Illuminate\Validation\ValidationException $e) {
        throw $e;
    } catch (\Exception $e) {
        Log::error('Error saving internship data', [
            'mahasiswa_id' => $this->mahasiswa->id ?? null,
            'company_type' => $this->company_type,
            'error' => $e->getMessage(),
        ]);

        session()->flash('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
    }
};

$getInternshipInfo = function () {
    try {
        if (!$this->mahasiswa) {
            return 'Tidak diketahui';
        }

        $kontrak = KontrakMagang::with(['lowonganMagang.perusahaan'])
            ->where('mahasiswa_id', $this->mahasiswa->id)
            ->latest()
            ->first();

        if ($kontrak && $kontrak->lowonganMagang && $kontrak->lowonganMagang->perusahaan) {
            $perusahaan = $kontrak->lowonganMagang->perusahaan;
            return "{$perusahaan->nama} - {$perusahaan->lokasi}";
        }

        return 'Lokasi magang belum ditentukan';
    } catch (\Exception $e) {
        Log::error('Error getting internship info', ['error' => $e->getMessage()]);
        return 'Error mengambil informasi magang';
    }
};

$resetForm = function () {
    $this->reset(['company_type', 'selected_company_id', 'selected_lowongan_id', 'company_name', 'company_address', 'bidang_industri', 'lokasi_magang', 'surat_izin_magang', 'available_lowongan']);
};

?>

<div class="space-y-4 border-t pt-4 mt-4">
    <div class="flex justify-between items-center">
        <h3 class="text-md font-semibold text-gray-700">Informasi Magang</h3>
    </div>

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

        @if (session()->has('info'))
            <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50">
                {{ session('info') }}
            </div>
        @endif

        <!-- Student info with internship location -->
        <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50">
            <strong>Mahasiswa:</strong> {{ $mahasiswa->nama }} ({{ $mahasiswa->nim }}) <br>
            <strong>Status:</strong> {{ ucwords(str_replace('_', ' ', $mahasiswa->status_magang)) }} <br>
            @if ($mahasiswa->status_magang === 'sedang magang')
                <strong>Lokasi Magang:</strong> {{ $this->getInternshipInfo() }}
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
            @if (count($partner_companies) > 0)
                <div>
                    <x-flux::field>
                        <x-flux::label>Pilih Perusahaan Mitra</x-flux::label>
                        <x-flux::select wire:model.live="selected_company_id" placeholder="Pilih perusahaan">
                            <option value="">Pilih perusahaan</option>
                            @foreach ($partner_companies as $company)
                                <option value="{{ $company->id }}">
                                    {{ $company->nama }} - {{ $company->lokasi }}
                                    @if ($company->bidangIndustri)
                                        ({{ $company->bidangIndustri->nama }})
                                    @endif
                                </option>
                            @endforeach
                        </x-flux::select>
                        <x-flux::error for="selected_company_id" />
                    </x-flux::field>
                </div>

                <!-- Job Selection for Partner Company -->
                @if ($selected_company_id && count($available_lowongan) > 0)
                    <div>
                        <x-flux::field>
                            <x-flux::label>Pilih Lowongan Magang</x-flux::label>
                            <x-flux::select wire:model="selected_lowongan_id" placeholder="Pilih lowongan">
                                <option value="">Pilih lowongan</option>
                                @foreach ($available_lowongan as $lowongan)
                                    <option value="{{ $lowongan->id }}">
                                        {{ $lowongan->nama }}
                                        @if ($lowongan->pekerjaan)
                                            - {{ $lowongan->pekerjaan->nama }}
                                        @endif
                                        @if ($lowongan->lokasiMagang)
                                            - {{ $lowongan->lokasiMagang->lokasi }}
                                        @endif
                                    </option>
                                @endforeach
                            </x-flux::select>
                            <x-flux::error for="selected_lowongan_id" />
                        </x-flux::field>
                    </div>

                    <!-- Show selected job details -->
                    @if ($selected_lowongan_id)
                        @php
                            $selectedJob = $available_lowongan->firstWhere('id', $selected_lowongan_id);
                        @endphp
                        @if ($selectedJob)
                            <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50">
                                <strong>Detail Lowongan:</strong><br>
                                <strong>Nama:</strong> {{ $selectedJob->nama }}<br>
                                <strong>Kuota:</strong> {{ $selectedJob->kuota }} orang<br>
                                @if ($selectedJob->pekerjaan)
                                    <strong>Jenis Pekerjaan:</strong> {{ $selectedJob->pekerjaan->nama }}<br>
                                @endif
                                <strong>Jenis Magang:</strong>
                                {{ ucfirst(str_replace('_', ' ', $selectedJob->jenis_magang)) }}<br>
                                <strong>Remote:</strong> {{ $selectedJob->open_remote == 'ya' ? 'Ya' : 'Tidak' }}<br>
                                <strong>Deskripsi:</strong> {{ Str::limit($selectedJob->deskripsi, 200) }}<br>
                                @if ($selectedJob->persyaratan)
                                    <strong>Persyaratan:</strong> {{ Str::limit($selectedJob->persyaratan, 200) }}
                                @endif
                            </div>
                        @endif
                    @endif
                @elseif ($selected_company_id)
                    <div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50">
                        <strong>Tidak ada lowongan aktif untuk perusahaan ini.</strong><br>
                        Silakan pilih perusahaan lain atau hubungi administrator.
                    </div>
                @endif
            @else
                <div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50">
                    <strong>Tidak ada perusahaan mitra dengan lowongan aktif saat ini.</strong><br>
                    Silakan pilih "Perusahaan Non-Mitra" untuk mendaftar ke perusahaan lain.
                </div>
            @endif
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
