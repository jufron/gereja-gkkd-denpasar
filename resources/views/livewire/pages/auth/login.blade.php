<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <x-auth-session-status class="mb-5" :status="session('status')" />

    <div class="mb-8">
        <h1 class="text-2xl font-bold tracking-tight">Selamat datang kembali</h1>
        <p class="mt-1.5 text-sm text-muted">Masuk untuk mengelola pelayanan GKKD Denpasar.</p>
    </div>

    <form wire:submit="login" class="space-y-5">
        {{-- Email --}}
        <x-be.field label="Email" for="email">
            <x-text-input wire:model="form.email" id="email" type="email" name="email" required autofocus autocomplete="username" placeholder="nama@gkkdbali.org" />
            <x-input-error :messages="$errors->get('form.email')" />
        </x-be.field>

        {{-- Password --}}
        <x-be.field label="Kata Sandi" for="password">
            <x-input-password wire:model="form.password" id="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('form.password')" />
        </x-be.field>

        {{-- Remember me --}}
        <div class="flex items-center justify-between">
            <label for="remember" class="inline-flex items-center gap-2 text-sm text-muted">
                <input
                    wire:model="form.remember"
                    id="remember"
                    type="checkbox"
                    class="h-4 w-4 rounded border-line-strong text-accent focus:ring-accent"
                    name="remember"
                >
                Ingat saya
            </label>

            @if (Route::has('password.request'))
                <a
                    href="{{ route('password.request') }}"
                    wire:navigate
                    class="text-sm font-medium text-accent transition-colors hover:text-accent-strong"
                >
                    Lupa kata sandi?
                </a>
            @endif
        </div>

        <x-primary-button>
            Masuk
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
            Belum punya akun?
            <a href="{{ route('register') }}" wire:navigate class="font-medium text-accent transition-colors hover:text-accent-strong">
                Daftar
            </a>
        </p>
    </form>
</div>
