<button {{ $attributes->merge([
    'type' => 'button',
    'class' => 'be-btn be-btn-ghost',
]) }}>
    {{ $slot }}
</button>
