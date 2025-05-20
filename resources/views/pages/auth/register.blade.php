<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6 pt-11">
    <div class="bg-white shadow-lg flex flex-col rounded-md p-7">
        <h1 class="text-black font-black text-center text-3xl">DAFTAR</h1>

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form wire:submit="register" class="flex flex-col gap-4 pt-8">
            <!-- NIM -->
            <flux:field>
                <flux:label class="text-black!">NIM</flux:label>
                <flux:input wire:model="nim" type="text" required autofocus autocomplete="nim"
                    placeholder="Masukkan NIM anda" class:input="text-black! rounded-xl border-magnet-def-grey-400!" />
                <flux:error name="nim" />
            </flux:field>

            <!-- Nama -->
            <flux:field>
                <flux:label class="text-black!">Nama Lengkap</flux:label>
                <flux:input wire:model="name" type="text" required autofocus autocomplete="name"
                    placeholder="Nama Lengkap" class:input="text-black! rounded-xl border-magnet-def-grey-400!" />
                <flux:error name="name" />
            </flux:field>
            <flux:field>
                <flux:label class="text-black!">Jurusan</flux:label>
                <flux:input wire:model="jurusan" type="text" readonly value="Teknologi Informasi"
                    class:input="text-black! rounded-xl border-magnet-def-grey-400!" />
                <flux:error name="jurusan" />
            </flux:field>

            <flux:field>
                <flux:label class="text-black!">Program Studi</flux:label>
                <flux:input.group class="rounded-xl border-magnet-def-grey-400!">
                    <flux:select wire:model="prodi" class:select="text-black!">
                        <flux:select.option value="Teknik Informatika">D4 Teknik Informatika</flux:select.option>
                        <flux:select.option value="Sistem Informasi">D4 Sistem Informasi Bisnis</flux:select.option>
                        <flux:select.option value="Pengembangan Perangkat Lunak Situs">D2 Pengembangan Perangkat Lunak
                            Situs</flux:select.option>
                    </flux:select>
                </flux:input.group>
                <flux:error name="prodi" />
            </flux:field>


            <flux:field>
                <flux:label class="text-black!">Jenis Kelamin</flux:label>
                <flux:input.group>
                    <flux:select wire:model="jenis_kelamin"
                        class:input="text-black! rounded-xl border-magnet-def-grey-400!">
                        <flux:select.option value="Laki-laki">Laki-laki</flux:select.option>
                        <flux:select.option value="Perempuan">Perempuan</flux:select.option>
                    </flux:select>
                </flux:input.group>
                <flux:error name="jenis_kelamin" />
            </flux:field>

            <!-- Password -->
            <flux:field>
                <flux:label class="text-black!">Password</flux:label>
                <flux:input wire:model="password" type="password" required autocomplete="new-password"
                    placeholder="Password" class:input="text-black! rounded-xl border-magnet-def-grey-400!" viewable />
                <flux:description class="text-xs text-magnet-def-grey-500! mt-0!">Kata sandi minimal 8 karakter,
                    kombinasikan huruf besar, kecil, angka, dan simbol demi keamanan terbaik.</flux:description>
                <flux:error name="password" />
            </flux:field>

            <!-- Konfirmasi Password -->
            <flux:field>
                <flux:label class="text-black!">Konfirmasi Password</flux:label>
                <flux:input wire:model="password_confirmation" type="password" required autocomplete="new-password"
                    placeholder="Konfirmasi password" class:input="text-black! rounded-xl border-magnet-def-grey-400!"
                    viewable />
                <flux:error name="password_confirmation" />
            </flux:field>
            <div class="flex items-center justify-end my-1">
                <flux:button type="submit" variant="primary" class="w-full bg-magnet-sky-teal text-white">
                    {{ __('Daftar') }}
                </flux:button>
            </div>
        </form>

    </div>

    <!-- Session Status -->
</div>