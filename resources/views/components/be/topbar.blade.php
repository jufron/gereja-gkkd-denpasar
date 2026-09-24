@props([
    'title' => 'Dashboard Overview',
    'description' => 'Ringkasan aktivitas dan pelayanan GKKD Bali',
])

@php
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
@endphp

<header class="sticky top-0 z-30 flex h-20 items-center justify-between gap-4 border-b border-line bg-card/90 px-4 backdrop-blur-md sm:px-6 lg:px-8">

    <div class="flex items-center gap-3">
        <button
            @click="sidebarOpen = true"
            class="rounded-xl p-2.5 text-muted transition-colors hover:bg-ink/5 hover:text-ink focus:outline-none lg:hidden"
            aria-label="Buka menu"
        >
            <i class="fa-solid fa-bars text-xl"></i>
        </button>
        <div>
            <h2 class="text-xl font-bold tracking-tight text-ink">{{ $title }}</h2>
            <p class="hidden text-xs text-muted sm:block">{{ $description }}</p>
        </div>
    </div>

    <div class="flex items-center gap-2 sm:gap-4">

        {{-- Search Bar --}}
        <div class="relative hidden w-64 md:block">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-muted"></i>
            <input
                type="text"
                placeholder="Cari jemaat, warta, kegiatan..."
                class="h-9 w-full rounded-xl border border-transparent bg-ink/5 pl-9 pr-4 text-xs text-ink placeholder:text-muted focus:border-accent focus:bg-card focus:outline-none transition-all"
            >
        </div>

        {{-- Notification Dropdown --}}
        <div class="relative" x-data="{ openNotif: false }">
            <button
                @click="openNotif = !openNotif"
                @click.outside="openNotif = false"
                class="relative rounded-xl p-2.5 text-muted transition-colors hover:bg-ink/5 hover:text-ink focus:outline-none"
                aria-label="Notifikasi"
            >
                <i class="fa-regular fa-bell text-lg"></i>
                <span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-accent ring-2 ring-card"></span>
            </button>

            <div
                x-show="openNotif"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                class="absolute right-0 z-50 mt-2 w-80 rounded-2xl border border-line bg-card py-2 shadow-xl"
                style="display: none;"
            >
                <div class="flex items-center justify-between border-b border-line px-4 py-2">
                    <span class="text-xs font-bold text-ink">Notifikasi Pelayanan</span>
                </div>

                {{-- TODO: sambungkan ke tabel notifikasi. --}}
                <div class="px-4 py-6">
                    <div class="flex flex-col items-center gap-2 text-center">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-ink/5 text-muted">
                            <i class="fa-regular fa-bell text-lg"></i>
                        </div>
                        <p class="text-xs font-semibold text-ink">Belum ada notifikasi</p>
                        <p class="text-[11px] text-muted">Pemberitahuan pelayanan akan muncul di sini.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Profile Dropdown --}}
        <div class="relative" x-data="{ openProfile: false }">
            <button
                @click="openProfile = !openProfile"
                @click.outside="openProfile = false"
                class="flex items-center gap-3 rounded-xl py-1 pl-2 pr-1 transition-colors hover:bg-ink/5 focus:outline-none"
                aria-label="Menu profil"
            >
                <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gradient-to-tr from-accent-strong to-accent text-xs font-bold text-white">
                    {{ collect(explode(' ', trim($user?->name ?? '')))->filter()->map(fn ($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('') }}
                </span>
                <i class="fa-solid fa-chevron-down hidden text-xs text-muted sm:block"></i>
            </button>

            <div
                x-show="openProfile"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                class="absolute right-0 z-50 mt-2 w-56 rounded-2xl border border-line bg-card py-2 shadow-xl"
                style="display: none;"
            >
                <div class="border-b border-line px-4 py-2">
                    <p class="truncate text-xs font-bold text-ink">{{ $user?->name ?? 'Tamu' }}</p>
                    <p class="truncate text-[11px] text-muted">{{ $user?->email ?? '-' }}</p>
                </div>

                <a href="{{ route('profile') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-muted transition-colors hover:bg-ink/5 hover:text-accent">
                    <i class="fa-solid fa-user-gear w-4 text-center"></i> Profil Saya
                </a>
                <a href="{{ route('profile.security') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-muted transition-colors hover:bg-ink/5 hover:text-accent">
                    <i class="fa-solid fa-shield-halved w-4 text-center"></i> Keamanan
                </a>
                <div class="my-1 border-t border-line"></div>
                <button
                    type="button"
                    @click="openProfile = false; $dispatch('open-modal', 'confirm-logout')"
                    class="flex w-full items-center gap-2.5 px-4 py-2.5 text-xs text-danger transition-colors hover:bg-danger/10"
                >
                    <i class="fa-solid fa-right-from-bracket w-4 text-center"></i> Keluar
                </button>
            </div>
        </div>

    </div>
</header>
