<flux:sidebar sticky stashable
    class="bg-zinc-50 dark:bg-zinc-900 border-r rtl:border-r-0 rtl:border-l border-zinc-200 dark:border-zinc-700">

    <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

    <a href="{{ route('guest.landing-page') }}" wire:navigate>
        <h1 class="text-3xl font-black ps-2 mx-4 text-center text-magnet-sky-teal">MAGNET</h1>
    </a>

    <flux:navlist variant="outline">
        <flux:navlist.item
            icon="home"
            href="{{ route('dashboard') }}"
            :current="request()->is('dashboard')"
            wire:navigate>
            Dashboard
        </flux:navlist.item>

        <flux:navlist.item
            icon="flask-conical"
            href="{{ route('mahasiswa.pengajuan-magang') }}"
            :current="request()->is('pengajuan-magang')"
            wire:navigate>
            Pengajuan Magang
        </flux:navlist.item>

        <flux:navlist.item
            icon="message-square-more"
            href="{{ route('mahasiswa.konsul-dospem') }}"
            :current="request()->is('konsul-dospem')"
            class="whitespace-normal break-words"
            wire:navigate>
            Konsultasi Dosen <br>
            Pembimbing
        </flux:navlist.item>

        <flux:navlist.item
            icon="battery-medium"
            href="{{ route('mahasiswa.pembaruan-status') }}"
            :current="request()->is('pembaruan-status')"
            wire:navigate>
            Pembaruan Status
        </flux:navlist.item>

        <flux:navlist.item
            icon="file-chart-column-increasing"
            href="{{ route('mahasiswa.log-mahasiswa') }}"
            :current="request()->is('log-mahasiswa')"
            wire:navigate>
            Log Magang
        </flux:navlist.item>

        <flux:navlist.item
            icon="message-circle"
            href="{{ route('mahasiswa.saran-dari-dosen') }}"
            :current="request()->is('saran-dari-dosen')"
            wire:navigate>
            Saran dari<br>
            Dosen
        </flux:navlist.item>
        <flux:navlist.item
            icon="history"
            href="{{ route('mahasiswa.riwayat-rekomendasi') }}"
            :current="request()->is('riwayat-rekomendasi')"
            wire:navigate>
            Riwayat Rekomendasi <br>
            Magang
        </flux:navlist.item>
    </flux:navlist>

    <flux:spacer />

    <flux:dropdown position="top" align="start" class="max-lg:hidden">
        <flux:profile avatar="https://unavatar.io/x/calebporzio" name="{{ auth('mahasiswa')->user()->nama }}" />

        <flux:menu class="p-0!">
            <flux:navlist variant="outline" class="w-full">
                <flux:button variant="ghost" class="flex my-2">
                    <flux:avatar src="https://unavatar.io/x/calebporzio" class="mx-auto" />
                    <flux:navlist.item href="{{ route('profile') }}" class="text-black!" wire:navigate>
                        <div class="text-base leading-6 font-normal">{{ auth('mahasiswa')->user()->nama }}</div>
                        <div class="text-xs leading-4 font-medium">{{ auth('mahasiswa')->user()->nim }}</div>
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
