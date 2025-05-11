<flux:sidebar stashable
    class="bg-zinc-50 dark:bg-zinc-900 border-r rtl:border-r-0 rtl:border-l border-zinc-200 dark:border-zinc-700">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />
    <a href="#">
        <H1 class="text-3xl font-black ps-2 mx-4 text-center text-[#219EBC]">MAGNET</H1>
    </a>
    <flux:navlist variant="outline">
        <flux:navlist.item icon="home" href="{{ route('dashboard') }}" current>
            Dashboard
        </flux:navlist.item>

        <flux:navlist.group expandable heading="Kelola Data" :expanded="false">
            <flux:navlist.item icon="user" href="{{ route('students-data') }}">
                Data Mahasiswa
            </flux:navlist.item>
            <flux:navlist.item icon="user" href="#">
                Data Dosen
            </flux:navlist.item>
            <flux:navlist.item icon="building-2" href="#">
                Data Perusahaan
            </flux:navlist.item>
        </flux:navlist.group>

        <flux:navlist.group expandable heading="Magang" :expanded="false">
            <flux:navlist.item icon="briefcase-business" href="#">
                Lowongan Magang
            </flux:navlist.item>
            <flux:navlist.item icon="flask-conical" href="#">
                Pengajuan Magang
            </flux:navlist.item>
            <flux:navlist.item icon="chart-no-axes-combined" href="#">
                Tren Magang
            </flux:navlist.item>
            <flux:navlist.item icon="crown" href="#">
                Aturan Magang
            </flux:navlist.item>
        </flux:navlist.group>

        <flux:navlist.group expandable heading="Laporan" :expanded="false">
            <flux:navlist.item icon="file-text" href="#">
                Laporan Statistik<br>Magang
            </flux:navlist.item>
        </flux:navlist.group>

        <flux:navlist.group expandable heading="Sistem" :expanded="false">
            <flux:navlist.item icon="file-cog" href="#">
                Evaluasi Sistem<br>Rekomendasi
            </flux:navlist.item>
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