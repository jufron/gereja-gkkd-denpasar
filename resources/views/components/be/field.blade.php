@props([
    'label' => null,
    'for' => null,
    'hint' => null,
    'help' => null,
])

<div {{ $attributes->merge(['class' => 'space-y-1.5']) }}>
    @if ($label)
        <label for="{{ $for }}" class="be-label">{{ $label }}</label>
    @endif

    {{ $slot }}

    @if ($hint)
        <p class="text-[11px] text-muted">{{ $hint }}</p>
    @endif

    @if ($help)
        <p class="text-[11px] text-danger">{{ $help }}</p>
    @endif
</div>
