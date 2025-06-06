<?php
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\KontrakMagang;
use App\Models\Magang;
use App\Models\Perusahaan;
use function Livewire\Volt\{layout, state, mount};

layout('components.layouts.user.main');

state([
    'status' => '',
    'mahasiswa' => null,
    'perusahaan' => null,
    'magang' => null,
    'kontrak_magang' => null,
]);

mount(function () {
    $this->mahasiswa = Auth::guard('mahasiswa')->user();

    if ($this->mahasiswa) {
        // Get the latest kontrak magang for the mahasiswa
        $this->kontrak_magang = KontrakMagang::where('mahasiswa_id', $this->mahasiswa->id)
            ->with(['magang.perusahaan', 'magang'])
            ->latest()
            ->first();

        // Set status based on current mahasiswa status
        $status = $this->mahasiswa->status_magang;

        switch ($status) {
            case 'sedang magang':
                $this->status = 'Sedang Magang';
                if ($this->kontrak_magang) {
                    $this->perusahaan = $this->kontrak_magang->magang->perusahaan;
                    $this->magang = $this->kontrak_magang->magang;
                }
                break;

            case 'selesai magang':
                $this->status = 'Selesai Magang';
                if ($this->kontrak_magang) {
                    $this->perusahaan = $this->kontrak_magang->magang->perusahaan;
                    $this->magang = $this->kontrak_magang->magang;
                }
                break;

            case 'belum magang':
            default:
                $this->status = 'Belum Magang';
                $this->perusahaan = null;
                $this->magang = null;
        }
    }
});
?>

<x-slot:user>mahasiswa</x-slot:user>
<div class="w-full flex-shrink-0 rounded-[15px] p-4 flex flex-col overflow-y-auto">
    @if ($this->perusahaan && $this->magang)
        <div class="card shadow-md bg-white text-accent-content w-full mb-4">
            <button onclick="window.location='{{ route('mahasiswa.detail-log') }}'">
                <div class="card-body">
                    <div class="flex align-middle items-center">
                        <img src="{{ asset('logo-perusahaan.png') }}" alt="Logo {{ $this->perusahaan->nama }}"
                            class="w-10 h-10 object-contain">
                        <p class="h-fit px-3">{{ $this->perusahaan->nama }}</p>
                        <span class="badge badge-primary ml-auto">{{ $this->status }}</span>
                    </div>
                    <div class="font-bold text-lg">
                        <p>{{ $this->magang->nama }}</p>
                    </div>
                    <p>{{ $this->magang->lokasi }}</p>
                    @if ($this->kontrak_magang)
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Mulai:
                                {{ \Carbon\Carbon::parse($this->kontrak_magang->waktu_awal)->format('d M Y') }}</span>
                            <span>Selesai:
                                {{ \Carbon\Carbon::parse($this->kontrak_magang->waktu_akhir)->format('d M Y') }}</span>
                        </div>
                    @endif
                </div>
            </button>
        </div>
    @else
        <div class="card shadow-md bg-white text-accent-content w-full mb-4">
            <div class="card-body text-center">
                <div class="font-bold text-lg mb-2">
                    <p>Status: {{ $this->status }}</p>
                </div>
                @if ($this->status === 'Belum Magang')
                    <p class="text-gray-600">Anda belum memiliki magang aktif</p>
                    <button class="btn btn-primary mt-4" onclick="window.location='{{ route('mahasiswa.search') }}'">
                        Cari Magang
                    </button>
                @else
                    <p class="text-gray-600">Data magang tidak ditemukan</p>
                @endif
            </div>
        </div>
    @endif
</div>
