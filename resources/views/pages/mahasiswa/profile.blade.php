<x-layouts.mahasiswa.main>
    <div class="gap-3 flex flex-col">
        <div class="card bg-white shadow-md">
            <div class="card-body p-5">
                <flux:avatar circle src="https://unavatar.io/x/{{ auth('mahasiswa')->user()->nama }}" class="w-24 h-24" />
                <div class="grid grid-cols-2 gap-3 ">
                    <flux:input readonly value="{{ auth('mahasiswa')->user()->nama }}" type="text" label="Nama Lengkap" />
                    <flux:input readonly value="{{ auth('mahasiswa')->user()->nim }}" type="text" label="NIM" />
                    <flux:input readonly value="{{ auth('mahasiswa')->user()->jurusan }}" type="text" label="Jurusan" />
                    <flux:input readonly value="{{ auth('mahasiswa')->user()->program_studi }}" type="text"
                        label="Program Studi" />
                    <flux:input readonly
                        value="{{ auth('mahasiswa')->user()->jenis_kelamin }}"
                        type="text" label="Jenis Kelamin" />
                    <flux:input readonly value="{{ auth('mahasiswa')->user()->alamat }}" type="text" label="Alamat" />

                </div>
            </div>

            <div class="card-actions flex justify-end p-5">
                <flux:button class="bg-magnet-sky-teal! text-white!" icon="pencil">Edit data anda</flux:button>
            </div>
        </div>

        <div class="card bg-white shadow-md">
            <div class="card-body grid grid-cols-2 gap-3">
                <flux:input readonly value="{{ auth('mahasiswa')->user()->preferensiMahasiswa()->first()->bidang_pekerjaan }}" type="text"
                    label="Bidang pekerjaan" />
                <flux:input readonly value="{{ auth('mahasiswa')->user()->preferensiMahasiswa()->first()->lokasi }}" type="text" label="Lokasi magang" />
                <flux:input readonly value="{{ auth('mahasiswa')->user()->preferensiMahasiswa()->first()->reputasi }}" type="text" label="Reputasi" />
                <flux:input readonly value="{{ auth('mahasiswa')->user()->preferensiMahasiswa()->first()->uang_saku }}" type="text" label="Uang saku" />
                <flux:input readonly value="{{ auth('mahasiswa')->user()->preferensiMahasiswa()->first()->open_remote }}" type="text"
                    label="Open remote" />
            </div>

            <div class="card-actions flex justify-end p-5">
                <flux:button class="bg-magnet-sky-teal! text-white!" icon="pencil">Edit data preferensi magang
                </flux:button>
            </div>
        </div>
    </div>
</x-layouts.mahasiswa.main>
