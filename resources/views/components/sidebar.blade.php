<flux:sidebar sticky stashable
    class="bg-[#276DA9]! border-r rtl:border-r-0 rtl:border-l border-zinc-200 dark:border-zinc-700">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

    <flux:brand href="#" logo="https://fluxui.dev/img/demo/logo.png" name="MAGNET." class="px-2 dark:hidden" />
        class="px-2 hidden dark:flex" />


    <flux:navlist variant="outline">
        <flux:navlist.item icon="home" href="#" current>Dashboard</flux:navlist.item>
        <flux:navlist.group expandable heading="Kelola Data" class="lg:grid" :expanded="false">
            <flux:navlist.item href="#">Data Mahasiswa</flux:navlist.item>
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

    <flux:navlist variant="outline">
        <flux:navlist.item icon="cog-6-tooth" href="#">Settings</flux:navlist.item>
        <flux:navlist.item icon="information-circle" href="#">Help</flux:navlist.item>
    </flux:navlist>

    <flux:dropdown position="top" align="start" class="max-lg:hidden">
        <flux:profile avatar="https://fluxui.dev/img/demo/user.png" name="Olivia Martin" />

        <flux:menu>
            <flux:menu.radio.group>
                <flux:menu.radio checked>Olivia Martin</flux:menu.radio>
                <flux:menu.radio>Truly Delta</flux:menu.radio>
            </flux:menu.radio.group>

            <flux:menu.separator />

            <flux:menu.item icon="arrow-right-start-on-rectangle">Logout</flux:menu.item>
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
