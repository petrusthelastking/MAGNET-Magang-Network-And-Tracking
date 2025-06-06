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
    'debug_mode' => false,
    'debug_logs' => [],
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
        $this->addDebugLog('Mount function started');
        $this->debug_mode = env('APP_DEBUG', false);

        $this->mahasiswa = Auth::guard('mahasiswa')->user();
        $this->addDebugLog('Retrieved mahasiswa from auth', [
            'mahasiswa_exists' => !is_null($this->mahasiswa),
            'mahasiswa_id' => $this->mahasiswa->id ?? null,
            'mahasiswa_name' => $this->mahasiswa->nama ?? null,
        ]);

        if (!$this->mahasiswa) {
            $this->addDebugLog('No mahasiswa found, setting error message');
            session()->flash('error', 'Anda harus login sebagai mahasiswa.');
            return;
        }

        // Check existing internship contract
        $existingContract = KontrakMagang::where('mahasiswa_id', $this->mahasiswa->id)->exists();
        $this->addDebugLog('Checked existing contract', ['has_contract' => $existingContract]);

        $this->partner_companies = Perusahaan::where('kategori', 'mitra')->get();
        $this->addDebugLog('Retrieved partner companies', [
            'count' => $this->partner_companies->count(),
            'companies' => $this->partner_companies->pluck('nama', 'id')->toArray(),
        ]);
    } catch (\Exception $e) {
        $this->addDebugLog('Error in mount function', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        Log::error('Mount function error', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
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
        $this->addDebugLog('Loading lowongan for company', ['company_id' => $this->selected_company_id]);

        if (!$this->selected_company_id) {
            $this->available_lowongan = [];
            $this->selected_lowongan_id = '';
            return;
        }

        $this->available_lowongan = LowonganMagang::where('perusahaan_id', $this->selected_company_id)->where('status', 'buka')->get();

        $this->addDebugLog('Retrieved lowongan', [
            'count' => $this->available_lowongan->count(),
            'lowongan' => $this->available_lowongan->pluck('nama', 'id')->toArray(),
        ]);

        // Reset selected lowongan when company changes
        $this->selected_lowongan_id = '';
    } catch (\Exception $e) {
        $this->addDebugLog('Error loading lowongan', [
            'error' => $e->getMessage(),
            'company_id' => $this->selected_company_id,
        ]);

        $this->available_lowongan = [];
        $this->selected_lowongan_id = '';
    }
};

$save = function () {
    try {
        $this->addDebugLog('Save function started');

        if (!$this->mahasiswa) {
            $this->addDebugLog('No mahasiswa found during save');
            session()->flash('error', 'Data mahasiswa tidak ditemukan.');
            return;
        }

        $this->addDebugLog('Validating form data', [
            'company_type' => $this->company_type,
            'selected_company_id' => $this->selected_company_id,
            'selected_lowongan_id' => $this->selected_lowongan_id,
            'company_name' => $this->company_name,
        ]);

        $this->validate();
        $this->addDebugLog('Validation passed');

        // Check if student already has active internship
        $existingContract = KontrakMagang::where('mahasiswa_id', $this->mahasiswa->id)->exists();
        if ($existingContract) {
            $this->addDebugLog('Student already has active contract');
            session()->flash('error', 'Anda sudah memiliki kontrak magang aktif.');
            return;
        }

        $lowongan_magang_id = null;
        $suratPath = null;

        if ($this->company_type === 'partner') {
            $this->addDebugLog('Processing partner company');

            // Validate selected company exists
            $selectedCompany = Perusahaan::find($this->selected_company_id);
            if (!$selectedCompany) {
                $this->addDebugLog('Selected company not found', ['company_id' => $this->selected_company_id]);
                session()->flash('error', 'Perusahaan mitra tidak ditemukan.');
                return;
            }

            // Validate selected lowongan exists and belongs to the company
            $selectedLowongan = LowonganMagang::where('id', $this->selected_lowongan_id)->where('perusahaan_id', $this->selected_company_id)->first();

            if (!$selectedLowongan) {
                $this->addDebugLog('Selected lowongan not found or invalid', [
                    'lowongan_id' => $this->selected_lowongan_id,
                    'company_id' => $this->selected_company_id,
                ]);
                session()->flash('error', 'Lowongan magang tidak ditemukan atau tidak valid.');
                return;
            }

            $lowongan_magang_id = $selectedLowongan->id;
            $this->addDebugLog('Using existing lowongan', ['lowongan_magang_id' => $lowongan_magang_id]);
        } else {
            $this->addDebugLog('Processing non-partner company');

            // Handle file upload
            if ($this->surat_izin_magang) {
                $suratPath = $this->surat_izin_magang->store('surat-izin-magang', 'public');
                $this->addDebugLog('File uploaded', ['path' => $suratPath]);
            }

            // Create new company
            $newCompany = Perusahaan::create([
                'nama' => $this->company_name,
                'bidang_industri' => $this->bidang_industri,
                'lokasi' => $this->company_address,
                'kategori' => 'non_mitra',
                'rating' => 0,
            ]);

            $this->addDebugLog('Created new company', ['company_id' => $newCompany->id]);

            // Create new lowongan
            $magang = LowonganMagang::create([
                'nama' => "Magang di {$this->company_name}",
                'deskripsi' => "Program magang di {$this->company_name}",
                'persyaratan' => 'Sesuai dengan persyaratan perusahaan',
                'perusahaan_id' => $newCompany->id,
                'status' => 'buka',
                'lokasi' => $this->lokasi_magang,
            ]);

            $lowongan_magang_id = $magang->id;
            $this->addDebugLog('Created new lowongan', ['lowongan_magang_id' => $lowongan_magang_id]);
        }

        // Create internship contract - FIXED: Use 'lowongan_magang_id' instead of 'magang_id'
        $kontrak = KontrakMagang::create([
            'mahasiswa_id' => $this->mahasiswa->id,
            'lowongan_magang_id' => $lowongan_magang_id, // CHANGED: from 'magang_id' to 'lowongan_magang_id'
            'waktu_awal' => now(),
            'waktu_akhir' => now()->addMonths(3),
            'status' => 'aktif',
            'surat_izin_path' => $suratPath,
        ]);

        $this->addDebugLog('Created internship contract', ['kontrak_id' => $kontrak->id]);

        // Update student internship status
        $this->mahasiswa->update(['status_magang' => 'sedang magang']);
        $this->addDebugLog('Updated mahasiswa status');

        // Get internship location info
        $internshipInfo = $this->getInternshipInfo();
        $this->addDebugLog('Retrieved internship info', ['info' => $internshipInfo]);

        session()->flash('success', "Data magang berhasil disimpan! Anda sedang magang di: {$internshipInfo}");
        $this->resetForm();

        $this->addDebugLog('Save process completed successfully');
    } catch (\Illuminate\Validation\ValidationException $e) {
        $this->addDebugLog('Validation error', [
            'errors' => $e->errors(),
            'failed_rules' => $e->validator->failed(),
        ]);
        throw $e;
    } catch (\Exception $e) {
        $this->addDebugLog('Error in save function', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        Log::error('Error saving internship data', [
            'mahasiswa_id' => $this->mahasiswa->id ?? null,
            'company_type' => $this->company_type,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        session()->flash('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
    }
};

$getInternshipInfo = function () {
    try {
        if (!$this->mahasiswa) {
            $this->addDebugLog('No mahasiswa for internship info');
            return 'Tidak diketahui';
        }

        // FIXED: Updated relationship name to match actual database field
        $kontrak = KontrakMagang::with(['lowonganMagang.perusahaan']) // CHANGED: from 'magang' to 'lowonganMagang'
            ->where('mahasiswa_id', $this->mahasiswa->id)
            ->latest()
            ->first();

        $this->addDebugLog('Retrieved contract for info', [
            'contract_exists' => !is_null($kontrak),
            'has_lowongan' => $kontrak && $kontrak->lowonganMagang, // CHANGED: from 'magang' to 'lowonganMagang'
            'has_perusahaan' => $kontrak && $kontrak->lowonganMagang && $kontrak->lowonganMagang->perusahaan,
        ]);

        if ($kontrak && $kontrak->lowonganMagang && $kontrak->lowonganMagang->perusahaan) {
            // CHANGED: from 'magang' to 'lowonganMagang'
            $perusahaan = $kontrak->lowonganMagang->perusahaan;
            return "{$perusahaan->nama} - {$perusahaan->lokasi}";
        }

        return 'Lokasi magang belum ditentukan';
    } catch (\Exception $e) {
        $this->addDebugLog('Error getting internship info', ['error' => $e->getMessage()]);
        return 'Error mengambil informasi magang';
    }
};

$resetForm = function () {
    $this->addDebugLog('Resetting form');
    $this->reset(['company_type', 'selected_company_id', 'selected_lowongan_id', 'company_name', 'company_address', 'bidang_industri', 'lokasi_magang', 'surat_izin_magang', 'available_lowongan']);
};

$addDebugLog = function ($message, $data = null) {
    if ($this->debug_mode) {
        $logs = $this->debug_logs ?? [];
        $logs[] = [
            'timestamp' => now()->format('H:i:s'),
            'message' => $message,
            'data' => $data,
        ];
        $this->debug_logs = $logs;

        Log::info("Internship Form Debug: {$message}", [
            'mahasiswa_id' => $this->mahasiswa->id ?? 'not_found',
            'data' => $data,
        ]);
    }
};

$clearDebugLogs = function () {
    $this->debug_logs = [];
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
            <div>
                <x-flux::field>
                    <x-flux::label>Pilih Perusahaan Mitra</x-flux::label>
                    <x-flux::select wire:model.live="selected_company_id" placeholder="Pilih perusahaan">
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
                                    @if ($lowongan->lokasi)
                                        - {{ $lowongan->lokasi }}
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
                            <strong>Deskripsi:</strong> {{ Str::limit($selectedJob->deskripsi, 200) }}<br>
                            @if ($selectedJob->persyaratan)
                                <strong>Persyaratan:</strong> {{ Str::limit($selectedJob->persyaratan, 200) }}
                            @endif
                        </div>
                    @endif
                @endif
            @elseif ($selected_company_id && count($available_lowongan) == 0)
                <div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50">
                    Tidak ada lowongan magang yang tersedia untuk perusahaan ini saat ini.
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
