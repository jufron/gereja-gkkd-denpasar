@props(['value'])

<label {{ $attributes->merge(['class' => 'be-label mb-1.5']) }}>
    {{ $value ?? $slot }}
</label>
