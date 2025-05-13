<x-layouts.mahasiswa.mahasiswa >
    <flux:breadcrumbs class="mb-5">
        <flux:breadcrumbs.item href="{{ route('mahasiswa.setting-profile') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('mahasiswa.setting-profile') }}" class="text-black">Setting Profile</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="bg-[#E0F7FA] min-h-screen p-6">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-4 text-black">Data Diri Mahasiswa</h2>

        <form class="space-y-4 text-black">
            <!-- Nama -->
            <div>
                <label class="block font-medium mb-1">Nama</label>
                <input type="text" name="nama" class="w-full rounded-md border-gray-300 shadow-sm text-black focus:ring focus:ring-green-200 focus:border-green-400" />
            </div>

            <!-- NIM -->
            <div>
                <label class="block font-medium mb-1">NIM</label>
                <input type="text" name="nim" class="w-full rounded-md border-gray-300 shadow-sm text-black focus:ring focus:ring-green-200 focus:border-green-400" />
            </div>

            <!-- Jurusan -->
            <div>
                <label class="block font-medium mb-1">Jurusan</label>
                <input type="text" name="jurusan" class="w-full rounded-md border-gray-300 shadow-sm text-black focus:ring focus:ring-green-200 focus:border-green-400" />
            </div>

            <!-- Program Studi -->
            <div>
                <label class="block font-medium mb-1">Program Studi</label>
                <input type="text" name="prodi" class="w-full rounded-md border-gray-300 shadow-sm text-black focus:ring focus:ring-green-200 focus:border-green-400" />
            </div>

            <!-- Jenis Kelamin -->
            <div>
                <label class="block font-medium mb-1">Jenis Kelamin</label>
                <input type="text" name="jenis_kelamin" class="w-full rounded-md border-gray-300 shadow-sm text-black focus:ring focus:ring-green-200 focus:border-green-400" />
            </div>

            <!-- Alamat -->
            <div>
                <label class="block font-medium mb-1">Alamat</label>
                <textarea name="alamat"
                        class="w-full rounded-md border-gray-300 shadow-sm text-black focus:ring focus:ring-green-200 focus:border-green-400 resize-y min-h-[80px]"></textarea>
            </div>


            <!-- Prestasi -->
            <div>
                <label class="block font-medium mb-1">Prestasi </label>
                <input type="text" name="prestasi_" class="w-full rounded-md border-gray-300 shadow-sm text-black focus:ring focus:ring-green-200 focus:border-green-400" />
            </div>

            <!-- Tombol Simpan -->
            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-md shadow">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

</x-layouts.mahasiswa.mahasiswa>