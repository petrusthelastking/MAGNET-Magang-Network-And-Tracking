<?php

use function Livewire\Volt\{state};

state([
        'criteria_order' => [
        [
            'key' => 'pekerjaan',
            'label' => 'Kesesuaian Pekerjaan',
            'description' => 'Seberapa sesuai posisi/pekerjaan dengan minat Anda'
        ],
        [
            'key' => 'bidang_industri',
            'label' => 'Kesesuaian Bidang Industri',
            'description' => 'Seberapa cocok bidang industri dengan preferensi Anda'
        ],
        [
            'key' => 'lokasi_magang',
            'label' => 'Kesesuaian Lokasi Magang',
            'description' => 'Seberapa strategis lokasi magang untuk Anda'
        ],
        [
            'key' => 'jenis_magang',
            'label' => 'Jenis Magang (Berbayar/Tidak)',
            'description' => 'Apakah magang berbayar penting untuk Anda'
        ],
        [
            'key' => 'open_remote',
            'label' => 'Ketersediaan Remote',
            'description' => 'Seberapa penting fleksibilitas kerja remote'
        ]
    ],

    'pekerjaan_rank' => 1,
    'bidang_industri_rank' => 2,
    'lokasi_magang_rank' => 3,
    'jenis_magang_rank' => 4,
    'open_remote_rank' => 5,
]);


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

$prevStep = function () {
    $this->dispatch('update-step', [
        'step' => 1
    ]);
};

$nextStep = function () {
    $this->dispatch('update-step', [
        'step' => 3,

        'pekerjaan_rank' => $this->pekerjaan_rank,
        'bidang_industri_rank' => $this->bidang_industri_rank,
        'lokasi_magang_rank' => $this->lokasi_magang_rank,
        'jenis_magang_rank' => $this->jenis_magang_rank,
        'open_remote_rank' => $this->open_remote_rank,
    ]);
};

?>

<div class="flex min-h-screen">
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
            <flux:button variant="primary" icon="check" wire:click="nextStep"
                class="bg-magnet-sky-teal px-6 py-2">
                Simpan Preferensi
            </flux:button>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>

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
</div>
