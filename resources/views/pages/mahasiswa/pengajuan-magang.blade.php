<x-layouts.mahasiswa.mahasiswa>
    <div class="card bg-white shadow-md p-5">
        @php
            // Pastikan statusMagang selalu memiliki nilai, jika tidak ada, gunakan default
            $statusMagang = $statusMagang ?? 'Tidak magang';

            $pesan = '';
            $warnaBadge = '';
            $labelBadge = '';
            $tombol = '';

            switch ($statusMagang) {
                case 'Tidak magang':
                    $pesan = 'Anda belum pernah mengajukan magang. Silakan ajukan terlebih dahulu ke admin.';
                    $warnaBadge = 'orange';
                    $labelBadge = 'Belum mengajukan';
                    $tombol =
                        '<a href="' .
                        route('mahasiswa.form-pengajuan-magang') .
                        '" class="flux-button bg-magnet-sky-teal text-white px-4 py-2 rounded-lg">Ajukan Pengajuan Magang</a>';
                    break;

                case 'Sedang magang':
                    $pesan = 'Pengajuan magang Anda telah diproses. Anda sedang dalam masa magang.';
                    $warnaBadge = 'blue';
                    $labelBadge = 'Sedang magang';
                    $tombol = ''; // tidak ada tombol
                    break;

                case 'Selesai magang':
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
        </div>

        @if (!empty($tombol))
            <div class="card-actions flex mt-4">
                {!! $tombol !!}
            </div>
        @endif
    </div>
</x-layouts.mahasiswa.mahasiswa>
