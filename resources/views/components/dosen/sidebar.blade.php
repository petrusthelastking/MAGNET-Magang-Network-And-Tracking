<flux:sidebar sticky stashable class="bg-zinc-50 border-r rtl:border-r-0 rtl:border-l border-zinc-200 ">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

    <a href="#">
        <h1 class="text-3xl font-black ps-2 mx-4 text-center text-magnet-sky-teal">MAGNET</h1>
    </a>

    <flux:navlist variant="outline">
        <flux:navlist.item icon="home" href="{{ route('dosen.dashboard') }}" :current="request()->is('/dashboard')">
            Dashboard
        </flux:navlist.item>

    <flux:navlist.item icon="user-round" href="{{ route('dosen.mahasiswa-bimbingan') }}">
            Mahasiswa Bimbingan
        </flux:navlist.item>

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