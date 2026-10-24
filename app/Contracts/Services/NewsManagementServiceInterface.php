<?php

namespace App\Contracts\Services;

use App\Models\News;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Kontrak layanan pengelolaan berita pada dashboard.
 *
 * Memisahkan aturan bisnis (sanitasi, slug, banner, status) dari controller
 * dan komponen Livewire agar dapat diuji serta dipelihara secara terpusat.
 */
interface NewsManagementServiceInterface
{
    /**
     * Ambil daftar berita terfilter.
     *
     * Mendukung pencarian judul/excerpt dan filter status.
     * Hasil diurutkan dari yang terbaru.
     *
     * @param  string  $search  Kata kunci pencarian.
     * @param  string  $status  Status filter ('', 'draft', 'published').
     * @param  int  $perPage  Jumlah data per halaman.
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(string $search, string $status, int $perPage = 10): LengthAwarePaginator;

    /**
     * Ambil jumlah berita per status.
     *
     * Dipakai untuk kartu statistik di atas tabel. Hasilnya di-cache.
     *
     * @return array{total: int, published: int, draft: int}
     */
    public function statistics(): array;

    /**
     * Ambil data pendukung untuk form tambah/ubah.
     *
     * @return array{categories: \Illuminate\Database\Eloquent\Collection, news: \App\Models\News}
     */
    public function formData(): array;

    /**
     * Simpan berita baru.
     *
     * @param  array<string, mixed>  $data  Data validasi dari form.
     * @return \App\Models\News
     */
    public function create(array $data): News;

    /**
     * Perbarui berita yang ada.
     *
     * @param  \App\Models\News  $news  Berita yang akan diperbarui.
     * @param  array<string, mixed>  $data  Data validasi dari form.
     * @return \App\Models\News
     */
    public function update(News $news, array $data): News;

    /**
     * Hapus berita beserta file banner-nya.
     *
     * @param  \App\Models\News  $news  Berita yang akan dihapus.
     */
    public function delete(News $news): void;

    /**
     * Tukar status terbit/draft.
     *
     * @param  \App\Models\News  $news  Berita yang statusnya akan ditukar.
     * @return \App\Models\News
     */
    public function toggleStatus(News $news): News;
}
