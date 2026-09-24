@props([
    'src' => null,
    'alt' => null,
    'size' => 'md',
])

@php
    $sizes = [
        'sm' => 'h-9 w-9 text-xs',
        'md' => 'h-11 w-11 text-sm',
        'lg' => 'h-20 w-20 text-2xl',
    ];

    $initials = collect(explode(' ', trim(auth()->user()?->name ?? '')))
        ->filter()
        ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
        ->take(2)
        ->implode('');
@endphp

@if ($src)
    <img
        src="{{ $src }}"
        alt="{{ $alt ?? __('Foto profil') }}"
        class="{{ $sizes[$size] }} rounded-2xl object-cover ring-1 ring-ink/10"
    >
@else
    <span
        class="{{ $sizes[$size] }} inline-flex shrink-0 items-center justify-center rounded-2xl bg-gradient-to-tr from-accent-strong to-accent font-bold text-white"
        aria-hidden="true"
    >
        {{ $initials ?: '?' }}
    </span>
@endif
