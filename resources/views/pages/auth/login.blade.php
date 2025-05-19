<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}; ?>

<div class="flex flex-col gap-6 ">
    <div class="bg-white shadow-lg flex flex-col rounded-md p-6">
        <h1 class="text-black font-black text-center text-xl">Masuk</h1>
        <form wire:submit="login" class="flex flex-col pt-9">
            <flux:field>
                <flux:label class="text-black!">NIM/NIP/NIDN</flux:label>
                <flux:input wire:model="email" class="border-2 border-magnet-def-grey-400! rounded-xl text-black!"
                    class:input="text-black!" type="email" placeholder="Masukkan NIM/NIP/NIDN anda" required />
                <flux:error name="username" />
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
                <flux:link class="text-magnet-sky-teal hover:underline" :href="route('register')" wire:navigate>{{ __('Daftar di sini sekarang') }}</flux:link>
            </div>
        @endif
    </div>

</div>