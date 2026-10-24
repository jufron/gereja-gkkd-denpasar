<x-be.layouts.app title="{{ $news->title }}" description="Pratinjau artikel berita">

    <main class="mx-auto w-full max-w-4xl flex-1 space-y-6">

        <x-be.page-header
            title="Pratinjau Berita"
            :description="$news->title"
        >
            <x-slot:actions>
                <a href="{{ route('admin.berita') }}" class="be-btn be-btn-ghost">
                    <i class="fa-solid fa-arrow-left text-[11px]"></i>
                    Kembali
                </a>
                <a href="{{ route('admin.berita.ubah', $news) }}" class="be-btn be-btn-primary">
                    <i class="fa-solid fa-pen text-[11px]"></i>
                    Ubah
                </a>
            </x-slot:actions>
        </x-be.page-header>

        @if ($news->status === 'draft')
            <div class="flex items-center gap-3 rounded-2xl border border-warning/30 bg-warning/10 p-4 text-sm font-medium text-warning" role="note">
                <i class="fa-solid fa-circle-info"></i>
                <span>Pratinjau — artikel ini belum terbit.</span>
            </div>
        @endif

        <x-be.card class="overflow-hidden">
            @if ($news->featured_image)
                <img src="{{ asset('storage/'.$news->featured_image) }}" class="aspect-video w-full object-cover" alt="{{ $news->title }}">
            @endif

            <div class="p-6 lg:p-8">
                <h1 class="text-2xl font-bold tracking-tight text-ink lg:text-3xl">{{ $news->title }}</h1>

                <div class="mt-4 flex flex-wrap items-center gap-x-6 gap-y-2 text-xs text-muted">
                    @if ($news->category)
                        <span class="be-badge {{ $news->category->color }}">{{ $news->category->name }}</span>
                    @endif

                    @if ($news->author)
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-user"></i>
                            {{ $news->author->name }}
                        </span>
                    @endif

                    <span class="flex items-center gap-1.5">
                        <i class="fa-solid fa-calendar-day"></i>
                        {{ $news->published_at?->translatedFormat('d F Y H:i') ?? 'Belum diterbitkan' }}
                    </span>

                    <span class="flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-dot"></i>
                        <span class="{{ $news->status === 'published' ? 'text-success' : 'text-warning' }} font-semibold">
                            {{ $news->status === 'published' ? 'Diterbitkan' : 'Draft' }}
                        </span>
                    </span>
                </div>

                @if ($news->excerpt)
                    <p class="mt-6 border-l-2 border-accent pl-4 text-base italic text-muted">
                        {{ $news->excerpt }}
                    </p>
                @endif

                <div class="berita-content mt-6">
                    {!! $news->content !!}
                </div>
            </div>
        </x-be.card>

    </main>

</x-be.layouts.app>
