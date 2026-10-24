<x-be.layouts.app title="Berita" description="Kelola artikel berita GKKD Bali">

    <main class="mx-auto w-full max-w-7xl flex-1 space-y-6">

        <x-be.page-header
            title="Berita"
            description="Daftar artikel berita yang sudah diterbitkan atau masih draft."
        />

        <livewire:dashboard.berita-table />

    </main>

</x-be.layouts.app>
