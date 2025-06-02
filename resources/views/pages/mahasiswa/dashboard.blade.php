<x-layouts.user.main user="mahasiswa">

    <!-- Wrapper dengan jarak 9px antar card -->
    <div class="flex flex-col gap-[30px]">
        <!-- Mid content card -->
        <h2 class="text-[18px] font-extrabold leading-6 text-black w-[570.126px] flex-shrink-0 font-['Inter']">
            Pemberitahuan Terbaru
        </h2>
        <div
            class="w-full h-[162px] flex-shrink-0 rounded-[15px] bg-white shadow-[0px_4px_4px_0px_rgba(0,0,0,0.25)] p-4 flex flex-col justify-between">
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
            <div
                class="w-full h-[162px] flex-shrink-0 rounded-[15px] bg-white shadow-[0pdx_4px_4px_0px_rgba(0,0,0,0.25)] p-4 flex flex-col justify-between">
                <div class="text-black text-base font-medium">
                    <div class="card-body">
                        <div class="flex align-middle items-center">
                            <img src="{{ asset('logo-perusahaan.png') }}" alt="Logo Perusahaan"
                                class="w-10 h-10 object-contain">
                            <p class="h-fit px-3">PT.Kimia Farma</p>
                        </div>
                        <div class="font-bold text-lg">
                            <p>Frontend Web Developer</p>
                        </div>
                        <p>Jakarta</p>
                    </div>
                </div>
            </div>
            <div
                class="w-full h-[162px] flex-shrink-0 rounded-[15px] bg-white shadow-[0pdx_4px_4px_0px_rgba(0,0,0,0.25)] p-4 flex flex-col justify-between">
                <div class="text-black text-base font-medium">
                    <div class="card-body">
                        <div class="flex align-middle items-center">
                            <img src="{{ asset('logo-perusahaan.png') }}" alt="Logo Perusahaan"
                                class="w-10 h-10 object-contain">
                            <p class="h-fit px-3">PT.Kimia Farma</p>
                        </div>
                        <div class="font-bold text-lg">
                            <p>Frontend Web Developer</p>
                        </div>
                        <p>Jakarta</p>
                    </div>
                </div>
            </div>
            <div
                class="w-full h-[162px] flex-shrink-0 rounded-[15px] bg-white shadow-[0pdx_4px_4px_0px_rgba(0,0,0,0.25)] p-4 flex flex-col justify-between">
                <div class="text-black text-base font-medium">
                    <div class="card-body">
                        <div class="flex align-middle items-center">
                            <img src="{{ asset('logo-perusahaan.png') }}" alt="Logo Perusahaan"
                                class="w-10 h-10 object-contain">
                            <p class="h-fit px-3">PT.Kimia Farma</p>
                        </div>
                        <div class="font-bold text-lg">
                            <p>Frontend Web Developer</p>
                        </div>
                        <p>Jakarta</p>
                    </div>
                </div>
            </div>
            <div
                class="w-full h-[162px] flex-shrink-0 rounded-[15px] bg-white shadow-[0pdx_4px_4px_0px_rgba(0,0,0,0.25)] p-4 flex flex-col justify-between">
                <div class="text-black text-base font-medium">
                    <div class="card-body">
                        <div class="flex align-middle items-center">
                            <img src="{{ asset('logo-perusahaan.png') }}" alt="Logo Perusahaan"
                                class="w-10 h-10 object-contain">
                            <p class="h-fit px-3">PT.Kimia Farma</p>
                        </div>
                        <div class="font-bold text-lg">
                            <p>Frontend Web Developer</p>
                        </div>
                        <p>Jakarta</p>
                    </div>
                </div>
            </div>
            <div
                class="w-full h-[162px] flex-shrink-0 rounded-[15px] bg-white shadow-[0pdx_4px_4px_0px_rgba(0,0,0,0.25)] p-4 flex flex-col justify-between">
                <div class="text-black text-base font-medium">
                    <div class="card-body">
                        <div class="flex align-middle items-center">
                            <img src="{{ asset('logo-perusahaan.png') }}" alt="Logo Perusahaan"
                                class="w-10 h-10 object-contain">
                            <p class="h-fit px-3">PT.Kimia Farma</p>
                        </div>
                        <div class="font-bold text-lg">
                            <p>Frontend Web Developer</p>
                        </div>
                        <p>Jakarta</p>
                    </div>
                </div>
            </div>
            <div
                class="w-full h-[162px] flex-shrink-0 rounded-[15px] bg-white shadow-[0pdx_4px_4px_0px_rgba(0,0,0,0.25)] p-4 flex flex-col justify-between">
                <div class="text-black text-base font-medium">
                    <div class="card-body">
                        <div class="flex align-middle items-center">
                            <img src="{{ asset('logo-perusahaan.png') }}" alt="Logo Perusahaan"
                                class="w-10 h-10 object-contain">
                            <p class="h-fit px-3">PT.Kimia Farma</p>
                        </div>
                        <div class="font-bold text-lg">
                            <p>Frontend Web Developer</p>
                        </div>
                        <p>Jakarta</p>
                    </div>
                </div>
            </div>
            <div
                class="w-full h-[162px] flex-shrink-0 rounded-[15px] bg-white shadow-[0pdx_4px_4px_0px_rgba(0,0,0,0.25)] p-4 flex flex-col justify-between">
                <div class="text-black text-base font-medium">
                    <div class="card-body">
                        <div class="flex align-middle items-center">
                            <img src="{{ asset('logo-perusahaan.png') }}" alt="Logo Perusahaan"
                                class="w-10 h-10 object-contain">
                            <p class="h-fit px-3">PT.Kimia Farma</p>
                        </div>
                        <div class="font-bold text-lg">
                            <p>Frontend Web Developer</p>
                        </div>
                        <p>Jakarta</p>
                    </div>
                </div>
            </div>
            <div
                class="w-full h-[162px] flex-shrink-0 rounded-[15px] bg-white shadow-[0pdx_4px_4px_0px_rgba(0,0,0,0.25)] p-4 flex flex-col justify-between">
                <div class="text-black text-base font-medium">
                    <div class="card-body">
                        <div class="flex align-middle items-center">
                            <img src="{{ asset('logo-perusahaan.png') }}" alt="Logo Perusahaan"
                                class="w-10 h-10 object-contain">
                            <p class="h-fit px-3">PT.Kimia Farma</p>
                        </div>
                        <div class="font-bold text-lg">
                            <p>Frontend Web Developer</p>
                        </div>
                        <p>Jakarta</p>
                    </div>
                </div>
            </div>
            <div
                class="w-full h-[162px] flex-shrink-0 rounded-[15px] bg-white shadow-[0pdx_4px_4px_0px_rgba(0,0,0,0.25)] p-4 flex flex-col justify-between">
                <div class="text-black text-base font-medium">
                    <div class="card-body">
                        <div class="flex align-middle items-center">
                            <img src="{{ asset('logo-perusahaan.png') }}" alt="Logo Perusahaan"
                                class="w-10 h-10 object-contain">
                            <p class="h-fit px-3">PT.Kimia Farma</p>
                        </div>
                        <div class="font-bold text-lg">
                            <p>Frontend Web Developer</p>
                        </div>
                        <p>Jakarta</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </x-layouts.mahasiswa.main>
