<?php
use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\{layout, state, mount};

state([
    'status' => '',
    'mahasiswa' => null,
]);

layout('components.layouts.user.main');

mount(function () {
    $this->mahasiswa = Auth::guard('mahasiswa')->user();

    if ($this->mahasiswa) {
        // Set initial status based on current mahasiswa status
        $currentStatus = $this->mahasiswa->status_magang;

        switch ($currentStatus) {
            case 'tidak_magang':
            case 'tidak magang':
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
                $this->status = '';
        }
    }
});

$updateStatus = function () {
    // This method handles the form submission
    // But the actual processing will be done by child components
    if (!$this->status) {
        session()->flash('error', 'Silakan pilih status magang terlebih dahulu.');
        return;
    }
};

// Listen for events from child components
$refreshParent = function () {
    if ($this->mahasiswa) {
        $this->mahasiswa->refresh();

        // Update status display based on updated mahasiswa data
        $currentStatus = $this->mahasiswa->status_magang;

        switch ($currentStatus) {
            case 'tidak_magang':
            case 'tidak magang':
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
        }
    }
};

?>

<div>
    <x-slot:user>mahasiswa</x-slot:user>

    <div class="bg-[#DFF6F9] min-h-screen">
        <!-- Judul -->
        <h2 class="text-lg font-semibold text-black mb-1">Pembaruan status magang</h2>
        <p class="text-black mb-6">Anda perlu memperbarui status magang anda secara manual jika telah diterima atau
            selesai kontrak magang</p>

        <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
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

            @if ($mahasiswa)
                <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50">
                    <strong>Mahasiswa:</strong> {{ $mahasiswa->nama }} ({{ $mahasiswa->nim }})<br>
                    <strong>Status saat ini:</strong> {{ ucwords(str_replace('_', ' ', $mahasiswa->status_magang)) }}
                </div>
            @endif

            <div class="mb-4">
                <flux:field>
                    <flux:label>Status Magang Saat Ini</flux:label>
                    <flux:select wire:model.live="status" placeholder="Status Magang Saat Ini">
                        <flux:select.option value="Tidak Magang">Tidak Magang</flux:select.option>
                        <flux:select.option value="Sedang Magang">Sedang Magang</flux:select.option>
                        <flux:select.option value="Selesai Magang">Selesai Magang</flux:select.option>
                    </flux:select>
                </flux:field>
            </div>

            @if ($status == 'Sedang Magang')
                @livewire('mahasiswa.pembaruan-status-sedang-magang')
            @elseif($status == 'Selesai Magang')
                @livewire('mahasiswa.pembaruan-status-selesai-magang')
            @endif
        </div>
    </div>
</div>
