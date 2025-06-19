<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\KontrakMagang;
use function Livewire\Volt\{layout, state, mount, computed};

state([
    'search' => '',
]);

layout('components.layouts.user.main');

mount(function () {
    // Pastikan user adalah dosen
    if (!Auth::guard('dosen')->check()) {
        abort(403, 'Unauthorized access');
    }
});

$mahasiswaBimbingan = computed(function () {
    $dosenId = Auth::guard('dosen')->id();

    $query = Mahasiswa::with(['kontrakMagang.lowonganMagang.perusahaan'])
        ->whereHas('kontrakMagang', function ($query) use ($dosenId) {
            $query->where('dosen_id', $dosenId);
        })
        ->orderBy('nama');

    // Apply search filter
    if ($this->search) {
        $query->where(function ($q) {
            $q->where('nama', 'like', '%' . $this->search . '%')
                ->orWhere('nim', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
        });
    }

    return $query->get()->map(function ($mahasiswa) {
        $kontrak = $mahasiswa->kontrakMagang->first();

        return [
            'id' => $mahasiswa->id,
            'nama' => $mahasiswa->nama,
            'nim' => $mahasiswa->nim,
            'email' => $mahasiswa->email,
            'status_magang' => $mahasiswa->status_magang,
            'perusahaan_nama' => $kontrak->lowonganMagang->perusahaan->nama ?? 'Tidak ada',
            'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($mahasiswa->nama) . '&background=random',
        ];
    });
});

$updateSearch = function () {
    // This will automatically trigger the computed property to recalculate
};

?>

<div>
    <x-slot:user>dosen</x-slot:user>

    <flux:breadcrumbs class="mb-5">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('dosen.komunikasi') }}" class="text-black">Komunikasi
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Search Section -->
    <div class="mb-6">
        <div class="bg-white rounded-lg shadow-sm p-4">
            <flux:input wire:model.live.debounce.300ms="search"
                placeholder="Cari mahasiswa berdasarkan nama, NIM, atau email..." icon="magnifying-glass"
                class="w-full" />
        </div>
    </div>

    <!-- Results Info -->
    @if ($search)
        <div class="mb-4">
            <div class="alert alert-info">
                <flux:icon name="information-circle" class="w-5 h-5" />
                <span>
                    Hasil pencarian untuk: "<strong>{{ $search }}</strong>"
                    ({{ $this->mahasiswaBimbingan->count() }} data ditemukan)
                </span>
            </div>
        </div>
    @endif

    <!-- Student List -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-4 pb-2 text-xs opacity-60 tracking-wide border-b">
            Komunikasi dengan Mahasiswa Bimbingan
        </div>

        @if ($this->mahasiswaBimbingan->count() > 0)
            @foreach ($this->mahasiswaBimbingan as $mahasiswa)
                <div
                    class="flex items-center justify-between p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center gap-4 flex-1">
                        <div class="avatar">
                            <div class="w-10 h-10 rounded-lg">
                                <img src="{{ $mahasiswa['avatar'] }}" alt="{{ $mahasiswa['nama'] }}" />
                            </div>
                        </div>

                        <div class="flex-1">
                            <div class="font-medium text-gray-900">{{ $mahasiswa['nama'] }}</div>
                            <div class="text-xs uppercase font-semibold opacity-60">{{ $mahasiswa['nim'] }}</div>
                            <div class="text-xs text-gray-500 mt-1">
                                <flux:icon name="building-office" class="w-3 h-3 inline mr-1" />
                                {{ $mahasiswa['perusahaan_nama'] }}
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <flux:button icon="message-square-text" variant="filled" size="sm"
                            href="{{ route('dosen.komunikasi-mahasiswa', ['id' => $mahasiswa['id']]) }}">
                            <span class="hidden sm:inline">Chat</span>
                        </flux:button>
                    </div>
                </div>
            @endforeach
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <flux:icon name="user-group" class="w-12 h-12 text-gray-400" />
                </div>

                @if ($search)
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada hasil yang ditemukan</h3>
                    <p class="text-gray-500 mb-4">
                        Tidak ada mahasiswa yang cocok dengan pencarian "{{ $search }}"
                    </p>
                    <flux:button wire:click="$set('search', '')" variant="ghost">
                        Hapus Filter
                    </flux:button>
                @else
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada mahasiswa bimbingan</h3>
                    <p class="text-gray-500">
                        Anda belum memiliki mahasiswa bimbingan yang sedang atau telah menyelesaikan magang.
                    </p>
                @endif
            </div>
        @endif
    </div>

    <!-- Summary Info -->
    <div class="mt-6 bg-white rounded-lg shadow-sm p-4">
        <div class="flex items-center justify-between text-sm text-gray-600">
            <span>Total mahasiswa bimbingan: {{ $this->mahasiswaBimbingan->count() }}</span>
            @if ($search)
                <flux:button wire:click="$set('search', '')" variant="ghost" size="sm" icon="x-mark">
                    Reset Pencarian
                </flux:button>
            @endif
        </div>
    </div>
</div>
