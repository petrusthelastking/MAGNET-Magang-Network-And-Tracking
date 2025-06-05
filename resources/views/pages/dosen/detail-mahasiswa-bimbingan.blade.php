<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\KontrakMagang;
use App\Models\LogMagang;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use function Livewire\Volt\{layout, state, mount, computed};

state(['mahasiswaId', 'perPage' => 10, 'currentPage' => 1]);

layout('components.layouts.user.main');

mount(function ($id) {
    // Pastikan user adalah dosen
    if (!Auth::guard('dosen')->check()) {
        abort(403, 'Unauthorized access');
    }

    $this->mahasiswaId = $id;
});

// Get mahasiswa detail with kontrak magang
$mahasiswaDetail = computed(function () {
    $dosenId = Auth::guard('dosen')->id();

    $data = DB::table('mahasiswa as m')->join('kontrak_magang as km', 'm.id', '=', 'km.mahasiswa_id')->join('lowongan_magang as lm', 'km.lowongan_magang_id', '=', 'lm.id')->join('perusahaan as p', 'lm.perusahaan_id', '=', 'p.id')->join('pekerjaan as pk', 'lm.pekerjaan_id', '=', 'pk.id')->where('m.id', $this->mahasiswaId)->where('km.dosen_id', $dosenId)->select('m.id', 'm.nama', 'm.nim', 'm.program_studi', 'p.nama as perusahaan', 'pk.nama as posisi', 'km.waktu_awal', 'km.waktu_akhir', 'km.id as kontrak_id')->first();

    if (!$data) {
        abort(404, 'Kontrak magang tidak ditemukan');
    }

    // Calculate duration and remaining days
    $startDate = Carbon::parse($data->waktu_awal);
    $endDate = Carbon::parse($data->waktu_akhir);
    $today = Carbon::today();

    $totalDuration = $startDate->diffInDays($endDate);
    $remainingDays = $today->diffInDays($endDate, false); // false allows negative values

    return [
        'id' => $data->id,
        'nama' => $data->nama,
        'nim' => $data->nim,
        'program_studi' => $data->program_studi ?? '-',
        'perusahaan' => $data->perusahaan ?? '-',
        'posisi' => $data->posisi ?? '-',
        'waktu_awal' => $startDate->format('j F Y'),
        'waktu_akhir' => $endDate->format('j F Y'),
        'durasi' => "{$totalDuration} hari",
        'sisa_waktu' => $remainingDays > 0 ? "{$remainingDays} hari" : 'Sudah selesai',
        'kontrak_id' => $data->kontrak_id,
    ];
});

// Get log mahasiswa with pagination
$logMahasiswa = computed(function () {
    $mahasiswa = $this->mahasiswaDetail;

    return LogMagang::where('kontrak_magang_id', $mahasiswa['kontrak_id'])
        ->orderBy('created_at', 'desc')
        ->paginate($this->perPage, ['*'], 'page', $this->currentPage);
});

// Get total log count
$totalLogCount = computed(function () {
    $mahasiswa = $this->mahasiswaDetail;

    return LogMagang::where('kontrak_magang_id', $mahasiswa['kontrak_id'])->count();
});

// Pagination methods
$nextPage = function () {
    $totalPages = ceil($this->totalLogCount / $this->perPage);
    if ($this->currentPage < $totalPages) {
        $this->currentPage++;
    }
};

$prevPage = function () {
    if ($this->currentPage > 1) {
        $this->currentPage--;
    }
};

$goToPage = function ($page) {
    $totalPages = ceil($this->totalLogCount / $this->perPage);
    if ($page >= 1 && $page <= $totalPages) {
        $this->currentPage = $page;
    }
};

$changePerPage = function ($newPerPage) {
    $this->perPage = (int) $newPerPage;
    $this->currentPage = 1; // Reset to first page
};

// Get pagination info
$paginationInfo = computed(function () {
    $total = $this->totalLogCount;
    $perPage = $this->perPage;
    $currentPage = $this->currentPage;

    $totalPages = ceil($total / $perPage);
    $startItem = ($currentPage - 1) * $perPage + 1;
    $endItem = min($currentPage * $perPage, $total);

    return [
        'total' => $total,
        'start' => $total > 0 ? $startItem : 0, // PERBAIKAN: Hindari start = 1 ketika total = 0
        'end' => $endItem,
        'current_page' => $currentPage,
        'total_pages' => $totalPages,
        'per_page' => $perPage,
    ];
});

?>

