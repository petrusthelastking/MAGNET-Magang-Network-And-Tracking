<flux:sidebar stashable
    class="bg-[linear-gradient(180deg,_#276DA9_56.79%,_#0F2B43_113.18%)]! text-white! border-r rtl:border-r-0 rtl:border-l border-zinc-950 min-w-64">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

    <a href="{{ route('dashboard') }}" >
        <div class="flex items-center justify-center">
            <flux:icon.magnet />

            <H1 class="text-3xl font-black ps-2 mx-4 text-white">MAGNET</H1>
        </div>
    </a>

        <div class="flex justify-start min-w-min">
            <ul class="menu gap-y-3 w-full">
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ request()->is('/dashboard') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                </li>
    
                <li>
                    <details>
                        <summary>Kelola Data</summary>
                        <ul class="w-full">
                            <li>
                                <a href="{{ route('students-data') }}"
                                    class="{{ request()->is('/students-data') ? 'active' : '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Data Mahasiswa
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Data Dosen
                                </a>
                            </li>
                        </ul>
                    </details>
                </li>
    
                <li>
                    <details>
                        <summary>Magang</summary>
                        <ul class="w-full">
                            <li>
                                <a href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                    </svg>
                                    Pengajuan Magang
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    Tren Magang
                                </a>
                            </li>
                        </ul>
                    </details>
                </li>
    
                <li>
                    <details>
                        <summary>Laporan</summary>
                        <ul class="w-full">
                            <li>
                                <a href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Laporan Statistik Magang
                                </a>
                            </li>
                        </ul>
                    </details>
                </li>
    
                <li>
                    <details>
                        <summary>Sistem</summary>
                        <ul class="w-full">
                            <li>
                                <a href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Evaluasi Sistem Rekomendasi
                                </a>
                            </li>
                        </ul>
                    </details>
                </li>
            </ul>
        </div>
        
        <flux:spacer />

        <flux:navlist>
            <flux:navlist.item icon="cog-6-tooth" href="#">Settings</flux:navlist.item>
            <flux:navlist.item icon="information-circle" href="#">Help</flux:navlist.item>
        </flux:navlist>

        <flux:dropdown position="top" align="start" class="max-lg:hidden">
            <flux:profile avatar="https://fluxui.dev/img/demo/user.png" name="Olivia Martin" />

            <flux:menu>
                <flux:menu.item href="/profile" class="flex justify-start">
                    <div class="w-8 p-0">
                        <img src="https://fluxui.dev/img/demo/user.png" alt="" class="w-full">
                    </div>
                    <div class="flex flex-col ml-3">
                        <span>{{ auth()->user()->name }}</span>
                        <span class="text-xs">me@email.com</span>
                    </div>
                </flux:menu.item>

                <flux:menu.item icon="settings">Pengaturan</flux:menu.item>

                <flux:menu.separator />

                <flux:menu.item icon="arrow-right-start-on-rectangle" class="bg-red-700">Logout</flux:menu.item>
            </flux:menu>
        </flux:dropdown>
</flux:sidebar>

<flux:header class="lg:hidden">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
    <flux:spacer />
    <flux:dropdown position="top" alignt="start">
        <flux:profile avatar="https://fluxui.dev/img/demo/user.png" />
        <flux:menu>
            <flux:menu.radio.group>
                <flux:menu.radio checked>Olivia Martin</flux:menu.radio>
                <flux:menu.radio>Truly Delta</flux:menu.radio>
            </flux:menu.radio.group>
            <flux:menu.separator />
            <flux:menu.item icon="arrow-right-start-on-rectangle">Logout</flux:menu.item>
        </flux:menu>
    </flux:dropdown>

</flux:header>