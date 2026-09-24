@props([
    'as' => 'div',
    'class' => null,
])

<{{ $as }} {{ $attributes->merge(['class' => 'be-card ' . $class]) }}>
    {{ $slot }}
</{{ $as }}>
