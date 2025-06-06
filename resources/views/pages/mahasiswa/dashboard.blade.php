<?php

use function Livewire\Volt\{state, mount};
use App\Models\LowonganMagang;

state([
    'ranking_results',
    'recommendations'
]);

mount(function () {
    $recommendationInternshipsPath = 'preferensi_magang/' . auth('mahasiswa')->user()->id .'/final_ranks_alternatives.json';

    if (Storage::exists($recommendationInternshipsPath)) {
        $recommendationInternships = Storage::read($recommendationInternshipsPath);
        $this->recommendations = json_decode($recommendationInternships, true);
    }
});

?>

<div>
    <div class="flex flex-col gap-8">
        <h2 class="font-semibold leading-6 text-black w-full flex-shrink-0">
            Pemberitahuan Terbaru
        </h2>
        <div class="w-full h-40 flex-shrink-0 rounded-lg bg-white s p-4 flex flex-col justify-between shadow-lg">
            <p class="text-black text-base font-medium">
                Isi pemberitahuan terbaru
            </p>
        </div>

        <div class="w-full flex justify-center">
            <form action="{{ route('mahasiswa.hasil-pencarian') }}" method="GET" class="flex w-full justify-center">
                <flux:input type="submit" icon="magnifying-glass" name="query" class="w-1/3!"
                    placeholder="Cari Tempat Magang Yang Anda Inginkan" />
            </form>
        </div>

        <h2 class="font-extrabold leading-6 text-black w-full">Rekomendasi Tempat Magang</h2>

        <div class="grid grid-cols-1 gap-3">
            @if ($recommendations && count($recommendations) > 0)
                @for ($i=0; $i < count($recommendations); $i++)
                    <div onclick="window.location='{{ route('mahasiswa.detail-perusahaan') }}'" role="button"
                        class="card shadow-lg hover:cursor-pointer">
                        <div class="card-body bg-white hover:bg-gray-100 transition-colors rounded-md">
                            <div class="flex align-middle items-center gap-4">
                                <img src="{{ asset('img/company/company-kimia-farma.png') }}" alt="Logo Perusahaan"
                                    class="w-10 h-10 object-contain">
                                <p>Lowongan #{{ $recommendation['lowongan_id'] ?? 'N/A' }}</p>
                                <span class="ml-auto text-xs bg-green-100 px-2 py-1 rounded">
                                    Score: {{ $recommendation['total_score'] ?? 'N/A' }}
                                </span>
                            </div>
                            <div>
                                <p class="font-bold text-base">Recommended Position</p>
                                <p class="text-sm text-gray-600">Based on your preferences</p>
                                <p class="text-xs text-gray-500">Rank: {{ $i + 1 }}</p>
                            </div>
                        </div>
                    </div>
                @endfor
            @endif
        </div>
    </div>
</div>
