@props([
    'title' => null,
    'description' => null,
    'actions' => null,
])

<div class="space-y-1">
    <nav class="flex text-xs text-muted" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 transition-colors hover:text-accent">
                    <i class="fa-solid fa-house text-[11px]"></i>
                    Dashboard
                </a>
            </li>
            @isset($title)
                <li>
                    <div class="flex items-center">
                        <i class="fa-solid fa-chevron-right text-[10px] text-ink/30"></i>
                        <span class="ml-1.5 md:ml-2 font-medium text-ink">{{ $title }}</span>
                    </div>
                </li>
            @endisset
        </ol>
    </nav>

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        @if ($title)
            <div>
                <h1 class="text-xl font-bold tracking-tight text-ink lg:text-2xl">{{ $title }}</h1>
                @if ($description)
                    <p class="mt-1 text-xs text-muted lg:text-sm">{{ $description }}</p>
                @endif
            </div>
        @endif

        @isset($actions)
            <div class="flex items-center gap-2.5">
                {{ $actions }}
            </div>
        @endisset
    </div>
</div>
