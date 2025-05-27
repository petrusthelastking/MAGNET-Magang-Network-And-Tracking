<?php

use function Livewire\Volt\{state};
use App\Helpers\UserAuthenticationHelper;

state([
    'userRole' => UserAuthenticationHelper::getUserRole()
]);

?>

<flux:header sticky class="bg-white lg:bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">

    <flux:navbar class="lg:hidden w-full">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        <flux:spacer />
        <flux:dropdown position="top" align="start">
            <flux:profile avatar="https://unavatar.io/x/calebporzio" name="{{ auth($userRole)->user()->nama }}" />

            <flux:menu class="p-0!">
                <flux:navlist variant="outline" class="w-full">
                    <flux:button variant="ghost" class="flex my-2">
                        <flux:avatar src="https://unavatar.io/x/calebporzio" class="mx-auto" />
                        <flux:navlist.item href="{{ route('profile') }}" class="text-black!">
                            <div class="text-base leading-6 font-normal">{{ auth($userRole)->user()->nama }}</div>
                            <div class="text-xs leading-4 font-medium">{{ auth($userRole)->user()->nip }}</div>
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
    </flux:navbar>
    <flux:navbar scrollable class="flex! justify-end! w-full">
        <div class="flex gap-5 text-magnet-sky-teal">
            <a href="#">
                <flux:icon.headset />
            </a>
            <a href="#">
                <flux:icon.bookmark />
            </a>
            <a href="#">
                <flux:icon.bell />
            </a>
        </div>
    </flux:navbar>
</flux:header>
