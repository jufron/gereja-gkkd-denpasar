<x-be.layouts.app title="All User" description="Daftar seluruh pengguna sistem GKKD Bali">

    <main class="mx-auto w-full max-w-7xl flex-1 space-y-6">

        <x-be.page-header
            title="All User"
            description="Daftar seluruh pengguna terdaftar, lengkap dengan sumber login (Google/Facebook)."
        />

        {{-- Filters --}}
        <x-be.card class="p-5">
            <form method="GET" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="lg:col-span-2">
                    <label for="q" class="be-label">Cari Pengguna</label>
                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-muted"></i>
                        <input id="q" name="q" type="search" value="{{ $filters['q'] ?? '' }}" placeholder="Nama atau email..." class="be-input pl-9">
                    </div>
                </div>

                <div>
                    <label for="provider" class="be-label">Sumber Login</label>
                    <select id="provider" name="provider" class="be-input">
                        <option value="">Semua</option>
                        <option value="google" @selected(($filters['provider'] ?? null) === 'google')>Google</option>
                        <option value="facebook" @selected(($filters['provider'] ?? null) === 'facebook')>Facebook</option>
                        <option value="lokal" @selected(($filters['provider'] ?? null) === 'lokal')>Lokal (Email)</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="be-btn be-btn-ghost w-full">
                        <i class="fa-solid fa-filter text-[11px]"></i> Filter
                    </button>
                    <a href="{{ route('all-user') }}" class="be-btn be-btn-ghost" title="Reset">
                        <i class="fa-solid fa-rotate-left text-[11px]"></i>
                    </a>
                </div>
            </form>
        </x-be.card>

        {{-- Data table --}}
        <x-be.card class="overflow-hidden">
            <div class="flex flex-col justify-between gap-4 border-b border-line p-5 sm:flex-row sm:items-center">
                <div>
                    <h3 class="text-base font-bold text-ink">Daftar Pengguna</h3>
                    <p class="text-xs text-muted">{{ $users->total() }} pengguna terdaftar</p>
                </div>
            </div>

            @if ($users->isEmpty())
                <x-be.empty-state
                    icon="fa-users"
                    title="Tidak ada pengguna"
                    description="Pengguna yang cocok dengan filter belum ada. Coba ubah kata kunci atau sumber login."
                />
            @else
                <div class="w-full overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-line bg-ink/[0.03] text-[11px] font-semibold uppercase tracking-wider text-muted">
                                <th class="px-6 py-3.5">Pengguna</th>
                                <th class="px-6 py-3.5">Sumber Login</th>
                                <th class="px-6 py-3.5">Role</th>
                                <th class="px-6 py-3.5">Verifikasi</th>
                                <th class="px-6 py-3.5">Terdaftar</th>
                                <th class="px-6 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-line text-xs text-ink/80">
                            @foreach ($users as $user)
                                @php
                                    $providers = [
                                        'google' => ['label' => 'Google', 'icon' => 'fa-google', 'tone' => 'accent'],
                                        'facebook' => ['label' => 'Facebook', 'icon' => 'fa-facebook', 'tone' => 'neutral'],
                                    ];
                                    $verified = filled($user->email_verified_at);
                                    $photo = $user->avatar ?? $user->socialAccounts->pluck('avatar')->filter()->first();
                                @endphp

                                <tr class="transition-colors hover:bg-ink/[0.02]">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <x-be.avatar :src="$photo" :name="$user->name" size="sm" />
                                            <div class="min-w-0">
                                                <p class="font-bold text-ink">{{ $user->name }}</p>
                                                <p class="truncate text-[11px] text-muted">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($user->socialAccounts->isEmpty())
                                            <span class="inline-flex items-center gap-1.5 text-muted">
                                                <i class="fa-solid fa-envelope text-xs"></i> Lokal (Email)
                                            </span>
                                        @else
                                            <div class="flex flex-wrap gap-1.5">
                                                @foreach ($user->socialAccounts as $account)
                                                    @php
                                                        $provider = $providers[$account->provider] ?? ['label' => ucfirst($account->provider), 'icon' => 'fa-circle-nodes', 'tone' => 'neutral'];
                                                    @endphp
                                                    <x-be.badge :tone="$provider['tone']">
                                                        <i class="fa-brands {{ $provider['icon'] }} mr-1"></i>{{ $provider['label'] }}
                                                    </x-be.badge>
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @forelse ($user->roles as $role)
                                            <x-be.badge tone="accent">{{ $role->name }}</x-be.badge>
                                        @empty
                                            <span class="text-muted">—</span>
                                        @endforelse
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-be.badge :tone="$verified ? 'success' : 'warning'">
                                            {{ $verified ? 'Terverifikasi' : 'Belum' }}
                                        </x-be.badge>
                                    </td>
                                    <td class="px-6 py-4 text-muted">{{ $user->created_at?->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="relative inline-block" x-data="{ open: false }">
                                            <button @click="open = !open" @click.outside="open = false" class="rounded-lg p-1.5 text-muted transition-colors hover:text-accent" aria-label="Opsi">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <div
                                                x-show="open"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                x-transition:leave="transition ease-in duration-150"
                                                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                                x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                                                class="absolute right-0 z-50 mt-2 w-40 rounded-2xl border border-line bg-card py-1.5 shadow-xl"
                                                style="display: none;"
                                            >
                                                <a href="#" class="flex items-center gap-2.5 px-4 py-2 text-xs text-muted transition-colors hover:bg-ink/5 hover:text-accent">
                                                    <i class="fa-solid fa-eye w-4 text-center"></i> Lihat Detail
                                                </a>
                                                <a href="#" class="flex items-center gap-2.5 px-4 py-2 text-xs text-muted transition-colors hover:bg-ink/5 hover:text-accent">
                                                    <i class="fa-solid fa-pen w-4 text-center"></i> Edit
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-line p-5">
                    {{ $users->links() }}
                </div>
            @endif
        </x-be.card>

    </main>

</x-be.layouts.app>
