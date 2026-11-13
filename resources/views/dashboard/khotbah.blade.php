<x-be.layouts.app title="Khotbah" description="Kelola rangkuman khotbah GKKD Bali">

    <main class="mx-auto w-full max-w-7xl flex-1 space-y-6">

        <x-be.page-header
            title="Khotbah"
            description="Daftar rangkuman khotbah yang sudah diterbitkan atau masih draft."
        />

        <livewire:dashboard.sermon-table />

    </main>

</x-be.layouts.app>
