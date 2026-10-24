<?php

namespace App\Livewire\Dashboard;

use App\Models\FinanceCategory;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

/**
 * Komponen "Kategori Keuangan" pada dashboard.
 *
 * Mengelola kategori pemasukan/pengeluaran. Tipe (income | expense)
 * dipilih lewat tab; keduanya dikelola dalam satu manajer.
 */
final class FinanceCategoryManager extends Component
{
    /** Tipe yang sedang aktif di tab: income | expense. */
    #[Locked]
    public string $tipe = 'income';

    public ?int $kategoriId = null;
    public string $name = '';
    public string $code = '';
    public string $description = '';
    public int $sortOrder = 0;
    public bool $isActive = true;

    public string $cari = '';
    public string $filterStatus = '';

    public bool $formOpen = false;
    public bool $hapusOpen = false;
    public ?int $hapusId = null;

    public ?string $pesan = null;
    public string $pesanTone = 'success';

    public function mount(): void
    {
        abort_unless(auth()->user()?->can('Kelola Keuangan'), 403);
    }

    private function setPesan(string $pesan, string $tone = 'success'): void
    {
        $this->pesan = $pesan;
        $this->pesanTone = $tone;
    }

    public function pilihTipe(string $tipe): void
    {
        abort_unless(in_array($tipe, ['income', 'expense'], true), 422);
        $this->tipe = $tipe;
        unset($this->categories, $this->statistik);
    }

    public function resetFilter(): void
    {
        $this->reset('cari', 'filterStatus');
    }

    #[Computed]
    public function categories(): Collection
    {
        $cari = trim($this->cari);

        return FinanceCategory::query()
            ->ofType($this->tipe)
            ->when($cari !== '', fn ($q) => $q->where(function ($w) use ($cari) {
                $w->where('name', 'like', "%{$cari}%")
                    ->orWhere('code', 'like', "%{$cari}%")
                    ->orWhere('description', 'like', "%{$cari}%");
            }))
            ->when($this->filterStatus === 'aktif', fn ($q) => $q->active())
            ->when($this->filterStatus === 'nonaktif', fn ($q) => $q->where('is_active', false))
            ->ordered()
            ->get();
    }

    #[Computed]
    public function statistik(): array
    {
        $base = FinanceCategory::query()->ofType($this->tipe);

        return [
            'total' => (clone $base)->count(),
            'aktif' => (clone $base)->active()->count(),
            'nonaktif' => (clone $base)->where('is_active', false)->count(),
        ];
    }

    public function bukaFormTambah(): void
    {
        $this->reset('name', 'code', 'description', 'kategoriId');
        $this->sortOrder = (int) FinanceCategory::query()->ofType($this->tipe)->max('sort_order') + 1;
        $this->isActive = true;
        $this->resetValidation();
        $this->formOpen = true;
    }

    public function bukaFormUbah(int $id): void
    {
        $category = FinanceCategory::findOrFail($id);

        $this->kategoriId = $category->id;
        $this->name = $category->name;
        $this->code = $category->code ?? '';
        $this->description = $category->description ?? '';
        $this->sortOrder = $category->sort_order;
        $this->isActive = $category->is_active;
        $this->resetValidation();
        $this->formOpen = true;
    }

    public function simpan(): void
    {
        $data = $this->validate([
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'code' => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string', 'max:255'],
            'sortOrder' => ['required', 'integer', 'min:0', 'max:9999'],
            'isActive' => ['boolean'],
        ], [], [
            'name' => 'nama kategori',
            'code' => 'kode',
            'description' => 'deskripsi',
            'sortOrder' => 'urutan tampil',
        ]);

        $name = trim($data['name']);

        // Nama harus unik per tipe.
        $exists = FinanceCategory::query()
            ->ofType($this->tipe)
            ->where('name', $name)
            ->when($this->kategoriId, fn ($q) => $q->where('id', '!=', $this->kategoriId))
            ->exists();

        abort_if($exists, 422, 'Nama kategori sudah dipakai untuk tipe ini.');

        $payload = [
            'name' => $name,
            'code' => trim((string) ($data['code'] ?? '')) ?: null,
            'description' => trim((string) ($data['description'] ?? '')) ?: null,
            'sort_order' => $data['sortOrder'],
            'is_active' => $this->isActive,
        ];

        if ($this->kategoriId) {
            $category = FinanceCategory::findOrFail($this->kategoriId);
            $category->update($payload);
            $this->setPesan('Kategori keuangan berhasil diperbarui.');
        } else {
            FinanceCategory::create($payload + ['type' => $this->tipe]);
            $this->setPesan('Kategori keuangan baru berhasil ditambahkan.');
        }

        unset($this->categories, $this->statistik);

        $this->reset('name', 'code', 'description');
        $this->formOpen = false;
    }

    public function toggleAktif(int $id): void
    {
        $category = FinanceCategory::findOrFail($id);
        $category->update(['is_active' => ! $category->is_active]);

        unset($this->categories, $this->statistik);
    }

    public function bukaKonfirmasiHapus(int $id): void
    {
        $this->hapusId = $id;
        $this->hapusOpen = true;
    }

    public function hapus(): void
    {
        $category = FinanceCategory::findOrFail($this->hapusId);

        // Kategori yang sudah terpakai tidak bisa dihapus (DB restrictOnDelete).
        try {
            $category->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            $this->hapusOpen = false;
            $this->setPesan('Kategori tidak dapat dihapus karena sudah dipakai transaksi.', 'error');
            return;
        }

        unset($this->categories, $this->statistik, $this->hapusId);
        $this->hapusOpen = false;
        $this->setPesan('Kategori keuangan berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.finance-category-manager');
    }
}
