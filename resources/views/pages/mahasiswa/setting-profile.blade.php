<x-layouts.mahasiswa.mahasiswa>
    <div class="gap-3 flex flex-col">
        <div class="card bg-white shadow-md">       
            <div class="card-body p-5">
                <flux:avatar circle src="https://unavatar.io/x/calebporzio" class="w-24 h-24" />
                <div class="grid grid-cols-2 gap-3 ">
                    <flux:input readonly value="Gracia Melati" type="text" label="Nama Lengkap" />
                    <flux:input readonly value="233413215689" type="text" label="NIM" />
                    <flux:input readonly value="Teknologi Informasi" type="text" label="Jurusan" />
                    <flux:input readonly value="D4 Teknik Iformatika" type="text" label="Program Studi" />
                    <flux:input readonly value="laki-laki" type="text" label="jenis Kelamin" />
                    <flux:input readonly value="Surabaya, Jawa Timur" type="text" label="Alamat" />
                </div>
            </div>

            <div class="card-actions flex justify-end p-5">
                <flux:button class="bg-magnet-sky-teal! text-white!" icon="pencil">Edit data anda</flux:button>
            </div>
        </div>


        <div class="card bg-white shadow-md">
            <div class="card-body grid grid-cols-2 gap-3">
                <flux:input readonly value="ReactJS, TensorFlow, Keras" type="text" label="Skill yang anda miliki" />
                <flux:input readonly value="Pariwisata" type="text" label="Bidang industri" />
                <flux:input readonly value="Frontend web developer" type="text" label="Pekerjaan impian" />
                <flux:input readonly value="2.500.000" type="text" label="Upah minimum" />
                <flux:input readonly value="Surabaya, Jawa Timur" type="text" label="Lokasi magang" />
            </div>

            <div class="card-actions flex justify-end p-5">
                <flux:button class="bg-magnet-sky-teal! text-white!" icon="pencil">Edit data preferensi magang</flux:button>
            </div>
        </div>
    </div>
</x-layouts.mahasiswa.mahasiswa>