<div
    class="card bg-gradient-to-br from-white to-gray-50 shadow-lg border border-gray-100 rounded-xl p-6 text-gray-800 transition-all duration-300 hover:shadow-xl">
    <!-- Header Section -->
    <div class="flex items-center gap-3 mb-6">
        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                </path>
            </svg>
        </div>
        <div>
            <h3 class="text-lg font-semibold text-gray-900">Pengajuan Magang</h3>
            <p class="text-sm text-gray-600">Kelola pengajuan magang Anda</p>
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
            <flux:text class="text-blue-800 text-sm leading-relaxed">
                Anda belum pernah mengajukan magang. Silakan ajukan terlebih dahulu untuk memulai proses magang Anda.
            </flux:text>
        </div>
    </div>

    <!-- Status Section -->
    <div class="bg-gray-50 rounded-lg p-4 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="font-medium text-gray-700">Status Pengajuan:</p>
            </div>
            <flux:badge variant="solid" color="orange" class="px-3 py-1 text-sm font-medium">
                Belum Diajukan
            </flux:badge>
        </div>
    </div>

    <!-- Action Section -->
    <div class="flex flex-col sm:flex-row gap-3">
        <flux:button variant="primary" href="{{ route('mahasiswa.form-pengajuan-magang') }}"
            class="bg-magnet-sky-teal hover:bg-cyan-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 flex items-center justify-center gap-2 shadow-sm hover:shadow-md">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
            </svg>
            Ajukan Magang Sekarang
        </flux:button>
    </div>

    <!-- Footer Info -->
    <div class="mt-6 pt-4 border-t border-gray-200">
        <p class="text-xs text-gray-500 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Pastikan dokumen persyaratan sudah lengkap sebelum mengajukan
        </p>
    </div>
</div>
