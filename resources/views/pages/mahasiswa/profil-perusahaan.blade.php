<x-layouts.user.main user="mahasiswa">
    <h2 class="text-[18px] font-extrabold leading-6 text-black w-[570.126px] flex-shrink-0 font-['Inter']">
        Profil Perusahaan
    </h2>
    <div>
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center gap-4">
                <img src="{{ asset('logo-perusahaan.png') }}" alt="Logo Perusahaan" class="w-16 h-16 object-contain">
                <div>
                    <h2 class="text-xl font-bold">PT Mencari Cinta Sejati</h2>
                    <div class="flex items-center text-sm text-gray-600">
                        <flux:icon.map-pin class="mr-1 size-4" />
                        <p>793 Chelsie Creek Apt. 841Ettieton, IN 85923-3183</p>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <flux:icon.building class="mr-1 size-4" />
                        <p>Software Consultant</p>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-4 mt-4">
                <div class="flex items-center text-sm text-gray-600 w-full justify-center">
                    <flux:icon.handshake class="mr-1 size-5" />
                    <p>Mitra</p>
                </div>
                <div class="flex items-center text-sm text-gray-600 w-full justify-center">
                    <flux:icon.star class="mr-1 size-5" />
                    <p>4.3 | Total penilaian : 69</p>
                </div>
                <div class="flex items-center text-sm text-gray-600 w-full justify-center">
                    <flux:icon.globe class="mr-1 size-5" />
                    <a href="www.google.com">www.pecel.co.id</a>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6 space-y-4 mt-3">
            <h3 class="text-lg font-semibold">Tentang Kami</h3>
            <div class="text-black text-md mt-4">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut
                    labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                    laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                    voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat
                    cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

                    Curabitur pretium tincidunt lacus. Nulla gravida orci a odio. Nullam varius, turpis et
                    commodo pharetra, est eros bibendum elit, nec luctus magna felis sollicitudin mauris.
                    Integer in mauris eu nibh euismod gravida. Duis ac tellus et risus auctor mattis. Vestibulum
                    eu odio at massa consectetur varius. Vivamus convallis mauris id sapien egestas blandit.
                    Nunc in sapien eget nibh malesuada aliquet. Proin at elit eu orci interdum tempus. Aenean id
                    risus id mi volutpat eleifend. Fusce vel justo non dolor scelerisque accumsan.

                    Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis
                    egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec
                    eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat
                    eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi,
                    condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt
                    condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in
                    turpis pulvinar facilisis. Ut felis.

                    Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna
                    eros eu erat. Aliquam erat volutpat. Nam dui mi, gravida at, lacinia vitae, commodo a,
                    nulla. In posuere felis sed lacus. Ut enim ad minim veniam, quis nostrud exercitation
                    ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
        </div>
    </div>
    </div>
</x-layouts.user.main>
