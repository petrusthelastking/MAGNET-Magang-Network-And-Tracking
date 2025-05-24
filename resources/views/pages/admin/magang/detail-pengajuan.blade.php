<x-layouts.admin.main>
    <flux:breadcrumbs class="mb-5">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('admin.data-pengajuan') }}" class="text-black">Kelola data pengajuan
            magang
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('admin.detail-pengajuan') }}" class="text-black">Detail pengajuan magang
            Magang
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <h1 class="text-base font-bold leading-6 text-black">Detail Informasi Pengajuan Magang</h1>

    <div class=" min-h-screen p-6">
        <div class="px-4 font-sans text-black">
            <div class="flex gap-8 items-start">
                <div class="flex flex-col items-center bg-white p-4 rounded-xl shadow-md">
                    <img src="{{ asset('cewek.png') }}" alt="Foto Mahasiswa"
                        class="w-40 h-52 object-cover rounded-md mb-4" />
                </div>

                <div class="w-full">
                    <div class="bg-white p-6 rounded-xl shadow-md w-full max-w-3xl">
                        <h2 class="text-lg font-semibold mb-4">Informasi Pelamar</h2>
                        <form class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium">Nama</label>
                                <input type="text" placeholder="Placeholder"
                                    class="w-full border rounded-md px-3 py-2" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium">NIM</label>
                                <input type="text" placeholder="Placeholder"
                                    class="w-full border rounded-md px-3 py-2" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium">Jurusan</label>
                                <input type="text" placeholder="Placeholder"
                                    class="w-full border rounded-md px-3 py-2" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium">Program Studi</label>
                                <input type="text" placeholder="Placeholder"
                                    class="w-full border rounded-md px-3 py-2" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium">Jenis Kelamin</label>
                                <input type="text" placeholder="Placeholder"
                                    class="w-full border rounded-md px-3 py-2" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium">Umur</label>
                                <input type="text" placeholder="Placeholder"
                                    class="w-full border rounded-md px-3 py-2" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium">Status Magang</label>
                                <input type="text" placeholder="Placeholder"
                                    class="w-full border rounded-md px-3 py-2" />
                            </div>

                    </div>
                    <div class="bg-white p-6 mt-4 rounded-xl shadow-md w-full max-w-3xl">
                        <h2 class="text-lg font-semibold mb-4">Dokumen-dokumen magang</h2>
                        <form class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium">Daftar Riwayat Hidup</label>
                                <input type="file" class="border rounded-md px-3 py-2" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium">CV</label>
                                <input type="file" class="border rounded-md px-3 py-2" />
                            </div>

                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>

</x-layouts.admin.admin>
