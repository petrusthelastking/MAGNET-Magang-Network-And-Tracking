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
    'available_lowongan' => collect(),
    'mahasiswa' => null,
    // DEBUG STATES
    'debug_info' => [],
    'show_debug' => false,
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

        // Load partner companies with active job openings - WITH DEBUG
        $this->partner_companies = Perusahaan::where('kategori', 'mitra')
            ->whereHas('lowongan_magang', function ($query) {
                $query->where('status', 'buka');
            })
            ->get();

        // DEBUG: Log partner companies data
        $this->debug_info['total_mitra_companies'] = Perusahaan::where('kategori', 'mitra')->count();
        $this->debug_info['mitra_companies_with_active_jobs'] = $this->partner_companies->count();

        // DEBUG: Get detailed info about each company and their jobs
        $companyDebug = [];
        foreach ($this->partner_companies as $company) {
            $activeJobs = LowonganMagang::where('perusahaan_id', $company->id)->where('status', 'buka')->count();
            $totalJobs = LowonganMagang::where('perusahaan_id', $company->id)->count();

            $companyDebug[] = [
                'id' => $company->id,
                'name' => $company->nama,
                'active_jobs' => $activeJobs,
                'total_jobs' => $totalJobs,
            ];
        }
        $this->debug_info['company_details'] = $companyDebug;

        Log::info('Mount function debug info', $this->debug_info);
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
        // Clear previous debug info
        $this->debug_info['lowongan_debug'] = [];

        if (!$this->selected_company_id) {
            $this->available_lowongan = collect();
            $this->selected_lowongan_id = '';
            return;
        }

        // DEBUG: Get company info
        $selectedCompany = Perusahaan::find($this->selected_company_id);
        $this->debug_info['lowongan_debug']['selected_company'] = [
            'id' => $selectedCompany->id ?? 'NOT_FOUND',
            'name' => $selectedCompany->nama ?? 'NOT_FOUND',
            'kategori' => $selectedCompany->kategori ?? 'NOT_FOUND',
        ];

        // DEBUG: Check all lowongan for this company (regardless of status)
        $allLowonganForCompany = LowonganMagang::where('perusahaan_id', $this->selected_company_id)->get();
        $this->debug_info['lowongan_debug']['all_lowongan_count'] = $allLowonganForCompany->count();

        $lowonganDetails = [];
        foreach ($allLowonganForCompany as $lowongan) {
            $lowonganDetails[] = [
                'id' => $lowongan->id,
                'status' => $lowongan->status,
                'kuota' => $lowongan->kuota,
                'pekerjaan_id' => $lowongan->pekerjaan_id,
                'pekerjaan_name' => $lowongan->pekerjaan->nama ?? 'NO_PEKERJAAN',
                'lokasi_magang_id' => $lowongan->lokasi_magang_id,
                'lokasi_name' => $lowongan->lokasi_magang->lokasi ?? 'NO_LOKASI',
            ];
        }
        $this->debug_info['lowongan_debug']['all_lowongan_details'] = $lowonganDetails;

        // Load active job openings for selected company
        $this->available_lowongan = LowonganMagang::where('perusahaan_id', $this->selected_company_id)
            ->where('status', 'buka')
            ->with(['pekerjaan', 'lokasi_magang'])
            ->get();

        // DEBUG: Active lowongan info
        $this->debug_info['lowongan_debug']['active_lowongan_count'] = $this->available_lowongan->count();
        $this->debug_info['lowongan_debug']['active_lowongan_ids'] = $this->available_lowongan->pluck('id')->toArray();

        // DEBUG: Check if relationships are loaded properly
        $relationshipDebug = [];
        foreach ($this->available_lowongan as $lowongan) {
            $relationshipDebug[] = [
                'lowongan_id' => $lowongan->id,
                'has_pekerjaan' => $lowongan->pekerjaan ? true : false,
                'pekerjaan_name' => $lowongan->pekerjaan->nama ?? 'NULL',
                'has_lokasi' => $lowongan->lokasi_magang ? true : false,
                'lokasi_name' => $lowongan->lokasi_magang->lokasi ?? 'NULL',
            ];
        }
        $this->debug_info['lowongan_debug']['relationship_check'] = $relationshipDebug;

        // Reset selected lowongan when company changes
        $this->selected_lowongan_id = '';

        // Log debug info
        Log::info('LoadLowongan debug info', $this->debug_info['lowongan_debug']);
    } catch (\Exception $e) {
        Log::error('Error loading lowongan', [
            'company_id' => $this->selected_company_id,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        $this->available_lowongan = collect();
        $this->selected_lowongan_id = '';
        $this->debug_info['lowongan_debug']['error'] = $e->getMessage();
    }
};

$toggleDebug = function () {
    $this->show_debug = !$this->show_debug;
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
            $selectedLowongan = LowonganMagang::where('id', $this->selected_lowongan_id)->where('perusahaan_id', $this->selected_company_id)->where('status', 'buka')->first();

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
            $lokasi_magang = \App\Models\lokasi_magang::firstOrCreate([
                'kategori_lokasi' => 'Onsite',
                'lokasi' => $this->lokasi_magang,
            ]);

            // Create new lowongan
            $magang = LowonganMagang::create([
                'kuota' => 1,
                'pekerjaan_id' => $pekerjaan->id,
                'deskripsi' => "Program magang di {$this->company_name}",
                'persyaratan' => 'Sesuai dengan persyaratan perusahaan',
                'jenis_magang' => 'tidak berbayar',
                'open_remote' => 'tidak',
                'perusahaan_id' => $newCompany->id,
                'lokasi_magang_id' => $lokasi_magang->id,
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
    $this->reset(['company_type', 'selected_company_id', 'selected_lowongan_id', 'company_name', 'company_address', 'bidang_industri', 'lokasi_magang', 'surat_izin_magang']);
    $this->available_lowongan = collect();
    $this->debug_info = [];
};

?>

<div class="space-y-4 border-t pt-4 mt-4">
    <div class="flex justify-between items-center">
        <h3 class="text-md font-semibold text-gray-700">Informasi Magang</h3>
        <!-- DEBUG TOGGLE BUTTON -->
        <button wire:click="toggleDebug"
            class="px-3 py-1 text-xs bg-gray-200 hover:bg-gray-300 rounded-md transition-colors">
            {{ $show_debug ? 'Hide' : 'Show' }} Debug
        </button>
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

        <!-- DEBUG INFORMATION -->
        {{-- @if ($show_debug)
            <div class="p-4 mb-4 text-xs text-gray-800 rounded-lg bg-gray-100 border">
                <strong>🐛 DEBUG INFORMATION:</strong><br>

                <div class="mt-2">
                    <strong>Mount Debug:</strong><br>
                    - Total Mitra Companies: {{ $debug_info['total_mitra_companies'] ?? 'N/A' }}<br>
                    - Mitra with Active Jobs: {{ $debug_info['mitra_companies_with_active_jobs'] ?? 'N/A' }}<br>

                    @if (isset($debug_info['company_details']))
                        <strong>Company Details:</strong><br>
                        @foreach ($debug_info['company_details'] as $detail)
                            &nbsp;&nbsp;- {{ $detail['name'] }} (ID: {{ $detail['id'] }}):
                            {{ $detail['active_jobs'] }}/{{ $detail['total_jobs'] }} active jobs<br>
                        @endforeach
                    @endif
                </div>

                @if (isset($debug_info['lowongan_debug']))
                    <div class="mt-2 border-t pt-2">
                        <strong>Lowongan Debug:</strong><br>
                        - Selected Company: {{ $debug_info['lowongan_debug']['selected_company']['name'] ?? 'N/A' }}
                        (ID: {{ $debug_info['lowongan_debug']['selected_company']['id'] ?? 'N/A' }})<br>
                        - All Lowongan Count: {{ $debug_info['lowongan_debug']['all_lowongan_count'] ?? 'N/A' }}<br>
                        - Active Lowongan Count:
                        {{ $debug_info['lowongan_debug']['active_lowongan_count'] ?? 'N/A' }}<br>
                        - Active IDs:
                        {{ implode(', ', $debug_info['lowongan_debug']['active_lowongan_ids'] ?? []) }}<br>

                        @if (isset($debug_info['lowongan_debug']['all_lowongan_details']))
                            <strong>All Lowongan Details:</strong><br>
                            @foreach ($debug_info['lowongan_debug']['all_lowongan_details'] as $detail)
                                &nbsp;&nbsp;- ID {{ $detail['id'] }}: Status={{ $detail['status'] }},
                                Pekerjaan={{ $detail['pekerjaan_name'] }},
                                Lokasi={{ $detail['lokasi_name'] }}<br>
                            @endforeach
                        @endif

                        @if (isset($debug_info['lowongan_debug']['error']))
                            <strong class="text-red-600">Error:</strong>
                            {{ $debug_info['lowongan_debug']['error'] }}<br>
                        @endif
                    </div>
                @endif
            </div>
        @endif --}}

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
                                    {{ $company->nama }}
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
                @if ($selected_company_id && $available_lowongan->count() > 0)
                    <div>
                        <x-flux::field>
                            <x-flux::label>Pilih Lowongan Magang</x-flux::label>
                            <x-flux::select wire:model="selected_lowongan_id" placeholder="Pilih lowongan">
                                <option value="">Pilih lowongan</option>
                                @foreach ($available_lowongan as $lowongan)
                                    <option value="{{ $lowongan->id }}">
                                        @if ($lowongan->pekerjaan)
                                            {{ $lowongan->pekerjaan->nama }}
                                        @else
                                            Lowongan Magang
                                        @endif
                                        @if ($lowongan->lokasi_magang)
                                            - {{ $lowongan->lokasi_magang->lokasi }}
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
                                <strong>ID Lowongan:</strong> {{ $selectedJob->id }}<br>
                                @if ($selectedJob->pekerjaan)
                                    <strong>Jenis Pekerjaan:</strong> {{ $selectedJob->pekerjaan->nama }}<br>
                                @else
                                    <strong class="text-red-600">⚠️ Pekerjaan:</strong> <span class="text-red-600">Tidak
                                        ditemukan (ID: {{ $selectedJob->pekerjaan_id }})</span><br>
                                @endif
                                <strong>Kuota:</strong> {{ $selectedJob->kuota }} orang<br>
                                <strong>Jenis Magang:</strong>
                                {{ ucfirst(str_replace('_', ' ', $selectedJob->jenis_magang)) }}<br>
                                <strong>Remote:</strong> {{ $selectedJob->open_remote == 'ya' ? 'Ya' : 'Tidak' }}<br>
                                <strong>Status:</strong> <span
                                    class="text-green-600 font-semibold">{{ ucfirst($selectedJob->status) }}</span><br>
                                <strong>Deskripsi:</strong> {{ Str::limit($selectedJob->deskripsi, 200) }}<br>
                                @if ($selectedJob->persyaratan)
                                    <strong>Persyaratan:</strong> {{ Str::limit($selectedJob->persyaratan, 200) }}
                                @endif
                                @if ($selectedJob->lokasi_magang)
                                    <strong>Lokasi:</strong> {{ $selectedJob->lokasi_magang->kategori_lokasi }} -
                                    {{ $selectedJob->lokasi_magang->lokasi }}<br>
                                @else
                                    <strong class="text-red-600">⚠️ Lokasi:</strong> <span class="text-red-600">Tidak
                                        ditemukan (ID: {{ $selectedJob->lokasi_magang_id }})</span><br>
                                @endif
                            </div>
                        @else
                            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50">
                                <strong>⚠️ Error:</strong> Selected job dengan ID {{ $selected_lowongan_id }} tidak
                                ditemukan dalam available_lowongan collection.<br>
                                Available IDs: {{ $available_lowongan->pluck('id')->join(', ') }}
                            </div>
                        @endif
                    @endif
                @elseif ($selected_company_id)
                    <div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50">
                        <strong>⚠️ Tidak ada lowongan aktif (status buka) untuk perusahaan ini.</strong><br>
                        @if ($show_debug)
                            <small>Company ID: {{ $selected_company_id }} | Available lowongan:
                                {{ $available_lowongan->count() }}</small><br>
                        @endif
                        Silakan pilih perusahaan lain atau hubungi administrator.
                    </div>
                @endif
            @else
                <div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50">
                    <strong>⚠️ Tidak ada perusahaan mitra dengan lowongan aktif (status buka) saat ini.</strong><br>
                    @if ($show_debug)
                        <small>Partner companies loaded: {{ count($partner_companies) }}</small><br>
                    @endif
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
