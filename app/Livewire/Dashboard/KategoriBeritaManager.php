<?php

namespace App\Livewire\Dashboard;

use App\Models\NewsCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

/**
 * Komponen "Kategori Berita" pada dashboard.
 *
 * Mengelola kategori/tag berita yang dipakai halaman berita publik
 * (mis. "Renungan", "Aksi Kasih", "Pengumuman").
 *
 * Akses dibatasi untuk user dengan permission "Kelola Berita" (lihat mount()).
 */
final class KategoriBeritaManager extends Component
{
    // ─────────────────────────────────────────────────────────────────────
    // State komponen
    // ─────────────────────────────────────────────────────────────────────

    /** Id kategori yang sedang diubah di modal. */
    #[Locked]
    public ?int $kategoriId = null;

    /** Nama kategori pada modal tambah/edit. */
    public string $name = '';

    /** Kelas warna Tailwind untuk label kategori. */
    public string $color = 'bg-accent/10 text-accent dark:text-accent-soft';

    /** Deskripsi singkat kategori. */
    public string $description = '';

    /** Urutan tampil kategori. */
    public int $sortOrder = 0;

    /** Status aktif kategori (hanya yang aktif tampil di publik). */
    public bool $isActive = true;

    /** Id kategori yang menunggu konfirmasi penghapusan. */
    public ?int $hapusId = null;

    /** Kata kunci pencarian pada tabel. */
    public string $cari = '';

    /** Filter status pada tabel: '' (semua), 'aktif', 'nonaktif'. */
    public string $filterStatus = '';

    /** State modal form tambah/ubah kategori (di-entangle ke Alpine). */
    public bool $formOpen = false;

    /** State modal konfirmasi hapus (di-entangle ke Alpine). */
    public bool $hapusOpen = false;

    /** Pesan notifikasi sementara (success/error) untuk view. */
    public ?string $pesan = null;

    public string $pesanTone = 'success';

    /**
     * Pilihan warna siap pakai.
     *
     * Kelas Tailwind harus tertulis di source agar ikut di-generate oleh
     * Tailwind v4 (kelas yang hanya ada di database tidak akan ditemukan).
     *
     * @var array<string, string>
     */
    public const COLOR_OPTIONS = [
        'Ungu (default)' => 'bg-accent/10 text-accent dark:text-accent-soft',
        'Biru' => 'bg-blue-500/10 text-blue-600 dark:text-blue-400',
        'Hijau' => 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400',
        'Merah' => 'bg-rose-500/10 text-rose-600 dark:text-rose-400',
        'Kuning' => 'bg-amber-500/10 text-amber-600 dark:text-amber-400',
        'Netral' => 'bg-slate-500/10 text-slate-600 dark:text-slate-400',
    ];

    // ─────────────────────────────────────────────────────────────────────
    // Siklus hidup & helper
    // ─────────────────────────────────────────────────────────────────────

    /** Batasi halaman hanya untuk pemilik permission "Kelola Berita". */
    public function mount(): void
    {
        abort_unless(auth()->user()?->can('Kelola Berita'), 403);
    }

    /** Simpan notifikasi sementara untuk ditampilkan di view. */
    public function setPesan(string $pesan, string $tone = 'success'): void
    {
        $this->pesan = $pesan;
        $this->pesanTone = $tone;
    }

    /** Reset filter pencarian dan status. */
    public function resetFilter(): void
    {
        $this->reset('cari', 'filterStatus');
    }

    // ─────────────────────────────────────────────────────────────────────
    // Data (computed)
    // ─────────────────────────────────────────────────────────────────────

    /** Daftar kategori terfilter, urut sesuai sort_order. */
    #[Computed]
    public function categories(): Collection
    {
        $cari = trim($this->cari);

        return NewsCategory::query()
            ->when($cari !== '', fn ($query) => $query->where(function ($q) use ($cari) {
                $q->where('name', 'like', "%{$cari}%")
                    ->orWhere('slug', 'like', "%{$cari}%")
                    ->orWhere('description', 'like', "%{$cari}%");
            }))
            ->when($this->filterStatus === 'aktif', fn ($query) => $query->where('is_active', true))
            ->when($this->filterStatus === 'nonaktif', fn ($query) => $query->where('is_active', false))
            ->ordered()
            ->get();
    }

    /** Ringkasan angka untuk kartu statistik. */
    #[Computed]
    public function statistik(): array
    {
        return [
            'total' => NewsCategory::count(),
            'aktif' => NewsCategory::where('is_active', true)->count(),
            'nonaktif' => NewsCategory::where('is_active', false)->count(),
        ];
    }

