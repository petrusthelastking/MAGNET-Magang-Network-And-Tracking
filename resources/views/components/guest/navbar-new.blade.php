<div class="navbar px-5 py-0">
    <div class="navbar-start">
        <a href="/" class="text-white flex items-center gap-2">
            <flux:icon.ship-wheel />
            MAGNET
        </a>
    </div>
    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1 flex">
            <flux:button variant="ghost" class="text-white!" href="#petunjuk">Pedoman Magang</flux:button>
            <flux:button variant="ghost" class="text-white!" href="#kendala">FAQ</flux:button>
            <flux:button variant="ghost" class="text-white!" href="#about">Tentang Kami</flux:button>
        </ul>
    </div>
    <div class="navbar-end">

        <flux:button icon="brain-circuit" size="sm" class=" text-white rounded-full!" href="{{ route('pengembang') }}">Pengembang</flux:button>

        
    </div>
</div>