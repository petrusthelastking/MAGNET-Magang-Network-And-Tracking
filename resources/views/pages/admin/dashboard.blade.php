<x-layouts.user.main user="admin">
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
      <div class="w-full bg-white rounded-md border border-magnet-def-grey-400 p-4">
        <div class="px-6 pb-4 border-b border-gray-200">
          <h3 class="pt-2 text-lg font-semibold text-gray-900 text-center">Bidang industri terpopuler</h3>
        </div>
        <div class="p-4">
          <div class="space-y-1">
            <div class="flex items-center justify-between py-3 border-b border-gray-100">
              <div class="flex items-center">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                  <span class="text-sm font-semibold text-blue-600">1</span>
                </div>
                <p class="font-medium text-gray-900">Pariwisata</p>
              </div>
              <span class="text-sm font-semibold text-gray-900">451 mahasiswa magang</span>
            </div>
            <div class="flex items-center justify-between py-3 border-b border-gray-100">
              <div class="flex items-center">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                  <span class="text-sm font-semibold text-blue-600">2</span>
                </div>
                <p class="font-medium text-gray-900">Makanan & minuman</p>
              </div>
              <span class="text-sm font-semibold text-gray-900">367 mahasiswa magang</span>
            </div>
            <div class="flex items-center justify-between py-3 border-b border-gray-100">
              <div class="flex items-center">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                  <span class="text-sm font-semibold text-blue-600">3</span>
                </div>
                <p class="font-medium text-gray-900">Konveksi</p>
              </div>
              <span class="text-sm font-semibold text-gray-900">278 mahasiswa magang</span>
            </div>
            <div class="flex items-center justify-between py-3 border-b border-gray-100">
              <div class="flex items-center">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                  <span class="text-sm font-semibold text-blue-600">4</span>
                </div>
                <p class="font-medium text-gray-900">Pertanian</p>
              </div>
              <span class="text-sm font-semibold text-gray-900">123 mahasiswa magang</span>
            </div>
            <div class="flex items-center justify-between py-3">
              <div class="flex items-center">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                  <span class="text-sm font-semibold text-blue-600">5</span>
                </div>
                <p class="font-medium text-gray-900">Pendidikan</p>
              </div>
              <span class="text-sm font-semibold text-gray-900">56 mahasiswa magang</span>
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

</x-layouts.user.main>