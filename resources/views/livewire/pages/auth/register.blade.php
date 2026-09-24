<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold tracking-tight">Buat akun baru</h1>
        <p class="mt-1.5 text-sm text-muted">Daftar untuk mulai mengelola pelayanan GKKD Denpasar.</p>
    </div>

    <form wire:submit="register" class="space-y-5">
        {{-- Name --}}
        <x-be.field label="Nama Lengkap" for="name">
            <x-text-input wire:model="name" id="name" type="text" name="name" required autofocus autocomplete="name" placeholder="Nama lengkap Anda" />
            <x-input-error :messages="$errors->get('name')" />
        </x-be.field>

        {{-- Email --}}
        <x-be.field label="Email" for="email">
            <x-text-input wire:model="email" id="email" type="email" name="email" required autocomplete="username" placeholder="nama@gkkdbali.org" />
            <x-input-error :messages="$errors->get('email')" />
        </x-be.field>

        {{-- Password --}}
        <x-be.field label="Kata Sandi" for="password">
            <x-input-password wire:model="password" id="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" />
        </x-be.field>

        {{-- Confirm Password --}}
        <x-be.field label="Konfirmasi Kata Sandi" for="password_confirmation">
            <x-input-password wire:model="password_confirmation" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </x-be.field>

        <x-primary-button>
            Daftar
        </x-primary-button>

        {{-- Divider --}}
        <div class="flex items-center gap-4">
            <span class="h-px flex-1 bg-line"></span>
            <span class="text-xs font-medium text-muted">atau</span>
            <span class="h-px flex-1 bg-line"></span>
        </div>

        {{-- ponytail: tombol UI-only. Arahkan ke route OAuth (Socialite) saat kredensial tersedia. --}}
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <a
                href="#"
                class="flex items-center justify-center gap-2.5 rounded-xl border border-line bg-surface px-4 py-2.5 text-sm font-medium text-ink transition-colors hover:border-line-strong hover:bg-ink/5 focus:outline-none focus-visible:ring-2 focus-visible:ring-accent focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
            >
                <i class="fa-brands fa-facebook text-base text-[#1877f2]"></i>
                Facebook
            </a>
            <a
                href="#"
                class="flex items-center justify-center gap-2.5 rounded-xl border border-line bg-surface px-4 py-2.5 text-sm font-medium text-ink transition-colors hover:border-line-strong hover:bg-ink/5 focus:outline-none focus-visible:ring-2 focus-visible:ring-accent focus-visible:ring-offset-2 focus-visible:ring-offset-surface"
            >
                <i class="fa-brands fa-google text-base"></i>
                Google
            </a>
        </div>

        <p class="text-center text-sm text-muted">
            Sudah punya akun?
            <a href="{{ route('login') }}" wire:navigate class="font-medium text-accent transition-colors hover:text-accent-strong">
                Masuk
            </a>
        </p>
    </form>
</div>
