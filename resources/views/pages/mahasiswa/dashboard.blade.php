<?php

use function Livewire\Volt\{state, mount};
use App\Models\FinalRankRecommendation;

state(['ranking_results', 'recommendations']);

mount(function () {
    $this->recommendations = FinalRankRecommendation::with(['lowonganMagang.perusahaan', 'lowonganMagang.pekerjaan'])
        ->where('mahasiswa_id', auth('mahasiswa')->user()->id)
        ->orderBy('rank', 'asc')
        ->limit(20)
        ->get()
        ->toArray();
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
                @foreach ($recommendations as $item)
                    <div onclick="window.location='{{ route('mahasiswa.detail-perusahaan') }}'" role="button"
                        class="card shadow-lg hover:cursor-pointer">
                        <div class="card-body bg-white hover:bg-gray-100 transition-colors rounded-md">
                            <div class="flex align-middle items-center gap-4">
                                <img src="{{ asset('img/company/company-kimia-farma.png') }}" alt="Logo Perusahaan"
                                    class="w-10 h-10 object-contain">
                                <p>{{ $item['lowongan_magang']['perusahaan']['nama'] }}</p>
                            </div>
                            <div>
                                <p class="font-bold text-base">{{ $item['lowongan_magang']['pekerjaan']['nama'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
