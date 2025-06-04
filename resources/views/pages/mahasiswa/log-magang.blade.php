<x-layouts.user.main user="mahasiswa">
    <div class="min-h-screen">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Log Magang 30 Februari 2077</h2>

        <div class="bg-white rounded-lg shadow-md p-5 mx-auto">
            <div class="space-y-6">

                <flux:field>
                    <flux:label>Hari, Tanggal</flux:label>
                    <flux:input readonly type="date" class="bg-gray-50!"/>
                </flux:field>

                <flux:field>
                    <flux:label>Jam Masuk</flux:label>
                    <flux:input readonly type="time" class="bg-gray-50!" />
                </flux:field>

                <flux:field>
                    <flux:label>Jam Pulang</flux:label>
                    <flux:input readonly type="time" class="bg-gray-50!" />
                </flux:field>

                <flux:field>
                    <flux:label>Kegiatan</flux:label>
                    <flux:textarea readonly placeholder="Isi kegiatan anda hari ini" rows="4" class="bg-gray-50!">
                    </flux:textarea>
                </flux:field>
            </div>
        </div>
    </div>
</x-layouts.user.main>