<div>
    <x-slot:user>dosen</x-slot:user>

    <flux:breadcrumbs class="mb-5">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('dosen.mahasiswa-bimbingan') }}" class="text-black">
            Mahasiswa Bimbingan
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item class="text-black">Detail Mahasiswa Bimbingan</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <h1 class="text-base font-bold leading-6 text-black">Informasi Mahasiswa Magang</h1>

    <div class="min-h-screen p-6">
        <div class="px-4 font-sans text-black">
            <div class="flex gap-8 items-start">
                <div class="flex flex-col items-center bg-white p-4 rounded-xl shadow-md">
                    <img src="{{ asset('dosen.png') }}" alt="Foto Mahasiswa"
                        class="w-40 h-52 object-cover rounded-md mb-4" />
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md w-full">
                    <flux:field class="flex! my-2">
                        <flux:label class="w-1/12">Nama</flux:label>
                        <flux:input value="{{ $this->mahasiswaDetail['nama'] }}" readonly />
                    </flux:field>
                    <flux:field class="flex! my-2">
                        <flux:label class="w-1/12">NIM</flux:label>
                        <flux:input value="{{ $this->mahasiswaDetail['nim'] }}" readonly />
                    </flux:field>
                    <flux:field class="flex! my-2">
                        <flux:label class="w-1/12">Program Studi</flux:label>
                        <flux:input value="{{ $this->mahasiswaDetail['program_studi'] }}" readonly />
                    </flux:field>
                    <flux:field class="flex! my-2">
                        <flux:label class="w-1/12">Perusahaan yang dituju</flux:label>
                        <flux:input value="{{ $this->mahasiswaDetail['perusahaan'] }}" readonly />
                    </flux:field>
                    <flux:field class="flex! my-2">
                        <flux:label class="w-1/12">Posisi</flux:label>
                        <flux:input value="{{ $this->mahasiswaDetail['posisi'] }}" readonly />
                    </flux:field>
                    <flux:field class="flex! my-2">
                        <flux:label class="w-1/12">Mulai Magang</flux:label>
                        <flux:input value="{{ $this->mahasiswaDetail['waktu_awal'] }}" readonly />
                    </flux:field>
                    <flux:field class="flex! my-2">
                        <flux:label class="w-1/12">Akhir Magang</flux:label>
                        <flux:input value="{{ $this->mahasiswaDetail['waktu_akhir'] }}" readonly />
                    </flux:field>
                    <flux:field class="flex! my-2">
                        <flux:label class="w-1/12">Durasi</flux:label>
                        <flux:input value="{{ $this->mahasiswaDetail['durasi'] }}" readonly />
                    </flux:field>
                    <flux:field class="flex! my-2">
                        <flux:label class="w-1/12">Sisa Waktu</flux:label>
                        <flux:input value="{{ $this->mahasiswaDetail['sisa_waktu'] }}" readonly />
                    </flux:field>
                </div>
            </div>
        </div>

        <flux:button class="bg-magnet-sky-teal! text-white! my-5"
            href="{{ route('dosen.komunikasi-mahasiswa', ['id' => $this->mahasiswaDetail['id']]) }}">
            Berikan Masukan kepada Mahasiswa
        </flux:button>

        <div>
            <h1 class="text-base font-bold leading-6 text-black my-4">Log Mahasiswa</h1>
        </div>

        <div class="overflow-y-auto flex flex-col items-center mt-4 rounded-lg shadow bg-white">
            <table class="table-auto w-full">
                <thead class="bg-white text-black">
                    <tr class="border-b">
                        <th class="text-center px-6 py-3">No</th>
                        <th class="text-left px-6 py-3">Aktivitas</th>
                        <th class="text-left px-6 py-3">Tanggal</th>
                        <th class="text-left px-6 py-3">Waktu</th>
                        <th class="text-center px-6 py-3">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="bg-white text-black">
                    @forelse ($this->logMahasiswa as $index => $log)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3 text-center">
                                {{ ($this->paginationInfo['current_page'] - 1) * $this->paginationInfo['per_page'] + $index + 1 }}
                            </td>
                            <td class="px-6 py-3">{{ $log->aktivitas ?? '-' }}</td>
                            <td class="px-6 py-3">{{ $log->created_at->format('j M Y') }}</td>
                            <td class="px-6 py-3">{{ $log->created_at->format('H.i') }} WIB</td>
                            <td class="px-6 py-3">{{ $log->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-3 text-center text-gray-500">
                                Belum ada log aktivitas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between w-full p-3">
            <div class="flex items-center justify-between w-full p-3">
                <div class="text-black mt-6">
                    <p>Menampilkan {{ $this->paginationInfo['start'] }} - {{ $this->paginationInfo['end'] }} dari
                        {{ $this->paginationInfo['total'] }} data</p>
                </div>

                <div class="flex mt-6" id="pagination-controls">
                    <button
                        class="px-3 py-2 text-sm bg-gray-200 text-gray-700 rounded hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed"
                        onclick="goToPrevPage()" {{ $this->paginationInfo['current_page'] <= 1 ? 'disabled' : '' }}>
                        ←
                    </button>

                    @for ($i = 1; $i <= min(5, $this->paginationInfo['total_pages']); $i++)
                        <button
                            class="px-3 py-2 text-sm rounded {{ $this->paginationInfo['current_page'] == $i ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}"
                            onclick="goToPage({{ $i }})">
                            {{ $i }}
                        </button>
                    @endfor

                    <button
                        class="px-3 py-2 text-sm bg-gray-200 text-gray-700 rounded hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed"
                        onclick="goToNextPage()"
                        {{ $this->paginationInfo['current_page'] >= $this->paginationInfo['total_pages'] ? 'disabled' : '' }}>
                        →
                    </button>
                </div>

                <div class="flex gap-3 items-center text-black mt-6">
                    <p>Baris per halaman</p>
                    <select onchange="changePerPage(this.value)" class="w-20 px-2 py-1 border rounded">
                        <option value="10" {{ $this->perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ $this->perPage == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ $this->perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $this->perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
            </div>

            <script>
                function goToPage(page) {
                    @this.call('goToPage', page);
                }

                function goToPrevPage() {
                    @this.call('prevPage');
                }

                function goToNextPage() {
                    @this.call('nextPage');
                }

                function changePerPage(perPage) {
                    @this.call('changePerPage', perPage);
                }
            </script>