    /** Pilihan warna untuk ditampilkan di view. */
    public function colorOptions(): array
    {
        return self::COLOR_OPTIONS;
    }

    // ─────────────────────────────────────────────────────────────────────
    // Aksi CRUD
    // ─────────────────────────────────────────────────────────────────────

    /** Buka modal dalam mode tambah kategori baru. */
    public function bukaFormTambah(): void
    {
        $this->reset('name', 'description', 'kategoriId');
        $this->color = array_values(self::COLOR_OPTIONS)[0];
        // Taruh kategori baru di urutan paling akhir.
        $this->sortOrder = (int) NewsCategory::max('sort_order') + 1;
        $this->isActive = true;
        $this->resetValidation();
        $this->formOpen = true;
    }

    /** Buka modal dalam mode ubah kategori. */
    public function bukaFormUbah(int $kategoriId): void
    {
        $category = NewsCategory::findOrFail($kategoriId);

        $this->kategoriId = $category->id;
        $this->name = $category->name;
        $this->color = $category->color ?: array_values(self::COLOR_OPTIONS)[0];
        $this->description = $category->description ?? '';
        $this->sortOrder = $category->sort_order;
        $this->isActive = $category->is_active;
        $this->resetValidation();
        $this->formOpen = true;
    }

    /** Simpan kategori (buat baru atau perbarui), slug dibuat otomatis & unik. */
    public function simpan(): void
    {
        $data = $this->validate([
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'color' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'sortOrder' => ['required', 'integer', 'min:0', 'max:9999'],
            'isActive' => ['boolean'],
        ], [], [
            'name' => 'nama kategori',
            'color' => 'warna',
            'description' => 'deskripsi',
            'sortOrder' => 'urutan tampil',
        ]);

        $nama = trim($data['name']);
        $slug = $this->uniqueSlug($nama, $this->kategoriId);
        $deskripsi = trim((string) ($data['description'] ?? ''));

        $payload = [
            'name' => $nama,
            'slug' => $slug,
            'color' => $data['color'],
            'description' => $deskripsi !== '' ? $deskripsi : null,
            'sort_order' => $data['sortOrder'],
            'is_active' => $this->isActive,
        ];

        if ($this->kategoriId) {
            $category = NewsCategory::findOrFail($this->kategoriId);
            $category->update($payload);

            $this->setPesan('Kategori berita berhasil diperbarui.', 'success');
        } else {
            $category = NewsCategory::create($payload);

            $this->setPesan('Kategori berita baru berhasil ditambahkan.', 'success');
        }

        // Reset cache computed agar daftar kategori diperbarui.
        unset($this->categories, $this->statistik);

        $this->reset('name', 'description');
        $this->formOpen = false;
    }

    /** Aktifkan/nonaktifkan kategori langsung dari tabel. */
    public function toggleAktif(int $kategoriId): void
    {
        $category = NewsCategory::findOrFail($kategoriId);
        $category->update(['is_active' => ! $category->is_active]);

        unset($this->categories, $this->statistik);
    }

    /** Buka modal konfirmasi hapus kategori. */
    public function bukaKonfirmasiHapus(int $kategoriId): void
    {
        $this->hapusId = $kategoriId;
        $this->hapusOpen = true;
    }

    /** Hapus kategori. */
    public function hapus(): void
    {
        $category = NewsCategory::findOrFail($this->hapusId);

        $category->delete();

        if ($this->kategoriId === (int) $category->id) {
            $this->kategoriId = null;
        }

        unset($this->categories, $this->statistik, $this->hapusId);

        $this->hapusOpen = false;
        $this->setPesan('Kategori berita berhasil dihapus.', 'success');
    }

    /**
     * Buat slug unik dari nama kategori.
     *
     * Bila slug sudah dipakai, tambahkan akhiran angka (-2, -3, ...).
     * $ignoreId dipakai saat mengubah agar kategori itu sendiri tidak dianggap bentrok.
     */
    private function uniqueSlug(string $nama, ?int $ignoreId = null): string
    {
        $base = Str::slug($nama) ?: 'kategori';
        $slug = $base;
        $suffix = 2;

        while (
            NewsCategory::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }

    // ─────────────────────────────────────────────────────────────────────
    // Render
    // ─────────────────────────────────────────────────────────────────────

    public function render()
    {
        return view('livewire.kategori-berita-manager');
    }
}
