<x-layouts.mahasiswa.mahasiswa>
    <flux:breadcrumbs class="mb-5">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" class="text-black">Dashboard</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Wrapper dengan jarak 9px antar card -->
    <div class="flex flex-col gap-[30px]">
        <!-- Mid content card -->
        <h2
            class="text-[18px] font-extrabold leading-6 text-black w-[570.126px] h-[27px] flex-shrink-0 font-['Inter'] mt-6">
            Pemberitahuan Terbaru
        </h2>
        <div
            class="w-full h-[162px] flex-shrink-0 rounded-[15px] bg-white shadow-[0px_4px_4px_0px_rgba(0,0,0,0.25)] p-4 flex flex-col justify-between">
            <p class="text-black text-base font-medium">
                Isi pemberitahuan terbaru
            </p>
        </div>

        <div class="w-full flex justify-center">
            <flux:input icon="magnifying-glass" class="w-114!" placeholder="Cari Tempat Magang Yang Anda Inginkan" />
        </div>

        <!-- Bottom content card -->
        <h2
            class="text-[18px] font-extrabold leading-6 text-black w-[570.126px] h-[27px] flex-shrink-0 font-['Inter'] mt-6">
            Rekomendasi Tempat Magang
        </h2>
        <div class="grid grid-cols-3 gap-3">
            <div
                class="w-full h-[162px] flex-shrink-0 rounded-[15px] bg-white shadow-[0pdx_4px_4px_0px_rgba(0,0,0,0.25)] p-4 flex flex-col justify-between">
                <p class="text-black text-base font-medium">
                    Isi Rekomendasi tempat magang 1
                </p>
            </div>
            <div
                class="w-full h-[162px] flex-shrink-0 rounded-[15px] bg-white shadow-[0pdx_4px_4px_0px_rgba(0,0,0,0.25)] p-4 flex flex-col justify-between">
                <p class="text-black text-base font-medium">
                    Isi Rekomendasi tempat magang 2
                </p>
            </div>
            <div
                class="w-full h-[162px] flex-shrink-0 rounded-[15px] bg-white shadow-[0pdx_4px_4px_0px_rgba(0,0,0,0.25)] p-4 flex flex-col justify-between">
                <p class="text-black text-base font-medium">
                    Isi Rekomendasi tempat magang 3
                </p>
            </div>
                        <div
                class="w-full h-[162px] flex-shrink-0 rounded-[15px] bg-white shadow-[0pdx_4px_4px_0px_rgba(0,0,0,0.25)] p-4 flex flex-col justify-between">
                <p class="text-black text-base font-medium">
                    Isi Rekomendasi tempat magang 4
                </p>
            </div>
            <div
                class="w-full h-[162px] flex-shrink-0 rounded-[15px] bg-white shadow-[0pdx_4px_4px_0px_rgba(0,0,0,0.25)] p-4 flex flex-col justify-between">
                <p class="text-black text-base font-medium">
                    Isi Rekomendasi tempat magang 5
                </p>
            </div>
            <div
                class="w-full h-[162px] flex-shrink-0 rounded-[15px] bg-white shadow-[0pdx_4px_4px_0px_rgba(0,0,0,0.25)] p-4 flex flex-col justify-between">
                <p class="text-black text-base font-medium">
                    Isi Rekomendasi tempat magang 6
                </p> 
            </div>
                        <div
                class="w-full h-[162px] flex-shrink-0 rounded-[15px] bg-white shadow-[0pdx_4px_4px_0px_rgba(0,0,0,0.25)] p-4 flex flex-col justify-between">
                <p class="text-black text-base font-medium">
                    Isi Rekomendasi tempat magang 7
                </p>
            </div>
            <div
                class="w-full h-[162px] flex-shrink-0 rounded-[15px] bg-white shadow-[0pdx_4px_4px_0px_rgba(0,0,0,0.25)] p-4 flex flex-col justify-between">
                <p class="text-black text-base font-medium">
                    Isi Rekomendasi tempat magang 8
                </p> 
            </div>
            <div
                class="w-full h-[162px] flex-shrink-0 rounded-[15px] bg-white shadow-[0pdx_4px_4px_0px_rgba(0,0,0,0.25)] p-4 flex flex-col justify-between">
                <p class="text-black text-base font-medium">
                    Isi Rekomendasi tempat magang 9
                </p>
            </div>
        </div>
    </div>
</x-layouts.mahasiswa.mahasiswa>