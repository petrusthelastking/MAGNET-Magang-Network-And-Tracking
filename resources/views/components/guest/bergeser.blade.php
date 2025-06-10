    <style>
        @keyframes scroll-horizontal {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }

        @keyframes scroll-horizontal-reverse {
            0% {
                transform: translateX(-50%);
            }
            100% {
                transform: translateX(0);
            }
        }

        .scroll-horizontal {
            animation: scroll-horizontal 60s linear infinite;
        }

        .scroll-horizontal-reverse {
            animation: scroll-horizontal-reverse 60s linear infinite;
        }
    </style>

    <section class="min-h-screen p-4 sm:p-6 lg:p-10 pb-8 flex flex-col items-center justify-center" id="partner">
        <h1 class="text-center text-2xl font-bold mb-8">Apa kata mereka tentang MAGNET?</h1>

        <!-- Baris 1: ke kanan -->
        <div class="overflow-hidden w-full mb-6">
            <div class="flex scroll-horizontal" style="width: max-content;">
                <!-- Set 1 -->
                <div class="flex gap-4">
                    <div class="bg-white rounded-xl p-4 w-80 shadow-md flex-shrink-0">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/60?img=1" class="rounded-full w-12 h-12">
                            <div>
                                <p class="font-bold">Putri Gracia</p>
                                <p class="text-sm italic text-gray-500">Pernah magang sebagai Frontend developer di PT AQUA</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm">Sangat mudah, cepat, dan dapat diandalkan</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 w-80 shadow-md flex-shrink-0">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/60?img=2" class="rounded-full w-12 h-12">
                            <div>
                                <p class="font-bold">Ahmad Rizki</p>
                                <p class="text-sm italic text-gray-500">Software Engineer di Tokopedia</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm">MAGNET membantu saya menemukan talent terbaik untuk proyek startup saya. Prosesnya sangat efisien!</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 w-80 shadow-md flex-shrink-0">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/60?img=3" class="rounded-full w-12 h-12">
                            <div>
                                <p class="font-bold">Sari Dewi</p>
                                <p class="text-sm italic text-gray-500">UI/UX Designer di Gojek</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm">Platform yang user-friendly dengan fitur matching yang akurat. Recommended!</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 w-80 shadow-md flex-shrink-0">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/60?img=4" class="rounded-full w-12 h-12">
                            <div>
                                <p class="font-bold">Budi Santoso</p>
                                <p class="text-sm italic text-gray-500">Product Manager di Shopee</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm">Dengan MAGNET, saya bisa fokus pada project tanpa khawatir mencari tim yang tepat</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 w-80 shadow-md flex-shrink-0">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/60?img=5" class="rounded-full w-12 h-12">
                            <div>
                                <p class="font-bold">Maya Indira</p>
                                <p class="text-sm italic text-gray-500">Data Scientist di Traveloka</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm">Sistem rating dan review di MAGNET sangat membantu dalam memilih collaborator</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 w-80 shadow-md flex-shrink-0">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/60?img=6" class="rounded-full w-12 h-12">
                            <div>
                                <p class="font-bold">Doni Pratama</p>
                                <p class="text-sm italic text-gray-500">Mobile Developer di Bukalapak</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm">Interface yang clean dan intuitif. Mudah digunakan bahkan untuk pemula</p>
                    </div>
                </div>
                <!-- Set 2 (duplikat) -->
                <div class="flex gap-4 ml-4">
                    <div class="bg-white rounded-xl p-4 w-80 shadow-md flex-shrink-0">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/60?img=1" class="rounded-full w-12 h-12">
                            <div>
                                <p class="font-bold">Putri Gracia</p>
                                <p class="text-sm italic text-gray-500">Pernah magang sebagai Frontend developer di PT AQUA</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm">Sangat mudah, cepat, dan dapat diandalkan</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 w-80 shadow-md flex-shrink-0">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/60?img=2" class="rounded-full w-12 h-12">
                            <div>
                                <p class="font-bold">Ahmad Rizki</p>
                                <p class="text-sm italic text-gray-500">Software Engineer di Tokopedia</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm">MAGNET membantu saya menemukan talent terbaik untuk proyek startup saya. Prosesnya sangat efisien!</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 w-80 shadow-md flex-shrink-0">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/60?img=3" class="rounded-full w-12 h-12">
                            <div>
                                <p class="font-bold">Sari Dewi</p>
                                <p class="text-sm italic text-gray-500">UI/UX Designer di Gojek</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm">Platform yang user-friendly dengan fitur matching yang akurat. Recommended!</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 w-80 shadow-md flex-shrink-0">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/60?img=4" class="rounded-full w-12 h-12">
                            <div>
                                <p class="font-bold">Budi Santoso</p>
                                <p class="text-sm italic text-gray-500">Product Manager di Shopee</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm">Dengan MAGNET, saya bisa fokus pada project tanpa khawatir mencari tim yang tepat</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 w-80 shadow-md flex-shrink-0">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/60?img=5" class="rounded-full w-12 h-12">
                            <div>
                                <p class="font-bold">Maya Indira</p>
                                <p class="text-sm italic text-gray-500">Data Scientist di Traveloka</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm">Sistem rating dan review di MAGNET sangat membantu dalam memilih collaborator</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 w-80 shadow-md flex-shrink-0">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/60?img=6" class="rounded-full w-12 h-12">
                            <div>
                                <p class="font-bold">Doni Pratama</p>
                                <p class="text-sm italic text-gray-500">Mobile Developer di Bukalapak</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm">Interface yang clean dan intuitif. Mudah digunakan bahkan untuk pemula</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Baris 2: ke kiri -->
        <div class="overflow-hidden w-full">
            <div class="flex scroll-horizontal-reverse" style="width: max-content;">
                <!-- Set 1 -->
                <div class="flex gap-4">
                    <div class="bg-white rounded-xl p-4 w-80 shadow-md flex-shrink-0">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/60?img=7" class="rounded-full w-12 h-12">
                            <div>
                                <p class="font-bold">Lisa Kartika</p>
                                <p class="text-sm italic text-gray-500">Digital Marketing Specialist di Blibli</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm">MAGNET membuat networking jadi lebih mudah. Saya sudah dapat beberapa project bagus!</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 w-80 shadow-md flex-shrink-0">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/60?img=8" class="rounded-full w-12 h-12">
                            <div>
                                <p class="font-bold">Rendra Malik</p>
                                <p class="text-sm italic text-gray-500">Backend Developer di OVO</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm">Fitur chat dan video call terintegrasi sangat memudahkan komunikasi dengan klien</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 w-80 shadow-md flex-shrink-0">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/60?img=9" class="rounded-full w-12 h-12">
                            <div>
                                <p class="font-bold">Fitri Amelia</p>
                                <p class="text-sm italic text-gray-500">Content Writer di Detik.com</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm">Payment system yang aman dan transparan. Tidak ada lagi khawatir soal pembayaran</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 w-80 shadow-md flex-shrink-0">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/60?img=10" class="rounded-full w-12 h-12">
                            <div>
                                <p class="font-bold">Adi Nugroho</p>
                                <p class="text-sm italic text-gray-500">DevOps Engineer di Grab</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm">Algoritma matching-nya sangat akurat. Saya selalu dapat project yang sesuai skill</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 w-80 shadow-md flex-shrink-0">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/60?img=11" class="rounded-full w-12 h-12">
                            <div>
                                <p class="font-bold">Rina Safitri</p>
                                <p class="text-sm italic text-gray-500">Graphic Designer di Zalora</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm">Dashboard analytics membantu saya track performa dan earnings dengan mudah</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 w-80 shadow-md flex-shrink-0">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/60?img=12" class="rounded-full w-12 h-12">
                            <div>
                                <p class="font-bold">Hendra Wijaya</p>
                                <p class="text-sm italic text-gray-500">Full Stack Developer di Dana</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm">Customer support yang responsif dan helpful. Issue selalu cepat terselesaikan</p>
                    </div>
                </div>
                <!-- Set 2 (duplikat) -->
                <div class="flex gap-4 ml-4">
                    <div class="bg-white rounded-xl p-4 w-80 shadow-md flex-shrink-0">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/60?img=7" class="rounded-full w-12 h-12">
                            <div>
                                <p class="font-bold">Lisa Kartika</p>
                                <p class="text-sm italic text-gray-500">Digital Marketing Specialist di Blibli</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm">MAGNET membuat networking jadi lebih mudah. Saya sudah dapat beberapa project bagus!</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 w-80 shadow-md flex-shrink-0">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/60?img=8" class="rounded-full w-12 h-12">
                            <div>
                                <p class="font-bold">Rendra Malik</p>
                                <p class="text-sm italic text-gray-500">Backend Developer di OVO</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm">Fitur chat dan video call terintegrasi sangat memudahkan komunikasi dengan klien</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 w-80 shadow-md flex-shrink-0">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/60?img=9" class="rounded-full w-12 h-12">
                            <div>
                                <p class="font-bold">Fitri Amelia</p>
                                <p class="text-sm italic text-gray-500">Content Writer di Detik.com</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm">Payment system yang aman dan transparan. Tidak ada lagi khawatir soal pembayaran</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 w-80 shadow-md flex-shrink-0">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/60?img=10" class="rounded-full w-12 h-12">
                            <div>
                                <p class="font-bold">Adi Nugroho</p>
                                <p class="text-sm italic text-gray-500">DevOps Engineer di Grab</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm">Algoritma matching-nya sangat akurat. Saya selalu dapat project yang sesuai skill</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 w-80 shadow-md flex-shrink-0">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/60?img=11" class="rounded-full w-12 h-12">
                            <div>
                                <p class="font-bold">Rina Safitri</p>
                                <p class="text-sm italic text-gray-500">Graphic Designer di Zalora</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm">Dashboard analytics membantu saya track performa dan earnings dengan mudah</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 w-80 shadow-md flex-shrink-0">
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/60?img=12" class="rounded-full w-12 h-12">
                            <div>
                                <p class="font-bold">Hendra Wijaya</p>
                                <p class="text-sm italic text-gray-500">Full Stack Developer di Dana</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm">Customer support yang responsif dan helpful. Issue selalu cepat terselesaikan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>