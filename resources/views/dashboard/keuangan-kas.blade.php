<x-be.layouts.app
    :title="$tipe === 'income' ? 'Kas Masuk' : 'Kas Keluar'"
    :description="$tipe === 'income'
        ? 'Catat seluruh pemasukan gereja: persembahan, perpuluhan, donasi.'
        : 'Catat seluruh pengeluaran gereja: operasional, honor, pemeliharaan.'"
>

    <main class="mx-auto w-full max-w-7xl flex-1 space-y-6">

        <x-be.page-header
            :title="$tipe === 'income' ? 'Kas Masuk' : 'Kas Keluar'"
            :description="$tipe === 'income'
                ? 'Catat seluruh pemasukan gereja: persembahan, perpuluhan, donasi.'
                : 'Catat seluruh pengeluaran gereja: operasional, honor, pemeliharaan.'"
        />

        <livewire:dashboard.kas-table :tipe="$tipe" />

    </main>

</x-be.layouts.app>
