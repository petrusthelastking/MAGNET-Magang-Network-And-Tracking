<?php

use Flux\Flux;
use function Livewire\Volt\{layout, state, updated, computed};
use Illuminate\Support\Facades\DB;
use App\Models\{PreferensiMahasiswa, BidangIndustri, Pekerjaan, LokasiMagang, KriteriaPekerjaan, KriteriaBidangIndustri, KriteriaJenisMagang, KriteriaLokasiMagang, KriteriaOpenRemote};
use App\Helpers\DecisionMaking\ROC;

layout('components.layouts.guest.with-navbar');

state([
    'step' => 1,
    'showStep1' => true,
    'showStep2' => false,

    'pekerjaan_list' => Pekerjaan::pluck('nama', 'id'),
    'bidang_industri_list' => BidangIndustri::pluck('nama', 'id'),
    'lokasi_magang_list' => LokasiMagang::pluck('kategori_lokasi', 'id'),

    'pekerjaan',
    'bidang_industri',
    'lokasi_magang',
    'jenis_magang',
    'open_remote',

    // New drag-and-drop ranking system
    'criteria_order' => [['key' => 'pekerjaan', 'label' => 'Kesesuaian Pekerjaan', 'description' => 'Seberapa sesuai posisi/pekerjaan dengan minat Anda'], ['key' => 'bidang_industri', 'label' => 'Kesesuaian Bidang Industri', 'description' => 'Seberapa cocok bidang industri dengan preferensi Anda'], ['key' => 'lokasi_magang', 'label' => 'Kesesuaian Lokasi Magang', 'description' => 'Seberapa strategis lokasi magang untuk Anda'], ['key' => 'jenis_magang', 'label' => 'Jenis Magang (Berbayar/Tidak)', 'description' => 'Apakah magang berbayar penting untuk Anda'], ['key' => 'open_remote', 'label' => 'Ketersediaan Remote', 'description' => 'Seberapa penting fleksibilitas kerja remote']],

    'pekerjaan_rank',
    'bidang_industri_rank',
    'lokasi_magang_rank',
    'jenis_magang_rank',
    'open_remote_rank',

    'errors' => [],
]);

$prevStep = fn() => $this->step--;
$nextStep = fn() => $this->step++;

// New method to handle drag-and-drop reordering
$updateCriteriaOrder = function ($orderedKeys) {
    // Reorder the criteria_order array based on the new order
    $newOrder = [];
    foreach ($orderedKeys as $key) {
        foreach ($this->criteria_order as $criteria) {
            if ($criteria['key'] === $key) {
                $newOrder[] = $criteria;
                break;
            }
        }
    }
    $this->criteria_order = $newOrder;

    // Update individual rank values based on position
    foreach ($this->criteria_order as $index => $criteria) {
        $rank = $index + 1; // Position 0 = Rank 1, Position 1 = Rank 2, etc.
        $this->{$criteria['key'] . '_rank'} = $rank;
    }
};

$storePreferensiMahasiswa = function () {
    DB::transaction(function () {
        $mhs_id = auth('mahasiswa')->user()->id;
        $kriteria_pekerjaan = KriteriaPekerjaan::create([
            'pekerjaan_id' => $this->pekerjaan,
            'mahasiswa_id' => $mhs_id,
            'rank' => $this->pekerjaan_rank,
            'bobot' => ROC::getWeight($this->pekerjaan_rank, 5),
        ]);

        $kriteria_bidang_industri = KriteriaBidangIndustri::create([
            'bidang_industri_id' => $this->bidang_industri,
            'mahasiswa_id' => $mhs_id,
            'rank' => $this->bidang_industri_rank,
            'bobot' => ROC::getWeight($this->bidang_industri_rank, 5),
        ]);

        $kriteria_lokasi_magang = KriteriaLokasiMagang::create([
            'lokasi_magang_id' => $this->lokasi_magang,
            'mahasiswa_id' => $mhs_id,
            'rank' => $this->lokasi_magang_rank,
            'bobot' => ROC::getWeight($this->lokasi_magang_rank, 5),
        ]);

        $kriteria_jenis_magang = KriteriaJenisMagang::create([
            'jenis_magang' => $this->jenis_magang,
            'mahasiswa_id' => $mhs_id,
            'rank' => $this->jenis_magang_rank,
            'bobot' => ROC::getWeight($this->jenis_magang_rank, 5),
        ]);

        $kriteria_open_remote = KriteriaOpenRemote::create([
            'open_remote' => $this->open_remote,
            'mahasiswa_id' => $mhs_id,
            'rank' => $this->open_remote_rank,
            'bobot' => ROC::getWeight($this->open_remote_rank, 5),
        ]);

        $message = 'Data preferensi magang berhasil dibuat';

        session()->flash('task', 'Membuat data preferensi magang');
        session()->flash('message', $message);

        Flux::modal('response-modal')->show();
    });
};

