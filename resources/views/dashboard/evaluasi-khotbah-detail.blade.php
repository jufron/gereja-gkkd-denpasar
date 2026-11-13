<x-be.layouts.app title="Detail Evaluasi Khotbah" description="Detail evaluasi khotbah bulanan">

    <main class="mx-auto w-full max-w-4xl flex-1 space-y-6">

        <x-be.page-header
            title="Detail Evaluasi Khotbah"
            :description="$evaluasi->nama ?: 'Anonim'"
        >
            <x-slot:actions>
                <a href="{{ route('admin.evaluasi-khotbah.index') }}" class="be-btn be-btn-ghost">
                    <i class="fa-solid fa-arrow-left text-[11px]"></i>
                    Kembali
                </a>
            </x-slot:actions>
        </x-be.page-header>

        @if (session('success'))
            <div class="flex items-center gap-3 rounded-2xl border border-success/30 bg-success/10 p-4 text-sm font-medium text-success" role="status">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-3">
            {{-- Kartu utama --}}
            <x-be.card class="overflow-hidden lg:col-span-2">
                <div class="p-6 lg:p-7">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <p class="text-xs text-muted">Penilaian keseluruhan</p>
                            <p class="mt-1 flex items-baseline gap-1">
                                <span class="text-4xl font-bold text-ink">{{ $evaluasi->rating }}</span>
                                <span class="text-lg text-muted">/ 5</span>
                            </p>
                            <p class="mt-1 text-sm font-medium text-accent dark:text-accent-soft">
                                {{ \App\Models\SermonEvaluation::RATING[$evaluasi->rating] ?? '' }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-muted">Periode dievaluasi</p>
                            <p class="mt-1 text-base font-semibold text-ink">
                                {{ \App\Models\SermonEvaluation::BULAN[$evaluasi->bulan] ?? $evaluasi->bulan }} {{ $evaluasi->tahun }}
                            </p>
                            <p class="mt-1 text-xs text-muted">Masuk: {{ $evaluasi->created_at->translatedFormat('d F Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="mt-6 space-y-5 border-t border-line pt-6">
                        <div>
                            <h3 class="text-sm font-bold text-ink">Apa yang paling berkesan</h3>
                            <p class="mt-2 whitespace-pre-line rounded-2xl border border-line bg-ink/[0.02] p-4 text-sm leading-relaxed text-ink">
                                {{ $evaluasi->berkesan ?: 'Tidak diisi' }}
                            </p>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-ink">Masukan / saran</h3>
                            <p class="mt-2 whitespace-pre-line rounded-2xl border border-line bg-ink/[0.02] p-4 text-sm leading-relaxed text-ink">
                                {{ $evaluasi->masukan ?: 'Tidak diisi' }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 grid gap-4 border-t border-line pt-5 text-sm sm:grid-cols-2">
                        <div>
                            <p class="text-xs text-muted">Nama</p>
                            <p class="mt-0.5 font-medium text-ink">{{ $evaluasi->nama ?: 'Anonim' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-muted">Tanggal masuk</p>
                            <p class="mt-0.5 font-medium text-ink">{{ $evaluasi->created_at->translatedFormat('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </x-be.card>

            {{-- Aksi --}}
            <div class="space-y-6">
                <x-be.card x-data="{ open: false }">
                    <div class="p-5">
                        <h3 class="text-sm font-bold text-danger">Hapus</h3>
                        <p class="mt-1 text-xs leading-relaxed text-muted">
                            Menghapus evaluasi secara permanen.
                        </p>
                        <button type="button" x-on:click="open = true" class="mt-3 w-full rounded-full border border-danger/30 px-5 py-2.5 text-sm font-medium text-danger transition-colors hover:bg-danger/10">
                            Hapus Evaluasi
                        </button>
                    </div>

                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        x-on:keydown.escape.window="open = false"
                        class="fixed inset-0 z-[60] flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm"
                        style="display: none;"
                    >
                        <div
                            x-show="open"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                            class="w-full max-w-md rounded-3xl bg-card p-6 shadow-2xl"
                            x-on:click.outside="open = false"
                            role="dialog"
                            aria-modal="true"
                        >
                            <div class="flex items-start gap-4">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-danger/10 text-danger">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                </span>
                                <div class="space-y-1.5">
                                    <h3 class="text-base font-bold text-ink">Hapus Evaluasi?</h3>
                                    <p class="text-sm text-muted">
                                        Data evaluasi akan dihapus permanen dan tidak dapat dipulihkan.
                                    </p>
                                </div>
                            </div>
                            <div class="mt-6 flex items-center justify-end gap-2.5">
                                <x-be.button type="button" variant="ghost" x-on:click="open = false">Batal</x-be.button>
                                <form method="POST" action="{{ route('admin.evaluasi-khotbah.destroy', $evaluasi) }}">
                                    @csrf
                                    @method('DELETE')
                                    <x-be.button type="submit" variant="danger" icon="fa-trash-can">Hapus</x-be.button>
                                </form>
                            </div>
                        </div>
                    </div>
                </x-be.card>
            </div>
        </div>

    </main>

</x-be.layouts.app>
