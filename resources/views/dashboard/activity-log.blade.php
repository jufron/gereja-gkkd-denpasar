<x-be.layouts.app title="Log Aktivitas" description="Jejak autentikasi dan perubahan data di sistem">

    <main class="mx-auto w-full max-w-7xl flex-1 space-y-6">

        <x-be.page-header
            title="Log Aktivitas"
            description="Jejak autentikasi dan perubahan data di sistem."
        />

        {{-- Stats strip --}}
        <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
            <x-be.card class="p-5">
                <span class="text-[11px] font-semibold uppercase tracking-wider text-muted">Total Aktivitas</span>
                <h3 class="mt-2 text-2xl font-bold text-ink">{{ number_format($stats['total'], 0, ',', '.') }}</h3>
            </x-be.card>
            <x-be.card class="p-5">
                <span class="text-[11px] font-semibold uppercase tracking-wider text-muted">Hari Ini</span>
                <h3 class="mt-2 text-2xl font-bold text-ink">{{ $stats['today'] }}</h3>
            </x-be.card>
            <x-be.card class="p-5">
                <span class="text-[11px] font-semibold uppercase tracking-wider text-muted">Login Hari Ini</span>
                <h3 class="mt-2 text-2xl font-bold text-ink">{{ $stats['logins_today'] }}</h3>
            </x-be.card>
            <x-be.card class="p-5">
                <span class="text-[11px] font-semibold uppercase tracking-wider text-muted">Login Gagal</span>
                <h3 class="mt-2 text-2xl font-bold text-ink">{{ $stats['failed'] }}</h3>
            </x-be.card>
        </div>

        {{-- Filters --}}
        <x-be.card class="p-5">
            <form method="GET" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-6">
                <div class="lg:col-span-2">
                    <label for="q" class="be-label">Pencarian</label>
                    <input id="q" name="q" type="search" value="{{ $filters['q'] ?? '' }}" placeholder="Cari deskripsi..." class="be-input">
                </div>
                <div>
                    <label for="event" class="be-label">Jenis Aksi</label>
                    <select id="event" name="event" class="be-input">
                        <option value="">Semua</option>
                        @foreach ($events as $event)
                            <option value="{{ $event }}" @selected(($filters['event'] ?? null) === $event)>{{ $event }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="from" class="be-label">Dari</label>
                    <input id="from" name="from" type="date" value="{{ $filters['from'] ?? '' }}" class="be-input">
                </div>
                <div>
                    <label for="to" class="be-label">Sampai</label>
                    <input id="to" name="to" type="date" value="{{ $filters['to'] ?? '' }}" class="be-input">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="be-btn be-btn-ghost w-full">
                        <i class="fa-solid fa-filter text-[11px]"></i> Filter
                    </button>
                    <a href="{{ route('log-aktivitas') }}" class="be-btn be-btn-ghost" title="Reset">
                        <i class="fa-solid fa-rotate-left text-[11px]"></i>
                    </a>
                </div>
            </form>
        </x-be.card>

        {{-- Timeline --}}
        <x-be.card class="overflow-hidden">
            <div class="flex items-center justify-between border-b border-line p-5">
                <div>
                    <h3 class="text-base font-bold text-ink">Riwayat Aktivitas</h3>
                    <p class="text-xs text-muted">{{ $activities->total() }} entri ditemukan</p>
                </div>
            </div>

            @if ($activities->isEmpty())
                <x-be.empty-state
                    icon="fa-clock-rotate-left"
                    title="Belum ada aktivitas"
                    description="Jejak autentikasi dan perubahan data akan tercatat di sini."
                />
            @else
                <div class="divide-y divide-line">
                    @foreach ($activities as $activity)
                        @php
                            $tones = [
                                'login' => 'success',
                                'logout' => 'neutral',
                                'login_gagal' => 'danger',
                                'terkunci' => 'warning',
                                'register' => 'accent',
                                'password_direset' => 'warning',
                                'created' => 'success',
                                'updated' => 'accent',
                                'deleted' => 'danger',
                            ];
                            $tone = $tones[$activity->description] ?? 'neutral';

                            $icons = [
                                'login' => 'fa-right-to-bracket',
                                'logout' => 'fa-right-from-bracket',
                                'login_gagal' => 'fa-triangle-exclamation',
                                'terkunci' => 'fa-lock',
                                'register' => 'fa-user-plus',
                                'password_direset' => 'fa-key',
                                'created' => 'fa-plus',
                                'updated' => 'fa-pen',
                                'deleted' => 'fa-trash-can',
                            ];
                            $icon = $icons[$activity->description] ?? 'fa-clock-rotate-left';

                            $hasChanges = filled($activity->properties['old'] ?? null) || filled($activity->properties['attributes'] ?? null);
                        @endphp

                        <div class="flex items-start gap-4 p-5">
                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl
                                {{ $tone === 'neutral' ? 'bg-ink/5 text-muted' : "bg-{$tone}/15 text-{$tone}" }}">
                                <i class="fa-solid {{ $icon }}"></i>
                            </span>

                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <x-be.badge :tone="$tone">{{ $activity->description }}</x-be.badge>
                                    <span class="text-sm font-semibold text-ink">
                                        {{ $activity->causer?->name ?? 'Sistem' }}
                                    </span>
                                    @if ($activity->subject)
                                        <span class="text-xs text-muted">
                                            pada {{ class_basename($activity->subject_type) }} #{{ $activity->subject_id }}
                                        </span>
                                    @endif
                                </div>

                                <p class="mt-1 text-xs text-muted">
                                    {{ $activity->log_name }}
                                    @if (! empty($activity->properties['ip']))
                                        <span class="mx-1.5">•</span> {{ $activity->properties['ip'] }}
                                    @endif
                                    @if (! empty($activity->properties['user_agent']))
                                        <span class="mx-1.5">•</span> {{ \Illuminate\Support\Str::limit($activity->properties['user_agent'], 60) }}
                                    @endif
                                </p>

                                @if ($hasChanges)
                                    <div class="mt-3 overflow-x-auto rounded-xl border border-line">
                                        <table class="w-full text-left text-xs">
                                            <thead>
                                                <tr class="border-b border-line bg-ink/[0.03] text-[10px] font-semibold uppercase tracking-wider text-muted">
                                                    <th class="px-3 py-2">Atribut</th>
                                                    <th class="px-3 py-2">Sebelum</th>
                                                    <th class="px-3 py-2">Sesudah</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-line">
                                                @php
                                                    $old = $activity->properties['old'] ?? [];
                                    $new = $activity->properties['attributes'] ?? $activity->properties->toArray();
                                    $keys = collect(array_keys($new))->merge(array_keys($old))->unique();
                                                @endphp
                                                @foreach ($keys as $key)
                                                    <tr>
                                                        <td class="px-3 py-2 font-medium text-muted">{{ $key }}</td>
                                                        <td class="px-3 py-2 text-danger/80">
                                                            {{ isset($old[$key]) ? json_encode($old[$key]) : '<span class="text-muted">—</span>' }}
                                                        </td>
                                                        <td class="px-3 py-2 text-success/80">
                                                            {{ isset($new[$key]) ? json_encode($new[$key]) : '<span class="text-muted">—</span>' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>

                            <time
                                class="shrink-0 text-[11px] text-muted"
                                title="{{ $activity->created_at?->format('d M Y, H:i:s') }}"
                            >
                                {{ $activity->created_at?->diffForHumans() }}
                            </time>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-line p-5">
                    {{ $activities->links() }}
                </div>
            @endif
        </x-be.card>

    </main>

</x-be.layouts.app>
