<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

use function Livewire\Volt\{layout, rules, state, protect};

layout('components.layouts.guest.with-navbar');

state([
    'userID' => '',
    'password' => '',
    'remember' => false,
]);

rules([
    'userID' => 'required|string|min:10|regex:/^[0-9]+$/',
    'password' => 'required|string|min:8',
])->messages([
            'userID.required' => 'NIM/NIP/NIDN tidak boleh kosong.',
            'userID.min' => 'NIM/NIP/NIDN harus terdiri dari minimal 10 karakter.',
            'userID.regex' => 'NIM/NIP/NIDN hanya boleh terdiri dari angka.',
            'password.required' => 'Password tidak boleh kosong.',
            'password.min' => 'Password harus terdiri dari minimal 8 karakter.',
        ]);

$login = function (): void {
    $this->validate();
    $this->ensureIsNotRateLimited();

    $role = null;

    if (
        Auth::guard('mahasiswa')->attempt([
            'nim' => $this->userID,
            'password' => $this->password,
        ])
    ) {
        $role = 'mahasiswa';
    } elseif (
        Auth::guard('dosen')->attempt([
            'nidn' => $this->userID,
            'password' => $this->password,
        ])
    ) {
        $role = 'dosen';
    } elseif (
        Auth::guard('admin')->attempt([
            'nip' => $this->userID,
            'password' => $this->password,
        ])
    ) {
        $role = 'admin';
    }

    if (!$role) {
        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'userID' => 'NIM / NIDN / NIP atau password salah.',
        ]);
    }

    RateLimiter::clear($this->throttleKey());
    Session::regenerate();

    redirect(route('dashboard'));
};

$ensureIsNotRateLimited = protect(function (): void {
    if (!RateLimiter::tooManyAttempts($this->throttleKey(), 3)) {
        return;
    }

    event(new Lockout(request()));

    $seconds = RateLimiter::availableIn($this->throttleKey());

    throw ValidationException::withMessages([
        'userID' => __('auth.throttle', [
            'seconds' => $seconds,
            'minutes' => ceil($seconds / 60),
        ]),
    ]);
});

$throttleKey = protect(function (): string {
    return Str::transliterate(Str::lower($this->userID) . '|' . request()->ip());
});

?>
<div class=" py-4 px-4">
    <div class="max-w-6xl mx-auto">

        <div class="text-center">
            <div
                class="inline-flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-r from-magnet-sky-teal to-blue-700 rounded-full mb-3 shadow-lg">
                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Masuk Akun</h1>
            <p class="text-gray-600 text-sm sm:text-lg">Akses platform pembelajaran digital Anda</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 w-full max-w-6xl mt-4">
            <div class="lg:col-span-4">
                <div class="bg-white shadow-lg flex flex-col rounded-xl overflow-hidden h-full">
                    <div class="bg-gradient-to-r from-magnet-sky-teal to-blue-700 p-4 sm:p-5">
                        <h2 class="text-lg sm:text-xl font-bold text-white mb-1">Selamat Datang</h2>
                        <p class="text-blue-100 text-sm sm:text-base">Masukkan kredensial Anda untuk melanjutkan</p>
                    </div>

                    <div class="p-4 sm:p-6 flex-grow">
                        <form wire:submit="login" class="space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center mb-3">
                                        <div
                                            class="w-5 h-5 bg-magnet-sky-teal rounded-full flex items-center justify-center mr-2">
                                            <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-sm sm:text-base font-semibold text-gray-900">Identitas Pengguna
                                        </h3>
                                    </div>

                                    <flux:field>
                                        <flux:label class="text-black! text-sm font-medium">
                                            NIM/NIP/NIDN <span class="text-red-500">*</span>
                                        </flux:label>
                                        <flux:input wire:model="userID"
                                            class="border-2 border-magnet-def-grey-400! rounded-lg text-black! text-sm"
                                            class:input="text-black!" type="text"
                                            placeholder="Masukkan NIM/NIP/NIDN anda" required />
                                        <flux:error name="userID" />
                                        <p class="text-xs text-magnet-def-grey-500 mt-2">
                                            Masukkan NIM, NIP, atau NIDN sesuai dengan jenis pengguna anda
                                        </p>
                                    </flux:field>
                                </div>

                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center mb-3">
                                        <div
                                            class="w-5 h-5 bg-red-600 rounded-full flex items-center justify-center mr-2">
                                            <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-sm sm:text-base font-semibold text-gray-900">Keamanan</h3>
                                    </div>

                                    <flux:field>
                                        <flux:label class="text-black! text-sm font-medium">
                                            Password <span class="text-red-500">*</span>
                                        </flux:label>
                                        <flux:input wire:model="password"
                                            class="border-2 border-magnet-def-grey-400! rounded-lg text-sm"
                                            class:input="text-black!" type="password"
                                            placeholder="Masukkan password anda" required
                                            autocomplete="current-password" viewable />
                                        <flux:error name="password" />
                                    </flux:field>

                                    <div class="text-right mt-2">
                                        <flux:link
                                            class="text-sm text-magnet-sky-teal hover:text-blue-800 hover:underline font-medium"
                                            href="#">
                                            Lupa Password?
                                        </flux:link>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-gray-200">
                                <flux:button type="submit"
                                    class="w-full bg-magnet-sky-teal! hover:bg-blue-700! mb-3 border-0 text-white! py-3 text-sm sm:text-base font-semibold rounded-lg shadow-lg transform transition-all duration-200 hover:scale-105">
                                    <span class="flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                            </path>
                                        </svg>
                                        <span>Masuk</span>
                                    </span>
                                </flux:button>

                                @if (Route::has('register'))
                                    <div class="space-x-1 rtl:space-x-reverse text-center text-sm">
                                        <span class="text-gray-600">Belum punya akun ?</span>
                                        <flux:link
                                            class="text-magnet-sky-teal hover:text-blue-800 font-medium hover:underline"
                                            :href="route('register')" wire:navigate>
                                            Daftar di sini sekarang
                                        </flux:link>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div class="bg-white rounded-lg shadow-md p-4 sm:p-5 h-full">
                    <h3 class="font-semibold text-gray-900 mb-4 text-center text-sm sm:text-base">Jenis Pengguna</h3>

                    <div class="flex items-center p-3 bg-blue-50 rounded-lg mb-3">
                        <div
                            class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-xs sm:text-sm">Mahasiswa</h4>
                            <p class="text-xs text-gray-600">Gunakan NIM untuk masuk</p>
                        </div>
                    </div>

                    <div class="flex items-center p-3 bg-green-50 rounded-lg mb-3">
                        <div
                            class="w-8 h-8 sm:w-10 sm:h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-xs sm:text-sm">Dosen</h4>
                            <p class="text-xs text-gray-600">Gunakan NIDN untuk masuk</p>
                        </div>
                    </div>

                    <div class="flex items-center p-3 bg-purple-50 rounded-lg">
                        <div
                            class="w-8 h-8 sm:w-10 sm:h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-xs sm:text-sm">Admin</h4>
                            <p class="text-xs text-gray-600">Gunakan NIP untuk masuk</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>