<?php

use App\Models\Admin;
use App\Models\DosenPembimbing as Dosen;
use App\Models\Mahasiswa;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string')]
    public string $username = ''; // bisa nim, nidn, atau nip

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    public function login(): void
    {
        $this->validate();
        $this->ensureIsNotRateLimited();

        $user = null;
        $role = null;

        // Cek dari Mahasiswa
        $mahasiswa = Mahasiswa::where('nim', $this->username)->first();
        if ($mahasiswa && Hash::check($this->password, $mahasiswa->password)) {
            $user = $mahasiswa;
            $role = 'mahasiswa';
        }

        // Cek dari Dosen jika belum ditemukan
        if (!$user) {
            $dosen = Dosen::where('nidn', $this->username)->first();
            if ($dosen && Hash::check($this->password, $dosen->password)) {
                $user = $dosen;
                $role = 'dosen';
            }
        }

        // Cek dari Admin jika belum ditemukan
        if (!$user) {
            $admin = Admin::where('nip', $this->username)->first();
            if ($admin && Hash::check($this->password, $admin->password)) {
                $user = $admin;
                $role = 'admin';
            }
        }

        if (!$user) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'username' => 'NIM / NIDN / NIP atau password salah.',
            ]);
        }

        // Simpan informasi user dan role dalam session
        Session::put('user_id', $user->id);
        Session::put('user_role', $role);
        Session::put('user_data', [
            'id' => $user->id,
            'nama' => $user->nama,
            'role' => $role,
            'identifier' => $role === 'mahasiswa' ? $user->nim : ($role === 'dosen' ? $user->nidn : $user->nip),
        ]);

        // Untuk kompatibilitas dengan Laravel Auth (opsional)
        // Anda bisa membuat guard khusus atau menggunakan session saja
        Auth::loginUsingId($user->id, $this->remember);

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        // Redirect berdasarkan role
        $redirectUrl = match ($role) {
            'mahasiswa' => route('mahasiswa.dashboard'),
            'dosen' => route('dosen.dashboard'),
            'admin' => route('admin.dashboard'),
            default => route('dashboard'),
        };

        $this->redirect($redirectUrl, navigate: true);
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'username' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->username) . '|' . request()->ip());
    }
};
?>

<div class="flex flex-col gap-6 ">
    <div class="bg-white shadow-lg flex flex-col rounded-md p-6">
        <h1 class="text-black font-black text-center text-xl">Masuk</h1>
        <form wire:submit="login" class="flex flex-col pt-9">
            <flux:field>
                <flux:label class="text-black!">NIM/NIP/NIDN</flux:label>
                <flux:input wire:model="username" class="border-2 border-magnet-def-grey-400! rounded-xl text-black!"
                    class:input="text-black!" type="text" placeholder="Masukkan NIM/NIP/NIDN anda" required />
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
                <flux:link class="text-magnet-sky-teal hover:underline" :href="route('register')" wire:navigate>
                    {{ __('Daftar di sini sekarang') }}</flux:link>
            </div>
        @endif
    </div>

</div>
