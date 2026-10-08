<?php

namespace App\Livewire\Dashboard;

use App\Models\Badge;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

/**
 * Komponen "Badge Manager" pada halaman Jadwal Ibadah.
 *
 * Mengelola badge kategori jadwal (label seperti "Tim Pelayanan",
 * "Komunitas Sel") yang berelasi satu-ke-banyak dengan tabel schedules.
 *
 * Akses dibatasi untuk user dengan permission "Kelola Jadwal" (lihat mount()).
 */
final class BadgeManager extends Component
{
    // ─────────────────────────────────────────────────────────────────────
    // State komponen
    // ─────────────────────────────────────────────────────────────────────

    /** Id badge yang sedang diubah di modal. */
    #[Locked]
    public ?int $badgeId = null;

    /** Nama badge pada modal tambah/edit. */
    public string $name = '';

    /** Kelas warna Tailwind untuk badge. */
    public string $color = 'bg-accent/10 text-accent dark:text-accent-soft';

    /** Id badge yang menunggu konfirmasi penghapusan. */
    public ?int $hapusId = null;

    /** State modal form tambah/ubah badge (di-entangle ke Alpine). */
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

    /** Batasi halaman hanya untuk pemilik permission "Kelola Jadwal". */
    public function mount(): void
    {
        abort_unless(auth()->user()?->can('Kelola Jadwal'), 403);
    }

    /** Simpan notifikasi sementara untuk ditampilkan di view. */
    public function setPesan(string $pesan, string $tone = 'success'): void
    {
        $this->pesan = $pesan;
        $this->pesanTone = $tone;
    }

    // ─────────────────────────────────────────────────────────────────────
    // Data (computed)
    // ─────────────────────────────────────────────────────────────────────

    /** Daftar badge beserta jumlah jadwal yang memakainya. */
    #[Computed]
    public function badges(): Collection
    {
        return Badge::query()
            ->withCount('schedules')
            ->orderBy('name')
            ->get();
    }

    /** Pilihan warna untuk ditampilkan di view. */
    public function colorOptions(): array
    {
        return self::COLOR_OPTIONS;
    }

    // ─────────────────────────────────────────────────────────────────────
    // Aksi CRUD
    // ─────────────────────────────────────────────────────────────────────

    /** Buka modal dalam mode tambah badge baru. */
    public function bukaFormTambah(): void
    {
        $this->reset('name', 'badgeId');
        $this->color = array_values(self::COLOR_OPTIONS)[0];
        $this->resetValidation();
        $this->formOpen = true;
    }

    /** Buka modal dalam mode ubah badge. */
    public function bukaFormUbah(int $badgeId): void
    {
        $badge = Badge::findOrFail($badgeId);

        $this->badgeId = $badge->id;
        $this->name = $badge->name;
        $this->color = $badge->color ?: array_values(self::COLOR_OPTIONS)[0];
        $this->resetValidation();
        $this->formOpen = true;
    }

    /** Simpan badge (buat baru atau perbarui), slug dibuat otomatis & unik. */
    public function simpan(): void
    {
        $data = $this->validate([
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'color' => ['required', 'string', 'max:255'],
        ]);

        $nama = trim($data['name']);
        $slug = $this->uniqueSlug($nama, $this->badgeId);

        if ($this->badgeId) {
            $badge = Badge::findOrFail($this->badgeId);
            $badge->update(['name' => $nama, 'slug' => $slug, 'color' => $data['color']]);

            activity('jadwal')
                ->on($badge)
                ->withProperties(['nama' => $nama])
                ->log('Ubah badge jadwal');

            $this->setPesan('Badge berhasil diperbarui.', 'success');
        } else {
            $badge = Badge::create(['name' => $nama, 'slug' => $slug, 'color' => $data['color']]);

            activity('jadwal')
                ->on($badge)
                ->withProperties(['nama' => $nama])
                ->log('Tambah badge jadwal');

            $this->setPesan('Badge baru berhasil ditambahkan.', 'success');
        }

        // Reset cache computed agar daftar badge diperbarui.
        unset($this->badges);

        $this->reset('name');
        $this->formOpen = false;
    }

    /** Buka modal konfirmasi hapus badge. */
    public function bukaKonfirmasiHapus(int $badgeId): void
    {
        $this->hapusId = $badgeId;
        $this->hapusOpen = true;
    }

    /** Hapus badge; ditolak bila masih dipakai oleh jadwal. */
    public function hapus(): void
    {
        $badge = Badge::withCount('schedules')->findOrFail($this->hapusId);

        if ($badge->schedules_count > 0) {
            $this->setPesan(
                "Badge \"{$badge->name}\" masih dipakai {$badge->schedules_count} jadwal. Pindahkan dulu jadwalnya.",
                'error'
            );

            $this->hapusOpen = false;

            return;
        }

        $badge->delete();

        activity('jadwal')->withProperties(['nama' => $badge->name])->log('Hapus badge jadwal');

        unset($this->badges, $this->hapusId);

        $this->hapusOpen = false;
        $this->setPesan('Badge berhasil dihapus.', 'success');
    }

    /**
     * Buat slug unik dari nama badge.
     *
     * Bila slug sudah dipakai, tambahkan akhiran angka (-2, -3, ...).
     * $ignoreId dipakai saat mengubah agar badge itu sendiri tidak dianggap bentrok.
     */
    private function uniqueSlug(string $nama, ?int $ignoreId = null): string
    {
        $base = Str::slug($nama) ?: 'badge';
        $slug = $base;
        $suffix = 2;

        while (
            Badge::query()
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
        return view('livewire.badge-manager');
    }
}
