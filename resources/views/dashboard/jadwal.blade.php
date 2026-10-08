<x-be.layouts.app title="Jadwal Ibadah" description="Kelola badge kategori dan jadwal pertemuan/ibadah jemaat">

    <main class="mx-auto w-full max-w-7xl flex-1 space-y-6">

        <x-be.page-header
            title="Jadwal Ibadah"
            description="Kelola badge kategori dan jadwal pertemuan/ibadah yang tampil di halaman utama."
        />

        <livewire:dashboard.badge-manager />

        <livewire:dashboard.jadwal-manager />

    </main>

</x-be.layouts.app>
