<?php

use function Livewire\Volt\{layout, rules, state};
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Mahasiswa;

layout('components.layouts.guest.with-navbar');

state([
    'nim' => null,
    'nama' => null,
    'email' => null,
    'jurusan' => 'Teknologi Informasi',
    'program_studi',
    'angkatan' => null,
    'jenis_kelamin' => null,
    'tanggal_lahir' => null,
    'alamat' => null,
    'password' => null,
    'password_confirmation' => null,
]);

rules([
    'password' => ['required', 'string', 'confirmed', Password::default()],
])->messages([
            'nim.required' => 'NIM tidak boleh kosong.',
            'nim.min' => 'NIM/NIP/NIDN harus terdiri dari minimal 10 karakter.',
            'nim.regex' => 'NIM/NIP/NIDN hanya boleh terdiri dari angka.',
            'password.required' => 'Password tidak boleh kosong.',
            'password.min' => 'Password harus terdiri dari minimal 8 karakter.',
        ]);

$register = function (): void {
    event(
        new Registered(
            ($mahasiswa = Mahasiswa::create([
                'nama' => $this->nama,
                'nim' => $this->nim,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'jurusan' => $this->jurusan,
                'program_studi' => $this->program_studi,
                'angkatan' => $this->angkatan,
                'jenis_kelamin' => $this->jenis_kelamin,
                'tanggal_lahir' => $this->tanggal_lahir,
                'alamat' => $this->alamat,
            ])),
        ),
    );

    Auth::guard('mahasiswa')->login($mahasiswa);

    $this->redirectIntended(route('mahasiswa.persiapan-preferensi', absolute: false), navigate: true);
};

?>

<div class="flex flex-col gap-4 sm:gap-6 w-full h-fit justify-center items-center p-4 sm:p-8 lg:p-14">
    <div class="bg-white shadow-lg flex flex-col rounded-md p-4 sm:p-6 lg:p-7 w-full max-w-sm sm:max-w-lg lg:max-w-2xl">
        <h1 class="text-black font-black text-center text-xl sm:text-2xl lg:text-3xl mb-2 sm:mb-4">DAFTAR</h1>

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form wire:submit="register" class="flex flex-col gap-3 sm:gap-4 pt-4 sm:pt-6 lg:pt-8">
            <!-- Grid layout for larger screens -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 sm:gap-4">
                <flux:field>
                    <flux:label class="text-sm sm:text-base">NIM</flux:label>
                    <flux:input wire:model="nim" type="text" required autofocus autocomplete="nim"
                        placeholder="Masukkan NIM anda" class="text-sm sm:text-base" />
                    <flux:error name="nim" />
                </flux:field>

                <flux:field>
                    <flux:label class="text-sm sm:text-base">Nama Lengkap</flux:label>
                    <flux:input wire:model="nama" type="text" required autofocus autocomplete="nama"
                        placeholder="Nama Lengkap" class="text-sm sm:text-base" />
                    <flux:error name="nama" />
                </flux:field>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 sm:gap-4">
                <flux:field>
                    <flux:label class="text-sm sm:text-base">Email</flux:label>
                    <flux:input wire:model="email" type="text" required autofocus autocomplete="email"
                        placeholder="Email" class="text-sm sm:text-base" />
                    <flux:error name="email" />
                </flux:field>

                <flux:field>
                    <flux:label class="text-sm sm:text-base">Jurusan</flux:label>
                    <flux:input wire:model="jurusan" type="text" value="Teknologi Informasi" placeholder="Jurusan"
                        disabled class="text-sm sm:text-base" />
                    <flux:error name="jurusan" />
                </flux:field>
            </div>

            <flux:field>
                <flux:label class="text-sm sm:text-base">Program Studi</flux:label>
                <flux:select wire:model.live="program_studi" placeholder="Pilih program studi anda"
                    class="text-sm sm:text-base">
                    <flux:select.option value="D4 Teknik Informatika">D4 Teknik Informatika</flux:select.option>
                    <flux:select.option value="D4 Sistem Informasi Bisnis">D4 Sistem Informasi Bisnis
                    </flux:select.option>
                    <flux:select.option value="D2 Pengembangan Piranti Lunak Situs">D2 Pengembangan Piranti Lunak Situs
                    </flux:select.option>
                </flux:select>
                <flux:error name="program_studi" />
            </flux:field>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                <flux:field>
                    <flux:label class="text-sm sm:text-base">Angkatan</flux:label>
                    <flux:input wire:model="angkatan" type="text" required autofocus autocomplete="nama"
                        placeholder="Angkatan" class="text-sm sm:text-base" />
                    <flux:error name="angkatan" />
                </flux:field>

                <flux:field>
                    <flux:label class="text-sm sm:text-base">Jenis Kelamin</flux:label>
                    <flux:select placeholder="Jenis kelamin" wire:model="jenis_kelamin" class="text-sm sm:text-base">
                        <flux:select.option value="L">Laki-laki</flux:select.option>
                        <flux:select.option value="P">Perempuan</flux:select.option>
                    </flux:select>
                    <flux:error name="jenis_kelamin" />
                </flux:field>

                <flux:field>
                    <flux:input label="Tanggal lahir" type="date" max="2999-12-31" wire:model="tanggal_lahir"
                        class="text-sm sm:text-base" />
                </flux:field>
            </div>

            <flux:field>
                <flux:textarea wire:model="alamat" label="Alamat" placeholder="Domisili asal anda"
                    class="text-sm sm:text-base min-h-[80px] sm:min-h-[100px]" />
                <flux:error name="alamat" />
            </flux:field>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 sm:gap-4">
                <flux:field>
                    <flux:label class="text-sm sm:text-base">Password</flux:label>
                    <flux:input wire:model="password" type="password" required autocomplete="new-password"
                        placeholder="Password" viewable class="text-sm sm:text-base" />
                    <flux:description class="text-xs sm:text-sm text-gray-500 mt-1">
                        Kata sandi minimal 8 karakter, kombinasikan huruf besar, kecil, angka, dan simbol demi keamanan
                        terbaik.
                    </flux:description>
                    <flux:error name="password" />
                </flux:field>

                <flux:field>
                    <flux:label class="text-sm sm:text-base">Konfirmasi Password</flux:label>
                    <flux:input wire:model="password_confirmation" type="password" required autocomplete="new-password"
                        placeholder="Konfirmasi password" viewable class="text-sm sm:text-base" />
                    <flux:error name="password_confirmation" />
                </flux:field>
            </div>

            <div class="flex items-center justify-end mt-2 sm:mt-4">
                <flux:button type="submit" variant="primary"
                    class="w-full sm:w-auto min-w-[120px] bg-magnet-sky-teal text-white text-sm sm:text-base py-2 sm:py-3 px-6 sm:px-8">
                    {{ __('Daftar') }}
                </flux:button>
            </div>
        </form>
    </div>
</div>