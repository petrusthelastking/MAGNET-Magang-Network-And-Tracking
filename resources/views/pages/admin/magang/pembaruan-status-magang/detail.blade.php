<?php

use Flux\Flux;
use function Livewire\Volt\{layout, state, mount, computed};
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\FormPengajuanMagang;
use App\Models\BerkasPengajuanMagang;
use App\Models\DosenPembimbing;
use App\Models\KontrakMagang;
use App\Models\LowonganMagang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

layout('components.layouts.user.main');

state([
    'formPengajuanMagang' => null,
    'status_pengajuan' => null,
    'berkasPengajuanMagang' => null,

    // Mahasiswa data
    'mahasiswa' => null,
    'nama_lengkap' => null,
    'nim' => null,
    'email' => null,
    'jurusan' => null,
    'program_studi' => null,
    'jenis_kelamin' => null,
    'tanggal_lahir' => null,
    'angkatan' => null,
    'alamat' => null,
    'status_magang' => null,

    // Documents
    'cv' => null,
    'transkrip_nilai' => null,
    'portfolio' => null,

    // Dosen Pembimbing
    'dosenPembimbingList' => [],
    'dosenPembimbingSelected' => null,

    // Available Lowongan for assignment
    'lowonganMagangList' => [],
    'lowonganMagangSelected' => null,

    // Approval data
    'keterangan' => '',
    'rejection_reason' => '',

    // State flags
    'isDataFound' => true,
    'isProcessing' => false,
]);

// Computed properties
$documentUrls = computed(function () {
    if (!$this->berkasPengajuanMagang) return [];

    return [
        'cv' => $this->cv ? Storage::url($this->cv) : null,
        'transkrip_nilai' => $this->transkrip_nilai ? Storage::url($this->transkrip_nilai) : null,
        'portfolio' => $this->portfolio ? Storage::url($this->portfolio) : null,
    ];
});

$canApprove = computed(function () {
    return $this->formPengajuanMagang && 
           $this->formPengajuanMagang->status === 'diproses' &&
           $this->dosenPembimbingSelected &&
           !$this->isProcessing;
});

$canReject = computed(function () {
    return $this->formPengajuanMagang && 
           $this->formPengajuanMagang->status === 'diproses' &&
           !$this->isProcessing;
});

