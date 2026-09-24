@props([
    'tone' => 'neutral',
])

@php
    $tones = [
        'neutral' => 'bg-ink/10 text-ink/70',
        'accent' => 'bg-accent/10 text-accent',
        'success' => 'bg-success/15 text-success',
        'warning' => 'bg-warning/15 text-warning',
        'danger' => 'bg-danger/15 text-danger',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'be-badge ' . ($tones[$tone] ?? $tones['neutral'])]) }}>
    {{ $slot }}
</span>
