<flux:sidebar sticky stashable class="bg-zinc-50 border-r rtl:border-r-0 rtl:border-l border-zinc-200 ">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

    <a href="{{ route('guest.landing-page') }}" wire:navigate>
        <h1 class="text-3xl font-black ps-2 mx-4 text-center text-magnet-sky-teal">MAGNET</h1>
    </a>

    <flux:navlist variant="outline">
        <flux:navlist.item
            icon="home"
            href="{{ route('dashboard') }}"
            :current="request()->is('/dashboard')"
            wire:navigate>
            Dashboard
        </flux:navlist.item>


        @php
            $isRequestToKelolaData = request()->is('kelola-data-master/*');
        @endphp
        <flux:navlist.group expandable heading="Kelola Data Master" :expanded="$isRequestToKelolaData">
            <flux:navlist.item
                icon="user"
                :current="request()->fullUrlIs(route('admin.data-mahasiswa'))"
                href="{{ route('admin.data-mahasiswa') }}"
                wire:navigate
                class="text-magnet-deep-ocean-blue!">
                Data Mahasiswa
            </flux:navlist.item>
            <flux:navlist.item
                icon="user"
                :current="request()->fullUrlIs(route('admin.data-dosen'))"
                href="{{ route('admin.data-dosen') }}" class="text-magnet-deep-ocean-blue!">
                Data Dosen
            </flux:navlist.item>
            <flux:navlist.item
                icon="building-2"
                href="{{ route('admin.data-perusahaan') }}"
                :current="request()->fullUrlIs(route('admin.data-perusahaan'))"
                class="text-magnet-deep-ocean-blue!">
                Data Perusahaan
            </flux:navlist.item>
        </flux:navlist.group>

        @php
            $isRequestToMagang = request()->is('magang/*');
        @endphp
        <flux:navlist.group expandable heading="Magang" :expanded="$isRequestToMagang">
            <flux:navlist.item
                icon="briefcase-business"
                href="{{ route('admin.data-lowongan') }}"
                :current="request()->is('data-lowongan')"
                class="text-magnet-deep-ocean-blue!">
                Lowongan Magang
            </flux:navlist.item>
            <flux:navlist.item
                icon="flask-conical"
                href="{{ route('admin.data-pengajuan-magang') }}"
                :current="request()->is('data-pengajuan-magang')"
                class="text-magnet-deep-ocean-blue!">
                Pengajuan Magang
            </flux:navlist.item>
            <flux:navlist.item
                icon="flask-conical"
                href="{{ route('admin.data-pengajuan-diperbarui') }}"
                :current="request()->is('data-pengajuan-diperbarui')"
                class="text-magnet-deep-ocean-blue!">
                Pengajuan Magang<br>Diperbarui
            </flux:navlist.item>
            <flux:navlist.item
                icon="crown"
                href="{{ route('admin.aturan-magang') }}"
                :current="request()->is('aturan-magang')"
                class="text-magnet-deep-ocean-blue!">
                Aturan Magang
            </flux:navlist.item>
        </flux:navlist.group>

        <flux:navlist.group expandable heading="Laporan"
            :expanded="request()->fullUrlIs(route('admin.laporan-statistik-magang'))"
            class="text-magnet-deep-ocean-blue!">
            <flux:navlist.item
                icon="file-text"
                href="{{ route('admin.laporan-statistik-magang') }}"
                class="text-magnet-deep-ocean-blue!">
                Laporan Statistik<br>Magang
            </flux:navlist.item>
        </flux:navlist.group>

        <flux:navlist.group expandable heading="Sistem"
            :expanded="request()->fullUrlIs(route('admin.evaluasi-sistem-rekomendasi'))"
            class="text-magnet-deep-ocean-blue!">
            <flux:navlist.item
                icon="file-cog"
                href="{{ route('admin.evaluasi-sistem-rekomendasi') }}"
                class="text-magnet-deep-ocean-blue!">
                Evaluasi Sistem<br>Rekomendasi
            </flux:navlist.item>
        </flux:navlist.group>
    </flux:navlist>

    <flux:spacer />

    <flux:dropdown position="top" align="start" class="max-lg:hidden">
        <flux:profile avatar="https://unavatar.io/x/calebporzio" name="{{ auth('admin')->user()->nama }}" />

        <flux:menu class="p-0!">
            <flux:navlist variant="outline" class="w-full">
                <flux:button variant="ghost" class="flex my-2">
                    <flux:avatar src="https://unavatar.io/x/calebporzio" class="mx-auto" wire:navigate />
                    <flux:navlist.item href="{{ route('profile') }}" class="text-black!">
                        <div class="text-base leading-6 font-normal">{{ auth('admin')->user()->nama }}</div>
                        <div class="text-xs leading-4 font-medium">{{ auth('admin')->user()->nip }}</div>
                    </flux:navlist.item>
                </flux:button>
            </flux:navlist>

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:button type="submit" variant="danger" class="w-full rounded-t-none! hover:cursor-pointer"
                    icon="arrow-right-start-on-rectangle">
                    {{ __('Log Out') }}
                </flux:button>
            </form>
        </flux:menu>
    </flux:dropdown>
</flux:sidebar>
