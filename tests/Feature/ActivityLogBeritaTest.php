<?php

namespace Tests\Feature;

use App\Contracts\Services\NewsManagementServiceInterface;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

class ActivityLogBeritaTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        $this->admin = User::factory()->create();
        $this->admin->assignRole('Administrator');
        $this->actingAs($this->admin);
    }

    private function service(): NewsManagementServiceInterface
    {
        return app(NewsManagementServiceInterface::class);
    }

    public function test_tambah_berita_dicatat_di_activity_log(): void
    {
        $news = $this->service()->create([
            'title' => 'Berita A',
            'category_id' => null,
            'excerpt' => null,
            'content' => '<p>Konten berita</p>',
            'status' => 'draft',
            'banner' => null,
            'hapus_banner' => null,
            'published_at' => null,
        ]);

        $this->assertDatabaseHas('activity_log', [
            'log_name' => 'berita',
            'description' => 'Tambah berita',
            'causer_id' => $this->admin->id,
            'subject_type' => News::class,
            'subject_id' => $news->id,
        ]);

        // Konten HTML penuh tidak boleh ikut tersimpan.
        $activity = Activity::where('description', 'Tambah berita')->first();
        $this->assertArrayNotHasKey('content', $activity->attribute_changes['attributes'] ?? []);
    }

    public function test_ubah_status_berita_dicatat_dengan_label(): void
    {
        $news = $this->service()->create([
            'title' => 'Berita B',
            'category_id' => null,
            'excerpt' => null,
            'content' => '<p>x</p>',
            'status' => 'draft',
            'banner' => null,
            'hapus_banner' => null,
            'published_at' => null,
        ]);

        $news = $this->service()->toggleStatus($news);

        $this->assertDatabaseHas('activity_log', [
            'log_name' => 'berita',
            'description' => 'Berita diterbitkan',
            'causer_id' => $this->admin->id,
            'subject_id' => $news->id,
        ]);
    }

    public function test_hapus_berita_dicatat_dengan_subjek(): void
    {
        $news = $this->service()->create([
            'title' => 'Berita C',
            'category_id' => null,
            'excerpt' => null,
            'content' => '<p>x</p>',
            'status' => 'draft',
            'banner' => null,
            'hapus_banner' => null,
            'published_at' => null,
        ]);

        $this->service()->delete($news);

        $this->assertDatabaseHas('activity_log', [
            'log_name' => 'berita',
            'description' => 'Hapus berita',
            'causer_id' => $this->admin->id,
            'subject_type' => News::class,
            'subject_id' => $news->id,
        ]);
    }

    public function test_kategori_berita_dicatat_saat_ubah_dan_hapus(): void
    {
        $kategori = NewsCategory::create([
            'name' => 'Kategori A',
            'slug' => 'kategori-a',
            'color' => '#123456',
        ]);

        $this->assertDatabaseHas('activity_log', [
            'log_name' => 'berita',
            'description' => 'Tambah kategori berita',
            'causer_id' => $this->admin->id,
        ]);

        $kategori->update(['name' => 'Kategori B']);

        $this->assertDatabaseHas('activity_log', [
            'description' => 'Ubah kategori berita',
        ]);

        $kategori->delete();

        $this->assertDatabaseHas('activity_log', [
            'description' => 'Hapus kategori berita',
            'subject_type' => NewsCategory::class,
            'subject_id' => $kategori->id,
        ]);
    }
}
