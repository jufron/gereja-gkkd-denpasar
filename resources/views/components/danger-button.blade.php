<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'be-btn be-btn-danger',
]) }}>
    {{ $slot }}
</button>
