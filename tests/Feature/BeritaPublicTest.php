<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BeritaPublicTest extends TestCase
{
    use RefreshDatabase;

    private ?User $author = null;

    private function makePublishedNews(string $slug = 'artikel-test', ?string $status = 'published'): News
    {
        $this->author ??= User::factory()->create();

        $category = NewsCategory::query()->firstOrCreate(
            ['slug' => 'renungan'],
            ['name' => 'Renungan', 'color' => 'bg-accent/10 text-accent dark:text-accent-soft'],
        );

        return News::factory()->create([
            'slug' => $slug,
            'title' => 'Judul Artikel Test',
            'news_category_id' => $category->id,
            'user_id' => $this->author->id,
            'status' => $status,
            'published_at' => $status === 'published' ? now() : null,
        ]);
    }

    public function test_halaman_berita_menampilkan_artikel_published(): void
    {
        $this->makePublishedNews('artikel-satu');
        $this->makePublishedNews('artikel-dua');

        $this->get(route('berita'))
            ->assertOk()
            ->assertSee('Judul Artikel Test')
            ->assertSee('artikel-satu')
            ->assertSee('artikel-dua');
    }

    public function test_halaman_berita_menyembunyikan_draft(): void
    {
        $this->makePublishedNews('artikel-published');
        $this->makePublishedNews('artikel-draft', 'draft');

        $this->get(route('berita'))
            ->assertOk()
            ->assertSee('artikel-published')
            ->assertDontSee('artikel-draft');
    }

    public function test_detail_berita_published_terbuka(): void
    {
        $news = $this->makePublishedNews('artikel-detail');

        $this->get(route('berita.show', $news->slug))
            ->assertOk()
            ->assertSee('Judul Artikel Test');
    }

    public function test_detail_berita_draft_mengembalikan_404(): void
    {
        $news = $this->makePublishedNews('artikel-draft-404', 'draft');

        $this->get(route('berita.show', $news->slug))->assertNotFound();
    }

    public function test_filter_kategori_berita(): void
    {
        $author = User::factory()->create();
        $renungan = NewsCategory::factory()->create(['slug' => 'renungan', 'name' => 'Renungan']);
        $pelayanan = NewsCategory::factory()->create(['slug' => 'pelayanan', 'name' => 'Pelayanan']);

        News::factory()->create([
            'slug' => 'artikel-renungan',
            'news_category_id' => $renungan->id,
            'user_id' => $author->id,
            'status' => 'published',
            'published_at' => now(),
        ]);
        News::factory()->create([
            'slug' => 'artikel-pelayanan',
            'news_category_id' => $pelayanan->id,
            'user_id' => $author->id,
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->get(route('berita', ['kategori' => 'renungan']))
            ->assertOk()
            ->assertSee('artikel-renungan')
            ->assertDontSee('artikel-pelayanan');
    }
}
