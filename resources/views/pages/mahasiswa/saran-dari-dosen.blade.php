<?php
use function Livewire\Volt\{layout, state, mount, computed};
use App\Models\UmpanBalikMagang;
use App\Models\KontrakMagang;
use App\Models\Mahasiswa;

layout('components.layouts.user.main');

state(['mahasiswa_id' => null]);

mount(function () {
    // Ambil ID mahasiswa yang sedang login dari session atau auth
    $this->mahasiswa_id = auth()->user()->mahasiswa->id ?? 1; // fallback untuk testing
});

$komentarDosen = computed(function () {
    return UmpanBalikMagang::with([
        'kontrakMagang.mahasiswa',
        'kontrakMagang.dosenPembimbing',
        'kontrakMagang.lowonganMagang.perusahaan'
    ])
    ->whereHas('kontrakMagang.mahasiswa', function($query) {
        $query->where('id', $this->mahasiswa_id);
    })
    ->orderBy('tanggal', 'desc')
    ->get();
});

?>

<div>
    <x-slot:user>mahasiswa</x-slot:user>
    
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    Komentar & Umpan Balik Dosen
                </h2>
                <p class="text-gray-600 mt-1">Lihat semua komentar dan umpan balik dari dosen pembimbing</p>
            </div>

            <div class="p-6">
                @if($this->komentarDosen->count() > 0)
                    <div class="space-y-6">
                        @foreach($this->komentarDosen as $komentar)
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 border-l-4 border-blue-500">
                                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between mb-4">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-2">
                                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold mr-3">
                                                {{ substr($komentar->kontrakMagang->dosenPembimbing->nama, 0, 1) }}
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-800">
                                                    {{ $komentar->kontrakMagang->dosenPembimbing->nama }}
                                                </h3>
                                                <p class="text-sm text-gray-600">Dosen Pembimbing</p>
                                            </div>
                                        </div>
                                        
                                        <div class="ml-13">
                                            <div class="flex items-center text-sm text-gray-600 mb-2">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h3M9 7h6m-6 4h6m-6 4h6m-6 4h6"></path>
                                                </svg>
                                                <span class="font-medium">{{ $komentar->kontrakMagang->lowonganMagang->perusahaan->nama }}</span>
                                            </div>
                                            
                                            <div class="flex items-center text-sm text-gray-600 mb-3">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V4a2 2 0 012-2h4a2 2 0 012 2v3M8 7v13a2 2 0 002 2h4a2 2 0 002-2V7M8 7H6a2 2 0 00-2 2v9a2 2 0 002 2h1M8 7h8M6 7h-.01M18 7h.01"></path>
                                                </svg>
                                                <span>{{ $komentar->kontrakMagang->lowonganMagang->nama }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center text-sm text-gray-500 mt-2 lg:mt-0">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h8M8 15h8m-8 4h8"></path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($komentar->tanggal)->format('d M Y') }}
                                    </div>
                                </div>
                                
                                <div class="bg-white rounded-lg p-4 shadow-sm">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M14,3V5H17.59L7.76,14.83L9.17,16.24L19,6.41V10H21V3M19,19H5V5H12V3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V12H19V19Z" />
                                        </svg>
                                        <p class="text-gray-700 leading-relaxed">{{ $komentar->komentar }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <h3 class="text-xl font-medium text-gray-900 mb-2">Belum Ada Komentar</h3>
                        <p class="text-gray-500 mb-6">Belum ada komentar atau umpan balik dari dosen pembimbing Anda.</p>
                        <div class="bg-blue-50 rounded-lg p-4 max-w-md mx-auto">
                            <p class="text-sm text-blue-800">
                                <strong>Tips:</strong> Komentar dari dosen akan muncul setelah Anda menjalani periode magang dan dosen memberikan umpan balik.
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        @if($this->komentarDosen->count() > 0)
            <div class="mt-6 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-6 border-l-4 border-green-500">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-green-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="text-lg font-semibold text-green-800 mb-2">Informasi Penting</h4>
                        <p class="text-green-700 text-sm leading-relaxed">
                            Komentar dan umpan balik dari dosen pembimbing sangat berharga untuk perkembangan Anda. 
                            Gunakan masukan ini untuk meningkatkan performa dan keterampilan selama periode magang.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>