<?php

use function Livewire\Volt\{state, mount};

$startMCDMInternshipRecommendation = function () {

};

mount(function () {
    $startMCDMInternshipRecommendation;
});

?>

<div>
    <div class="flex flex-col gap-8">
        <h2 class="font-semibold leading-6 text-black w-full flex-shrink-0">
            Pemberitahuan Terbaru
        </h2>
        <div
            class="w-full h-[162px] flex-shrink-0 rounded-[15px] bg-white s p-4 flex flex-col justify-between">
            <p class="text-black text-base font-medium">
                Isi pemberitahuan terbaru
            </p>
        </div>

        <div class="w-full flex justify-center">
            <form action="{{ route('mahasiswa.search') }}" method="GET" class="flex w-full justify-center">
                <flux:input icon="magnifying-glass" name="query" class="w-114!"
                    placeholder="Cari Tempat Magang Yang Anda Inginkan" />
            </form>
        </div>

        <!-- Bottom content card -->
        <h2
            class="text-[18px] font-extrabold leading-6 text-black w-[570.126px] h-[27px] flex-shrink-0 font-['Inter'] mt-6">
            Rekomendasi Tempat Magang
        </h2>
        <div class="grid grid-cols-3 gap-3">
            <button onclick="window.location='{{ route('mahasiswa.detail-perusahaan') }}'"
                class="text-black text-base font-medium no-underline w-full text-left">
                <div class="card-body bg-white hover:bg-gray-100 transition-colors rounded-md">
                    <div class="flex align-middle items-center">
                        <img src="{{ asset('logo-perusahaan.png') }}" alt="Logo Perusahaan"
                            class="w-10 h-10 object-contain">
                        <p class="h-fit px-3">PT. Kimia Farma</p>
                    </div>
                    <div class="font-bold text-lg mt-2">
                        <p>Frontend Web Developer</p>
                    </div>
                    <p class="text-sm text-gray-600">Jakarta</p>
                </div>
            </button>

            <button onclick="window.location='{{ route('mahasiswa.detail-perusahaan') }}'"
                class="text-black text-base font-medium no-underline w-full text-left">
                <div class="card-body bg-white hover:bg-gray-100 transition-colors rounded-md">
                    <div class="flex align-middle items-center">
                        <img src="{{ asset('logo-perusahaan.png') }}" alt="Logo Perusahaan"
                            class="w-10 h-10 object-contain">
                        <p class="h-fit px-3">PT. Kimia Farma</p>
                    </div>
                    <div class="font-bold text-lg mt-2">
                        <p>Frontend Web Developer</p>
                    </div>
                    <p class="text-sm text-gray-600">Jakarta</p>
                </div>
            </button>

            <button onclick="window.location='{{ route('mahasiswa.detail-perusahaan') }}'"
                class="text-black text-base font-medium no-underline w-full text-left">
                <div class="card-body bg-white hover:bg-gray-100 transition-colors rounded-md">
                    <div class="flex align-middle items-center">
                        <img src="{{ asset('logo-perusahaan.png') }}" alt="Logo Perusahaan"
                            class="w-10 h-10 object-contain">
                        <p class="h-fit px-3">PT. Kimia Farma</p>
                    </div>
                    <div class="font-bold text-lg mt-2">
                        <p>Frontend Web Developer</p>
                    </div>
                    <p class="text-sm text-gray-600">Jakarta</p>
                </div>
            </button>

            <button onclick="window.location='{{ route('mahasiswa.detail-perusahaan') }}'"
                class="text-black text-base font-medium no-underline w-full text-left">
                <div class="card-body bg-white hover:bg-gray-100 transition-colors rounded-md">
                    <div class="flex align-middle items-center">
                        <img src="{{ asset('logo-perusahaan.png') }}" alt="Logo Perusahaan"
                            class="w-10 h-10 object-contain">
                        <p class="h-fit px-3">PT. Kimia Farma</p>
                    </div>
                    <div class="font-bold text-lg mt-2">
                        <p>Frontend Web Developer</p>
                    </div>
                    <p class="text-sm text-gray-600">Jakarta</p>
                </div>
            </button>

            <button onclick="window.location='{{ route('mahasiswa.detail-perusahaan') }}'"
                class="text-black text-base font-medium no-underline w-full text-left">
                <div class="card-body bg-white hover:bg-gray-100 transition-colors rounded-md">
                    <div class="flex align-middle items-center">
                        <img src="{{ asset('logo-perusahaan.png') }}" alt="Logo Perusahaan"
                            class="w-10 h-10 object-contain">
                        <p class="h-fit px-3">PT. Kimia Farma</p>
                    </div>
                    <div class="font-bold text-lg mt-2">
                        <p>Frontend Web Developer</p>
                    </div>
                    <p class="text-sm text-gray-600">Jakarta</p>
                </div>
            </button>

            <button onclick="window.location='{{ route('mahasiswa.detail-perusahaan') }}'"
                class="text-black text-base font-medium no-underline w-full text-left">
                <div class="card-body bg-white hover:bg-gray-100 transition-colors rounded-md">
                    <div class="flex align-middle items-center">
                        <img src="{{ asset('logo-perusahaan.png') }}" alt="Logo Perusahaan"
                            class="w-10 h-10 object-contain">
                        <p class="h-fit px-3">PT. Kimia Farma</p>
                    </div>
                    <div class="font-bold text-lg mt-2">
                        <p>Frontend Web Developer</p>
                    </div>
                    <p class="text-sm text-gray-600">Jakarta</p>
                </div>
            </button>

            <button onclick="window.location='{{ route('mahasiswa.detail-perusahaan') }}'"
                class="text-black text-base font-medium no-underline w-full text-left">
                <div class="card-body bg-white hover:bg-gray-100 transition-colors rounded-md">
                    <div class="flex align-middle items-center">
                        <img src="{{ asset('logo-perusahaan.png') }}" alt="Logo Perusahaan"
                            class="w-10 h-10 object-contain">
                        <p class="h-fit px-3">PT. Kimia Farma</p>
                    </div>
                    <div class="font-bold text-lg mt-2">
                        <p>Frontend Web Developer</p>
                    </div>
                    <p class="text-sm text-gray-600">Jakarta</p>
                </div>
            </button>

            <button onclick="window.location='{{ route('mahasiswa.detail-perusahaan') }}'"
                class="text-black text-base font-medium no-underline w-full text-left">
                <div class="card-body bg-white hover:bg-gray-100 transition-colors rounded-md">
                    <div class="flex align-middle items-center">
                        <img src="{{ asset('logo-perusahaan.png') }}" alt="Logo Perusahaan"
                            class="w-10 h-10 object-contain">
                        <p class="h-fit px-3">PT. Kimia Farma</p>
                    </div>
                    <div class="font-bold text-lg mt-2">
                        <p>Frontend Web Developer</p>
                    </div>
                    <p class="text-sm text-gray-600">Jakarta</p>
                </div>
            </button>

            <button onclick="window.location='{{ route('mahasiswa.detail-perusahaan') }}'"
                class="text-black text-base font-medium no-underline w-full text-left">
                <div class="card-body bg-white hover:bg-gray-100 transition-colors rounded-md">
                    <div class="flex align-middle items-center">
                        <img src="{{ asset('logo-perusahaan.png') }}" alt="Logo Perusahaan"
                            class="w-10 h-10 object-contain">
                        <p class="h-fit px-3">PT. Kimia Farma</p>
                    </div>
                    <div class="font-bold text-lg mt-2">
                        <p>Frontend Web Developer</p>
                    </div>
                    <p class="text-sm text-gray-600">Jakarta</p>
                </div>
            </button>
        </div>
    </div>
</div>
