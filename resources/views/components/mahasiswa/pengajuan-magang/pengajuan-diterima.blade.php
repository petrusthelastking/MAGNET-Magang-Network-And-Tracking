<?php
use Illuminate\Support\Facades\Auth;

$mahasiswa = Auth::user()->mahasiswa;
?>

<div
    class="card bg-gradient-to-br from-white to-green-50 shadow-lg border border-green-200 rounded-xl p-6 text-gray-800 transition-all duration-300 hover:shadow-xl">
    <!-- Header Section -->
    <div class="flex items-center gap-3 mb-6">
        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <h3 class="text-lg font-semibold text-gray-900">Pengajuan Magang</h3>
            <p class="text-sm text-gray-600">Selamat! Pengajuan Anda telah disetujui</p>
        </div>
    </div>

    <!-- Status Section -->
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                <p class="font-medium text-gray-700">Status Pengajuan:</p>
            </div>
            <flux:badge variant="solid" color="green" class="px-3 py-1 text-sm font-medium">
                Diterima
            </flux:badge>
        </div>
    </div>

    <!-- Success Message -->
    <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-green-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd"></path>
            </svg>
            <div>
                <p class="text-green-800 text-sm font-medium mb-1">
                    Pengajuan magang Anda telah disetujui!
                </p>
                <flux:text class="text-green-700 text-sm leading-relaxed">
                    Anda bisa berkonsultasi terkait proses magang pada dosen pembimbing Anda.
                </flux:text>
            </div>
        </div>
    </div>

    <!-- Action Section -->
    <div class="bg-blue-50 rounded-lg p-4 mb-4">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                </path>
            </svg>
            <div>
                <p class="text-blue-800 text-sm font-medium mb-1">Langkah Selanjutnya:</p>
                <p class="text-blue-700 text-sm">
                    Fitur konsultasi bisa diakses pada bagian
                    <flux:link href="{{ route('mahasiswa.konsul-dospem') }}"
                        class="font-semibold text-blue-600 hover:text-blue-800 underline underline-offset-2 hover:underline-offset-4 transition-all">
                        Konsultasi
                    </flux:link>
                </p>
            </div>
        </div>
    </div>

    <!-- Quick Action -->
    <div class="flex gap-3">
        <flux:button variant="primary" href="{{ route('mahasiswa.konsul-dospem') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 flex items-center gap-2 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                </path>
            </svg>
            Mulai Konsultasi
        </flux:button>
    </div>

    <!-- Progress Timeline -->
    <div class="bg-gray-50 rounded-lg p-4 mt-4">
        <p class="text-sm font-medium text-gray-700 mb-3">Status Lengkap:</p>
        <div class="flex items-center gap-2 text-xs text-gray-600">
            <div class="flex items-center gap-1">
                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                <span>Diajukan</span>
            </div>
            <div class="flex-1 h-px bg-green-300"></div>
            <div class="flex items-center gap-1">
                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                <span>Verifikasi</span>
            </div>
            <div class="flex-1 h-px bg-green-300"></div>
            <div class="flex items-center gap-1">
                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                <span class="font-medium text-green-700">Diterima</span>
            </div>
        </div>
    </div>
</div>
