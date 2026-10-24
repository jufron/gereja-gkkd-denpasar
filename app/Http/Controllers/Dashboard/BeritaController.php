<?php

namespace App\Http\Controllers\Dashboard;

use App\Contracts\Services\NewsManagementServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SaveNewsRequest;
use App\Models\News;

/**
 * Menangani permintaan pengelolaan berita pada dashboard.
 *
 * Controller hanya bertugas mengorkestrasi alur: menerima request,
 * memanggil service, lalu mengarahkan response (view / redirect).
 * Aturan bisnis (validasi berat, sanitasi, upload, slug, status)
 * didelegasikan ke NewsManagementService agar mudah diuji dan dipelihara.
 */
final class BeritaController extends Controller
{
    /**
     * Suntik dependency service pengelolaan berita.
     */
    public function __construct(
        private readonly NewsManagementServiceInterface $news,
    ) {}

    /**
     * Tampilkan halaman daftar berita.
     *
     * Daftar berita dirender oleh komponen Livewire BeritaTable.
     */
    public function index()
    {
        return view('dashboard.berita');
    }

    /**
     * Tampilkan formulir untuk menulis berita baru.
     */
    public function create()
    {
        $data = $this->news->formData();

        return view('dashboard.berita-form', [
            'news' => $data['news'],
            'categories' => $data['categories'],
            'isEdit' => false,
        ]);
    }

    /**
     * Tampilkan formulir terisi untuk mengubah berita yang ada.
     *
     * @param \App\Models\News $news Berita yang akan diubah.
     */
    public function edit(News $news)
    {
        $data = $this->news->formData();

        return view('dashboard.berita-form', [
            'news' => $news,
            'categories' => $data['categories'],
            'isEdit' => true,
        ]);
    }

    /**
     * Simpan berita baru ke penyimpanan.
     *
     * @param \App\Http\Requests\Dashboard\SaveNewsRequest $request
     */
    public function store(SaveNewsRequest $request)
    {
        $this->news->create($request->validated());

        return redirect()->route('admin.berita')
            ->with('success', 'Berita ditambahkan.');
    }

    /**
     * Tampilkan pratinjau artikel dari sisi admin.
     *
     * Dapat menampilkan berita berstatus draft. Akses dibatasi
     * untuk pemilik permission "Kelola Berita".
     *
     * @param \App\Models\News $news Berita yang akan dipratinjau.
     */
    public function show(News $news)
    {
        abort_unless(auth()->user()?->can('Kelola Berita'), 403);

        $news->load(['category', 'author']);

        return view('dashboard.berita-show', [
            'news' => $news,
        ]);
    }

    /**
     * Perbarui data berita yang ada.
     *
     * @param \App\Http\Requests\Dashboard\SaveNewsRequest $request
     * @param \App\Models\News $news Berita yang akan diperbarui.
     */
    public function update(SaveNewsRequest $request, News $news)
    {
        $this->news->update($news, $request->validated());

        return redirect()->route('admin.berita')
            ->with('success', 'Berita diperbarui.');
    }

    /**
     * Hapus berita beserta barang banner-nya.
     *
     * @param \App\Models\News $news Berita yang akan dihapus.
     */
    public function destroy(News $news)
    {
        $this->news->delete($news);

        return back()->with('success', 'Berita dihapus.');
    }
}
