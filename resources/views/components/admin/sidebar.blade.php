<flux:sidebar sticky stashable class="bg-zinc-50 border-r rtl:border-r-0 rtl:border-l border-zinc-200 ">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

    <a href="#">
        <h1 class="text-3xl font-black ps-2 mx-4 text-center text-magnet-sky-teal">MAGNET</h1>
    </a>

    <flux:navlist variant="outline">
        <flux:navlist.item icon="home" href="{{ route('admin.dashboard') }}" :current="request()->is('/dashboard')">
            Dashboard
        </flux:navlist.item>

        @php
            $isRequestToKelolaData = request()->is('data-mahasiswa') || request()->is('data-perusahaan') || request()->is('data-dosen');
        @endphp

        <flux:navlist.group expandable heading="Kelola Data" :expanded="$isRequestToKelolaData">

            <flux:navlist.item icon="user" :current="request()->is('data-mahasiswa')"
                href="{{ route('admin.data-mahasiswa') }}" class="text-magnet-deep-ocean-blue!">
                Data Mahasiswa
            </flux:navlist.item>
            <flux:navlist.item icon="user" :current="request()->is('data-dosen')" href="{{ route('admin.data-dosen') }}"
                class="text-magnet-deep-ocean-blue!">
                Data Dosen
            </flux:navlist.item>
            <flux:navlist.item icon="building-2" href="{{ route('admin.data-perusahaan') }}"
                :current="request()->is('data-perusahaan')" class="text-magnet-deep-ocean-blue!">
                Data Perusahaan
            </flux:navlist.item>
        </flux:navlist.group>

        <flux:navlist.group expandable heading="Magang" :expanded="false">
            <flux:navlist.item icon="briefcase-business" href="{{ route('admin.data-lowongan') }}"
                :current="request()->is('/data-lowongan')" class="text-magnet-deep-ocean-blue!">
                Lowongan Magang
            </flux:navlist.item>
            <flux:navlist.item icon="flask-conical" href="{{ route('admin.data-pengajuan') }}" :current="request()->is('/pengajuan-magang')"
                class="text-magnet-deep-ocean-blue!">
                Pengajuan Magang
            </flux:navlist.item>
            <flux:navlist.item icon="chart-no-axes-combined" href="#" :current="request()->is('/tren-magang')"
                class="text-magnet-deep-ocean-blue!">
                Tren Magang
            </flux:navlist.item>
            <flux:navlist.item icon="crown" href="#" :current="request()->is('/aturan-magang')"
                class="text-magnet-deep-ocean-blue!">
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
