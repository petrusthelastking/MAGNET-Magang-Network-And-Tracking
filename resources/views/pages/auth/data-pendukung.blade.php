<x-layouts.guest.main>
    <x-guest.navbar />
    <div class="w-full min-h-screen pt-14 flex text-black">


        <!-- Kiri -->
        <div class="w-1/2 bg-magnet-frost-mist flex items-start justify-start">
            <h1 class="font-semibold text-lg m-20">Isi Data-Data Pendukung</h1>
        </div>

        <!-- Kanan -->
        <div class="w-1/2 bg-white flex items-center justify-center">
            <form class="w-4/5 space-y-4">
                <flux:field>
                    <flux:label class="text-black!">Skill yang anda miliki</flux:label>
                    <flux:input.group class="rounded-xl border-magnet-def-grey-400!">
                        <flux:select wire:model="skill" class:select="text-black!">
                            <flux:select.option value="">Pilih skill yang anda miliki</flux:select.option>
                            <flux:select.option value="Frontend Development">Frontend Development</flux:select.option>
                            <flux:select.option value="Backend Development">Backend Development</flux:select.option>
                            <flux:select.option value="Mobile Development">Mobile Development</flux:select.option>
                            <flux:select.option value="Data Analysis">Data Analysis</flux:select.option>
                            <flux:select.option value="UI/UX Design">UI/UX Design</flux:select.option>
                            <flux:select.option value="Database Management">Database Management</flux:select.option>
                        </flux:select>
                    </flux:input.group>
                    <flux:error name="skill" />
                </flux:field>

                <flux:field>
                    <flux:label class="text-black!">Preferensi pekerjaan</flux:label>
                    <flux:input.group class="rounded-xl border-magnet-def-grey-400!">
                        <flux:select wire:model="preferensi_pekerjaan" class:select="text-black!">
                            <flux:select.option value="">Pilih pekerjaan impian anda</flux:select.option>
                            <flux:select.option value="Software Developer">Software Developer</flux:select.option>
                            <flux:select.option value="Web Developer">Web Developer</flux:select.option>
                            <flux:select.option value="Mobile App Developer">Mobile App Developer</flux:select.option>
                            <flux:select.option value="Data Analyst">Data Analyst</flux:select.option>
                            <flux:select.option value="System Analyst">System Analyst</flux:select.option>
                            <flux:select.option value="UI/UX Designer">UI/UX Designer</flux:select.option>
                        </flux:select>
                    </flux:input.group>
                    <flux:error name="preferensi_pekerjaan" />
                </flux:field>

                <flux:field>
                    <flux:label class="text-black!">Bidang industri</flux:label>
                    <flux:input.group class="rounded-xl border-magnet-def-grey-400!">
                        <flux:select wire:model="bidang_industri" class:select="text-black!">
                            <flux:select.option value="">Bidang industri yang anda inginkan</flux:select.option>
                            <flux:select.option value="Teknologi Informasi">Teknologi Informasi</flux:select.option>
                            <flux:select.option value="E-commerce">E-commerce</flux:select.option>
                            <flux:select.option value="Fintech">Fintech</flux:select.option>
                            <flux:select.option value="Healthcare">Healthcare</flux:select.option>
                            <flux:select.option value="Education">Education</flux:select.option>
                            <flux:select.option value="Manufacturing">Manufacturing</flux:select.option>
                            <flux:select.option value="Startup">Startup</flux:select.option>
                        </flux:select>
                    </flux:input.group>
                    <flux:error name="bidang_industri" />
                </flux:field>

                <flux:field>
                    <flux:label class="text-black!">Lokasi magang</flux:label>
                    <flux:input.group class="rounded-xl border-magnet-def-grey-400!">
                        <flux:select wire:model="lokasi_magang" class:select="text-black!">
                            <flux:select.option value="">Jarak lokasi magang maksimum yang anda inginkan
                            </flux:select.option>
                            <flux:select.option value="< 5 km">
                                < 5 km dari lokasi saya</flux:select.option>
                                    <flux:select.option value="5-10 km">5-10 km dari lokasi saya</flux:select.option>
                                    <flux:select.option value="10-20 km">10-20 km dari lokasi saya</flux:select.option>
                                    <flux:select.option value="> 20 km">> 20 km dari lokasi saya</flux:select.option>
                                    <flux:select.option value="Remote">Remote/Work from Home</flux:select.option>
                        </flux:select>
                    </flux:input.group>
                    <flux:error name="lokasi_magang" />
                </flux:field>

                <flux:field>
                    <flux:label class="text-black!">Jarak maksimum lokasi magang</flux:label>
                    <flux:input wire:model="jarak_maksimum" type="text" required
                        placeholder="Jarak maksimum lokasi magang"
                        class:input="text-black! rounded-xl border-magnet-def-grey-400!" />
                    <flux:error name="jarak_maksimum" />
                </flux:field>

                <flux:field>
                    <flux:label class="text-black!">Upah minimum</flux:label>
                    <flux:input wire:model="upah_minimum" type="text" required placeholder="Rp 2.000.000"
                        class:input="text-black! rounded-xl border-magnet-def-grey-400!" />
                    <flux:error name="upah_minimum" />
                </flux:field>

                <div class="text-right">
                    <flux:button type="submit"
                        class="bg-cyan-500 hover:bg-cyan-600 text-white font-semibold px-5 py-2 rounded">
                        Lanjut →
                    </flux:button>
                </div>
            </form>
        </div>

    </div>
</x-layouts.guest.main>