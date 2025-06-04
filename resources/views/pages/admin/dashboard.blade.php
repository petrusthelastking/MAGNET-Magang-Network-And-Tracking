<div>
  <flux:breadcrumbs class="mb-5">
    <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
    <flux:breadcrumbs.item href="{{ route('dashboard') }}" class="text-black">Dashboard</flux:breadcrumbs.item>
  </flux:breadcrumbs>
  <div class="flex flex-col">
    {{-- atas --}}
    <div class="flex justify-between w-full gap-9">
      <div class="w-full rounded-md border border-magnet-def-grey-400 bg-white flex flex-col items-center">
        <span class="flex gap-3 p-3">
          <flux:icon.arrow-down-to-line />
          Pengajuan Magang Masuk
        </span>
        <p class="font-bold text-xl">34</p>
        <flux:button variant="primary"
          class="w-full border-t-gray-400! bg-white! rounded-b-md! text-black! font-black! rounded-t-none!">Lihat Semua
        </flux:button>
      </div>
      <div class="w-full rounded-md border border-magnet-def-grey-400 bg-white flex flex-col items-center">
        <span class="flex gap-3 p-3">
          <flux:icon.check />
          Pengajuan Magang Diterima
        </span>
        <p class="font-bold text-xl">1345</p>
        <flux:button variant="primary"
          class="w-full border-t-gray-400! bg-white! rounded-b-md! text-black! font-black! rounded-t-none!">Lihat Semua
        </flux:button>
      </div>
      <div class="w-full rounded-md border border-magnet-def-grey-400 bg-white flex flex-col items-center">
        <span class="flex gap-3 p-3">
          <flux:icon.x />
          Pengajuan Magang Ditolak
        </span>
        <p class="font-bold text-xl">278</p>
        <flux:button variant="primary"
          class="w-full border-t-gray-400! bg-white! rounded-b-md! text-black! font-black! rounded-t-none!">Lihat Semua
        </flux:button>
      </div>
    </div>
    {{-- bawah --}}

    <div class="flex justify-between w-full mt-11 gap-11 text-black">
      <div class="w-full bg-white rounded-md border border-magnet-def-grey-400 p-6">
        <div class="flex flex-col h-full">
          <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">Tren Mahasiswa Magang</h3>
          <div class="flex-1 relative" style="min-height: 300px;">
            <canvas id="magangChart" class="w-full h-full"></canvas>
          </div>
        </div>
      </div>
      <div class="w-full bg-white rounded-md border border-magnet-def-grey-400 p-6">
        <div class="flex flex-col h-full">
          <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">Bidang Industri Terpopuler </h3>
          <div class="flex items-center justify-center">
            <div class="mt-3">
              <ol class="space-y-4 text-black">
                <li class="flex justify-between items-center">
                  <div class="flex items-center space-x-3">
                    <span class="font-bold text-md">1</span>
                    <span class="font-semibold text-md">Pariwisata</span>
                  </div>
                  <span class="text-sm">451 mahasiswa magang</span>
                </li>

                <li class="flex justify-between items-center">
                  <div class="flex items-center space-x-3">
                    <span class="font-bold text-md">2</span>
                    <span class="font-semibold text-md">Makanan & minuman</span>
                  </div>
                  <span class="text-sm">367 mahasiswa magang</span>
                </li>

                <li class="flex justify-between items-center">
                  <div class="flex items-center space-x-3">
                    <span class="font-bold text-md">3</span>
                    <span class="font-semibold text-md">Konveksi</span>
                  </div>
                  <span class="text-sm">278 mahasiswa magang</span>
                </li>

                <li class="flex justify-between items-center">
                  <div class="flex items-center space-x-3">
                    <span class="font-bold text-md">4</span>
                    <span class="font-semibold text-md">Pertanian</span>
                  </div>
                  <span class="text-sm">123 mahasiswa magang</span>
                </li>

                <li class="flex justify-between items-center">
                  <div class="flex items-center space-x-3">
                    <span class="font-bold text-md">5</span>
                    <span class="font-semibold text-md">Pendidikan</span>
                  </div>
                  <span class="text-sm">56 mahasiswa magang</span>
                </li>
              </ol>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Script untuk Chart --}}
  <script>
    const ctx = document.getElementById('magangChart').getContext('2d');
    const magangChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['2019', '2020', '2021', '2022', '2023'],
        datasets: [{
          label: 'Jumlah Mahasiswa',
          data: [890, 1100, 1040, 1470, 1470],
          borderColor: 'brown',
          backgroundColor: 'transparent',
          tension: 0,
          borderWidth: 2,
          pointRadius: 4,
          pointBackgroundColor: 'brown'
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });


  </script>

</div>
