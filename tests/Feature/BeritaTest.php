<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BeritaTest extends TestCase
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

    public function test_index_berita_dapat_diakses_role_admin(): void
    {
        $this->get(route('admin.berita'))->assertOk()
            ->assertViewIs('dashboard.berita');
    }

    public function test_halaman_tambah_berita(): void
    {
        $this->get(route('admin.berita.tambah'))->assertOk();
    }

    public function test_bisa_simpan_berita_dengan_banner(): void
    {
        Storage::fake('public');
        $cat = NewsCategory::firstOrCreate(['slug' => 'renungan'], ['name' => 'Renungan', 'color' => '']);

        $img = File::image('banner.jpg', 600, 400);

        $res = $this->post(route('admin.berita.simpan'), [
            'title' => 'Berita Test',
            'category_id' => $cat->id,
            'content' => '<p>Halo <strong>berita</strong></p><img src="x" onerror="alert(1)">',
            'banner' => $img,
            'status' => 'published',
            'published_at' => '2026-01-01 10:00',
        ]);

        $res->assertRedirect(route('admin.berita'));

        $berita = News::first();
        $this->assertNotNull($berita);
        $this->assertSame('published', $berita->status);
        $this->assertStringContainsString('Berita Test', $berita->title);

        // XSS terhapus oleh purifier
        $this->assertStringNotContainsString('onerror', $berita->content);
        $this->assertStringNotContainsString('alert', $berita->content);

        // File banner ada di disk
        Storage::disk('public')->assertExists($berita->featured_image);
    }

    public function test_update_berita_mengganti_banner(): void
    {
        Storage::fake('public');
        $cat = NewsCategory::firstOrCreate(['slug' => 'renungan'], ['name' => 'Renungan', 'color' => '']);

        // upload pertama
        $img1 = File::image('b1.jpg', 600, 400);
        $this->post(route('admin.berita.simpan'), [
            'title' => 'Berita 1',
            'category_id' => $cat->id,
            'content' => '<p>Isi</p>',
            'banner' => $img1,
            'status' => 'draft',
        ]);

        $berita = News::firstOrFail();
        $oldBanner = $berita->featured_image;

        // upload kedua
        $img2 = File::image('b2.jpg', 800, 600);
        $this->put(route('admin.berita.update', $berita), [
            'title' => 'Berita 1 Updated',
            'category_id' => $cat->id,
            'content' => '<p>Isi baru</p>',
            'banner' => $img2,
            'status' => 'draft',
        ])->assertRedirect(route('admin.berita'));

        Storage::disk('public')->assertMissing($oldBanner);
        $berita->refresh();
        Storage::disk('public')->assertExists($berita->featured_image);
    }

    public function test_endpoint_upload_gambar_menerima_png(): void
    {
        Storage::fake('public');
        $img = File::image('inline.png', 200, 200);

        $this->postJson(route('admin.berita.upload-gambar'), [
            'upload' => $img,
        ])->assertOk()
            ->assertJsonStructure(['url']);

        Storage::disk('public')->assertExists('news/content');
    }

    public function test_endpoint_upload_gambar_menolak_file_non_image(): void
    {
        $this->postJson(route('admin.berita.upload-gambar'), [
            'upload' => File::create('text.txt', 100),
        ])->assertStatus(422);
    }

    public function test_non_admin_ditolak(): void
    {
        $this->admin->removeRole('Administrator');
        $this->get(route('admin.berita'))->assertForbidden();
    }

    public function test_slug_unik(): void
    {
        News::create(['title' => 'Judul Sama', 'slug' => 'judul-sama', 'content' => 'x', 'user_id' => $this->admin->id, 'status' => 'draft']);

        // create lagi dengan judul sama → slug jadi judul-sama-2
        $slug = News::uniqueSlug('Judul Sama');
        $this->assertSame('judul-sama-2', $slug);
    }
}
