<x-layouts.mahasiswa.mahasiswa>
    <div class="gap-3 flex flex-col">
        <div class="card bg-white shadow-md">
            <div class="card-body p-5">
                <flux:avatar circle src="https://unavatar.io/x/{{ $mahasiswa->nama }}" class="w-24 h-24" />
                <div class="grid grid-cols-2 gap-3 ">
                    <flux:input readonly value="{{ $mahasiswa->nama }}" type="text" label="Nama Lengkap" />
                    <flux:input readonly value="{{ $mahasiswa->nim }}" type="text" label="NIM" />
                    <flux:input readonly value="Teknologi Informasi" type="text" label="Jurusan" />
                    <flux:input readonly value="{{ $mahasiswa->program_studi ?? '-' }}" type="text"
                        label="Program Studi" />
                    <flux:input readonly
                        value="{{ $mahasiswa->jenis_kelamin == 'P' ? 'Perempuan' : ($mahasiswa->jenis_kelamin == 'L' ? 'Laki-laki' : '-') }}"
                        type="text" label="Jenis Kelamin" />
                    <flux:input readonly value="{{ $mahasiswa->alamat ?? '-' }}" type="text" label="Alamat" />

                </div>
            </div>

            <div class="card-actions flex justify-end p-5">
                <flux:button class="bg-magnet-sky-teal! text-white!" icon="pencil">Edit data anda</flux:button>
            </div>
        </div>

        <div class="card bg-white shadow-md">
            <div class="card-body grid grid-cols-2 gap-3">
                <flux:input readonly value="{{ $preferensi->bidang_pekerjaan ?? '-' }}" type="text"
                    label="Skill yang anda miliki" />
                <flux:input readonly value="{{ $preferensia->lokasi ?? '-' }}" type="text" label="Lokasi magang" />
                <flux:input readonly value="{{ $preferensi->reputasi ?? '-' }}" type="text" label="Reputasi" />
                <flux:input readonly value="{{ $preferensi->uang_saku ?? '-' }}" type="text" label="Uang saku" />
                <flux:input readonly value="{{ $preferensi->open_remote ?? '-' }}" type="text"
                    label="Open remote" />
            </div>

            <div class="card-actions flex justify-end p-5">
                <flux:button class="bg-magnet-sky-teal! text-white!" icon="pencil">Edit data preferensi magang
                </flux:button>
            </div>
        </div>
    </div>
</x-layouts.mahasiswa.mahasiswa>
