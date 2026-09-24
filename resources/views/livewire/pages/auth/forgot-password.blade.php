<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold tracking-tight">Atur ulang kata sandi</h1>
        <p class="mt-1.5 text-sm text-muted">Masukkan email Anda dan kami akan mengirimkan tautan untuk membuat kata sandi baru.</p>
    </div>

    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="space-y-5">
        {{-- Email --}}
        <x-be.field label="Email" for="email">
            <x-text-input wire:model="email" id="email" type="email" name="email" required autofocus placeholder="nama@gkkdbali.org" />
            <x-input-error :messages="$errors->get('email')" />
        </x-be.field>

        <x-primary-button>
            Kirim tautan reset
        </x-primary-button>

        <p class="text-center text-sm text-muted">
            Ingat kata sandi Anda?
            <a href="{{ route('login') }}" wire:navigate class="font-medium text-accent transition-colors hover:text-accent-strong">
                Masuk
            </a>
        </p>
    </form>
</div>
