<x-layouts.user.main user="admin">
    <flux:breadcrumbs class="mb-5">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('admin.statistik-magang') }}" class="text-black">Statistik magang
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('admin.perusahaan-terpopuler') }}" class="text-black">Perusahaan
            terpopuler
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="bg-white rounded-lg shadow p-4">
        <canvas id="perusahaanChart" height="100"></canvas>
    </div>
    <script>
        new Chart(document.getElementById('perusahaanChart'), {
            type: 'bar',
            data: {
                labels: ['PT ABC', 'PT DEF', 'PT KLM', 'PT JEF', 'PT OOP'],
                datasets: [{
                    data: [100, 88, 70, 40, 25],
                    backgroundColor: '#EF4444',
                    barThickness: 40
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 30 } }
                }
            }
        });
    </script>
</x-layouts.user.main>