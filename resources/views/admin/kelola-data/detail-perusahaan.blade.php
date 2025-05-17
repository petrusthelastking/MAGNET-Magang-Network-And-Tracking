<x-layouts.admin.admin>
    <flux:breadcrumbs class="mb-5">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('data-perusahaan') }}" class="text-black">Kelola Data Perusahaan
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('detail-perusahaan') }}" class="text-black">Detail Data Perusahaan
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <h1 class="text-base font-bold leading-6 text-black">Detail Informasi Perusahaan</h1>

    <div class=" min-h-screen p-6">
        <div class="px-4 font-sans text-black">
            <div class="flex gap-8 items-start">
                <div class="flex flex-col items-center bg-white p-4 rounded-xl shadow-md">
                    <img src="{{ asset('PT.png') }}" alt="Logo Perusahaan"
                        class="w-25 h-25 object-cover rounded-md mb-4" />
                    <div class="flex gap-4 mt-5">
                        <flux:button icon="pencil"
                            class="bg-emerald-500! hover:bg-emerald-600! text-white! rounded-md items-center">
                            Edit</flux:button>
                        <flux:modal.trigger name="delete-profile">
                            <flux:button icon="trash-2"
                                class="bg-red-500! hover:bg-red-600! text-white! rounded-md items-center">
                                Hapus</flux:button>
                        </flux:modal.trigger>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md w-full max-w-3xl">
                    <h2 class="text-lg font-semibold mb-4">Informasi Perusahaan</h2>
                    <form class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium">Nama</label>
                            <input type="text" placeholder="Placeholder" class="w-full border rounded-md px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Bidang Usaha</label>
                            <input type="text" placeholder="Placeholder" class="w-full border rounded-md px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Provinsi</label>
                            <input type="text" placeholder="Placeholder" class="w-full border rounded-md px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Kota</label>
                            <input type="text" placeholder="Placeholder" class="w-full border rounded-md px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Alamat</label>
                            <input type="text" placeholder="Placeholder" class="w-full border rounded-md px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Tahun Berdiri</label>
                            <input type="text" placeholder="Placeholder" class="w-full border rounded-md px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Jumlah Mahasiswa Magang</label>
                            <input type="text" placeholder="Placeholder" class="w-full border rounded-md px-3 py-2" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <flux:modal name="delete-profile" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Hapus Data?</flux:heading>
                <flux:text class="mt-2">
                    <p>Apakah anda yakin ingin menghapus data Perusahaan ?</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Batalkan</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="danger">Hapus</flux:button>
            </div>
        </div>
    </flux:modal>

</x-layouts.admin.admin>