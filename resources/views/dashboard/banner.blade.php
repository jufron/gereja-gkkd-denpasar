<x-be.layouts.app title="Banner Beranda" description="Kelola banner slider di hero halaman utama">

    <main class="mx-auto w-full max-w-7xl flex-1 space-y-6">

        <x-be.page-header
            title="Banner Beranda"
            description="Gambar slider pada bagian hero halaman utama. Urutan menentukan urutan tampil."
        />

        <livewire:dashboard.banner-manager />

    </main>

</x-be.layouts.app>
