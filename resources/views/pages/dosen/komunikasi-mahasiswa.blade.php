<x-layouts.user.main user="dosen">
    <flux:breadcrumbs class="mb-5">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('dosen.komunikasi') }}" class="text-black">Komunikasi
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <ul class="list bg-white rounded-box shadow-md">

        <li class="p-4 pb-2 text-xs opacity-60 tracking-wide">Komunikasi dengan Mahasiswa</li>

        <li class="list-row">
            <div>
                <img class="size-10 rounded-box" src="https://img.daisyui.com/images/profile/demo/1@94.webp" />
            </div>
            <div>
                <div>Ratih Saputri</div>
                <div class="text-xs uppercase font-semibold opacity-60">231010101010</div>
            </div>
            <flux:button icon="message-square-text" href="{{ route('dosen.komunikasi-mahasiswa') }}" />
        </li>

        <li class="list-row">
            <div>
                <img class="size-10 rounded-box" src="https://img.daisyui.com/images/profile/demo/4@94.webp" />
            </div>
            <div>
                <div>Ratih Saputri</div>
                <div class="text-xs uppercase font-semibold opacity-60">231010101010</div>
            </div>
            <flux:button icon="message-square-text" href="{{ route('dosen.komunikasi-mahasiswa') }}" />
        </li>

        <li class="list-row">
            <div>
                <img class="size-10 rounded-box" src="https://img.daisyui.com/images/profile/demo/3@94.webp" />
            </div>
            <div>
                <div>Ratih Saputri</div>
                <div class="text-xs uppercase font-semibold opacity-60">231010101010</div>
            </div>
            <flux:button icon="message-square-text" href="{{ route('dosen.komunikasi-mahasiswa') }}" />
        </li>
    </ul>
</x-layouts.user.main>
