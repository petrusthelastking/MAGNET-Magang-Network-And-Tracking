<?php

use App\Models\{KontrakMagang, LowonganMagang, UlasanMagang};
use Illuminate\Support\Facades\{Auth, Storage};
use Livewire\WithFileUploads;
use function Livewire\Volt\{state, mount, rules, uses};

uses(WithFileUploads::class);

state([
    'bukti_surat_selesai_magang' => null,
    'mahasiswa' => null,
    'kontrak_magang' => null,
    'review_rating' => null,
    'review_komentar' => '',
    'show_review_form' => false,
    'existing_review' => null,
]);

rules([
    'bukti_surat_selesai_magang' => 'required|file|mimes:pdf|max:2048',
    'review_rating' => 'required|integer|min:1|max:5',
    'review_komentar' => 'required|string|min:10|max:500',
]);

mount(function () {
    $this->mahasiswa = Auth::guard('mahasiswa')->user();

    if (!$this->mahasiswa) {
        session()->flash('error', 'Anda harus login sebagai mahasiswa.');
        return;
    }

    // Get active internship contract
    $this->kontrak_magang = KontrakMagang::with(['lowonganMagang.perusahaan'])
        ->where('mahasiswa_id', $this->mahasiswa->id)
        ->first();

    // Check if student already has a review for this internship
    if ($this->kontrak_magang) {
        $this->existing_review = UlasanMagang::where('kontrak_magang_id', $this->kontrak_magang->id)->first();

        if ($this->existing_review) {
            $this->review_rating = $this->existing_review->rating;
            $this->review_komentar = $this->existing_review->komentar;
        }
    }
});

$showReviewForm = function () {
    $this->show_review_form = true;
    $this->resetErrorBag();
};

$hideReviewForm = function () {
    $this->show_review_form = false;
    $this->resetErrorBag();
};

$completeInternship = function () {
    try {
        if (!$this->mahasiswa) {
            session()->flash('error', 'Data mahasiswa tidak ditemukan.');
            return;
        }

        if (!$this->kontrak_magang) {
            session()->flash('error', 'Kontrak magang tidak ditemukan.');
            return;
        }

        // Check if student is currently doing internship
        if (!$this->isCurrentlyDoingInternship()) {
            session()->flash('error', 'Anda tidak sedang melakukan magang aktif.');
            return;
        }

        $this->validate([
            'bukti_surat_selesai_magang' => 'required|file|mimes:pdf|max:2048',
            'review_rating' => 'required|integer|min:1|max:5',
            'review_komentar' => 'required|string|min:10|max:500',
        ]);

        // Start database transaction
        \DB::beginTransaction();

        try {
            // Store the uploaded file
            $filePath = $this->bukti_surat_selesai_magang->store('surat-selesai-magang', 'public');

            // Create or update the review
            if ($this->existing_review) {
                $this->existing_review->update([
                    'rating' => $this->review_rating,
                    'komentar' => $this->review_komentar,
                ]);
            } else {
                UlasanMagang::create([
                    'kontrak_magang_id' => $this->kontrak_magang->id,
                    'rating' => $this->review_rating,
                    'komentar' => $this->review_komentar,
                ]);
            }

            // Update mahasiswa status
            $updateData = ['status_magang' => 'selesai magang'];

            if (\Schema::hasColumn('mahasiswa', 'bukti_surat_selesai_magang')) {
                $updateData['bukti_surat_selesai_magang'] = $filePath;
            }

            $this->mahasiswa->update($updateData);

            // Update kontrak magang end date
            $kontrakUpdateData = ['waktu_akhir' => now()];

            if (\Schema::hasColumn('kontrak_magang', 'status')) {
                $kontrakUpdateData['status'] = 'selesai';
            }

            $this->kontrak_magang->update($kontrakUpdateData);

            \DB::commit();

            session()->flash('success', 'Status magang berhasil diperbarui menjadi selesai. Ulasan dan surat selesai magang telah tersimpan.');

            // Reset form
            $this->reset(['bukti_surat_selesai_magang', 'show_review_form']);

            // Refresh data
            $this->mahasiswa->refresh();
            $this->existing_review = UlasanMagang::where('kontrak_magang_id', $this->kontrak_magang->id)->first();

            // Emit event to parent component to refresh
            $this->dispatch('refreshParent');
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Fixed: Use Laravel's Arr::flatten or collect()->flatten() instead of array_flatten
        $errors = collect($e->errors())->flatten()->implode(', ');
        session()->flash('error', 'Error validasi: ' . $errors);
    } catch (\Illuminate\Database\QueryException $e) {
        session()->flash('error', 'Error database: ' . $e->getMessage());
    } catch (\Exception $e) {
        session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage() . ' (Line: ' . $e->getLine() . ')');
    }
};

