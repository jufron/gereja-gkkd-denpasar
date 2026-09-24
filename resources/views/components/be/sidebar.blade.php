@php
    use Illuminate\Support\Facades\Auth;

    // Navigasi sidebar: satu sumber kebenaran, menggantikan daftar <a> hardcode.
    // Halaman yang belum ada ditandai routeIs aman (null => '#').
    $navGroups = [
        [
            'label' => 'Ringkasan',
            'items' => [
                ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'fa-chart-pie'],
                ['label' => 'Data Jemaat', 'route' => 'table', 'icon' => 'fa-users'],
                ['label' => 'Pelayanan & Volunteer', 'route' => null, 'icon' => 'fa-hand-holding-heart'],
            ],
        ],
        [
            'label' => 'Ibadah & Agenda',
            'items' => [
                ['label' => 'Jadwal Ibadah', 'route' => null, 'icon' => 'fa-calendar-days'],
                ['label' => 'Keuangan & Persembahan', 'route' => null, 'icon' => 'fa-coins'],
            ],
        ],
        [
            'label' => 'User Management',
            'items' => [
                ['label' => 'All User', 'route' => null, 'icon' => 'fa-users'],
                ['label' => 'Hak Akses', 'route' => null, 'icon' => 'fa-user-shield'],
            ],
        ],
        [
            'label' => 'Berita Management',
            'items' => [
                ['label' => 'Berita', 'route' => null, 'icon' => 'fa-newspaper'],
                ['label' => 'Kategori Berita', 'route' => null, 'icon' => 'fa-tags'],
            ],
        ],
        [
            'label' => 'Aplikasi Management',
            'items' => [
                ['label' => 'Pengaturan', 'route' => 'pengaturan', 'icon' => 'fa-sliders'],
                ['label' => 'Log Aktivitas', 'route' => 'log-aktivitas', 'icon' => 'fa-clock-rotate-left'],
            ],
        ],
    ];

    $user = Auth::user();
@endphp

<aside
    class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col justify-between bg-sidebar text-white shadow-2xl transition-transform duration-300 ease-in-out lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
>
    {{-- Logo & Church Header --}}
    <div>
        <div class="flex h-20 items-center justify-between border-b border-white/10 px-6">
            <div class="flex items-center gap-3">
                <span class="h-10 w-10 overflow-hidden rounded-xl bg-white/10 ring-1 ring-white/15">
                    <img
                        src="{{ asset('images/logo.jpeg') }}"
                        alt="Logo GKKD Denpasar"
                        class="h-full w-full origin-top-left translate-x-[-9%] translate-y-[-40%] scale-[1.75]"
                    >
                </span>
                <div>
                    <h1 class="text-base font-bold leading-tight tracking-wide text-white">GKKD BALI</h1>
                    <span class="text-[10px] font-semibold uppercase tracking-wider text-accent-soft">Church Dashboard</span>
                </div>
            </div>
            <button
                @click="sidebarOpen = false"
                class="rounded-lg p-2 text-slate-400 transition-colors hover:text-white focus:outline-none lg:hidden"
                aria-label="Tutup menu"
            >
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        {{-- Navigation Links --}}
        <nav class="max-h-[calc(100vh-160px)] space-y-1.5 overflow-y-auto p-4">
            @foreach ($navGroups as $group)
                <div class="pb-1 pt-4 text-[11px] font-semibold uppercase tracking-wider text-slate-500 first:pt-2">{{ $group['label'] }}</div>

                @foreach ($group['items'] as $item)
                    @php
                        $href = $item['route'] && Route::has($item['route']) ? route($item['route']) : '#';
                        $isActive = $item['route'] && request()->routeIs($item['route']);
                    @endphp

                    <a
                        href="{{ $href }}"
                        @if ($href === '#') aria-disabled="true" @endif
                        class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all
                            {{ $isActive
                                ? 'bg-accent text-white shadow-md shadow-accent/25'
                                : 'text-slate-400 hover:bg-white/5 hover:text-slate-200' }}"
                    >
                        <i class="fa-solid {{ $item['icon'] }} w-5 text-center transition-colors {{ $isActive ? 'text-white' : 'text-slate-500 group-hover:text-slate-300' }}"></i>
                        <span>{{ $item['label'] }}</span>
                        @if ($href === '#')
                            <i class="fa-solid fa-lock ml-auto text-[9px] text-slate-600" title="Belum tersedia"></i>
                        @endif
                    </a>
                @endforeach
            @endforeach
        </nav>
    </div>

    {{-- Sidebar Footer User Card --}}
    <div class="border-t border-white/10 bg-black/30 p-4">
        <div class="flex items-center gap-3">
            <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gradient-to-tr from-accent-strong to-accent text-xs font-bold text-white">
                {{ collect(explode(' ', trim($user?->name ?? '')))->filter()->map(fn ($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('') }}
            </span>
            <div class="min-w-0 flex-1">
                <p class="truncate text-xs font-semibold text-slate-200">{{ $user?->name ?? 'Tamu' }}</p>
                <p class="truncate text-[11px] text-slate-400">{{ $user?->email ?? '-' }}</p>
            </div>
            <button
                type="button"
                @click="$dispatch('open-modal', 'confirm-logout')"
                class="rounded-lg p-2 text-slate-400 transition-colors hover:bg-white/5 hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-accent focus-visible:ring-offset-2 focus-visible:ring-offset-sidebar"
                title="Keluar"
                aria-label="Keluar"
            >
                <i class="fa-solid fa-right-from-bracket text-sm"></i>
            </button>
        </div>
    </div>
</aside>
