<x-layouts.user.main user="mahasiswa">
    <div>
        <div class="gap-3 flex flex-col">
            @for ($i = 0; $i < 21; $i++)
                <div onclick="window.location='{{ route('mahasiswa.detail-rekomendasi') }}'" role="button"
                    class="card shadow-lg hover:cursor-pointer">
                    <div class="card-body bg-white hover:bg-gray-100 transition-colors rounded-md">
                        <h2>Riwayat rekomendasi magang tanggal 12 Mei 2025</h2>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</x-layouts.user.main>
