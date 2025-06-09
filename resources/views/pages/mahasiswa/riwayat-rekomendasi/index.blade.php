<?php

use function Livewire\Volt\{computed, layout};
use Illuminate\Support\Facades\DB;
use App\Models\FinalRankRecommendation;
use Carbon\Carbon;

layout('components.layouts.user.main');

$riwayat = computed(function () {
    $mahasiswaId = auth('mahasiswa')->user()->id;

    return FinalRankRecommendation::where('mahasiswa_id', $mahasiswaId)->select(DB::raw('DATE(created_at) as tanggal_rekomendasi'))->distinct()->orderBy('tanggal_rekomendasi', 'desc')->get();
});

?>

<div class="font-sans">
    <x-slot:user>mahasiswa</x-slot:user>

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Riwayat Rekomendasi Magang</h1>
        <p class="text-gray-500 mt-1">Daftar rekomendasi magang yang telah Anda dapatkan sebelumnya.</p>
    </div>

    @if ($this->riwayat->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($this->riwayat as $item)
                @php
                    $tanggal = Carbon::parse($item->tanggal_rekomendasi);
                @endphp

                <div class="flex items-start gap-4 group hover:cursor-pointer transition-all duration-300">

                    <div class="flex-shrink-0 text-center w-20 p-3 bg-slate-50 border border-slate-200 rounded-xl">
                        <p class="text-magnet-sky-teal font-bold text-lg">
                            {{ $tanggal->locale('id')->isoFormat('ddd') }}
                        </p>
                        <p class="text-2xl font-extrabold text-slate-700">
                            {{ $tanggal->format('d') }}
                        </p>
                        <p class="text-xs text-slate-500">
                            {{ $tanggal->locale('id')->isoFormat('MMM') }}
                        </p>
                    </div>

                    <div
                        class="flex-grow bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-lg hover:border-magnet-sky-teal transition-all duration-300">
                        <div class="p-5 flex flex-col justify-between h-full">
                            <div>
                                <p class="text-gray-800 font-semibold text-lg">
                                    Rekomendasi Magang
                                </p>
                                <p class="text-sm text-gray-500 mt-1">
                                    Diberikan pada {{ $tanggal->isoFormat('D MMMM YYYY') }}
                                </p>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('mahasiswa.detail-rekomendasi', ['tanggal' => $item->tanggal_rekomendasi]) }}"
                                    class="inline-flex items-center px-4 py-2 bg-magnet-sky-teal text-white text-sm font-medium rounded-lg hover:bg-teal-600 transition-all duration-300">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @else
        <div class="mt-10 p-6 bg-white border border-gray-200 rounded-xl shadow-sm text-center">
            <p class="text-gray-500 text-sm">
                Belum ada rekomendasi magang yang tersedia untuk ditampilkan.
            </p>
        </div>
    @endif
</div>
