<?php
use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\{layout, state, mount};

state([
    'status' => '',
    'mahasiswa' => null,
    'isStatusLocked' => false,
]);

layout('components.layouts.user.main');

mount(function () {
    $this->mahasiswa = Auth::guard('mahasiswa')->user();

    if ($this->mahasiswa) {
        // Set initial status based on current mahasiswa status
        $currentStatus = $this->mahasiswa->status_magang;

        switch ($currentStatus) {
            case 'belum_magang':
            case 'belum magang':
                $this->status = 'Belum Magang';
                $this->isStatusLocked = false;
                break;
            case 'sedang_magang':
            case 'sedang magang':
                $this->status = 'Sedang Magang';
                $this->isStatusLocked = false;
                break;
            case 'selesai':
            case 'selesai_magang':
            case 'selesai magang':
                $this->status = 'Selesai Magang';
                $this->isStatusLocked = true; // Lock the dropdown for completed internships
                break;
            default:
                $this->status = '';
                $this->isStatusLocked = false;
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
            case 'belum_magang':
            case 'belum magang':
                $this->status = 'Belum Magang';
                $this->isStatusLocked = false;
                break;
            case 'sedang_magang':
            case 'sedang magang':
                $this->status = 'Sedang Magang';
                $this->isStatusLocked = false;
                break;
            case 'selesai':
            case 'selesai_magang':
            case 'selesai magang':
                $this->status = 'Selesai Magang';
                $this->isStatusLocked = true;
                break;
        }
    }
};

?>

<div>
    <x-slot:user>mahasiswa</x-slot:user>

    <div class="bg-magnet-frost-mist min-h-screen flex flex-col gap-5">
        <h2 class="text-lg font-semibold text-black">Pembaruan status magang</h2>
        <p class="text-black">Anda perlu memperbarui status magang anda secara manual jika telah diterima atau
            selesai kontrak magang</p>

        <div class="w-full bg-white p-6 rounded-lg shadow-md">
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

            <div>
                <flux:field>
                    <flux:label>Status Magang Saat Ini</flux:label>
                    @if ($isStatusLocked)
                        <flux:select wire:model.live="status" placeholder="Status Magang Saat Ini" disabled>
                            <flux:select.option value="Belum Magang">Belum Magang</flux:select.option>
                            <flux:select.option value="Sedang Magang">Sedang Magang</flux:select.option>
                            <flux:select.option value="Selesai Magang">Selesai Magang</flux:select.option>
                        </flux:select>
                    @else
                        <flux:select wire:model.live="status" placeholder="Status Magang Saat Ini">
                            <flux:select.option value="Belum Magang">Belum Magang</flux:select.option>
                            <flux:select.option value="Sedang Magang">Sedang Magang</flux:select.option>
                            <flux:select.option value="Selesai Magang">Selesai Magang</flux:select.option>
                        </flux:select>
                    @endif

                    @if ($isStatusLocked)
                        <flux:description class="text-gray-500">
                            Status tidak dapat diubah karena magang telah selesai.
                        </flux:description>
                    @endif
                    <flux:error name="status" />
                </flux:field>
            </div>

            @if ($status == 'Sedang Magang')
                <livewire:components.mahasiswa.pembaruan-status-magang.sedang-magang />
            @else
                <livewire:components.mahasiswa.pembaruan-status-magang.selesai-magang />
            @endif
        </div>
    </div>
</div>
