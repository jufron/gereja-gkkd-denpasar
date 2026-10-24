<?php

namespace Tests\Feature;

use App\Contracts\Services\NewsManagementServiceInterface;
use App\Livewire\Dashboard\BeritaTable;
use App\Models\AssetUsage;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
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

        // Banner tersimpan sebagai media + tercatat pemakaiannya.
        $this->assertDatabaseHas('asset_usages', [
            'news_id' => $berita->id,
            'kind' => 'banner',
        ]);
        $this->assertDatabaseHas('media', [
            'collection_name' => 'news-banner',
        ]);
    }

    public function test_update_berita_mengganti_banner(): void
    {
        Storage::fake('public');
        $cat = NewsCategory::firstOrCreate(['slug' => 'renungan'], ['name' => 'Renungan', 'color' => '']);

        $img1 = File::image('b1.jpg', 600, 400);
        $this->post(route('admin.berita.simpan'), [
            'title' => 'Berita 1',
            'category_id' => $cat->id,
            'content' => '<p>Isi</p>',
            'banner' => $img1,
            'status' => 'draft',
        ]);

        $berita = News::firstOrFail();
        $oldMediaId = AssetUsage::where('news_id', $berita->id)->where('kind', 'banner')->value('media_id');

        $img2 = File::image('b2.jpg', 800, 600);
        $this->put(route('admin.berita.update', $berita), [
            'title' => 'Berita 1 Updated',
            'category_id' => $cat->id,
            'content' => '<p>Isi baru</p>',
            'banner' => $img2,
            'status' => 'draft',
        ])->assertRedirect(route('admin.berita'));

        // Banner baru tercatat; banner lama dilepas pemakaiannya (yatim).
        $this->assertDatabaseMissing('asset_usages', ['media_id' => $oldMediaId]);
        $this->assertDatabaseHas('asset_usages', [
            'news_id' => $berita->id,
            'kind' => 'banner',
        ]);
        $newMediaId = AssetUsage::where('news_id', $berita->id)->where('kind', 'banner')->value('media_id');
        $this->assertNotSame($oldMediaId, $newMediaId);
    }

    public function test_endpoint_upload_gambar_menerima_png(): void
    {
        Storage::fake('public');
        $img = File::image('inline.png', 200, 200);

        $this->postJson(route('admin.berita.upload-gambar'), [
            'upload' => $img,
        ])->assertOk()
            ->assertJsonStructure(['url', 'id']);

        $this->assertDatabaseHas('media', [
            'collection_name' => 'news-content',
        ]);
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

    public function test_halaman_lihat_berita_dapat_diakses(): void
    {
        $berita = News::create([
            'title' => 'Berita Pratinjau',
            'slug' => 'berita-pratinjau',
            'content' => '<p>Isi artikel</p>',
            'user_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        $this->get(route('admin.berita.lihat', $berita))->assertOk()
            ->assertSee('Berita Pratinjau');
    }

    public function test_toggle_status_draft_ke_published_mengisi_tanggal(): void
    {
        $berita = News::create([
            'title' => 'Berita Toggle',
            'slug' => 'berita-toggle',
            'content' => '<p>x</p>',
            'user_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        Livewire::test(BeritaTable::class)
            ->call('toggleStatus', $berita->id)
            ->assertSet('pesan', 'Berita diterbitkan.');

        $berita->refresh();
        $this->assertSame('published', $berita->status);
        $this->assertNotNull($berita->published_at);
    }

    public function test_toggle_status_published_ke_draft_mengosongkan_tanggal(): void
    {
        $berita = News::create([
            'title' => 'Berita Toggle 2',
            'slug' => 'berita-toggle-2',
            'content' => '<p>x</p>',
            'user_id' => $this->admin->id,
            'status' => 'published',
            'published_at' => now(),
        ]);

        Livewire::test(BeritaTable::class)
            ->call('toggleStatus', $berita->id)
            ->assertSet('pesan', 'Berita dijadikan draft.');

        $berita->refresh();
        $this->assertSame('draft', $berita->status);
        $this->assertNull($berita->published_at);
    }

    public function test_statistik_berita_per_status(): void
    {
        // Bersihkan cache statistik (bisa terisi test sebelumnya — array cache
        // bertahan antar-test dalam satu proses).
        \Illuminate\Support\Facades\Cache::flush();

        News::create(['title' => 'A', 'slug' => 'a', 'content' => '<p>x</p>', 'user_id' => $this->admin->id, 'status' => 'published', 'published_at' => now()]);
        News::create(['title' => 'B', 'slug' => 'b', 'content' => '<p>x</p>', 'user_id' => $this->admin->id, 'status' => 'draft']);

        $service = app(NewsManagementServiceInterface::class);
        $statistik = $service->statistics();

        $this->assertSame(2, $statistik['total']);
        $this->assertSame(1, $statistik['published']);
        $this->assertSame(1, $statistik['draft']);
    }

    public function test_hapus_berita_melalui_komponen(): void
    {
        $berita = News::create([
            'title' => 'Berita Dihapus',
            'slug' => 'berita-dihapus',
            'content' => '<p>x</p>',
            'user_id' => $this->admin->id,
            'status' => 'draft',
        ]);

        Livewire::test(BeritaTable::class)
            ->call('bukaKonfirmasiHapus', $berita->id)
            ->assertSet('hapusOpen', true)
            ->call('hapus')
            ->assertSet('pesan', 'Berita berhasil dihapus.');

        $this->assertDatabaseMissing('news', ['id' => $berita->id]);
    }
}
