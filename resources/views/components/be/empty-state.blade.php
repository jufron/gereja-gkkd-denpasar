@props([
    'icon' => 'fa-folder-open',
    'title' => null,
    'description' => null,
])

<div class="flex flex-col items-center justify-center gap-3 px-6 py-16 text-center">
    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-accent/10 text-accent">
        <i class="fa-solid {{ $icon }} text-xl"></i>
    </div>

    @if ($title)
        <h3 class="text-base font-bold text-ink">{{ $title }}</h3>
    @endif

    @if ($description)
        <p class="max-w-sm text-sm text-muted">{{ $description }}</p>
    @endif

    @isset($slot)
        <div class="mt-2">{{ $slot }}</div>
    @endisset
</div>
