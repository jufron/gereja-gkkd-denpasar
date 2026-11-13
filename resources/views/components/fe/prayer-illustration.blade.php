@props([
    'class' => 'h-64 w-64 text-accent-soft/40',
])

{{--
    Ilustrasi line-art: dua tangan terbuka menadah cahaya.
    Pure inline SVG — mengikuti token warna (currentColor), tajam di semua DPI,
    tanpa aset biner. Dekoratif; pemakai wajib beri aria-hidden/arg.
--}}
<svg
    viewBox="0 0 200 200"
    fill="none"
    stroke="currentColor"
    stroke-width="1.5"
    stroke-linecap="round"
    stroke-linejoin="round"
    {{ $attributes->merge(['class' => $class]) }}
    aria-hidden="true"
>
    {{-- Cahaya dari atas --}}
    <g stroke-width="1.2">
        <path d="M100 14v22" />
        <path d="M54 28 66 43" />
        <path d="M146 28 134 43" />
        <path d="M24 58 40 65" />
        <path d="M176 58 160 65" />
        <path d="M100 40c-6 0-11 4-11 10s5 9 11 9 11-4 11-9-5-10-11-10Z" />
        <path d="M100 52c0 14-8 24-20 28" />
        <path d="M100 52c0 14 8 24 20 28" />
    </g>

    {{-- Tangan terbuka (tadah) --}}
    <path d="M46 118c0 26 22 44 54 44s54-18 54-44" />
    <path d="M46 118c-8 12-12 24-8 34 4 11 16 18 30 18" />
    <path d="M154 118c8 12 12 24 8 34-4 11-16 18-30 18" />
    <path d="M66 118c8 18 22 28 34 28s26-10 34-28" />
    <path d="M66 118c0-22 14-36 34-36s34 14 34 36" />

    {{-- Percikan/percaya penopang --}}
    <g stroke-width="1.2">
        <path d="M100 150v16" />
        <path d="M88 158l12 8 12-8" />
    </g>
</svg>
