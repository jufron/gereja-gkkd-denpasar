@props([
    'checked' => false,
    'name' => null,
])

<button
    type="button"
    role="switch"
    aria-checked="{{ $checked ? 'true' : 'false' }}"
    {{ $attributes->merge(['class' => 'be-switch bg-ink/20 aria-checked:bg-accent']) }}
    @if ($name) name="{{ $name }}" value="{{ $checked ? '1' : '0' }}" @endif
>
</button>
