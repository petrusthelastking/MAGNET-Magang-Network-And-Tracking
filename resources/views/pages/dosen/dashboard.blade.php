<div>
    <flux:breadcrumbs class="mb-5">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" icon="home" icon:variant="outline" />
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" class="text-black">Dashboard</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex justify-center">
                <div class="grid grid-cols-1 gap-6 w-full max-w-7xl">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Total Mahasiswa Bimbingan</p>
                                    <p class="text-xl font-semibold text-green-600 mt-2">10 Mahasiswa</p>
                                </div>
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-users text-green-600 text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Laporan Log Diakses</p>
                                    <p class="text-xl font-semibold text-blue-600 mt-2">7 dari 10</p>
                                </div>
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Feedback Diberikan</p>
                                    <p class="text-xl font-semibold text-purple-600 mt-2">5 Mahasiswa</p>
                                </div>
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-comment-dots text-purple-600 text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Status Profil</p>
                                    <p class="text-xl font-semibold text-yellow-600 mt-2">Lengkap</p>
                                </div>
                                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-user-cog text-yellow-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div>
        <div>
            <h1 class="text-base font-bold leading-6 text-black my-4">Daftar Mahasiswa Bimbingan</h1>
        </div>
        <div class="overflow-y-auto flex flex-col items-center mt-0 rounded-lg shadow bg-white ">
            <table class="table-auto w-full">
                <thead class="bg-white text-black">
                    <tr class="border-b">
                        <th class="text-center px-6 py-3">No</th>
                        <th class="text-left px-6 py-3">Nama Mahasiswa</th>
                        <th class="text-left px-6 py-3">Status Log</th>
                        <th class="text-left px-6 py-3">Feedback</th>
                        <th class="text-left px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white text-black">
                    @for ($i = 0; $i < 10; $i++)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3 text-center">{{ $i + 1 }}</td>
                            <td class="px-6 py-3">Ahmad Sukadani Setiawan</td>
                            <td class="px-6 py-3">Sudah dibaca</td>
                            <td class="px-6 py-3">Sudah diberikan</td>
                            <td class="px-6 py-3">
                                <flux:button class="bg-magnet-sky-teal! text-white! my-5"
                                    href="{{ route('dosen.detail-mahasiswa-bimbingan') }}">Lihat Detail
                                </flux:button>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        <div class="flex items-center justify-between w-full p-3">
            <div class="text-black mt-6">
                <p>Menampilkan 10 dari 1250 data</p>
            </div>
            <div class="flex mt-6">
                <flux:button icon="chevron-left" variant="ghost" />
                @for ($i = 0; $i < 5; $i++)
                    <flux:button variant="ghost">{{ $i + 1 }}</flux:button>
                @endfor
                <flux:button icon="chevron-right" variant="ghost" />
            </div>
            <div class="flex gap-3 items-center text-black mt-6">
                <p>Baris per halaman</p>
                <flux:select placeholder="10" class="w-20!">
                    <flux:select.option>10</flux:select.option>
                    <flux:select.option>25</flux:select.option>
                    <flux:select.option>50</flux:select.option>
                    <flux:select.option>100</flux:select.option>
                </flux:select>
            </div>
        </div>
    </div>