mount(function (int $id) {
    try {
        $this->formPengajuanMagang = FormPengajuanMagang::with([
            'berkasPengajuanMagang.mahasiswa'
        ])->findOrFail($id);

        // Set status display
        $this->status_pengajuan = match($this->formPengajuanMagang->status) {
            'diproses' => 'Belum diverifikasi',
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
            default => 'Unknown'
        };

        // Get berkas and mahasiswa data
        $berkas = $this->formPengajuanMagang->berkasPengajuanMagang;
        $this->berkasPengajuanMagang = $berkas;

        if ($berkas && $berkas->mahasiswa) {
            $mahasiswa = $berkas->mahasiswa;
            $this->mahasiswa = $mahasiswa;

            // Populate mahasiswa fields
            $this->nama_lengkap = $mahasiswa->nama;
            $this->nim = $mahasiswa->nim;
            $this->email = $mahasiswa->email;
            $this->jurusan = $mahasiswa->jurusan;
            $this->program_studi = $mahasiswa->program_studi;
            $this->jenis_kelamin = $mahasiswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
            
            // Fixed tanggal_lahir formatting
            if ($mahasiswa->tanggal_lahir) {
                try {
                    // Handle both string and Carbon instances
                    if (is_string($mahasiswa->tanggal_lahir)) {
                        $this->tanggal_lahir = Carbon::parse($mahasiswa->tanggal_lahir)->format('d M Y');
                    } elseif ($mahasiswa->tanggal_lahir instanceof Carbon) {
                        $this->tanggal_lahir = $mahasiswa->tanggal_lahir->format('d M Y');
                    } else {
                        $this->tanggal_lahir = null;
                    }
                } catch (\Exception $e) {
                    // If parsing fails, set to null or keep original value
                    $this->tanggal_lahir = $mahasiswa->tanggal_lahir;
                    \Log::warning('Failed to parse tanggal_lahir', [
                        'value' => $mahasiswa->tanggal_lahir,
                        'error' => $e->getMessage()
                    ]);
                }
            } else {
                $this->tanggal_lahir = null;
            }
            
            $this->angkatan = $mahasiswa->angkatan;
            $this->alamat = $mahasiswa->alamat;
            $this->status_magang = ucwords(str_replace('_', ' ', $mahasiswa->status_magang));
        }

        // Set document paths
        $this->cv = $berkas->cv ?? null;
        $this->transkrip_nilai = $berkas->transkrip_nilai ?? null;
        $this->portfolio = $berkas->portfolio ?? null;

        // Load dosen pembimbing options
        $this->dosenPembimbingList = DosenPembimbing::select('id', 'nama', 'nidn')
            ->orderBy('nama')
            ->get()
            ->pluck('nama', 'id')
            ->toArray();

        // Load available lowongan magang
        $this->lowonganMagangList = LowonganMagang::with(['perusahaan', 'pekerjaan'])
            ->where('status', 'buka')
            ->orderBy('created_at', 'desc')
            ->get()
            ->mapWithKeys(function ($lowongan) {
                $perusahaanNama = $lowongan->perusahaan ? $lowongan->perusahaan->nama : 'Perusahaan tidak tersedia';
                $pekerjaanNama = $lowongan->pekerjaan ? $lowongan->pekerjaan->nama : 'Pekerjaan tidak tersedia';
                return [$lowongan->id => $pekerjaanNama . ' - ' . $perusahaanNama];
            })
            ->toArray();

        // Set existing keterangan
        $this->keterangan = $this->formPengajuanMagang->keterangan ?? '';

    } catch (ModelNotFoundException $error) {
        $this->isDataFound = false;
        \Log::error('Form pengajuan not found: ' . $id, ['error' => $error->getMessage()]);
    } catch (\Exception $error) {
        $this->isDataFound = false;
        \Log::error('Error loading form pengajuan: ' . $id, ['error' => $error->getMessage()]);
    }
});

// Approval action
$approve = function () {
    if (!$this->canApprove) {
        session()->flash('error', 'Tidak dapat menyetujui pengajuan ini.');
        return;
    }

    $this->isProcessing = true;

    try {
        DB::transaction(function () {
            // Update form status
            $this->formPengajuanMagang->update([
                'status' => 'diterima',
                'keterangan' => $this->keterangan ?: 'Pengajuan disetujui',
            ]);

            // Create kontrak magang if lowongan selected
            if ($this->lowonganMagangSelected && $this->mahasiswa) {
                KontrakMagang::create([
                    'mahasiswa_id' => $this->mahasiswa->id,
                    'dosen_id' => $this->dosenPembimbingSelected,
                    'lowongan_magang_id' => $this->lowonganMagangSelected,
                    'waktu_awal' => now()->addDays(7), // Start in 7 days
                    'waktu_akhir' => now()->addMonths(3), // 3 months duration
                ]);

                // Only update mahasiswa status if currently 'belum_magang'
                if ($this->mahasiswa->status_magang === 'belum_magang') {
                    $this->mahasiswa->update(['status_magang' => 'sedang_magang']);
                }
            }
        });

        $this->status_pengajuan = 'Diterima';
        session()->flash('success', 'Pengajuan magang berhasil disetujui');
        
        // Refresh data
        $this->formPengajuanMagang->refresh();
        
        Flux::modal('success-modal')->show();

    } catch (\Exception $e) {
        \Log::error('Error approving application', [
            'form_id' => $this->formPengajuanMagang->id,
            'error' => $e->getMessage()
        ]);
        session()->flash('error', 'Terjadi kesalahan saat menyetujui pengajuan');
    } finally {
        $this->isProcessing = false;
        Flux::modal('approve-modal')->close();
    }
};

