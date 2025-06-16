<!-- Status: Sedang Diproses -->
<div
    class="card bg-gradient-to-br from-white to-yellow-50 shadow-lg border border-yellow-200 rounded-xl p-6 text-gray-800 transition-all duration-300 hover:shadow-xl">
    <!-- Header Section -->
    <div class="flex items-center gap-3 mb-6">
        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center animate-pulse">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <h3 class="text-lg font-semibold text-gray-900">Pengajuan Magang</h3>
            <p class="text-sm text-gray-600">Status terkini pengajuan Anda</p>
        </div>
    </div>

    <!-- Status Section -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></div>
                <p class="font-medium text-gray-700">Status Pengajuan:</p>
            </div>
            <flux:badge variant="solid" color="yellow" class="px-3 py-1 text-sm font-medium">
                Sedang Diproses
            </flux:badge>
        </div>
    </div>

    <!-- Info Message -->
    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 rounded-r-lg">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                    clip-rule="evenodd"></path>
            </svg>
            <div>
                <flux:text class="text-blue-800 text-sm leading-relaxed font-medium">
                    Mohon menunggu hingga pengajuan magang berhasil diverifikasi.
                </flux:text>
                <p class="text-blue-700 text-sm mt-1">
                    Proses verifikasi memerlukan waktu <span class="font-semibold">2-3 hari kerja</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Progress Timeline -->
    <div class="bg-gray-50 rounded-lg p-4">
        <p class="text-sm font-medium text-gray-700 mb-3">Timeline Verifikasi:</p>
        <div class="flex items-center gap-2 text-xs text-gray-600">
            <div class="flex items-center gap-1">
                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                <span>Diajukan</span>
            </div>
            <div class="flex-1 h-px bg-gray-300"></div>
            <div class="flex items-center gap-1">
                <div class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></div>
                <span class="font-medium">Verifikasi</span>
            </div>
            <div class="flex-1 h-px bg-gray-300"></div>
            <div class="flex items-center gap-1">
                <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
                <span>Selesai</span>
            </div>
        </div>
    </div>
</div>
