@props([
    'variant' => 'primary',
    'as' => 'button',
    'href' => null,
    'icon' => null,
])

@php
    $variants = [
        'primary' => 'be-btn be-btn-primary',
        'ghost' => 'be-btn be-btn-ghost',
        'danger' => 'be-btn be-btn-danger',
    ];

    $classes = $variants[$variant] ?? $variants['primary'];
@endphp

@if ($as === 'a')
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)
            <i class="fa-solid {{ $icon }} text-[11px]"></i>
        @endif
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => $attributes->get('type', 'submit'), 'class' => $classes]) }}>
        @if ($icon)
            <i class="fa-solid {{ $icon }} text-[11px]"></i>
        @endif
        {{ $slot }}
    </button>
@endif