// Rejection action
$reject = function () {
    if (!$this->canReject) {
        session()->flash('error', 'Tidak dapat menolak pengajuan ini.');
        return;
    }

    if (empty($this->rejection_reason)) {
        session()->flash('error', 'Alasan penolakan harus diisi.');
        return;
    }

    $this->isProcessing = true;

    try {
        $this->formPengajuanMagang->update([
            'status' => 'ditolak',
            'keterangan' => $this->rejection_reason,
        ]);

        $this->status_pengajuan = 'Ditolak';
        $this->keterangan = $this->rejection_reason;

        session()->flash('success', 'Pengajuan magang berhasil ditolak');
        Flux::modal('success-modal')->show();

    } catch (\Exception $e) {
        \Log::error('Error rejecting application', [
            'form_id' => $this->formPengajuanMagang->id,
            'error' => $e->getMessage()
        ]);
        session()->flash('error', 'Terjadi kesalahan saat menolak pengajuan');
    } finally {
        $this->isProcessing = false;
        Flux::modal('reject-modal')->close();
    }
};

// Download document - Fixed approach
$downloadDocument = function (string $type) {
    $filePath = null;
    $fileName = '';

    switch ($type) {
        case 'cv':
            $filePath = $this->cv;
            $fileName = 'CV_' . $this->nim . '.pdf';
            break;
        case 'transkrip':
            $filePath = $this->transkrip_nilai;
            $fileName = 'Transkrip_' . $this->nim . '.pdf';
            break;
        case 'portfolio':
            $filePath = $this->portfolio;
            $fileName = 'Portfolio_' . $this->nim . '.pdf';
            break;
    }

    if ($filePath && Storage::exists($filePath)) {
        // Use redirect to download route instead of direct return
        return redirect()->route('admin.download-document', [
            'type' => $type,
            'file' => base64_encode($filePath),
            'name' => $fileName
        ]);
    }

    session()->flash('error', 'File tidak ditemukan');
};

// Show approval modal
$showApprovalModal = function () {
    if (!$this->dosenPembimbingSelected) {
        session()->flash('error', 'Silakan pilih dosen pembimbing terlebih dahulu.');
        return;
    }
    Flux::modal('approve-modal')->show();
};

?>

