<x-layouts.mahasiswa.mahasiswa>
    <div class="gap-3 flex flex-col">
        <div class="card bg-white shadow-md">
            <div class="card-body p-5">
                <flux:avatar circle src="https://unavatar.io/x/{{ $mahasiswa->name }}" class="w-24 h-24" />
                <div class="grid grid-cols-2 gap-3 ">
                    <flux:input readonly value="{{ $user->name }}" type="text" label="Nama Lengkap" />
                    <flux:input readonly value="{{ $mahasiswa->nim }}" type="text" label="NIM" />
                    <flux:input readonly value="Teknologi Informasi" type="text" label="Jurusan" />
                    <flux:input readonly value="{{ $mahasiswa->programStudi->nama_program ?? '-' }}" type="text"
                        label="Program Studi" />
                    <flux:input readonly value="{{ $mahasiswa->jenis_kelamin ?? '-' }}" type="text"
                        label="Jenis Kelamin" />
                    <flux:input readonly value="{{ $mahasiswa->alamat ?? '-' }}" type="text" label="Alamat" />

                </div>
            </div>

            <div class="card-actions flex justify-end p-5">
                <flux:button class="bg-magnet-sky-teal! text-white!" icon="pencil">Edit data anda</flux:button>
            </div>
        </div>

        <div class="card bg-white shadow-md">
            <div class="card-body grid grid-cols-2 gap-3">
                <flux:input readonly value="{{ $preferensi->keahlian ?? '-' }}" type="text"
                    label="Skill yang anda miliki" />
                <flux:input readonly value="{{ $preferensi->bidang_industri ?? '-' }}" type="text"
                    label="Bidang industri" />
                <flux:input readonly value="{{ $preferensi->pekerjaan_impian ?? '-' }}" type="text"
                    label="Pekerjaan impian" />
                <flux:input readonly value="{{ $preferensi->upah_minimum ?? '-' }}" type="text"
                    label="Upah minimum" />
                <flux:input readonly value="{{ $preferensi->lokasi_magang ?? '-' }}" type="text"
                    label="Lokasi magang" />
            </div>

            <div class="card-actions flex justify-end p-5">
                <flux:button class="bg-magnet-sky-teal! text-white!" icon="pencil">Edit data preferensi magang
                </flux:button>
            </div>
        </div>
    </div>
</x-layouts.mahasiswa.mahasiswa>
