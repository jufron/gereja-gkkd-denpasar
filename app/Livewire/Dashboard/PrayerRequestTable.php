<?php

namespace App\Livewire\Dashboard;

use App\Models\PrayerRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Tabel permohonan doa di dashboard. Khusus Administrator.
 */
final class PrayerRequestTable extends Component
{
    use WithPagination;

    public string $cari = '';

    public string $filterStatus = '';

    public string $filterKategori = '';

    public ?int $hapusId = null;

    public ?string $hapusNama = null;

    public bool $hapusOpen = false;

    public bool $hapusPermanenOpen = false;

    public function mount(): void
    {
        abort_unless(auth()->user()?->hasRole('Administrator'), 403);
    }

    #[Computed]
    public function doa(): LengthAwarePaginator
    {
        $trashed = $this->filterStatus === 'terhapus';
        $status = $trashed ? '' : $this->filterStatus;

        $query = $trashed
            ? PrayerRequest::onlyTrashed()
            : PrayerRequest::query();

        return $query
            ->filter($this->cari, $status, $this->filterKategori)
            ->orderByDesc('created_at')
            ->paginate(10);
    }

    #[Computed]
    public function statistik(): array
    {
        return [
            'baru' => PrayerRequest::where('status', 'baru')->count(),
            'diproses' => PrayerRequest::where('status', 'diproses')->count(),
            'selesai' => PrayerRequest::where('status', 'selesai')->count(),
            'terhapus' => PrayerRequest::onlyTrashed()->count(),
        ];
    }

    public function updatedCari(): void
    {
        $this->resetPage();
    }

    public function updatedFilterStatus(): void
    {
        $this->resetPage();
    }

    public function updatedFilterKategori(): void
    {
        $this->resetPage();
    }

    public function resetFilter(): void
    {
        $this->reset('cari', 'filterStatus', 'filterKategori');
        $this->resetPage();
    }

    public function updateStatus(int $id, string $status): void
    {
        $doa = PrayerRequest::findOrFail($id);

        $doa->update([
            'status' => $status,
            'didoakan_pada' => $status === 'selesai'
                ? ($doa->didoakan_pada ?? now())
                : $doa->didoakan_pada,
        ]);

        notify()->success()->title('Status Diperbarui')->send();
        unset($this->doa, $this->statistik);
    }

    public function restore(int $id): void
    {
        $doa = PrayerRequest::onlyTrashed()->findOrFail($id);
        $doa->restore();

        notify()->success()->title('Dipulihkan')->send();
        unset($this->doa, $this->statistik);
    }

    public function bukaKonfirmasiHapus(int $id): void
    {
        $doa = PrayerRequest::findOrFail($id);
        $this->hapusId = $doa->id;
        $this->hapusNama = $doa->nama_lengkap;
        $this->hapusOpen = true;
    }

    public function hapus(): void
    {
        $doa = PrayerRequest::findOrFail($this->hapusId);
        $doa->delete();

        unset($this->doa, $this->statistik, $this->hapusId, $this->hapusNama);
        $this->hapusOpen = false;
        notify()->success()->title('Permohonan Dihapus')->send();
    }

    public function bukaKonfirmasiHapusPermanen(int $id): void
    {
        $doa = PrayerRequest::onlyTrashed()->findOrFail($id);
        $this->hapusId = $doa->id;
        $this->hapusNama = $doa->nama_lengkap;
        $this->hapusPermanenOpen = true;
    }

    public function hapusPermanen(): void
    {
        $doa = PrayerRequest::onlyTrashed()->findOrFail($this->hapusId);
        $doa->forceDelete();

        activity('doa')
            ->withProperties(['id' => $doa->id])
            ->log('Doa dihapus permanen');

        unset($this->doa, $this->statistik, $this->hapusId, $this->hapusNama);
        $this->hapusPermanenOpen = false;
        notify()->success()->title('Dihapus Permanen')->send();
    }

    public function render()
    {
        return view('livewire.prayer-request-table');
    }
}
