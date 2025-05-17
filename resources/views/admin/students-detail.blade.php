<x-layouts.admin.admin>

    <flux:breadcrumbs class="mb-5">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('students-data') }}" class="text-black">Kelola Data Mahasiswa
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('detail-students') }}" class="text-black">Detail Data Mahasiswa
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <h1 class="text-base font-bold leading-6 text-black">Detail Mahasiswa</h1>

    <div class=" min-h-screen p-6">
        <div class="flex">
            <div id="photoButtons" class="flex flex-col items-center gap-3">
                <div id="profilePreview"
                    class="w-[230px] h-[306px] flex-shrink-0 rounded-[10px] bg-[lightgray] bg-center bg-cover bg-no-repeat"
                    style="aspect-ratio: 115 / 153; background-image: url('/path/to/default.jpg');"></div>

                <input type="file" id="photoInput" accept="image/*" class="hidden" />

                <!-- Tombol Upload (jika belum ada foto) -->
                <button type="button" id="uploadButton" onclick="document.getElementById('photoInput').click()"
                    class="rounded-[8px] bg-[var(--Default-green-400,#34D399)] text-white shadow-[0px_4px_6px_-1px_rgba(0,0,0,0.10),0px_2px_4px_-1px_rgba(0,0,0,0.06)] flex h-[38px] px-[21px] py-[7px] justify-center items-center gap-[8px]">
                    Upload Foto
                </button>

                <!-- Tombol Edit & Hapus -->
                <div id="editDeleteBtns" class="flex gap-3">
                    <!-- Edit Foto -->
                    <flux:navlist.item icon="pencil" onclick="document.getElementById('photoInput').click()"
                        class="!text-black rounded-[8px] bg-[var(--Default-green-400,#34D399)] shadow-[0px_4px_6px_-1px_rgba(0,0,0,0.10),0px_2px_4px_-1px_rgba(0,0,0,0.06)] flex h-[38px] px-[21px] py-[7px] justify-center items-center gap-[8px]">
                        Edit Foto
                    </flux:navlist.item>

                    <!-- Hapus Foto -->
                    <flux:navlist.item icon="trash-2" onclick="removePhoto()"
                        class="!text-black rounded-[8px] bg-[var(--Default-red-400,#F87171)] shadow-[0px_4px_6px_-1px_rgba(0,0,0,0.10),0px_2px_4px_-1px_rgba(0,0,0,0.06)] flex h-[38px] px-[21px] py-[7px] justify-center items-center gap-[8px]">
                        Hapus Foto
                    </flux:navlist.item>
                </div>
                <div class="">
                    //form
                </div>
            </div>
        </div>


</x-layouts.admin.admin>