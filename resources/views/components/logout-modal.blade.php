@props([
    'name' => 'confirm-logout',
])

<div
    x-data="{ show: false }"
    x-on:open-modal.window="$event.detail === '{{ $name }}' ? show = true : null"
    x-on:close-modal.window="$event.detail === '{{ $name }}' ? show = false : null"
    x-on:keydown.escape.window="show = false"
    x-show="show"
    x-cloak
    class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto px-4 py-6 sm:px-0"
    style="display: none;"
>
    {{-- Backdrop --}}
    <div
        x-show="show"
        class="fixed inset-0 transform transition-all"
        x-on:click="show = false"
        x-transition:enter="ease-out duration-300 motion-reduce:transition-none"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200 motion-reduce:transition-none"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
    </div>

    {{-- Dialog --}}
    <div
        x-show="show"
        x-transition:enter="transition ease-out duration-300 motion-reduce:transition-none"
        x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="transition ease-in duration-200 motion-reduce:transition-none"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
        role="dialog"
        aria-modal="true"
        aria-labelledby="logout-modal-title"
        class="relative w-full max-w-md overflow-hidden rounded-2xl border border-line bg-card shadow-2xl sm:mx-auto"
    >
        <div class="p-6">
            <div class="flex items-start gap-4">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-danger/10 text-danger">
                    <i class="fa-solid fa-right-from-bracket text-lg"></i>
                </span>
                <div class="min-w-0">
                    <h3 id="logout-modal-title" class="text-base font-bold text-ink">Keluar dari akun?</h3>
                    <p class="mt-1.5 text-sm leading-relaxed text-muted">
                        Anda akan keluar dari sesi ini dan kembali ke halaman utama.
                    </p>
                </div>
            </div>

            <div class="mt-6 flex flex-col-reverse gap-2.5 sm:flex-row sm:justify-end">
                <button
                    type="button"
                    x-on:click="show = false"
                    class="be-btn be-btn-ghost focus:outline-none focus-visible:ring-2 focus-visible:ring-accent focus-visible:ring-offset-2 focus-visible:ring-offset-card"
                >
                    Batal
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="be-btn be-btn-danger w-full focus:outline-none focus-visible:ring-2 focus-visible:ring-danger focus-visible:ring-offset-2 focus-visible:ring-offset-card sm:w-auto"
                    >
                        <i class="fa-solid fa-right-from-bracket text-xs"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
