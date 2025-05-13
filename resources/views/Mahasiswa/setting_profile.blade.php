<x-layouts.mahasiswa.mahasiswa>
    <flux:breadcrumbs class="mb-5">
        <flux:breadcrumbs.item href="{{ route('mahasiswa.setting-profile') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('mahasiswa.setting-profile') }}" class="text-black">Setting Profile</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="bg-[#E0F7FA] min-h-screen p-6">
        <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold mb-4 text-black">Data Diri Mahasiswa</h2>

            <form class="space-y-4 text-black">

                <!-- Nama -->
                <div class="flex items-center gap-2 p-[6px_13px] align-self-stretch">
                    <label class="w-1/4 font-medium">Nama</label>
                    <input type="text" name="nama" class="w-full rounded-md border-gray-300 shadow-sm text-black" />
                </div>

                <!-- NIM -->
                <div class="flex items-center gap-2 p-[6px_13px] align-self-stretch">
                    <label class="w-1/4 font-medium">NIM</label>
                    <input type="text" name="nim"
                    oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                    class="w-full rounded-md border-gray-300 shadow-sm text-black bg-white/50 focus:ring focus:ring-green-200 focus:border-green-400" />
                </div>

                <!-- Jurusan -->
                <div class="flex items-center gap-2 p-[6px_13px] align-self-stretch">
                    <label class="w-1/4 font-medium">Jurusan</label>
                    <input type="text" name="jurusan" class="w-full rounded-md border-gray-300 shadow-sm text-black" />
                </div>

                <!-- Program Studi -->
                <div class="flex items-center gap-2 p-[6px_13px] align-self-stretch">
                    <label class="w-1/4 font-medium">Program Studi</label>
                    <input type="text" name="prodi" class="w-full rounded-md border-gray-300 shadow-sm text-black" />
                </div>

                <!-- Jenis Kelamin -->
                <div class="flex items-center gap-2 p-[6px_13px] align-self-stretch">
                    <label class="w-1/4 font-medium">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full rounded-md border-gray-300 shadow-sm text-black">
                        <option value="" disabled selected>Pilih jenis kelamin</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <!-- Alamat -->
                <div class="flex items-center gap-2 p-[6px_13px] align-self-stretch">
                    <label class="w-1/4 font-medium">Alamat</label>
                    <textarea name="alamat" class="w-full rounded-md border-gray-300 shadow-sm text-black min-h-[80px] resize-y"></textarea>
                </div>

                <!-- Prestasi -->
                <div class="flex items-center gap-2 p-[6px_13px] align-self-stretch">
                    <label class="w-1/4 font-medium">Prestasi</label>
                    <input type="text" name="prestasi_1" class="w-full rounded-md border-gray-300 shadow-sm text-black" />
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
