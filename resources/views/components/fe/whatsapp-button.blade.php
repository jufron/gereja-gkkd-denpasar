@php
    // TODO: ganti dengan nomor WhatsApp gereja (format internasional tanpa "+").
    $whatsappNumber = '6281234567890';
    $whatsappMessage = rawurlencode('Shalom, saya ingin bertanya tentang GKKD Denpasar.');
@endphp

<a
    href="https://wa.me/{{ $whatsappNumber }}?text={{ $whatsappMessage }}"
    target="_blank"
    rel="noopener noreferrer"
    aria-label="Hubungi kami lewat WhatsApp"
    class="fixed right-6 bottom-6 z-40 inline-flex h-14 w-14 items-center justify-center rounded-full bg-[#25D366] text-white shadow-lg shadow-black/20 transition-transform hover:scale-105 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#25D366] focus-visible:ring-offset-2 focus-visible:ring-offset-surface motion-reduce:transition-none"
>
    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M12.04 2c-5.5 0-9.96 4.46-9.96 9.96 0 1.76.46 3.48 1.34 5L2 22l5.16-1.35a9.9 9.9 0 0 0 4.88 1.28h.01c5.5 0 9.96-4.46 9.96-9.96S17.54 2 12.04 2Zm5.8 14.1c-.24.68-1.4 1.3-1.94 1.36-.5.06-1.12.08-1.8-.12-.42-.13-.96-.31-1.66-.61-2.92-1.26-4.82-4.2-4.97-4.4-.14-.2-1.18-1.57-1.18-3 0-1.42.75-2.12 1.02-2.4.26-.3.58-.36.78-.36l.56.01c.18 0 .42-.07.66.5.24.58.82 2 .9 2.14.07.14.12.3.02.5-.1.2-.15.32-.3.5l-.44.5c-.14.15-.3.3-.13.6.16.28.74 1.22 1.58 1.98 1.09.97 2 1.28 2.3 1.42.28.14.45.12.62-.08.16-.2.72-.84.9-1.13.2-.28.38-.23.64-.14.26.1 1.66.78 1.94.92.28.14.47.2.54.32.07.12.07.7-.17 1.38Z" />
    </svg>
</a>
