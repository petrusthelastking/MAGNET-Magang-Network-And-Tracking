<flux:sidebar sticky stashable
    class="bg-zinc-50 border-r rtl:border-r-0 rtl:border-l border-zinc-200 ">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />
    <a href="#">
        <H1 class="text-3xl font-black ps-2 mx-4 text-center text-magnet-sky-teal">MAGNET</H1>
    </a>
    <flux:navlist variant="outline">
        <flux:navlist.item icon="home" href="{{ route('dashboard') }}" :current="request()->is('/dashboard')">
        <flux:navlist.item icon="home" href="{{ route('dashboard') }}" :current="request()->is('/dashboard')">
            Dashboard
        </flux:navlist.item>

        <flux:navlist.group expandable heading="Kelola Data" :expanded="false">

            <flux:navlist.item icon="user" :current="request()->is('students-data')" href="{{ route('data-mahasiswa') }}" class="text-magnet-deep-ocean-blue!">
                Data Mahasiswa
            </flux:navlist.item>
            <flux:navlist.item icon="user" :current="request()->is('dosen-data')" href="{{ route('data-dosen') }}" class="text-magnet-deep-ocean-blue!">
                Data Dosen
            </flux:navlist.item>
            <flux:navlist.item icon="building-2" href="#" :current="request()->is('perusahaan-data')" class="text-magnet-deep-ocean-blue!">
            <flux:navlist.item icon="building-2" href="#" :current="request()->is('perusahaan-data')" class="text-magnet-deep-ocean-blue!">
                Data Perusahaan
            </flux:navlist.item>
        </flux:navlist.group>

        <flux:navlist.group expandable heading="Magang" :expanded="false">
            <flux:navlist.item icon="briefcase-business" href="#" :current="request()->is('/lowongan-magang')" class="text-magnet-deep-ocean-blue!">
            <flux:navlist.item icon="briefcase-business" href="#" :current="request()->is('/lowongan-magang')" class="text-magnet-deep-ocean-blue!">
                Lowongan Magang
            </flux:navlist.item>
            <flux:navlist.item icon="flask-conical" href="#" :current="request()->is('/pengajuan-magang')" class="text-magnet-deep-ocean-blue!">
            <flux:navlist.item icon="flask-conical" href="#" :current="request()->is('/pengajuan-magang')" class="text-magnet-deep-ocean-blue!">
                Pengajuan Magang
            </flux:navlist.item>
            <flux:navlist.item icon="chart-no-axes-combined" href="#" :current="request()->is('/tren-magang')" class="text-magnet-deep-ocean-blue!">
            <flux:navlist.item icon="chart-no-axes-combined" href="#" :current="request()->is('/tren-magang')" class="text-magnet-deep-ocean-blue!">
                Tren Magang
            </flux:navlist.item>
            <flux:navlist.item icon="crown" href="#" :current="request()->is('/aturan-magang')" class="text-magnet-deep-ocean-blue!">
            <flux:navlist.item icon="crown" href="#" :current="request()->is('/aturan-magang')" class="text-magnet-deep-ocean-blue!">
                Aturan Magang
            </flux:navlist.item>
        </flux:navlist.group>

        <flux:navlist.group expandable heading="Laporan" :expanded="false" class="text-magnet-deep-ocean-blue!">
            <flux:navlist.item icon="file-text" href="#" class="text-magnet-deep-ocean-blue!">
                Laporan Statistik<br>Magang
            </flux:navlist.item>
        </flux:navlist.group>

        <flux:navlist.group expandable heading="Sistem" :expanded="false" class="text-magnet-deep-ocean-blue!">
            <flux:navlist.item icon="file-cog" href="#" class="text-magnet-deep-ocean-blue!">
                Evaluasi Sistem<br>Rekomendasi
            </flux:navlist.item>
        </flux:navlist.group>
    </flux:navlist>

    <flux:spacer />
    
    <flux:dropdown position="top" align="start" class="max-lg:hidden">
        <flux:profile avatar="https://fluxui.dev/img/demo/user.png" name="Olivia Martin" />
        <flux:menu>
            <flux:menu.radio.group>
                <flux:menu.radio checked>Olivia Martin</flux:menu.radio>
                <flux:menu.radio>Truly Delta</flux:menu.radio>
            </flux:menu.radio.group>

            <flux:menu.separator />

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                    {{ __('Log Out') }}
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>
</flux:sidebar>