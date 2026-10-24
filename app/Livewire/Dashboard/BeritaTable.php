<?php

namespace App\Livewire\Dashboard;

use App\Contracts\Services\NewsManagementServiceInterface;
use App\Models\News;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Komponen "Berita" pada dashboard.
 *
 * Tabel artikel berita dengan pencarian, filter status, toggle terbit/draft,
 * dan hapus berkonfirmasi.
 *
 * Akses dibatasi untuk pemilik permission "Kelola Berita" (lihat mount()).
 */
final class BeritaTable extends Component
{
    use WithPagination;

    /** Kata kunci pencarian pada tabel. */
    public string $cari = '';

    /** Filter status: '' (semua), 'draft', 'published'. */
    public string $filterStatus = '';

    /** Id berita yang menunggu konfirmasi penghapusan. */
    public ?int $hapusId = null;

    /** Judul berita yang menunggu konfirmasi penghapusan. */
    public ?string $hapusJudul = null;

    /** State modal konfirmasi hapus (di-entangle ke Alpine). */
    public bool $hapusOpen = false;

    /** Pesan notifikasi inline (dipakai blade, konsisten dengan test). */
    public ?string $pesan = null;

    /** Tone notifikasi inline: 'success' | 'error'. */
    public string $pesanTone = 'success';

    /** Batasi halaman hanya untuk pemilik permission "Kelola Berita". */
    public function mount(): void
    {
        abort_unless(auth()->user()?->can('Kelola Berita'), 403);
    }

    /** Statistik jumlah berita per status. */
    #[Computed]
    public function statistik(): array
    {
        return $this->newsService()->statistics();
    }

    /** Daftar berita terfilter, terbaru dulu. */
    #[Computed]
    public function berita(): LengthAwarePaginator
    {
        return $this->newsService()->paginate($this->cari, $this->filterStatus, 10);
    }

    private function newsService(): NewsManagementServiceInterface
    {
        return app(NewsManagementServiceInterface::class);
    }

    /** Reset pagination saat pencarian berubah. */
    public function updatedCari(): void
    {
        $this->resetPage();
    }

    /** Reset pagination saat filter berubah. */
    public function updatedFilterStatus(): void
    {
        $this->resetPage();
    }

    /** Reset filter pencarian dan status. */
    public function resetFilter(): void
    {
        $this->reset('cari', 'filterStatus');
        $this->resetPage();
    }

    /** Toggle status terbit/draft langsung dari tabel. */
    public function toggleStatus(int $id): void
    {
        $news = $this->newsService()->toggleStatus(
            News::findOrFail($id)
        );

        notify()
            ->success()
            ->title($news->status === 'published' ? 'Berita Diterbitkan' : 'Berita Dijadikan Draft')
            ->send();

        // Notifikasi inline untuk konsistensi blade + test.
        $this->pesan = $news->status === 'published'
            ? 'Berita diterbitkan.'
            : 'Berita dijadikan draft.';
        $this->pesanTone = 'success';

        unset($this->berita, $this->statistik);
    }

    /** Buka modal konfirmasi hapus berita. */
    public function bukaKonfirmasiHapus(int $id): void
    {
        $news = News::findOrFail($id);
        $this->hapusId = $news->id;
        $this->hapusJudul = $news->title;
        $this->hapusOpen = true;
    }

    /** Hapus berita + banner. */
    public function hapus(): void
    {
        $news = News::findOrFail($this->hapusId);

        $this->newsService()->delete($news);

        unset($this->berita, $this->statistik, $this->hapusId, $this->hapusJudul);

        $this->hapusOpen = false;
        notify()->success()->title('Berita Dihapus')->send();
        $this->pesan = 'Berita berhasil dihapus.';
        $this->pesanTone = 'success';
    }

    public function render()
    {
        return view('livewire.berita-table');
    }
}
