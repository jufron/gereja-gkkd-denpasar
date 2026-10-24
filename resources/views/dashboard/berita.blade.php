<x-be.layouts.app title="Berita" description="Kelola artikel berita GKKD Bali">

    <main class="mx-auto w-full max-w-7xl flex-1 space-y-6">

        <x-be.page-header
            title="Berita"
            description="Daftar artikel berita yang sudah dipublikasikan atau masih draft."
        />

        @if (session('success'))
            <div class="rounded-xl bg-emerald-500/10 p-4 text-sm text-emerald-400">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex items-center justify-between">
            <a href="{{ route('admin.berita.tambah') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-accent px-4 py-2 text-sm font-semibold text-white hover:bg-accent/90">
                <i class="fa-solid fa-plus"></i>
                Tambah Berita
            </a>
        </div>

        @if ($berita->count())
            <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-700">
                <table class="w-full min-w-[800px] text-left text-sm">
                    <thead class="bg-slate-100 dark:bg-slate-800">
                        <tr>
                            <th class="px-4 py-3 font-medium">Judul</th>
                            <th class="px-4 py-3 font-medium">Kategori</th>
                            <th class="px-4 py-3 font-medium">Status</th>
                            <th class="px-4 py-3 font-medium">Dipublikasikan</th>
                            <th class="px-4 py-3 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @foreach ($berita as $item)
                            <tr>
                                <td class="px-4 py-3">{{ $item->title }}</td>
                                <td class="px-4 py-3">{{ $item->category?->name ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    @if ($item->status === 'published')
                                        <span class="text-xs text-emerald-500">Diterbitkan</span>
                                    @else
                                        <span class="text-xs text-slate-500">Draft</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-xs text-slate-500">
                                    {{ $item->published_at?->translatedFormat('d M Y H:i') ?? '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('admin.berita.ubah', $item) }}"
                                       class="text-sm text-accent hover:underline">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $berita->links() }}
        @else
            <x-be.empty-state
                title="Belum ada berita."
                description="Tekan tombol di atas untuk menulis artikel pertama."
            />
        @endif

    </main>

</x-be.layouts.app>
