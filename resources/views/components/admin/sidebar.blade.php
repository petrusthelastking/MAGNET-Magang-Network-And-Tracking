<flux:sidebar sticky stashable
    class="bg-magnet-medium-blue text-white! border-r rtl:border-r-0 rtl:border-l border-zinc-200">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

    <flux:brand href="#" logo="https://fluxui.dev/img/demo/logo.png" name="MAGNET" class="px-2" />


    <flux:navlist>
        <flux:navlist.item icon="home" href="{{ route('dashboard') }}" :current="request()->is('/dashboard')" class="active:text-white">Dashboard</flux:navlist.item>
        <flux:navlist.group expandable heading="Kelola Data" class="lg:grid" :expanded="false">
            <flux:navlist.item href="{{ route('students-data') }}" :current="request()->is('/students-data')">Data Mahasiswa</flux:navlist.item>
            <flux:navlist.item href="#">Data Dosen Pembimbing</flux:navlist.item>
            <flux:navlist.item href="#">Data Mahasiswa</flux:navlist.item>
        </flux:navlist.group>
        <flux:navlist.group expandable heading="Magang" class="lg:grid" :expanded="false">
            <flux:navlist.item href="#">Pengajuan Magang</flux:navlist.item>
            <flux:navlist.item href="#">Tren Magang</flux:navlist.item>
        </flux:navlist.group>
        <flux:navlist.group expandable heading="Laporan" class="lg:grid" :expanded="false">
            <flux:navlist.item href="#">Laporan Statistik Magang</flux:navlist.item>
        </flux:navlist.group>
        <flux:navlist.group expandable heading="Sistem" class="lg:grid" :expanded="false">
            <flux:navlist.item href="#">Evaluasi Sistem Rekomendasi</flux:navlist.item>
        </flux:navlist.group>
    </flux:navlist>

    <flux:spacer />

    <flux:navlist>
        <flux:navlist.item icon="cog-6-tooth" href="#">Settings</flux:navlist.item>
        <flux:navlist.item icon="information-circle" href="#">Help</flux:navlist.item>
    </flux:navlist>

    <flux:dropdown position="top" align="start" class="max-lg:hidden">
        <flux:profile avatar="https://fluxui.dev/img/demo/user.png" name="Olivia Martin" />

        <flux:menu>
            <flux:menu.item href="/profile" class="flex justify-start">
                <div class="w-8 p-0">
                    <img src="https://fluxui.dev/img/demo/user.png" alt="" class="w-full">
                </div>
                <div class="flex flex-col ml-3">
                    <span>{{ auth()->user()->name }}</span>
                    <span class="text-xs">me@email.com</span>
                </div>
            </flux:menu.item>

            <flux:menu.item icon="settings">Pengaturan</flux:menu.item>

            <flux:menu.separator />

            <flux:menu.item icon="arrow-right-start-on-rectangle" class="bg-red-700">Logout</flux:menu.item>
        </flux:menu>
    </flux:dropdown>
</flux:sidebar>

<flux:header class="lg:hidden">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
    <flux:spacer />
    <flux:dropdown position="top" alignt="start">
        <flux:profile avatar="https://fluxui.dev/img/demo/user.png" />
        <flux:menu>
            <flux:menu.radio.group>
                <flux:menu.radio checked>Olivia Martin</flux:menu.radio>
                <flux:menu.radio>Truly Delta</flux:menu.radio>
            </flux:menu.radio.group>
            <flux:menu.separator />
            <flux:menu.item icon="arrow-right-start-on-rectangle">Logout</flux:menu.item>
        </flux:menu>
    </flux:dropdown>

</flux:header>