$getInternshipInfo = function () {
    if (!$this->kontrak_magang || !$this->kontrak_magang->lowonganMagang || !$this->kontrak_magang->lowonganMagang->perusahaan) {
        return 'Informasi magang tidak tersedia';
    }

    $perusahaan = $this->kontrak_magang->lowonganMagang->perusahaan;
    return "{$perusahaan->nama} - {$perusahaan->lokasi}";
};

$isCurrentlyDoingInternship = function () {
    if (!$this->mahasiswa || !$this->kontrak_magang) {
        return false;
    }

    // Check if student status indicates active internship
    $activeStatuses = ['sedang magang', 'magang berlangsung', 'aktif magang'];
    $currentStatus = strtolower($this->mahasiswa->status_magang ?? '');

    // Check mahasiswa status
    $isActiveByStatus = in_array($currentStatus, $activeStatuses);

    // Check if contract is still active (not finished)
    $contractStatus = strtolower($this->kontrak_magang->status ?? 'aktif');
    $isActiveByContract = !in_array($contractStatus, ['selesai', 'completed', 'finished']);

    // Check if end date hasn't passed or is null (ongoing)
    $isActiveByDate = is_null($this->kontrak_magang->waktu_akhir) || $this->kontrak_magang->waktu_akhir->isFuture();

    return $isActiveByStatus && $isActiveByContract && $isActiveByDate;
};

$hasCompletedInternship = function () {
    if (!$this->mahasiswa) {
        return false;
    }

    $completedStatuses = ['selesai', 'selesai magang', 'completed', 'finished'];
    $currentStatus = strtolower($this->mahasiswa->status_magang ?? '');

    return in_array($currentStatus, $completedStatuses);
};

?>

