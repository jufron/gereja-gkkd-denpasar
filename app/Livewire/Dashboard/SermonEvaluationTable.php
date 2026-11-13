<?php

namespace App\Livewire\Dashboard;

use App\Models\SermonEvaluation;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Tabel evaluasi khotbah di dashboard. Khusus Administrator.
 */
final class SermonEvaluationTable extends Component
{
    use WithPagination;

    public string $cari = '';

    public string $bulan = '';

    public string $tahun = '';

    public string $rating = '';

    public ?int $hapusId = null;

    public bool $hapusOpen = false;

    public function mount(): void
    {
        abort_unless(auth()->user()?->hasRole('Administrator'), 403);
    }

    private function aplikasikanFilter($query)
    {
        return $query
            ->when($this->cari !== '', fn ($q) => $q->where('nama', 'like', "%{$this->cari}%"))
            ->when($this->bulan !== '', fn ($q) => $q->where('bulan', (int) $this->bulan))
            ->when($this->tahun !== '', fn ($q) => $q->where('tahun', (int) $this->tahun))
            ->when($this->rating !== '', fn ($q) => $q->where('rating', (int) $this->rating));
    }

    #[Computed]
    public function evaluasi(): LengthAwarePaginator
    {
        return $this->aplikasikanFilter(SermonEvaluation::query())
            ->orderByDesc('created_at')
            ->paginate(10);
    }

    #[Computed]
    public function statistik(): array
    {
        $ratings = $this->aplikasikanFilter(SermonEvaluation::query())->pluck('rating');
        $total = $ratings->count();
        $rataRata = $total ? round($ratings->avg(), 1) : 0.0;

        $distribusi = [];
        foreach (range(1, 5) as $n) {
            $distribusi[$n] = $ratings->filter(fn ($r) => (int) $r === $n)->count();
        }

        $periode = 'Semua periode';
        if ($this->bulan !== '' && $this->tahun !== '') {
            $periode = (SermonEvaluation::BULAN[(int) $this->bulan] ?? '').' '.$this->tahun;
        } elseif ($this->bulan !== '') {
            $periode = SermonEvaluation::BULAN[(int) $this->bulan] ?? '';
        } elseif ($this->tahun !== '') {
            $periode = 'Tahun '.$this->tahun;
        }

        return [
            'total' => $total,
            'rataRata' => number_format($rataRata, 1, ',', '.'),
            'distribusi' => $distribusi,
            'periode' => $periode,
        ];
    }

    public function updatedCari(): void
    {
        $this->resetPage();
    }

    public function updatedBulan(): void
    {
        $this->resetPage();
    }

    public function updatedTahun(): void
    {
        $this->resetPage();
    }

    public function updatedRating(): void
    {
        $this->resetPage();
    }

    public function resetFilter(): void
    {
        $this->reset('cari', 'bulan', 'tahun', 'rating');
        $this->resetPage();
    }

    public function bukaKonfirmasiHapus(int $id): void
    {
        $this->hapusId = $id;
        $this->hapusOpen = true;
    }

    public function hapus(): void
    {
        $evaluasi = SermonEvaluation::findOrFail($this->hapusId);
        $evaluasi->delete();

        activity('evaluasi')
            ->withProperties(['bulan' => $evaluasi->bulan, 'tahun' => $evaluasi->tahun])
            ->log('Hapus evaluasi khotbah');

        unset($this->evaluasi, $this->statistik, $this->hapusId);
        $this->hapusOpen = false;
        notify()->success()->title('Evaluasi Dihapus')->send();
    }

    public function render()
    {
        return view('livewire.sermon-evaluation-table');
    }
}
