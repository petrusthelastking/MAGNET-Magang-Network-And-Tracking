<flux:sidebar sticky stashable
    class="bg-zinc-50 dark:bg-zinc-900 border-r rtl:border-r-0 rtl:border-l border-zinc-200 dark:border-zinc-700">

    <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

    <a href="#">
        <h1 class="text-3xl font-black ps-2 mx-4 text-center text-[#219EBC]">MAGNET</h1>
    </a>

    {{-- GANTI navlist.item PEMBUNGKUS DENGAN navlist --}}
    <flux:navlist variant="outline">
        <flux:navlist.item icon="home" href="{{ route('mahasiswa.dashboard') }}"
            :current="request()->is('mahasiswa/dashboard')">
            Dashboard
        </flux:navlist.item>

        <flux:navlist.item icon="flask-conical" href="{{ route('mahasiswa.pengajuan-magang') }}"
            :current="request()->is('mahasiswa/pengajuan-magang')">
            Pengajuan Magang
        </flux:navlist.item>

        <flux:navlist.item icon="message-square-more" href="{{ route('mahasiswa.konsul-dospem') }}"
            :current="request()->is('mahasiswa/konsul-dospem')" class="whitespace-normal break-words">
            Konsultasi Dosen Pembimbing
        </flux:navlist.item>

        <flux:navlist.item icon="battery-medium" href="{{ route('mahasiswa.pembaruan-status') }}"
            :current="request()->is('mahasiswa/pembaruan-status')">
            Pembaruan Status
        </flux:navlist.item>

        <flux:navlist.item icon="file-chart-column-increasing" href="{{ route('mahasiswa.log-mahasiswa') }}"
            :current="request()->is('mahasiswa/log-mahasiswa')">
            Log Magang
        </flux:navlist.item>
    </flux:navlist>

    <flux:spacer />

    <flux:dropdown position="top" align="start" class="max-lg:hidden">
        <flux:profile avatar="https://unavatar.io/x/calebporzio" name="Olivia Martin" />

        <flux:menu>
            <flux:navlist variant="outline" class="w-full">
                <flux:avatar src="https://unavatar.io/x/calebporzio" class="mx-auto mb-1.5 " />
                <flux:navlist.item href="{{ route('mahasiswa.setting-profile') }}"
                    class="bg-cyan-300 hover:bg-blue-200 text-black! text-center! h-10!">
                    Olivia Martin
                </flux:navlist.item>
            </flux:navlist>

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:button type="submit" variant="danger" class="w-full h-10!" icon="arrow-right-start-on-rectangle">
                    {{ __('Log Out') }}
                </flux:button>
            </form>
        </flux:menu>
    </flux:dropdown>
</flux:sidebar>