<div class="space-y-4 border-t pt-4 mt-4">
    <h3 class="text-md font-semibold text-gray-700">Dokumen Selesai Magang</h3>

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

        @if ($this->hasCompletedInternship())
            <!-- Student has already completed internship -->
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50">
                <strong>Status:</strong> Magang telah selesai<br>
                @if ($mahasiswa->bukti_surat_selesai_magang)
                    <strong>Surat selesai magang:</strong>
                    <a href="{{ Storage::url($mahasiswa->bukti_surat_selesai_magang) }}" target="_blank"
                        class="text-blue-600 hover:underline">
                        Lihat dokumen
                    </a>
                @endif

                @if ($kontrak_magang)
                    <br><strong>Lokasi magang:</strong> {{ $this->getInternshipInfo() }}
                    <br><strong>Periode:</strong>
                    {{ $kontrak_magang->waktu_awal->format('d M Y') }} -
                    {{ $kontrak_magang->waktu_akhir ? $kontrak_magang->waktu_akhir->format('d M Y') : 'Sekarang' }}
                @endif

                @if ($existing_review)
                    <br><strong>Ulasan yang diberikan:</strong>
                    <div class="mt-2 p-3 bg-white rounded border">
                        <div class="flex items-center mb-2">
                            <strong>Rating:</strong>
                            <span class="ml-2">{{ $existing_review->rating }}/5</span>
                            <div class="ml-2 flex">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $existing_review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                        </div>
                        <strong>Komentar:</strong>
                        <p class="text-gray-700 mt-1">{{ $existing_review->komentar }}</p>
                    </div>
                @endif
            </div>
        @elseif ($this->isCurrentlyDoingInternship())
            <!-- Student is currently doing internship - show upload form with review -->
            @if ($kontrak_magang)
                <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50">
                    <strong>Mahasiswa:</strong> {{ $mahasiswa->nama }} ({{ $mahasiswa->nim }})<br>
                    <strong>Status saat ini:</strong>
                    {{ ucwords(str_replace('_', ' ', $mahasiswa->status_magang)) }}<br>
                    <strong>Lokasi magang:</strong> {{ $this->getInternshipInfo() }}<br>
                    <strong>Mulai magang:</strong> {{ $kontrak_magang->waktu_awal->format('d M Y') }}<br>
                </div>

                @if (!$show_review_form)
                    <!-- Show button to start completion process -->
                    <div class="text-center py-6">
                        <p class="text-gray-600 mb-4">Untuk menyelesaikan magang, Anda perlu mengisi ulasan perusahaan
                            dan mengunggah surat selesai magang.</p>
                        <flux:button wire:click="showReviewForm" variant="filled">
                            Mulai Proses Penyelesaian Magang
                        </flux:button>
                    </div>
                @else
                    <!-- Complete form with review and file upload -->
                    <form wire:submit.prevent="completeInternship" class="space-y-6">
                        <!-- Review Section -->
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <h4 class="text-lg font-semibold text-gray-700 mb-4">Ulasan Perusahaan</h4>
                            <p class="text-sm text-gray-600 mb-4">Berikan ulasan untuk perusahaan
                                {{ $this->getInternshipInfo() }}</p>

                            <div class="space-y-4">
                                <!-- Rating -->
                                <flux:field>
                                    <flux:label>Rating Perusahaan</flux:label>
                                    <select wire:model="review_rating"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">Pilih rating (1-5)</option>
                                        <option value="1">1 - Sangat Buruk</option>
                                        <option value="2">2 - Buruk</option>
                                        <option value="3">3 - Cukup</option>
                                        <option value="4">4 - Baik</option>
                                        <option value="5">5 - Sangat Baik</option>
                                    </select>
                                    <flux:description>
                                        Berikan rating untuk perusahaan berdasarkan pengalaman magang Anda
                                    </flux:description>
                                    <flux:error for="review_rating" />
                                </flux:field>

                                <!-- Comment -->
                                <flux:field>
                                    <flux:label>Komentar</flux:label>
                                    <textarea wire:model="review_komentar" rows="4"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        placeholder="Ceritakan pengalaman magang Anda di perusahaan ini...">
                                    </textarea>
                                    <flux:description>
                                        Tulis ulasan tentang pengalaman magang Anda (minimal 10 karakter, maksimal 500
                                        karakter)
                                        <span class="text-sm text-gray-500">
                                            @if ($review_komentar)
                                                ({{ strlen($review_komentar) }}/500 karakter)
                                            @endif
                                        </span>
                                    </flux:description>
                                    <flux:error for="review_komentar" />
                                </flux:field>
                            </div>
                        </div>

                        <!-- File Upload Section -->
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <h4 class="text-lg font-semibold text-gray-700 mb-4">Dokumen Selesai Magang</h4>

                            <flux:field>
                                <flux:label>Bukti Surat Selesai Magang (PDF)</flux:label>
                                <flux:input type="file" wire:model="bukti_surat_selesai_magang" accept=".pdf" />
                                <flux:description>
                                    Upload surat keterangan selesai magang dalam format PDF (maksimal 2MB)
                                </flux:description>

                                @if ($bukti_surat_selesai_magang && !$errors->has('bukti_surat_selesai_magang'))
                                    <div class="mt-2 text-sm text-green-600">
                                        File terpilih: {{ $bukti_surat_selesai_magang->getClientOriginalName() }}
                                    </div>
                                @endif

                                <div wire:loading wire:target="bukti_surat_selesai_magang"
                                    class="text-sm text-blue-600 mt-2">
                                    Mengunggah file...
                                </div>

                                <flux:error for="bukti_surat_selesai_magang" />
                            </flux:field>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-between pt-4">
                            <flux:button wire:click="hideReviewForm" variant="ghost">
                                Batal
                            </flux:button>

                            <flux:button type="submit" wire:loading.attr="disabled"
                                :disabled="!$bukti_surat_selesai_magang || !$review_rating || !$review_komentar">
                                <span wire:loading.remove wire:target="completeInternship">
                                    Selesaikan Magang
                                </span>
                                <span wire:loading wire:target="completeInternship">
                                    Memproses...
                                </span>
                            </flux:button>
                        </div>
                    </form>
                @endif
            @else
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50">
                    <strong>Peringatan:</strong> Kontrak magang tidak ditemukan untuk mahasiswa
                    {{ $mahasiswa->nama ?? 'Unknown' }}<br>
                    <strong>Mahasiswa ID:</strong> {{ $mahasiswa->id ?? 'N/A' }}<br>
                    <strong>Status mahasiswa:</strong> {{ $mahasiswa->status_magang ?? 'N/A' }}
                </div>
            @endif
        @else
            <!-- Student is not currently doing internship and hasn't completed one -->
            <div class="p-4 mb-4 text-sm text-gray-800 rounded-lg bg-gray-50">
                <strong>Status:</strong> Tidak sedang melakukan magang<br>
                <strong>Status mahasiswa:</strong>
                {{ ucwords(str_replace('_', ' ', $mahasiswa->status_magang ?? 'Belum ada status')) }}<br>

                @if (!$kontrak_magang)
                    <div class="mt-2 text-sm text-yellow-700">
                        Belum ada kontrak magang yang terdaftar.
                    </div>
                @else
                    <strong>Kontrak terakhir:</strong> {{ $this->getInternshipInfo() }}<br>
                    @if ($kontrak_magang->waktu_akhir)
                        <strong>Berakhir:</strong> {{ $kontrak_magang->waktu_akhir->format('d M Y') }}
            </div>
        @endif
    @endif
</div>
@endif
@endif
</div>
