<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold tracking-tight">Verifikasi email</h1>
        <p class="mt-1.5 text-sm text-muted">
            Terima kasih telah mendaftar. Sebelum memulai, verifikasi alamat email Anda dengan mengeklik tautan yang baru saja kami kirim. Jika email tidak diterima, kami dengan senang hati mengirimkannya kembali.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-5 flex items-center gap-2 rounded-xl border border-success/25 bg-success-soft px-3.5 py-2.5 text-sm font-medium text-success">
            <i class="fa-solid fa-circle-check text-xs"></i>
            Tautan verifikasi baru telah dikirim ke email yang Anda daftarkan.
        </div>
    @endif

    <div class="space-y-5">
        <x-primary-button wire:click="sendVerification">
            Kirim ulang email verifikasi
        </x-primary-button>

        <button
            wire:click="logout"
            type="submit"
            class="block w-full text-center text-sm font-medium text-muted transition-colors hover:text-ink"
        >
            Keluar
        </button>
    </div>
</div>
