<flux:sidebar sticky stashable class="bg-zinc-50 border-r rtl:border-r-0 rtl:border-l border-zinc-200 ">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

    <a href="{{ route('guest.landing-page') }}" wire:navigate>
        <h1 class="text-3xl font-black ps-2 mx-4 text-center text-magnet-sky-teal">MAGNET</h1>
    </a>

    <flux:navlist variant="outline">
        <flux:navlist.item
            icon="home"
            href="{{ route('dashboard') }}" :current="request()->is('/dashboard')"
            wire:navigate>
            Dashboard
        </flux:navlist.item>

        <flux:navlist.item
            icon="user-round"
            href="{{ route('dosen.mahasiswa-bimbingan') }}"
            wire:navigate>
            Mahasiswa Bimbingan
        </flux:navlist.item>

        <flux:navlist.item
            icon="message-square-more"
            href="{{ route('dosen.komunikasi') }}"
            wire:navigate>
            Komunikasi
        </flux:navlist.item>

    </flux:navlist>

    <flux:spacer />

    <flux:dropdown position="top" align="start" class="max-lg:hidden">
        <flux:profile
            avatar="{{ auth('dosen')->user()->foto ? asset('foto_dosen/' . auth('dosen')->user()->foto) : asset('img/user/lecturer-man.png') }}"
            name="{{ auth('dosen')->user()->nama }}" />

        <flux:menu class="p-0!">
            <flux:navlist variant="outline" class="w-full">
                <flux:button variant="ghost" class="flex my-2">
                    <flux:avatar src="{{ auth('dosen')->user()->foto ? asset('foto_dosen/' . auth('dosen')->user()->foto) : asset('img/user/lecturer-man.png') }}" class="mx-auto" />
                    <flux:navlist.item href="{{ route('profile') }}" class="text-black!" wire:navigate>
                        <div class="text-base leading-6 font-normal">{{ auth('dosen')->user()->nama }}</div>
                        <div class="text-xs leading-4 font-medium">{{ auth('dosen')->user()->nidn }}</div>
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
