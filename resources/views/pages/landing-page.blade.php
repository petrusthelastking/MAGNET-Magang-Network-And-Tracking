<x-layouts.guest>


    <section class="h-screen px-6 pt-6 flex justify-around items-start">
        <div class="container mx-auto">
            <div class="bg-magnet-deep-ocean-blue text-white rounded-2xl pb-72">
                <x-guest.navbar-new />
                <div class="text-center pt-8">
                    <h1 class="text-3xl font-medium mb-6 italic">Langkah Awal Kariermu<br>Dimulai Di Sini!</h1>

                    <p class="max-w-md mx-auto text-center text-sm text-white mb-6">
                        Magang nggak harus ribet. Cukup sesuaikan minatmu, dan kami bantu carikan yang paling cocok buat
                        kamu!
                    </p>
                    <flux:button class="text-black! bg-white! rounded-full! hover:bg-gray-200 border-0"
                        href="{{route('login')}}">Cari
                        tempat magang impianmu Sekarang</flux:button>
                </div>
            </div>

            <div class="bg-white rounded-lg p-8 shadow-lg -mt-64 relative z-10 mx-20 md:mx-72">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="rounded-lg h-72 flex justify-center items-center overflow-hidden">
                        <img src="{{asset('Mobdev.png')}}" alt="Mobile Development" class="object-cover w-full h-full">
                    </div>
                    <div class="rounded-lg h-72 flex justify-center items-center overflow-hidden">
                        <img src="{{asset('UI UX.png')}}" alt="UI UX" class="object-cover w-full h-full">
                    </div>
                    <div class="rounded-lg h-72 flex justify-center items-center overflow-hidden">
                        <img src="{{asset('sectr.png')}}" alt="Security Engineer" class="object-cover w-full h-full">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="h-screen p-10 pb-8 flex items-center justify-center" id="alur">
        <div class="w-full flex flex-col">

            <main class="container mx-auto p-5">
                <div class="text-center mb-16">
                    <h1 class="text-2xl font-bold mb-6 text-slate-800">Lebih dari 1.500++ perusahaan mitra
                        bekerja sama dengan JTI POLINEMA</h1>
                    <p class=" font-medium text-slate-600 mb-8">Bergabunglah dengan jaringan mitra
                        kami yang terus berkembang</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                    <!-- Contoh slot untuk logo mitra, ganti dengan asset gambar Anda -->
                    @foreach(range(1, 15) as $index)
                        <div class="p-4  flex items-center justify-center h-28">
                            <!-- Ganti dengan asset gambar partner -->
                            <img src="{{ asset('BRI.png') }}" alt="Partner Logo"
                                class="max-w-full max-h-24 object-contain">
                        </div>
                    @endforeach
                </div>
            </main>
        </div>
    </section>

    <section class="h-screen px-16 pt-16 pb-8 flex items-center justify-center" id="tata-tertib">
      

    </section>

    <section class="h-screen px-16 pt-16 pb-8 flex items-center justify-center" id="kendala">

        <div class="pt-52 bg-gradient-to-br from-gray-100 to-blue-50 p-6">

            <div
                class="bg-white/60 backdrop-blur-lg border border-white/30 rounded-2xl shadow-xl p-8 max-w-xl w-full text-center">

                <div class="flex flex-col items-center space-y-4">
                    <!-- Ikon -->
                    <div class="text-5xl text-blue-600">
                        ❓
                    </div>

                    <!-- Teks Utama -->
                    <h2 class="text-2xl font-bold text-gray-800">
                        Alami kendala dalam mengajukan magang?
                    </h2>
                    <p class="text-gray-700">
                        Kirimkan kendala yang kamu alami pada formulir berikut:
                    </p>

                    <!-- Tombol -->
                    <a href="form-pengaduan.html" class="btn btn-primary mt-4">
                        📩 Formulir Pengaduan Kendala
                    </a>
                </div>

            </div>

        </div>
    </section>

    <x-guest.footer />
</x-layouts.guest>