<div class="flex flex-col gap-5">
    <x-slot:user>admin</x-slot:user>

    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        {{-- <flux:breadcrumbs.item href="{{ route('admin.data-pengajuan-magang') }}" class="text-black">
            Kelola Data Pengajuan Magang
        </flux:breadcrumbs.item> --}}
        <flux:breadcrumbs.item class="text-black">Detail Pengajuan Magang</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex justify-between items-center">
        <h1 class="text-xl font-bold leading-6 text-black">Detail Informasi Pengajuan Magang</h1>
        <div class="flex gap-2">
            <!-- Status Badge -->
            @php
                $badgeColor = match($status_pengajuan) {
                    'Diterima' => 'green',
                    'Ditolak' => 'red',
                    'Belum diverifikasi' => 'yellow',
                    default => 'gray'
                };
            @endphp
            <flux:badge variant="solid" color="{{ $badgeColor }}" size="lg">
                {{ $status_pengajuan }}
            </flux:badge>
            
            {{-- <flux:button href="{{ route('admin.data-pengajuan-magang') }}" variant="ghost" icon="arrow-left">
                Kembali
            </flux:button> --}}
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="p-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200">
            {{ session('error') }}
        </div>
    @endif

    @if (!$isDataFound)
        <div class="bg-white p-12 rounded-xl shadow border border-gray-200 text-center">
            <flux:icon.exclamation-triangle class="w-16 h-16 text-gray-400 mx-auto mb-4" />
            <h3 class="text-lg font-medium text-gray-900 mb-2">Data Tidak Ditemukan</h3>
            <p class="text-gray-500">Data pengajuan magang yang Anda cari tidak ditemukan.</p>
        </div>
    @else
        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Mahasiswa Data -->
                <div class="bg-white p-6 rounded-xl shadow border border-gray-200">
                    <h2 class="text-lg font-semibold text-black mb-4 flex items-center gap-2">
                        <flux:icon.user class="w-5 h-5" />
                        Data Mahasiswa
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Nama Lengkap</label>
                                <p class="text-gray-900">{{ $nama_lengkap ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">NIM</label>
                                <p class="text-gray-900">{{ $nim ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Email</label>
                                <p class="text-gray-900">{{ $email ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Jenis Kelamin</label>
                                <p class="text-gray-900">{{ $jenis_kelamin ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Jurusan</label>
                                <p class="text-gray-900">{{ $jurusan ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Program Studi</label>
                                <p class="text-gray-900">{{ $program_studi ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Angkatan</label>
                                <p class="text-gray-900">{{ $angkatan ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Status Magang</label>
                                <p class="text-gray-900">{{ $status_magang ?? 'N/A' }}</p>
                            </div>
                        </div>
                        @if($alamat)
                        <div class="md:col-span-2">
                            <label class="text-sm font-medium text-gray-500">Alamat</label>
                            <p class="text-gray-900">{{ $alamat }}</p>
                        </div>
                        @endif
                        @if($tanggal_lahir)
                        <div class="md:col-span-2">
                            <label class="text-sm font-medium text-gray-500">Tanggal Lahir</label>
                            <p class="text-gray-900">{{ $tanggal_lahir }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Documents -->
                <div class="bg-white p-6 rounded-xl shadow border border-gray-200">
                    <h2 class="text-lg font-semibold text-black mb-4 flex items-center gap-2">
                        <flux:icon.document-text class="w-5 h-5" />
                        Berkas Pengajuan
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <flux:button 
                            wire:click="downloadDocument('cv')" 
                            variant="outline" 
                            icon="document-arrow-down"
                            class="justify-center {{ !$cv ? 'opacity-50 cursor-not-allowed' : '' }}"
                            :disabled="!$cv"
                        >
                            {{ $cv ? 'Unduh CV' : 'CV Tidak Ada' }}
                        </flux:button>
                        <flux:button 
                            wire:click="downloadDocument('transkrip')" 
                            variant="outline" 
                            icon="document-arrow-down"
                            class="justify-center {{ !$transkrip_nilai ? 'opacity-50 cursor-not-allowed' : '' }}"
                            :disabled="!$transkrip_nilai"
                        >
                            {{ $transkrip_nilai ? 'Unduh Transkrip' : 'Transkrip Tidak Ada' }}
                        </flux:button>
                        <flux:button 
                            wire:click="downloadDocument('portfolio')" 
                            variant="outline" 
                            icon="document-arrow-down"
                            class="justify-center {{ !$portfolio ? 'opacity-50 cursor-not-allowed' : '' }}"
                            :disabled="!$portfolio"
                        >
                            {{ $portfolio ? 'Unduh Portfolio' : 'Portfolio Tidak Ada' }}
                        </flux:button>
                    </div>
                </div>
            </div>

            <!-- Right Column - Actions -->
            <div class="space-y-6">
                <!-- Review Form -->
                @if($formPengajuanMagang && $formPengajuanMagang->status === 'diproses')
                <div class="bg-white p-6 rounded-xl shadow border border-gray-200">
                    <h2 class="text-lg font-semibold text-black mb-4 flex items-center gap-2">
                        <flux:icon.clipboard-document-check class="w-5 h-5" />
                        Peninjauan Pengajuan
                    </h2>
                    <div class="space-y-4">
                        <flux:field>
                            <flux:label>Dosen Pembimbing *</flux:label>
                            <flux:select wire:model.live="dosenPembimbingSelected" placeholder="Pilih Dosen Pembimbing">
                                @foreach($dosenPembimbingList as $id => $nama)
                                    <flux:select.option value="{{ $id }}">{{ $nama }}</flux:select.option>
                                @endforeach
                            </flux:select>
                            <flux:error name="dosenPembimbingSelected" />
                        </flux:field>

                        {{-- <flux:field>
                            <flux:label>Lowongan Magang (Opsional)</flux:label>
                            <flux:select wire:model.live="lowonganMagangSelected" placeholder="Pilih Lowongan Magang">
                                @foreach($lowonganMagangList as $id => $nama)
                                    <flux:select.option value="{{ $id }}">{{ $nama }}</flux:select.option>
                                @endforeach
                            </flux:select>
                        </flux:field> --}}

                        {{-- <flux:field>
                            <flux:label>Keterangan</flux:label>
                            <flux:textarea wire:model="keterangan" placeholder="Tambahkan keterangan jika diperlukan..." />
                        </flux:field> --}}
                    </div>

                    <div class="flex flex-col gap-3 mt-6">
                        <flux:button 
                            wire:click="showApprovalModal" 
                            variant="primary" 
                            icon="check-circle"
                            class="w-full justify-center"
                            :disabled="$isProcessing || !$dosenPembimbingSelected"
                        >
                            {{ $isProcessing ? 'Memproses...' : 'Setujui Pengajuan' }}
                        </flux:button>
                        
                        <flux:button 
                            variant="danger" 
                            icon="x-circle"
                            class="w-full justify-center"
                            onclick="Flux.modal('reject-modal').show()"
                            :disabled="$isProcessing"
                        >
                            Tolak Pengajuan
                        </flux:button>
                    </div>
                </div>
                @endif

                <!-- Status Info -->
                <div class="bg-white p-6 rounded-xl shadow border border-gray-200">
                    <h2 class="text-lg font-semibold text-black mb-4">Informasi Status</h2>
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Status Saat Ini</label>
                            <p class="text-lg font-medium text-gray-900">{{ $status_pengajuan }}</p>
                        </div>
                        @if($keterangan)
                        <div>
                            <label class="text-sm font-medium text-gray-500">Keterangan</label>
                            <p class="text-gray-900">{{ $keterangan }}</p>
                        </div>
                        @endif
                        @if($formPengajuanMagang)
                        <div>
                            <label class="text-sm font-medium text-gray-500">Waktu Pengajuan</label>
                            <p class="text-gray-900">{{ $formPengajuanMagang->created_at->format('d M Y H:i') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Approval Confirmation Modal -->
    <flux:modal name="approve-modal" title="Konfirmasi Persetujuan">
        <div class="space-y-4">
            <p>Apakah Anda yakin ingin menyetujui pengajuan magang ini?</p>
            @if($dosenPembimbingSelected && $dosenPembimbingList)
                <div class="bg-blue-50 p-3 rounded-lg">
                    <p class="text-sm"><strong>Dosen Pembimbing:</strong> {{ $dosenPembimbingList[$dosenPembimbingSelected] ?? 'N/A' }}</p>
                    @if($lowonganMagangSelected && $lowonganMagangList)
                        <p class="text-sm"><strong>Lowongan:</strong> {{ $lowonganMagangList[$lowonganMagangSelected] ?? 'N/A' }}</p>
                    @endif
                </div>
            @endif
        </div>
        
        <div class="flex justify-end gap-3 mt-6">
            <flux:button variant="ghost" onclick="Flux.modal('approve-modal').close()">
                Batal
            </flux:button>
            <flux:button wire:click="approve" variant="primary" :disabled="$isProcessing">
                {{ $isProcessing ? 'Memproses...' : 'Ya, Setujui' }}
            </flux:button>
        </div>
    </flux:modal>

    <!-- Rejection Modal -->
    <flux:modal name="reject-modal" title="Tolak Pengajuan Magang">
        <div class="space-y-4">
            <p>Berikan alasan penolakan pengajuan magang ini:</p>
            <flux:field>
                <flux:label>Alasan Penolakan *</flux:label>
                <flux:textarea 
                    wire:model="rejection_reason" 
                    placeholder="Masukkan alasan penolakan yang jelas..."
                    rows="4"
                    required
                />
                <flux:error name="rejection_reason" />
            </flux:field>
        </div>
        
        <div class="flex justify-end gap-3 mt-6">
            <flux:button variant="ghost" onclick="Flux.modal('reject-modal').close()">
                Batal
            </flux:button>
            <flux:button wire:click="reject" variant="danger" :disabled="$isProcessing">
                {{ $isProcessing ? 'Memproses...' : 'Tolak Pengajuan' }}
            </flux:button>
        </div>
    </flux:modal>

    <!-- Success Modal -->
    <flux:modal name="success-modal" title="Berhasil">
        <div class="text-center py-4">
            <flux:icon.check-circle class="w-16 h-16 text-green-500 mx-auto mb-4" />
            <p class="text-lg">Pengajuan berhasil diproses!</p>
        </div>
        <div class="flex justify-center mt-6">
            <flux:button onclick="Flux.modal('success-modal').close()" variant="primary">
                Tutup
            </flux:button>
        </div>
    </flux:modal>
</div>