<div class="card bg-white shadow-md rounded-2xl border border-gray-200">
    <div class="card-body p-6 flex flex-col items-center text-center space-y-4">

        <flux:icon.lock-closed class="h-16 w-16 text-gray-400" />

        <h2 class="text-xl font-semibold text-gray-800">Akses Ditolak</h2>

        <p class="text-gray-600 max-w-md">
            Status Anda saat ini <span class="font-medium text-red-600">tidak sedang magang</span>. Oleh
            karena itu, fitur <span class="font-semibold text-blue-600">Log Magang</span> belum dapat diakses.
        </p>

        <a href="{{ route('dashboard') }}" class="btn btn-outline btn-primary rounded-full px-6">
            Kembali ke Dashboard
        </a>

    </div>
</div>