$redirectToDashboard = fn() => redirect()->route('dashboard');

?>

<div>
    <div class="min-h-screen w-full">
        <!-- Step 1: Basic Information -->
        <div wire:show="step == 1" class="flex min-h-screen">
            <div class="w-1/2 p-24">
                <div class="sticky top-24">
                    <div class="flex items-center gap-3 mb-6">
                        <div
                            class="w-8 h-8 bg-magnet-sky-teal text-white rounded-full flex items-center justify-center text-sm font-semibold">
                            1</div>
                        <div
                            class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-semibold">
                            2</div>
                    </div>

                    <h1 class="text-3xl leading-8 font-black mb-4">Isi Data Preferensi Magang</h1>
                    <flux:text class="text-lg text-gray-600 mb-8">
                        Data-data berikut akan digunakan untuk menentukan rekomendasi magang yang sesuai dengan
                        preferensi Anda
                    </flux:text>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <flux:icon.information-circle class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" />
                            <div>
                                <h3 class="font-semibold text-blue-900 mb-1">Tips Pengisian</h3>
                                <p class="text-sm text-blue-800">Pilih opsi yang paling sesuai dengan preferensi magang
                                    Anda. Semua field wajib diisi untuk melanjutkan ke tahap berikutnya.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-1/2 bg-white p-24 flex flex-col justify-between">
                <div class="flex flex-col gap-6">
                    <flux:field>
                        <div class="flex items-center gap-2 mb-2">
                            <flux:label>Pekerjaan yang Diinginkan</flux:label>
                            <div class="group relative">
                                <flux:icon.question-mark-circle class="w-4 h-4 text-gray-400 cursor-help" />
                                <div
                                    class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-10">
                                    Pilih jenis pekerjaan/posisi yang ingin Anda ambil saat magang
                                </div>
                            </div>
                        </div>
                        <flux:select placeholder="Pilih pekerjaan yang diinginkan" wire:model.live="pekerjaan">
                            @foreach ($pekerjaan_list as $id => $nama)
                                <flux:select.option value="{{ $id }}">{{ $nama }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        @if (isset($errors['pekerjaan']))
                            <flux:error>{{ $errors['pekerjaan'] }}</flux:error>
                        @endif
                    </flux:field>

                    <flux:field>
                        <div class="flex items-center gap-2 mb-2">
                            <flux:label>Bidang Industri</flux:label>
                            <div class="group relative">
                                <flux:icon.question-mark-circle class="w-4 h-4 text-gray-400 cursor-help" />
                                <div
                                    class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-10">
                                    Pilih bidang industri perusahaan yang Anda minati
                                </div>
                            </div>
                        </div>
                        <flux:select placeholder="Pilih bidang industri" wire:model.live="bidang_industri">
                            @foreach ($bidang_industri_list as $id => $nama)
                                <flux:select.option value="{{ $id }}">{{ $nama }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        @if (isset($errors['bidang_industri']))
                            <flux:error>{{ $errors['bidang_industri'] }}</flux:error>
                        @endif
                    </flux:field>

                    <flux:field>
                        <div class="flex items-center gap-2 mb-2">
                            <flux:label>Lokasi Magang</flux:label>
                            <div class="group relative">
                                <flux:icon.question-mark-circle class="w-4 h-4 text-gray-400 cursor-help" />
                                <div
                                    class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-10">
                                    Pilih kategori lokasi magang yang diinginkan
                                </div>
                            </div>
                        </div>
                        <flux:select placeholder="Pilih lokasi magang" wire:model.live="lokasi_magang">
                            @foreach ($lokasi_magang_list->unique() as $id => $lokasi)
                                <flux:select.option value="{{ $id }}">{{ $lokasi }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        @if (isset($errors['lokasi_magang']))
                            <flux:error>{{ $errors['lokasi_magang'] }}</flux:error>
                        @endif
                    </flux:field>

                    <flux:field>
                        <div class="flex items-center gap-2 mb-2">
                            <flux:label>Jenis Magang</flux:label>
                            <div class="group relative">
                                <flux:icon.question-mark-circle class="w-4 h-4 text-gray-400 cursor-help" />
                                <div
                                    class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-10">
                                    Pilih apakah Anda mengutamakan magang berbayar atau tidak
                                </div>
                            </div>
                        </div>
                        <flux:select placeholder="Pilih jenis magang" wire:model.live="jenis_magang">
                            <flux:select.option value="tidak berbayar">Tidak Berbayar (Unpaid)</flux:select.option>
                            <flux:select.option value="berbayar">Berbayar (Paid)</flux:select.option>
                        </flux:select>
                        @if (isset($errors['jenis_magang']))
                            <flux:error>{{ $errors['jenis_magang'] }}</flux:error>
                        @endif
                    </flux:field>

                    <flux:field>
                        <div class="flex items-center gap-2 mb-2">
                            <flux:label>Bersedia Magang Remote?</flux:label>
                            <div class="group relative">
                                <flux:icon.question-mark-circle class="w-4 h-4 text-gray-400 cursor-help" />
                                <div
                                    class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-10">
                                    Apakah Anda bersedia melakukan magang secara remote/online?
                                </div>
                            </div>
                        </div>
                        <flux:select placeholder="Pilih kesediaan remote" wire:model.live="open_remote">
                            <flux:select.option value="ya">Ya, bersedia</flux:select.option>
                            <flux:select.option value="tidak">Tidak, hanya on-site</flux:select.option>
                        </flux:select>
                        @if (isset($errors['open_remote']))
                            <flux:error>{{ $errors['open_remote'] }}</flux:error>
                        @endif
                    </flux:field>
                </div>

                <div class="flex justify-between w-full mt-8">
                    <flux:spacer />
                    <flux:button variant="primary" icon="chevron-right" wire:click="nextStep"
                        class="bg-magnet-sky-teal px-6 py-2">
                        Lanjut ke Ranking
                    </flux:button>
                </div>
            </div>
        </div>

        <!-- Step 2: Enhanced Drag-and-Drop Ranking -->
        <div wire:show="step == 2" class="flex min-h-screen">
            <div class="w-1/2 p-24">
                <div class="sticky top-24">
                    <div class="flex items-center gap-3 mb-6">
                        <div
                            class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-semibold">
                            <flux:icon.check class="w-4 h-4" />
                        </div>
                        <div
                            class="w-8 h-8 bg-magnet-sky-teal text-white rounded-full flex items-center justify-center text-sm font-semibold">
                            2</div>
                    </div>

                    <h1 class="text-3xl leading-8 font-black mb-4">Urutkan Prioritas Kriteria</h1>
                    <flux:text class="text-lg text-gray-600 mb-8">
                        Seret dan lepas kriteria untuk mengurutkan berdasarkan tingkat kepentingan. Posisi teratas =
                        Paling Penting
                    </flux:text>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start gap-3">
                            <flux:icon.cursor-arrow-rays class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" />
                            <div>
                                <h3 class="font-semibold text-blue-900 mb-1">Cara Menggunakan</h3>
                                <p class="text-sm text-blue-800">Klik dan seret kriteria untuk mengubah urutannya.
                                    Kriteria di posisi teratas akan memiliki prioritas tertinggi dalam rekomendasi
                                    magang.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Ranking Summary -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-900 mb-3">Urutan Prioritas Saat Ini:</h3>
                        <div class="space-y-2 text-sm">
                            @foreach ($criteria_order as $index => $criteria)
                                <div class="flex justify-between items-center py-1">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="w-6 h-6 bg-magnet-sky-teal text-white rounded-full flex items-center justify-center text-xs font-semibold">
                                            {{ $index + 1 }}
                                        </span>
                                        <span>{{ $criteria['label'] }}</span>
                                    </div>
                                    <span class="text-xs text-gray-500">
                                        {{ $index === 0 ? 'Paling Penting' : ($index === 4 ? 'Prioritas Terakhir' : 'Prioritas ' . ($index + 1)) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-1/2 bg-white p-24 flex flex-col justify-between">
                <div>
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">Seret untuk Mengurutkan</h2>
                        <p class="text-sm text-gray-600">Urutkan kriteria dari yang paling prioritas (atas) hingga
                            prioritas terakhir (bawah)</p>
                    </div>

                    <!-- Sortable Criteria List -->
                    <div id="sortable-criteria" class="space-y-3">
                        @foreach ($criteria_order as $index => $criteria)
                            <div class="sortable-item bg-white border-2 border-gray-200 rounded-lg p-4 cursor-move hover:border-magnet-sky-teal hover:shadow-md transition-all duration-200"
                                data-key="{{ $criteria['key'] }}">
                                <div class="flex items-center gap-4">
                                    <!-- Drag Handle -->
                                    <div
                                        class="flex flex-col gap-0.5 text-gray-400 hover:text-magnet-sky-teal transition-colors">
                                        <div class="w-1 h-1 bg-current rounded-full"></div>
                                        <div class="w-1 h-1 bg-current rounded-full"></div>
                                        <div class="w-1 h-1 bg-current rounded-full"></div>
                                        <div class="w-1 h-1 bg-current rounded-full"></div>
                                        <div class="w-1 h-1 bg-current rounded-full"></div>
                                        <div class="w-1 h-1 bg-current rounded-full"></div>
                                    </div>

                                    <!-- Rank Badge -->
                                    <div
                                        class="w-8 h-8 bg-magnet-sky-teal text-white rounded-full flex items-center justify-center text-sm font-semibold flex-shrink-0">
                                        {{ $index + 1 }}
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900">{{ $criteria['label'] }}</h3>
                                        <p class="text-sm text-gray-600 mt-1">{{ $criteria['description'] }}</p>
                                    </div>

                                    <!-- Priority Label -->
                                    <div class="text-right">
                                        <span
                                            class="text-xs font-medium {{ $index === 0 ? 'text-green-600' : ($index === 4 ? 'text-gray-500' : 'text-blue-600') }}">
                                            {{ $index === 0 ? 'Paling Penting' : ($index === 4 ? 'prioritas terakhir' : 'Prioritas ' . ($index + 1)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-between w-full mt-8">
                    <flux:button variant="outline" icon="chevron-left" wire:click="prevStep" class="px-6 py-2">
                        Kembali
                    </flux:button>
                    <flux:button variant="primary" icon="check" wire:click="storePreferensiMahasiswa"
                        class="bg-magnet-sky-teal px-6 py-2">
                        Simpan Preferensi
                    </flux:button>
                </div>
            </div>
        </div>
    </div>

    <!-- Include SortableJS from CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>

    <!-- Initialize Sortable -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sortableEl = document.getElementById('sortable-criteria');
            if (sortableEl) {
                const sortable = Sortable.create(sortableEl, {
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    dragClass: 'sortable-drag',
                    onEnd: function(evt) {
                        // Get the new order of keys
                        const orderedKeys = Array.from(sortableEl.children).map(item =>
                            item.getAttribute('data-key')
                        );

                        // Update rank badges immediately for better UX
                        Array.from(sortableEl.children).forEach((item, index) => {
                            const badge = item.querySelector('.w-8.h-8');
                            const priorityLabel = item.querySelector('.text-right span');

                            if (badge) badge.textContent = index + 1;
                            if (priorityLabel) {
                                priorityLabel.textContent = index === 0 ? 'Paling Penting' :
                                    (index === 4 ? 'prioritas terakhir' : 'Prioritas ' + (
                                        index +
                                        1));
                                priorityLabel.className = `text-xs font-medium ${
                                    index === 0 ? 'text-green-600' :
                                    (index === 4 ? 'text-gray-500' : 'text-blue-600')
                                }`;
                            }
                        });

                        // Call Livewire method to update the backend
                        @this.call('updateCriteriaOrder', orderedKeys);
                    }
                });
            }
        });
    </script>

    <flux:modal name="response-modal" class="min-w-[24rem]">
        <div class="space-y-6">
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <flux:icon.check class="w-8 h-8 text-green-600" />
                </div>
                <flux:heading size="lg">{{ session('task') }}</flux:heading>
                <flux:text class="mt-2 text-gray-600">
                    <p>{{ session('message') }}</p>
                </flux:text>
            </div>
            <div class="flex gap-2 justify-center">
                <flux:modal.close>
                    <flux:button type="submit" variant="primary" class="bg-magnet-sky-teal px-8 py-2"
                        wire:click="redirectToDashboard">
                        Lanjut ke Dashboard
                    </flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>
</div>
