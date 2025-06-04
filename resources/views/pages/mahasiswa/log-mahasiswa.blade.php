<?php
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\KontrakMagang;
use App\Models\Magang;
use App\Models\Perusahaan;
use function Livewire\Volt\{layout, state, mount};

state([
    'status' => '',
    'mahasiswa' => null,
    'perusahaan' => null,
    'magang' => null,
    'kontrak_magang' => null,
    'debug_info' => [], // untuk debugging
]);

layout('components.layouts.user.main');

mount(function () {
    $this->mahasiswa = Auth::guard('mahasiswa')->user();

    // Debug: Log mahasiswa data
    $this->debug_info['mahasiswa_id'] = $this->mahasiswa->id ?? 'null';
    $this->debug_info['mahasiswa_status'] = $this->mahasiswa->status_magang ?? 'null';

    if ($this->mahasiswa) {
        // Query kontrak magang dengan relasi
        $this->kontrak_magang = KontrakMagang::where('mahasiswa_id', $this->mahasiswa->id)
            ->with(['magang.perusahaan', 'magang'])
            ->latest()
            ->first();

        // Debug: Log kontrak magang
        $this->debug_info['kontrak_magang_exists'] = $this->kontrak_magang ? 'yes' : 'no';

        if ($this->kontrak_magang) {
            $this->debug_info['kontrak_magang_id'] = $this->kontrak_magang->id;
            $this->debug_info['magang_id'] = $this->kontrak_magang->magang_id ?? 'null';

            // Set magang dan perusahaan
            $this->magang = $this->kontrak_magang->magang;
            $this->perusahaan = $this->kontrak_magang->magang->perusahaan ?? null;

            // Debug: Log magang dan perusahaan
            $this->debug_info['magang_nama'] = $this->magang->nama ?? 'null';
            $this->debug_info['perusahaan_nama'] = $this->perusahaan->nama ?? 'null';
        }

        // Set initial status based on current mahasiswa status
        $status = $this->mahasiswa->status_magang;

        switch ($status) {
            case 'tidak_magang':
            case 'tidak magang':
            case 'belum magang':
                $this->status = 'Tidak Magang';
                break;
            case 'sedang_magang':
            case 'sedang magang':
                $this->status = 'Sedang Magang';
                break;
            case 'selesai':
            case 'selesai_magang':
            case 'selesai magang':
                $this->status = 'Selesai Magang';
                break;
            default:
                $this->status = 'Status Tidak Dikenali';
                $this->debug_info['unknown_status'] = $status;
        }

        // Debug: Final status
        $this->debug_info['final_status'] = $this->status;
    }
});
?>

<div>
    <x-slot:user>mahasiswa</x-slot:user>

    @if ($status === 'Tidak Magang')
        <x-mahasiswa.log-magang.belum-magang />
    @elseif ($status === 'Sedang Magang')
        <x-mahasiswa.log-magang.sedang-magang :perusahaan="$this->perusahaan" :magang="$this->magang" :kontrak-magang="$this->kontrak_magang" />
    @elseif ($status === 'Selesai Magang')
        <x-mahasiswa.log-magang.selesai-magang :perusahaan="$this->perusahaan" :magang="$this->magang" :kontrak-magang="$this->kontrak_magang" />
    @else
        <div class="bg-white shadow-md p-5 rounded-lg mx-auto max-w-2xl">
            <p class="text-gray-700">Status magang Anda tidak dikenali.</p>
            <p class="text-gray-500">Status saat ini: {{ $status }}</p>
            <p class="text-gray-500">Silakan hubungi admin untuk informasi lebih lanjut.</p>
        </div>
    @endif
</div>
