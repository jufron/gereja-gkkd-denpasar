<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'be-btn be-btn-primary w-full hover:shadow-md',
]) }}>
    {{ $slot }}
</button>
