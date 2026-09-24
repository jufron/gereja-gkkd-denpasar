<x-be.layouts.app title="Dashboard Overview" description="Ringkasan aktivitas dan pelayanan GKKD Bali">

    <main class="mx-auto w-full max-w-7xl flex-1 space-y-6">

        {{-- Welcome banner: real photo under a dark scrim instead of a hand-rolled illustration. --}}
        <section class="relative overflow-hidden rounded-3xl bg-darkbase shadow-xl">
            <img
                src="{{ asset('images/fellowship.jpg') }}"
                alt=""
                aria-hidden="true"
                class="absolute inset-0 h-full w-full object-cover opacity-30"
            >
            <div class="absolute inset-0 bg-gradient-to-tr from-black/90 via-black/70 to-accent/25"></div>

            <div class="relative z-10 max-w-xl p-6 sm:p-8">
                <span class="mb-3 inline-flex items-center gap-1.5 rounded-full border border-accent/30 bg-accent/15 px-3 py-1 text-[11px] font-semibold text-accent-soft">
                    <i class="fa-solid fa-cross text-xs"></i> Gembalakanlah Domba-Domba-Ku
                </span>

                <h1 class="text-2xl font-extrabold tracking-tight text-white sm:text-3xl">Syalom, Selamat Datang!</h1>
                <p class="mt-2 text-sm leading-relaxed text-white/70">
                    Kiranya kasih karunia dan damai sejahtera Kristus menyertai seluruh pelayanan kita hari ini di GKKD Bali.
                </p>

                <div class="mt-5 inline-flex items-center gap-2.5 rounded-2xl border border-white/10 bg-white/10 px-4 py-2 backdrop-blur-md">
                    <i class="fa-solid fa-calendar-day text-sm text-accent-soft"></i>
                    <span class="text-xs font-semibold text-white">{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>
            </div>
        </section>

        {{-- KPI metrics --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 sm:gap-6">
            {{-- TODO: ganti angka di bawah dengan query agregat nyata (jemaat, kehadiran, komsel, persembahan). --}}
            @foreach ([
                ['label' => 'Total Jemaat', 'value' => '1.248', 'icon' => 'fa-users', 'note' => '+12,5% bulan ini', 'tone' => 'success'],
                ['label' => 'Kehadiran Minggu', 'value' => '892', 'icon' => 'fa-clipboard-user', 'note' => '88% dari kapasitas hall', 'tone' => 'success'],
                ['label' => 'Komunitas Sel (COOL)', 'value' => '42 Kelompok', 'icon' => 'fa-people-roof', 'note' => 'Denpasar & Badung', 'tone' => 'neutral'],
                ['label' => 'Persembahan Kasih', 'value' => 'Rp 48,5M', 'icon' => 'fa-wallet', 'note' => 'Laporan terverifikasi', 'tone' => 'success'],
            ] as $kpi)
                <x-be.card class="p-5 transition-shadow hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-semibold uppercase tracking-wider text-muted">{{ $kpi['label'] }}</span>
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl
                            {{ $kpi['tone'] === 'success' ? 'bg-success/10 text-success' : 'bg-ink/5 text-muted' }}">
                            <i class="fa-solid {{ $kpi['icon'] }} text-lg"></i>
                        </span>
                    </div>
                    <h3 class="mt-3 text-2xl font-bold text-ink">{{ $kpi['value'] }}</h3>
                    <div class="mt-2 flex items-center gap-1.5 text-xs font-medium
                        {{ $kpi['tone'] === 'success' ? 'text-success' : 'text-muted' }}">
                        @if ($kpi['tone'] === 'success')
                            <i class="fa-solid fa-arrow-trend-up"></i>
                        @else
                            <i class="fa-solid fa-location-dot"></i>
                        @endif
                        <span>{{ $kpi['note'] }}</span>
                    </div>
                </x-be.card>
            @endforeach
        </div>

        {{-- Main grid --}}
        <div class="grid grid-cols-12 gap-6">

            {{-- Attendance chart --}}
            <x-be.card class="col-span-12 flex flex-col justify-between p-5 lg:col-span-9 sm:p-6">
                <div class="mb-6 flex flex-col justify-between gap-2 sm:flex-row sm:items-center">
                    <div>
                        <h3 class="text-base font-bold text-ink">Grafik Kehadiran Ibadah Raya</h3>
                        <p class="text-xs text-muted">Ibadah Umum 1, 2, dan Youth Service (4 minggu terakhir)</p>
                    </div>
                    <span class="inline-flex items-center gap-1 rounded-lg bg-ink/5 px-3 py-1.5 text-[11px] font-medium text-muted">
                        <span class="h-2 w-2 rounded-full bg-accent"></span> Total Kehadiran
                    </span>
                </div>
                <div class="relative h-80 w-full">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </x-be.card>

            {{-- Calendar widget: generated for the current month via Carbon. --}}
            <x-be.card class="col-span-12 flex flex-col justify-between p-5 sm:col-span-6 lg:col-span-3">
                @php
                    $now = now();
                    $startOfMonth = $now->copy()->startOfMonth();
                    $padding = $startOfMonth->dayOfWeekIso - 1; // Monday-first
                    $daysInMonth = $now->daysInMonth;
                    // TODO: ganti agenda dummy di bawah dengan query ke tabel acara.
                    $eventDays = [
                        $now->copy()->next(Carbon\CarbonInterface::SUNDAY)->day => ['label' => 'Ibadah Raya 1 & 2', 'time' => '08:00 WITA', 'tone' => 'accent'],
                        $now->copy()->next(Carbon\CarbonInterface::WEDNESDAY)->day => ['label' => 'Mezbah Doa Online', 'time' => '19:00 WITA', 'tone' => 'warning'],
                    ];
                @endphp

                <div>
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-sm font-bold text-ink">{{ $now->translatedFormat('F Y') }}</h3>
                        <div class="flex items-center gap-1">
                            <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-ink/5 text-[10px] text-muted">
                                <i class="fa-solid fa-chevron-left"></i>
                            </span>
                            <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-ink/5 text-[10px] text-muted">
                                <i class="fa-solid fa-chevron-right"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-2 grid grid-cols-7 text-center text-[10px] font-semibold uppercase tracking-wider text-muted">
                        @foreach (['S', 'S', 'R', 'K', 'J', 'S', 'M'] as $dow)
                            <div>{{ $dow }}</div>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-7 gap-y-1.5 text-center text-xs">
                        @foreach (range(1, $padding) as $i)
                            <span class="py-1 text-ink/20">{{ $startOfMonth->copy()->subDays($padding - $i + 1)->day }}</span>
                        @endforeach

                        @foreach (range(1, $daysInMonth) as $day)
                            @php
                                $isToday = $day === $now->day;
                                $hasEvent = isset($eventDays[$day]);
                            @endphp
                            <span
                                class="cursor-pointer rounded-lg py-1
                                {{ $isToday
                                    ? 'bg-accent font-bold text-white shadow-sm shadow-accent/30'
                                    : ($hasEvent
                                        ? 'bg-accent/10 font-bold text-accent'
                                        : 'text-ink/80 hover:bg-ink/5') }}"
                            >{{ $day }}</span>
                        @endforeach
                    </div>

                    <div class="mt-5 space-y-2.5 border-t border-line pt-4">
                        <span class="block text-[10px] font-bold uppercase tracking-wider text-muted">Agenda Terdekat</span>

                        @foreach ($eventDays as $day => $event)
                            <div class="flex items-center justify-between rounded-xl border border-line bg-ink/[0.03] p-2.5">
                                <div>
                                    <h4 class="text-xs font-bold text-ink">{{ $event['label'] }}</h4>
                                    <p class="text-[10px] text-muted">{{ $day }} {{ $now->translatedFormat('M') }} • {{ $event['time'] }}</p>
                                </div>
                                <span class="h-2 w-2 rounded-full
                                    {{ $event['tone'] === 'warning' ? 'bg-warning' : 'bg-accent' }}"></span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-be.card>

        </div>

        {{-- Registration table --}}
        <x-be.card class="overflow-hidden">
            <div class="flex flex-col justify-between gap-4 border-b border-line p-5 sm:flex-row sm:items-center sm:p-6">
                <div>
                    <h3 class="text-base font-bold text-ink">Pendaftaran Pelayan &amp; Jemaat Baru</h3>
                    <p class="text-xs text-muted">Daftar verifikasi formulir keanggotaan terbaru minggu ini</p>
                </div>
                <div class="flex items-center gap-2">
                    {{-- TODO: sambungkan tombol filter & "Lihat Semua" ke halaman data jemaat. --}}
                    <button class="be-btn be-btn-ghost">
                        <i class="fa-solid fa-filter text-[11px]"></i> Filter
                    </button>
                    <button class="be-btn be-btn-ghost">
                        Lihat Semua
                    </button>
                </div>
            </div>

            {{-- TODO: ganti baris contoh di bawah dengan query ke tabel pendaftaran. --}}
            <div class="w-full overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-line bg-ink/[0.03] text-[11px] font-semibold uppercase tracking-wider text-muted">
                            <th class="px-6 py-3.5">Nama Jemaat</th>
                            <th class="px-6 py-3.5">Pelayanan</th>
                            <th class="px-6 py-3.5">Sektor Area</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line text-xs text-ink/80">
                        @foreach ([
                            ['initials' => 'DP', 'name' => 'Daniel Pratama', 'phone' => '0812-3456-7890', 'ministry' => 'Praise & Worship', 'area' => 'Denpasar Selatan', 'status' => 'Aktif', 'tone' => 'success'],
                            ['initials' => 'SK', 'name' => 'Sarah Kartika', 'phone' => '0819-8765-4321', 'ministry' => 'Multimedia & Creative', 'area' => 'Kuta Utara, Badung', 'status' => 'Verifikasi', 'tone' => 'warning'],
                        ] as $row)
                            <tr class="transition-colors hover:bg-ink/[0.02]">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3 font-medium">
                                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-accent/10 text-xs font-bold text-accent">
                                            {{ $row['initials'] }}
                                        </span>
                                        <div>
                                            <p class="font-bold text-ink">{{ $row['name'] }}</p>
                                            <p class="text-[11px] text-muted">{{ $row['phone'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">{{ $row['ministry'] }}</td>
                                <td class="px-6 py-4">{{ $row['area'] }}</td>
                                <td class="px-6 py-4">
                                    <x-be.badge :tone="$row['tone']">{{ $row['status'] }}</x-be.badge>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="rounded-lg p-1.5 text-muted transition-colors hover:text-accent" aria-label="Opsi">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-be.card>

    </main>

    @push('scripts')
        <script type="module">
            import Chart from 'chart.js/auto';

            document.addEventListener('DOMContentLoaded', function () {
                const el = document.getElementById('attendanceChart');
                if (!el) {
                    return;
                }

                const ctx = el.getContext('2d');

                const cssVar = (name) => getComputedStyle(document.documentElement)
                    .getPropertyValue(name)
                    .trim();

                const accent = cssVar('--color-accent') || '#8a00c2';
                const muted = cssVar('--color-muted') || '#5c5c5c';

                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, accent + '59');
                gradient.addColorStop(1, accent + '00');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4 (Terakhir)'],
                        datasets: [{
                            label: 'Kehadiran Ibadah Raya',
                            data: [740, 810, 790, 892],
                            borderColor: accent,
                            borderWidth: 3,
                            backgroundColor: gradient,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: accent,
                            pointBorderColor: cssVar('--color-card') || '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#121212',
                                titleFont: { size: 12, weight: 'bold' },
                                bodyFont: { size: 12 },
                                padding: 10,
                                cornerRadius: 8,
                                displayColors: false,
                            },
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { font: { size: 11 }, color: muted },
                            },
                            y: {
                                grid: { color: 'color-mix(in srgb, ' + muted + ' 15%, transparent)' },
                                ticks: { font: { size: 11 }, color: muted },
                                min: 500,
                            },
                        },
                    },
                });
            });
        </script>
    @endpush
</x-be.layouts.app>
