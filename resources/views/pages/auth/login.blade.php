<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

use function Livewire\Volt\{layout, rules, state, protect};

layout('components.layouts.auth');

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

$login = function () : void {
    $this->validate();
    $this->ensureIsNotRateLimited();

    $role = null;

    if (Auth::guard('mahasiswa')->attempt([
        'nim' => $this->userID,
        'password' => $this->password,
    ])) {
        $role = 'mahasiswa';
    } else if (Auth::guard('dosen')->attempt([
        'nidn' => $this->userID,
        'password' => $this->password,
    ])) {
        $role = 'dosen';
    } else if (Auth::guard('admin')->attempt([
        'nip' => $this->userID,
        'password' => $this->password,
    ])) {
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

$ensureIsNotRateLimited = protect(function () : void {
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

$throttleKey = protect(function () : string {
    return Str::transliterate(Str::lower($this->userID) . '|' . request()->ip());
});

?>

<div class="flex flex-col gap-6 ">
    <div class="bg-white shadow-lg flex flex-col rounded-md p-6">
        <h1 class="text-black font-black text-center text-xl">Masuk</h1>
        <form wire:submit="login" class="flex flex-col pt-9">
            <flux:field>
                <flux:label class="text-black!">NIM/NIP/NIDN</flux:label>
                <flux:input wire:model="userID" class="border-2 border-magnet-def-grey-400! rounded-xl text-black!"
                    class:input="text-black!" type="text" placeholder="Masukkan NIM/NIP/NIDN anda" required />
                <flux:error name="userID" />
                <p class="text-xs text-magnet-def-grey-500">
                    Masukkan NIM, NIP, atau NIDN sesuai dengan jenis pengguna anda
                </p>
            </flux:field>
            <flux:field class="pt-4">
                <flux:label class="text-black!">Password</flux:label>
                <flux:input wire:model="password" class="border-2 border-magnet-def-grey-400 rounded-xl"
                    class:input="text-black!" type="password" placeholder="Masukkan password anda" required />
                <flux:error name="password" />
            </flux:field>
            <flux:link class="text-sm text-end my-3 text-magnet-sky-teal" href="#">Lupa Password?</flux:link>
            <flux:button type="submit" class="w-full bg-magnet-sky-teal! mb-4 border-0 text-white!">Masuk</flux:button>

        </form>
        @if (Route::has('register'))
            <div class="space-x-1 rtl:space-x-reverse text-center text-sm ">
                <span class="text-black">{{ __('Belum punya akun ?') }}</span>
                <flux:link class="text-magnet-sky-teal hover:underline" :href="route('register')" wire:navigate>
                    {{ __('Daftar di sini sekarang') }}</flux:link>
            </div>
        @endif
    </div>

</div>
