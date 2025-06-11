<section class="min-h-screen p-4 sm:p-6 lg:p-10 pb-8 flex items-center justify-center" id="partner">
    <div class="w-full flex flex-col">
        <main class="container mx-auto p-2 sm:p-5">
            <div class="text-center mb-8 sm:mb-12 lg:mb-16">
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold mb-4 sm:mb-6 text-slate-800 px-4">
                    Lebih dari 1.500++ perusahaan mitra bekerja sama dengan JTI POLINEMA
                </h1>
                <p class="font-medium text-slate-600 mb-6 sm:mb-8 text-sm sm:text-base px-4">
                    Bergabunglah dengan jaringan mitra kami yang terus berkembang
                </p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-6 lg:gap-8">
                @foreach (range(1, 15) as $index)
                    <div class="p-2 sm:p-4 flex items-center justify-center h-20 sm:h-24 lg:h-28">
                        <img src="{{ asset('img/company/company-bri.png') }}" alt="Partner Logo"
                            class="max-w-full max-h-16 sm:max-h-20 lg:max-h-24 object-contain">
                    </div>
                @endforeach
            </div>
        </main>
    </div>
</section>
