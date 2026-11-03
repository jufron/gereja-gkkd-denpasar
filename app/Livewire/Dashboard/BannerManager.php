<?php

namespace App\Livewire\Dashboard;

use App\Http\Requests\Dashboard\SaveHeroBannerRequest;
use App\Models\AssetLibrary;
use App\Models\HeroBanner;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

/**
 * Komponen "Banner Manager" pada halaman Banner Beranda.
 *
 * Mengelola banner slider hero halaman utama. Gambar diunggah ke pustaka
 * media (koleksi hero-banner), metadata tampilan disimpan di hero_banners.
 *
 * Akses dibatasi untuk user dengan permission "Kelola Beranda" (lihat mount()).
 */
final class BannerManager extends Component
{
    use WithFileUploads;

    // ─────────────────────────────────────────────────────────────────────
    // State komponen
    // ─────────────────────────────────────────────────────────────────────

    /** Id banner yang sedang diubah di modal. */
    #[Locked]
    public ?int $bannerId = null;

    public string $badge = '';

    public string $caption = '';

    public string $alt = '';

    public string $linkUrl = '';

    public bool $isActive = true;

    /** File gambar yang diunggah (opsional saat ubah). */
    public ?TemporaryUploadedFile $foto = null;

    /** Id banner yang menunggu konfirmasi penghapusan. */
    public ?int $hapusId = null;

    public bool $formOpen = false;

    public bool $hapusOpen = false;

    public ?string $pesan = null;

    public string $pesanTone = 'success';

    // ─────────────────────────────────────────────────────────────────────
    // Siklus hidup & helper
    // ─────────────────────────────────────────────────────────────────────

    public function mount(): void
    {
        abort_unless(auth()->user()?->can('Kelola Beranda'), 403);
    }

    public function setPesan(string $pesan, string $tone = 'success'): void
    {
        $this->pesan = $pesan;
        $this->pesanTone = $tone;
    }

    // ─────────────────────────────────────────────────────────────────────
    // Data (computed)
    // ─────────────────────────────────────────────────────────────────────

    #[Computed]
    public function banners(): Collection
    {
        return HeroBanner::query()
            ->with('media')
            ->ordered()
            ->get();
    }

    // ─────────────────────────────────────────────────────────────────────
    // Aksi CRUD
    // ─────────────────────────────────────────────────────────────────────

    public function bukaFormTambah(): void
    {
        $this->reset(
            'bannerId',
            'badge',
            'caption',
            'alt',
            'linkUrl',
            'foto',
        );
        $this->isActive = true;
        $this->resetValidation();
        $this->formOpen = true;
    }

    public function bukaFormUbah(int $bannerId): void
    {
        $banner = HeroBanner::findOrFail($bannerId);

        $this->bannerId = $banner->id;
        $this->badge = $banner->badge;
        $this->caption = $banner->caption;
        $this->alt = $banner->alt;
        $this->linkUrl = $banner->link_url ?? '';
        $this->isActive = (bool) $banner->is_active;
        $this->foto = null;
        $this->resetValidation();
        $this->formOpen = true;
    }

    public function simpan(): void
    {
        $request = new SaveHeroBannerRequest;

        $data = $this->validate($request->rules(), $request->messages());

        $linkUrl = trim($data['linkUrl'] ?? '');
        $values = [
            'badge' => trim($data['badge']),
            'caption' => trim($data['caption']),
            'alt' => trim($data['alt']),
            'link_url' => $linkUrl === '' ? null : $linkUrl,
            'is_active' => $data['isActive'] ?? true,
        ];

        if ($this->foto) {
            $media = AssetLibrary::singleton()
                ->addMedia($this->foto)
                ->toMediaCollection('hero-banner');

            $values['media_id'] = $media->id;
        } elseif (! $this->bannerId) {
            $this->addError('foto', 'Gambar banner wajib diunggah.');
            $this->setPesan('Gambar banner wajib diunggah.', 'error');

            return;
        }

        if ($this->bannerId) {
            $banner = HeroBanner::findOrFail($this->bannerId);
            $banner->update($values);

            activity('beranda')
                ->on($banner)
                ->withProperties(['badge' => $values['badge']])
                ->log('Ubah banner beranda');

            $this->setPesan('Banner berhasil diperbarui.', 'success');
        } else {
            $banner = HeroBanner::create([
                'sort_order' => HeroBanner::query()->max('sort_order') + 1,
                ...$values,
            ]);

            activity('beranda')
                ->on($banner)
                ->withProperties(['badge' => $values['badge']])
                ->log('Tambah banner beranda');

            $this->setPesan('Banner baru berhasil ditambahkan.', 'success');
        }

        unset($this->banners);

        $this->reset('badge', 'caption', 'alt', 'linkUrl', 'foto');
        $this->formOpen = false;
    }

    public function bukaKonfirmasiHapus(int $bannerId): void
    {
        $this->hapusId = $bannerId;
        $this->hapusOpen = true;
    }

    public function hapus(): void
    {
        $banner = HeroBanner::findOrFail($this->hapusId);

        $badge = $banner->badge;

        $banner->delete();

        activity('beranda')
            ->withProperties(['badge' => $badge])
            ->log('Hapus banner beranda');

        unset($this->banners, $this->hapusId);

        $this->hapusOpen = false;
        $this->setPesan('Banner berhasil dihapus.', 'success');
    }

    public function naik(int $bannerId): void
    {
        $this->pindah($bannerId, -1);
    }

    public function turun(int $bannerId): void
    {
        $this->pindah($bannerId, 1);
    }

    public function toggleAktif(int $bannerId): void
    {
        $banner = HeroBanner::findOrFail($bannerId);
        $banner->update(['is_active' => ! $banner->is_active]);

        unset($this->banners);
    }

    private function pindah(int $bannerId, int $arah): void
    {
        $list = HeroBanner::query()->ordered()->get()->values();

        $index = $list->search(fn (HeroBanner $b) => $b->id === $bannerId);

        if ($index === false || $index + $arah < 0 || $index + $arah >= $list->count()) {
            return;
        }

        $banner = $list[$index];
        $tetangga = $list[$index + $arah];

        $tmp = $banner->sort_order;
        $banner->update(['sort_order' => $tetangga->sort_order]);
        $tetangga->update(['sort_order' => $tmp]);

        unset($this->banners);
    }

    public function render()
    {
        return view('livewire.banner-manager');
    }
}
