<x-layouts.mahasiswa.mahasiswa>
    <div class="card bg-white shadow-md p-5">
        @php
            $statusMagang = $statusMagang ?? 'belum magang';

            $pesan = '';
            $warnaBadge = '';
            $labelBadge = '';
            $tombol = '';

            switch ($statusMagang) {
                case 'belum magang':
                case null:
                case '':
                    $pesan = 'Anda belum pernah mengajukan magang. Silakan ajukan terlebih dahulu ke admin.';
                    $warnaBadge = 'orange';
                    $labelBadge = 'Belum magang';

                    // Cek apakah ada pengajuan dan statusnya
                    if (!$formPengajuan || $formPengajuan->status === 'ditolak') {
                        // Tampilkan tombol jika belum ada pengajuan atau pengajuan ditolak
                        $tombol =
                            '<a href="' .
                            route('mahasiswa.form-pengajuan-magang') .
                            '" class="flux-button bg-magnet-sky-teal text-white px-4 py-2 rounded-lg">Ajukan Pengajuan Magang</a>';
                    } else {
                        // Jika ada pengajuan dengan status menunggu atau disetujui, tidak ada tombol
                        $tombol = '';
                    }
                    break;

                case 'sedang magang':
                    $pesan = 'Pengajuan magang Anda telah diproses. Anda sedang dalam masa magang.';
                    $warnaBadge = 'blue';
                    $labelBadge = 'Sedang magang';
                    $tombol = ''; // tidak ada tombol
                    break;

                case 'selesai magang':
                    $pesan = 'Anda telah menyelesaikan magang. Terima kasih atas partisipasinya.';
                    $warnaBadge = 'green';
                    $labelBadge = 'Selesai magang';
                    $tombol = ''; // tidak ada tombol
                    break;

                default:
                    $pesan = 'Status magang tidak diketahui.';
                    $warnaBadge = 'red';
                    $labelBadge = 'Tidak Diketahui';
                    $tombol = '';
                    break;
            }
        @endphp

        <p class="text-black text-base font-normal p-2!">{{ $pesan }}</p>

        <div class="card-body text-black text-base font-medium">
            <div class="flex">
                <p class="w-60">Status magang saat ini:</p>
                <flux:badge variant="solid" color="{{ $warnaBadge }}">{{ $labelBadge }}</flux:badge>
            </div>

            {{-- Tambahan elemen untuk menampilkan status pengajuan --}}
            @if ($formPengajuan)
                @php
                    $statusPengajuan = $formPengajuan->status;
                    $warnaPengajuan = '';
                    $labelPengajuan = '';

                    switch ($statusPengajuan) {
                        case 'menunggu':
                            $warnaPengajuan = 'yellow';
                            $labelPengajuan = 'Menunggu Review';
                            break;
                        case 'disetujui':
                            $warnaPengajuan = 'green';
                            $labelPengajuan = 'Disetujui';
                            break;
                        case 'ditolak':
                            $warnaPengajuan = 'red';
                            $labelPengajuan = 'Ditolak';
                            break;
                        default:
                            $warnaPengajuan = 'gray';
                            $labelPengajuan = 'Status Tidak Diketahui';
                            break;
                    }
                @endphp

                <div class="flex mt-3">
                    <p class="w-60">Status pengajuan:</p>
                    <flux:badge variant="solid" color="{{ $warnaPengajuan }}">{{ $labelPengajuan }}</flux:badge>
                </div>

                <div class="flex mt-2">
                    <p class="w-60">Tanggal pengajuan:</p>
                    <p class="text-gray-600">
                        {{ $formPengajuan->created_at ? \Carbon\Carbon::parse($formPengajuan->created_at)->format('d F Y H:i') : '-' }}
                    </p>
                </div>

                @if ($formPengajuan->keterangan)
                    <div class="flex mt-2">
                        <p class="w-60">Keterangan:</p>
                        <p class="text-gray-600">{{ $formPengajuan->keterangan }}</p>
                    </div>
                @endif
            @endif
        </div>

        {{-- Tampilkan tombol hanya jika tidak kosong --}}
        @if (!empty($tombol))
            <div class="card-actions flex mt-4">
                {!! $tombol !!}
            </div>
        @endif
    </div>
</x-layouts.mahasiswa.mahasiswa>
