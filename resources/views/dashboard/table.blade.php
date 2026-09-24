<x-be.layouts.app title="Data Jemaat" description="Kelola data jemaat GKKD Bali">

    <main class="mx-auto w-full max-w-7xl flex-1 space-y-6" x-data="{ createOpen: false }">

        <x-be.page-header
            title="Data Jemaat"
            description="Daftar lengkap jemaat dan pendaftar pelayanan GKKD Bali."
        >
            <x-be.button variant="ghost" as="button" type="button" icon="fa-download">Export Data</x-be.button>
            <x-be.button as="button" type="button" icon="fa-plus" @click="createOpen = true">Tambah Data</x-be.button>
        </x-be.page-header>

        {{-- Filters --}}
        <x-be.card class="p-5">
            <div class="grid grid-cols-1 items-end gap-4 md:grid-cols-2 lg:grid-cols-4">
                <x-be.field label="Cari Jemaat" for="filterSearch">
                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-muted"></i>
                        <input id="filterSearch" type="text" placeholder="Nama atau telepon..." class="be-input pl-9">
                    </div>
                </x-be.field>

                <x-be.field label="Status" for="filterStatus">
                    <select id="filterStatus" class="be-input">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="verifikasi">Verifikasi</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </x-be.field>

                <x-be.field label="Sektor Area" for="filterSektor">
                    <select id="filterSektor" class="be-input">
                        <option value="">Semua Sektor</option>
                        <option value="denpasar-selatan">Denpasar Selatan</option>
                        <option value="denpasar-barat">Denpasar Barat</option>
                        <option value="kuta-utara">Kuta Utara, Badung</option>
                    </select>
                </x-be.field>

                <x-be.button as="button" type="button" variant="ghost" icon="fa-rotate-left">Reset Filter</x-be.button>
            </div>
        </x-be.card>

        {{-- Data table --}}
        <x-be.card class="overflow-hidden">
            <div class="flex flex-col justify-between gap-4 border-b border-line p-5 sm:flex-row sm:items-center">
                <div>
                    <h3 class="text-base font-bold text-ink">Daftar Jemaat</h3>
                    <p class="text-xs text-muted">Total 4 jemaat terdaftar di sistem</p>
                </div>
                <x-be.button as="button" type="button" variant="ghost" icon="fa-filter">Filter</x-be.button>
            </div>

            {{-- TODO: ganti baris contoh di bawah dengan query ke tabel jemaat + pagination. --}}
            <div class="w-full overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-line bg-ink/[0.03] text-[11px] font-semibold uppercase tracking-wider text-muted">
                            <th class="px-6 py-3.5">#</th>
                            <th class="px-6 py-3.5">Nama Jemaat</th>
                            <th class="px-6 py-3.5">Pelayanan</th>
                            <th class="px-6 py-3.5">Sektor Area</th>
                            <th class="px-6 py-3.5">Tanggal Daftar</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line text-xs text-ink/80">
                        @foreach ([
                            ['no' => '01', 'initials' => 'DP', 'name' => 'Daniel Pratama', 'phone' => '0812-3456-7890', 'ministry' => 'Praise & Worship', 'area' => 'Denpasar Selatan', 'date' => '12 Sep 2026', 'status' => 'Aktif', 'tone' => 'success'],
                            ['no' => '02', 'initials' => 'SK', 'name' => 'Sarah Kartika', 'phone' => '0819-8765-4321', 'ministry' => 'Multimedia & Creative', 'area' => 'Kuta Utara, Badung', 'date' => '15 Sep 2026', 'status' => 'Verifikasi', 'tone' => 'warning'],
                            ['no' => '03', 'initials' => 'KW', 'name' => 'Kevin Wibowo', 'phone' => '0853-1122-3344', 'ministry' => 'Sekolah Minggu', 'area' => 'Denpasar Barat', 'date' => '18 Sep 2026', 'status' => 'Aktif', 'tone' => 'success'],
                            ['no' => '04', 'initials' => 'ML', 'name' => 'Maria Lestari', 'phone' => '0878-5566-7788', 'ministry' => 'Pelayanan Diakonia', 'area' => 'Denpasar Selatan', 'date' => '20 Sep 2026', 'status' => 'Nonaktif', 'tone' => 'neutral'],
                        ] as $row)
                            <tr class="transition-colors hover:bg-ink/[0.02]">
                                <td class="px-6 py-4 font-medium text-muted">{{ $row['no'] }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-accent/10 text-xs font-bold text-accent">
                                            {{ $row['initials'] }}
                                        </span>
                                        <div>
                                            <p class="font-bold text-ink">{{ $row['name'] }}</p>
                                            <p class="text-[11px] text-muted">{{ $row['phone'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">{{ $row['ministry'] }}</td>
                                <td class="px-6 py-4">{{ $row['area'] }}</td>
                                <td class="px-6 py-4 text-muted">{{ $row['date'] }}</td>
                                <td class="px-6 py-4">
                                    <x-be.badge :tone="$row['tone']">{{ $row['status'] }}</x-be.badge>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="relative inline-block" x-data="{ open: false }">
                                        <button @click="open = !open" @click.outside="open = false" class="rounded-lg p-1.5 text-muted transition-colors hover:text-accent" aria-label="Opsi">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <div
                                            x-show="open"
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                            x-transition:leave="transition ease-in duration-150"
                                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                            x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                                            class="absolute right-0 z-50 mt-2 w-40 rounded-2xl border border-line bg-card py-1.5 shadow-xl"
                                            style="display: none;"
                                        >
                                            <a href="#" class="flex items-center gap-2.5 px-4 py-2 text-xs text-muted transition-colors hover:bg-ink/5 hover:text-accent">
                                                <i class="fa-solid fa-eye w-4 text-center"></i> Lihat Detail
                                            </a>
                                            <a href="#" class="flex items-center gap-2.5 px-4 py-2 text-xs text-muted transition-colors hover:bg-ink/5 hover:text-accent">
                                                <i class="fa-solid fa-pen w-4 text-center"></i> Edit
                                            </a>
                                            <a href="#" class="flex items-center gap-2.5 px-4 py-2 text-xs text-danger transition-colors hover:bg-danger/10">
                                                <i class="fa-solid fa-trash w-4 text-center"></i> Hapus
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="flex flex-col justify-between gap-4 border-t border-line p-5 sm:flex-row sm:items-center">
                <p class="text-xs text-muted">Menampilkan <span class="font-semibold text-ink">1–4</span> dari <span class="font-semibold text-ink">4</span> jemaat</p>
                <div class="flex items-center gap-2">
                    <button class="inline-flex cursor-not-allowed items-center gap-1.5 rounded-xl border border-line px-3 py-2 text-xs font-semibold text-muted" disabled>
                        <i class="fa-solid fa-chevron-left text-[10px]"></i> Sebelumnya
                    </button>
                    <button class="inline-flex cursor-not-allowed items-center gap-1.5 rounded-xl border border-line px-3 py-2 text-xs font-semibold text-muted" disabled>
                        Berikutnya <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </button>
                </div>
            </div>
        </x-be.card>

        {{-- Create modal --}}
        <div
            x-show="createOpen"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[60] flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm"
            style="display: none;"
            @keydown.escape.window="createOpen = false"
        >
            <div
                x-show="createOpen"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                class="flex max-h-[90vh] w-full max-w-2xl flex-col rounded-3xl bg-card shadow-2xl"
                @click.outside="createOpen = false"
            >
                <div class="flex items-center justify-between border-b border-line p-6">
                    <div>
                        <h3 class="text-base font-bold text-ink">Tambah Data Jemaat</h3>
                        <p class="text-xs text-muted">Isi formulir untuk mendaftarkan jemaat baru.</p>
                    </div>
                    <button @click="createOpen = false" class="flex h-9 w-9 items-center justify-center rounded-xl bg-ink/5 text-muted transition-colors hover:text-ink">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="overflow-y-auto p-6">
                    {{-- TODO: sambungkan ke endpoint store jemaat. --}}
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <x-be.field label="Nama Lengkap" for="formNama">
                            <input id="formNama" type="text" placeholder="Contoh: Daniel Pratama" class="be-input">
                        </x-be.field>

                        <x-be.field label="Nomor Telepon" for="formTelepon">
                            <input id="formTelepon" type="tel" placeholder="0812-3456-7890" class="be-input">
                        </x-be.field>

                        <x-be.field label="Bidang Pelayanan" for="formPelayanan">
                            <select id="formPelayanan" class="be-input">
                                <option value="">Pilih pelayanan</option>
                                <option value="pw">Praise &amp; Worship</option>
                                <option value="multimedia">Multimedia &amp; Creative</option>
                                <option value="sekolah-minggu">Sekolah Minggu</option>
                                <option value="diakonia">Pelayanan Diakonia</option>
                            </select>
                        </x-be.field>

                        <x-be.field label="Sektor Area" for="formSektor">
                            <select id="formSektor" class="be-input">
                                <option value="">Pilih sektor</option>
                                <option value="denpasar-selatan">Denpasar Selatan</option>
                                <option value="denpasar-barat">Denpasar Barat</option>
                                <option value="kuta-utara">Kuta Utara, Badung</option>
                            </select>
                        </x-be.field>

                        <x-be.field label="Tanggal Daftar" for="formTanggal">
                            <input id="formTanggal" type="date" class="be-input">
                        </x-be.field>

                        <x-be.field label="Status" for="formStatus">
                            <select id="formStatus" class="be-input">
                                <option value="aktif">Aktif</option>
                                <option value="verifikasi">Verifikasi</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </x-be.field>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2.5 border-t border-line p-6">
                    <button @click="createOpen = false" class="be-btn be-btn-ghost">Batal</button>
                    <x-be.button icon="fa-check">Simpan Data</x-be.button>
                </div>
            </div>
        </div>

    </main>

</x-be.layouts.app>
