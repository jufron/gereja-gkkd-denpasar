<?php

namespace App\Livewire\Dashboard;

use App\Models\Badge;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

/**
 * Komponen "Jadwal Manager" pada halaman Jadwal Ibadah.
 *
 * Mengelola jadwal pertemuan & ibadah jemaat yang berelasi dengan badge
 * kategori (satu jadwal memiliki satu badge).
 *
 * Akses dibatasi untuk user dengan permission "Kelola Jadwal" (lihat mount()).
 */
final class JadwalManager extends Component
{
    // ─────────────────────────────────────────────────────────────────────
    // State komponen
    // ─────────────────────────────────────────────────────────────────────

    /** Id jadwal yang sedang diubah di modal. */
    #[Locked]
    public ?int $scheduleId = null;

    /** Id badge kategori jadwal. */
    public ?int $badgeId = null;

    public string $title = '';

    public string $time = '';

    public string $day = '';

    public string $description = '';

    public int $sortOrder = 0;

    public bool $isActive = true;

    /** Id jadwal yang menunggu konfirmasi penghapusan. */
    public ?int $hapusId = null;

    /** State modal form tambah/ubah jadwal (di-entangle ke Alpine). */
    public bool $formOpen = false;

    /** State modal konfirmasi hapus (di-entangle ke Alpine). */
    public bool $hapusOpen = false;

    /** Pesan notifikasi sementara (success/error) untuk view. */
    public ?string $pesan = null;

    public string $pesanTone = 'success';

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

    /** Daftar jadwal beserta badge kategorinya, urut sesuai sort_order. */
    #[Computed]
    public function schedules(): Collection
    {
        return Schedule::query()
            ->with('badge')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    /** Semua badge untuk pilihan kategori di form. */
    #[Computed]
    public function badges(): Collection
    {
        return Badge::query()->orderBy('name')->get();
    }

    // ─────────────────────────────────────────────────────────────────────
    // Aksi CRUD
    // ─────────────────────────────────────────────────────────────────────

    /** Buka modal dalam mode tambah jadwal baru. */
    public function bukaFormTambah(): void
    {
        $this->reset('scheduleId', 'title', 'time', 'day', 'description', 'sortOrder');
        $this->badgeId = $this->badges->first()?->id;
        $this->isActive = true;
        $this->resetValidation();
        $this->formOpen = true;
    }

    /** Buka modal dalam mode ubah jadwal. */
    public function bukaFormUbah(int $scheduleId): void
    {
        $schedule = Schedule::findOrFail($scheduleId);

        $this->scheduleId = $schedule->id;
        $this->badgeId = $schedule->badge_id;
        $this->title = $schedule->title;
        $this->time = $schedule->time;
        $this->day = $schedule->day;
        $this->description = $schedule->description;
        $this->sortOrder = $schedule->sort_order;
        $this->isActive = $schedule->is_active;
        $this->resetValidation();
        $this->formOpen = true;
    }

    /** Simpan jadwal (buat baru atau perbarui). */
    public function simpan(): void
    {
        $data = $this->validate([
            'badgeId' => ['required', 'integer', 'exists:badges,id'],
            'title' => ['required', 'string', 'max:100'],
            'time' => ['required', 'string', 'max:100'],
            'day' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:1000'],
            'sortOrder' => ['required', 'integer', 'min:0', 'max:9999'],
            'isActive' => ['boolean'],
        ]);

        $payload = [
            'badge_id' => $data['badgeId'],
            'title' => trim($data['title']),
            'time' => trim($data['time']),
            'day' => trim($data['day']),
            'description' => trim($data['description']),
            'sort_order' => $data['sortOrder'],
            'is_active' => $this->isActive,
        ];

        if ($this->scheduleId) {
            $schedule = Schedule::findOrFail($this->scheduleId);
            $schedule->update($payload);

            activity('jadwal')
                ->on($schedule)
                ->withProperties(['judul' => $payload['title']])
                ->log('Ubah jadwal ibadah');

            $this->setPesan('Jadwal berhasil diperbarui.', 'success');
        } else {
            $schedule = Schedule::create($payload);

            activity('jadwal')
                ->on($schedule)
                ->withProperties(['judul' => $payload['title']])
                ->log('Tambah jadwal ibadah');

            $this->setPesan('Jadwal baru berhasil ditambahkan.', 'success');
        }

        // Reset cache computed agar daftar jadwal diperbarui.
        unset($this->schedules);

        $this->reset('title', 'time', 'day', 'description');
        $this->formOpen = false;
    }

    /** Aktifkan/nonaktifkan jadwal langsung dari tabel. */
    public function toggleAktif(int $scheduleId): void
    {
        $schedule = Schedule::findOrFail($scheduleId);
        $schedule->update(['is_active' => ! $schedule->is_active]);

        activity('jadwal')
            ->on($schedule)
            ->withProperties(['judul' => $schedule->title, 'aktif' => $schedule->is_active])
            ->log('Ubah status jadwal ibadah');

        unset($this->schedules);
    }

    /** Buka modal konfirmasi hapus jadwal. */
    public function bukaKonfirmasiHapus(int $scheduleId): void
    {
        $this->hapusId = $scheduleId;
        $this->hapusOpen = true;
    }

    /** Hapus jadwal. */
    public function hapus(): void
    {
        $schedule = Schedule::findOrFail($this->hapusId);
        $judul = $schedule->title;

        $schedule->delete();

        activity('jadwal')->withProperties(['judul' => $judul])->log('Hapus jadwal ibadah');

        if ($this->scheduleId === (int) $schedule->id) {
            $this->scheduleId = null;
        }

        unset($this->schedules, $this->hapusId);

        $this->hapusOpen = false;
        $this->setPesan('Jadwal berhasil dihapus.', 'success');
    }

    // ─────────────────────────────────────────────────────────────────────
    // Render
    // ─────────────────────────────────────────────────────────────────────

    public function render()
    {
        return view('livewire.jadwal-manager');
    }
}
