@props([
    'name' => 'password',
    'id' => null,
    'autocomplete' => 'current-password',
])

<div class="relative" x-data="{ show: false }">
    <input
        {{ $attributes->merge([
            'type' => 'password',
            'id' => $id ?? $name,
            'name' => $name,
            'autocomplete' => $autocomplete,
            'class' => 'be-input pr-11',
        ]) }}
        :type="show ? 'text' : 'password'"
    >

    <button
        type="button"
        @click="show = !show"
        class="absolute inset-y-0 right-0 flex w-11 items-center justify-center text-muted transition-colors hover:text-ink focus:outline-none"
        :aria-label="show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
        tabindex="-1"
    >
        <i class="fa-solid fa-eye text-sm" x-show="!show"></i>
        <i class="fa-solid fa-eye-slash text-sm" x-show="show" style="display: none;"></i>
    </button>
</div>
