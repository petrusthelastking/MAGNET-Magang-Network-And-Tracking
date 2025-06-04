<x-layouts.user.main user="mahasiswa">
    <div class="min-h-screen">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Log Magang 30 Februari 2077</h2>

        <div class="bg-white rounded-lg shadow-md p-5 mx-auto">
            <div class="space-y-6">

                <flux:field>
                    <flux:label>Hari, Tanggal</flux:label>
                    <flux:input type="date" class="bg-gray-50!" />
                </flux:field>

                <flux:field>
                    <flux:label>Jam Masuk</flux:label>
                    <flux:input type="time" class="bg-gray-50!" />
                </flux:field>

                <flux:field>
                    <flux:label>Jam Pulang</flux:label>
                    <flux:input type="time" class="bg-gray-50!" />
                </flux:field>

                <flux:field>
                    <flux:label>Kegiatan</flux:label>
                    <flux:textarea placeholder="Isi kegiatan anda hari ini" rows="4" class="bg-gray-50!">
                    </flux:textarea>
                </flux:field>

            </div>

            <div class="flex justify-end mt-8">
                <flux:button class="bg-magnet-sky-teal! text-white!">Ajukan Tanda Tangan</flux:button>
            </div>
        </div>
    </div>
</x-layouts.user.main>
