<?php

namespace App\Livewire\Dashboard;

use App\Models\Sermon;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Komponen "Khotbah" pada dashboard.
 *
 * Tabel rangkuman khotbah dengan pencarian, filter status, toggle
 * terbit/draft, dan hapus berkonfirmasi.
 *
 * Akses dibatasi untuk pemilik permission "Kelola Khotbah" (lihat mount()).
 */
final class SermonTable extends Component
{
    use WithPagination;

    public string $cari = '';

    public string $filterStatus = '';

    public ?int $hapusId = null;

    public ?string $hapusJudul = null;

    public bool $hapusOpen = false;

    public ?string $pesan = null;

    public string $pesanTone = 'success';

    public function mount(): void
    {
        abort_unless(auth()->user()?->can('Kelola Khotbah'), 403);
    }

    #[Computed]
    public function statistik(): array
    {
        return [
            'total' => Sermon::count(),
            'published' => Sermon::where('status', 'published')->count(),
            'draft' => Sermon::where('status', 'draft')->count(),
        ];
    }

    #[Computed]
    public function sermons(): LengthAwarePaginator
    {
        return Sermon::query()
            ->with('mediaUsages.media')
            ->when($this->cari !== '', fn ($q) => $q->where(function ($w) {
                $w->where('title', 'like', "%{$this->cari}%")
                    ->orWhere('preacher', 'like', "%{$this->cari}%");
            }))
            ->when($this->filterStatus !== '', fn ($q) => $q->where('status', $this->filterStatus))
            ->latest('preached_at')
            ->paginate(10);
    }

    public function updatedCari(): void
    {
        $this->resetPage();
    }

    public function updatedFilterStatus(): void
    {
        $this->resetPage();
    }

    public function resetFilter(): void
    {
        $this->reset('cari', 'filterStatus');
        $this->resetPage();
    }

    public function toggleStatus(int $id): void
    {
        $sermon = Sermon::findOrFail($id);

        if ($sermon->status === 'published') {
            $sermon->fill(['status' => 'draft', 'published_at' => null])->saveQuietly();
            $this->pesan = 'Khotbah dijadikan draft.';
        } else {
            $sermon->fill(['status' => 'published', 'published_at' => $sermon->published_at ?? now()])->saveQuietly();
            $this->pesan = 'Khotbah diterbitkan.';
        }

        $this->pesanTone = 'success';
        notify()->success()->title($this->pesan)->send();

        unset($this->sermons, $this->statistik);
    }

    public function bukaKonfirmasiHapus(int $id): void
    {
        $sermon = Sermon::findOrFail($id);
        $this->hapusId = $sermon->id;
        $this->hapusJudul = $sermon->title;
        $this->hapusOpen = true;
    }

    public function hapus(): void
    {
        Sermon::findOrFail($this->hapusId)->delete();

        unset($this->sermons, $this->statistik, $this->hapusId, $this->hapusJudul);

        $this->hapusOpen = false;
        notify()->success()->title('Khotbah Dihapus')->send();
        $this->pesan = 'Khotbah berhasil dihapus.';
        $this->pesanTone = 'success';
    }

    public function render()
    {
        return view('livewire.sermon-table');
    }
}
