<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mews\Purifier\Facades\Purifier;

final class BeritaFormController extends Controller
{
    /** Tampilkan formulir tambah berita */
    public function create()
    {
        $categories = NewsCategory::ordered()->get();

        return view('dashboard.berita-form', [
            'news' => new News,
            'categories' => $categories,
            'isEdit' => false,
        ]);
    }

    /** Tampilkan formulir edit berita */
    public function edit(News $news)
    {
        $categories = NewsCategory::ordered()->get();

        return view('dashboard.berita-form', [
            'news' => $news,
            'categories' => $categories,
            'isEdit' => true,
        ]);
    }

    /** Simpan berita baru */
    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $news = new News;

        $this->saveNews($news, $data, $request);

        return redirect()->route('admin.berita')
            ->with('success', 'Berita ditambahkan.');
    }

    /** Perbarui berita yang ada */
    public function update(Request $request, News $news)
    {
        $data = $this->validateData($request);

        $this->saveNews($news, $data, $request);

        return redirect()->route('admin.berita')
            ->with('success', 'Berita diperbarui.');
    }

    /** Hapus berita + banner */
    public function destroy(News $news)
    {
        if ($news->featured_image) {
            Storage::disk('public')->delete($news->featured_image);
        }

        $news->delete();

        return back()->with('success', 'Berita dihapus.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:200'],
            'category_id' => ['nullable', 'exists:news_categories,id'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'banner' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'status' => ['required', 'in:draft,published'],
            'published_at' => ['nullable', 'date'],
        ]);
    }

    private function saveNews(News $news, array $data, Request $request): void
    {
        // Sanitasi HTML content sebelum simpan
        $contentClean = Purifier::clean($data['content']);

        // Banner upload
        if (! empty($data['banner'])) {
            // Hapus banner lama
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }
            $bannerPath = $data['banner']->store('news/banner', 'public');
        } else {
            $bannerPath = $news->featured_image;
        }

        // Hapus banner jika diminta
        if (! empty($request->hapus_banner)) {
            if ($bannerPath) {
                Storage::disk('public')->delete($bannerPath);
            }
            $bannerPath = null;
        }

        // Slug otomatis unik
        $slug = News::uniqueSlug($data['title'], $news->exists ? $news->id : null);

        // Published at otomatis kalau status published & belum ada tanggal
        $publishedAt = $data['status'] === 'published'
            ? ($data['published_at'] ?? ($news->published_at ?? now()))
            : ($news->published_at ?? null);

        $news->fill([
            'title' => $data['title'],
            'slug' => $slug,
            'news_category_id' => $data['category_id'],
            'excerpt' => $data['excerpt'] ?? null,
            'content' => $contentClean,
            'featured_image' => $bannerPath,
            'status' => $data['status'],
            'published_at' => $publishedAt,
        ]);

        // Set user_id hanya saat create
        if (! $news->exists) {
            $news->user_id = auth()->id();
        }

        $news->save();
    }
}
