<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $password = '';

    /**
     * Confirm the current user's password.
     */
    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('web')->validate([
            'email' => Auth::user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold tracking-tight">Konfirmasi kata sandi</h1>
        <p class="mt-1.5 text-sm text-muted">Ini adalah area aman. Konfirmasi kata sandi Anda untuk melanjutkan.</p>
    </div>

    <form wire:submit="confirmPassword" class="space-y-5">
        {{-- Password --}}
        <x-be.field label="Kata Sandi" for="password">
            <x-input-password wire:model="password" id="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" />
        </x-be.field>

        <x-primary-button>
            Konfirmasi
        </x-primary-button>
    </form>
</div>
