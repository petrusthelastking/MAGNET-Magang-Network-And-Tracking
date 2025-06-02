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
            <canvas id="trendChart" class="w-full h-full"></canvas>
          </div>
        </div>
      </div>
      <div class="w-full bg-white rounded-md border border-magnet-def-grey-400 p-6">
        <div class="flex flex-col h-full">
          <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">Statistik </h3>
          <div class="flex-1 flex items-center justify-center">
            <div class="text-center text-gray-500">
              <div class="w-16 h-16 mx-auto mb-4 bg-gray-200 rounded-full flex items-center justify-center">
                <flux:icon.chart-bar class="w-8 h-8" />
              </div>
              <p class="text-sm">besok</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Script untuk Chart --}}
  <script>
    // Tunggu sampai semua resource loaded
    window.addEventListener('load', function() {
      // Double check jQuery dan Chart.js sudah loaded
      if (typeof $ === 'undefined') {
        console.error('jQuery not loaded');
        return;
      }
      
      if (typeof Chart === 'undefined') {
        console.error('Chart.js not loaded');
        return;
      }

      console.log('Initializing chart...');

      // Data sesuai dengan gambar - menunjukkan tren naik dari 1000 ke 1500
      const chartData = {
        labels: ['2020', '2021', '2022', '2023'],
        datasets: [{
          label: 'Jumlah Mahasiswa Magang',
          data: [950, 1100, 1050, 1450],
          borderColor: '#dc2626', // Merah seperti di gambar
          backgroundColor: 'rgba(220, 38, 38, 0.05)',
          borderWidth: 2.5,
          fill: false,
          tension: 0, 
          pointBackgroundColor: '#dc2626',
          pointBorderColor: '#ffffff',
          pointBorderWidth: 2,
          pointRadius: 4,
          pointHoverRadius: 6,
          pointHoverBackgroundColor: '#dc2626',
          pointHoverBorderColor: '#ffffff',
          pointHoverBorderWidth: 2
        }]
      };

      // Konfigurasi chart sesuai style gambar
      const config = {
        type: 'line',
        data: chartData,
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false // Hilangkan legend untuk clean look
            },
            tooltip: {
              backgroundColor: 'rgba(0, 0, 0, 0.8)',
              titleColor: '#ffffff',
              bodyColor: '#ffffff',
              borderColor: '#dc2626',
              borderWidth: 1,
              displayColors: false,
              callbacks: {
                title: function (context) {
                  return 'Tahun ' + context[0].label;
                },
                label: function (context) {
                  return 'Mahasiswa: ' + context.parsed.y.toLocaleString() + ' orang';
                }
              }
            }
          },
          scales: {
            y: {
              beginAtZero: false,
              min: 0,
              max: 1500,
              grid: {
                display: true,
                color: '#e5e7eb',
                lineWidth: 1
              },
              border: {
                display: true,
                color: '#374151'
              },
              ticks: {
                stepSize: 500,
                color: '#6b7280',
                font: {
                  size: 12
                },
                callback: function (value) {
                  return value.toLocaleString();
                }
              }
            },
            x: {
              grid: {
                display: true,
                color: '#e5e7eb',
                lineWidth: 1
              },
              border: {
                display: true,
                color: '#374151'
              },
              ticks: {
                color: '#6b7280',
                font: {
                  size: 12
                }
              }
            }
          },
          interaction: {
            intersect: false,
            mode: 'index'
          },
          animation: {
            duration: 1500,
            easing: 'easeInOutCubic'
          },
          elements: {
            line: {
              capBezierPoints: false
            }
          }
        }
      };

      // Cek apakah canvas element ada
      const canvasElement = document.getElementById('trendChart');
      if (!canvasElement) {
        console.error('Canvas element not found');
        return;
      }

      // Inisialisasi chart
      try {
        const ctx = canvasElement.getContext('2d');
        const chart = new Chart(ctx, config);
        console.log('Chart initialized successfully');

        // Hover effect pada card setelah chart berhasil dibuat
        $('.border-magnet-def-grey-400').hover(
          function () {
            $(this).addClass('shadow-lg transform scale-[1.02] transition-all duration-300');
          },
          function () {
            $(this).removeClass('shadow-lg transform scale-[1.02]');
          }
        );

      } catch (error) {
        console.error('Error creating chart:', error);
      }
    });

    // Fallback jika window load sudah lewat
    $(document).ready(function() {
      // Delay untuk memastikan semua script loaded
      setTimeout(function() {
        if (!window.chartInitialized && typeof Chart !== 'undefined') {
          console.log('Fallback chart initialization...');
          window.dispatchEvent(new Event('load'));
          window.chartInitialized = true;
        }
      }, 1000);
    });
  </script>

</x-layouts.user.main>