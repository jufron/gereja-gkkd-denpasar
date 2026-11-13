<?php

namespace Tests\Feature;

use App\Livewire\Dashboard\SermonTable;
use App\Models\AssetUsage;
use App\Models\Sermon;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class SermonTest extends TestCase
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

    private function simpanPayload(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Khotbah Test',
            'preacher' => 'Pdt. Andi',
            'preached_at' => '2026-10-15',
            'location' => 'Gedung Utama',
            'content' => '<p>Isi <strong>pembahasan</strong></p><img src="x" onerror="alert(1)">',
            'status' => 'published',
            'published_at' => '2026-10-15 08:00',
        ], $overrides);
    }

    public function test_index_khotbah_dapat_diakses_role_admin(): void
    {
        $this->get(route('admin.khotbah.index'))->assertOk()
            ->assertViewIs('dashboard.khotbah');
    }

    public function test_halaman_tambah_khotbah(): void
    {
        $this->get(route('admin.khotbah.tambah'))->assertOk();
    }

    public function test_bisa_simpan_khotbah_dengan_thumbnail(): void
    {
        Storage::fake('public');
        $img = File::image('thumb.jpg', 800, 450);

        $this->post(route('admin.khotbah.simpan'), $this->simpanPayload(['thumbnail' => $img]))
            ->assertRedirect(route('admin.khotbah.index'));

        $sermon = Sermon::where('title', 'Khotbah Test')->firstOrFail();
        $this->assertSame('published', $sermon->status);

        // XSS terhapus oleh purifier.
        $this->assertStringNotContainsString('onerror', $sermon->content);
        $this->assertStringNotContainsString('alert', $sermon->content);

        // Thumbnail tersimpan + tercatat pemakaian.
        $this->assertDatabaseHas('asset_usages', [
            'sermon_id' => $sermon->id,
            'kind' => 'thumbnail',
        ]);
        $this->assertDatabaseHas('media', [
            'collection_name' => 'sermon-thumbnail',
        ]);
    }

    public function test_update_khotbah_mengganti_thumbnail(): void
    {
        Storage::fake('public');

        $img1 = File::image('t1.jpg', 800, 450);
        $this->post(route('admin.khotbah.simpan'), $this->simpanPayload(['thumbnail' => $img1]));

        $sermon = Sermon::where('title', 'Khotbah Test')->firstOrFail();
        $oldMediaId = AssetUsage::where('sermon_id', $sermon->id)->where('kind', 'thumbnail')->value('media_id');

        $img2 = File::image('t2.jpg', 800, 450);
        $this->put(route('admin.khotbah.update', $sermon), $this->simpanPayload([
            'title' => 'Khotbah Updated',
            'thumbnail' => $img2,
        ]))->assertRedirect(route('admin.khotbah.index'));

        $this->assertDatabaseMissing('asset_usages', ['media_id' => $oldMediaId]);
        $newMediaId = AssetUsage::where('sermon_id', $sermon->id)->where('kind', 'thumbnail')->value('media_id');
        $this->assertNotSame($oldMediaId, $newMediaId);
        $this->assertDatabaseHas('sermons', ['id' => $sermon->id, 'title' => 'Khotbah Updated']);
    }

    public function test_non_admin_ditolak(): void
    {
        $this->admin->removeRole('Administrator');
        $this->get(route('admin.khotbah.index'))->assertForbidden();
    }

    public function test_slug_unik(): void
    {
        Sermon::create(['title' => 'Judul Sama', 'slug' => 'judul-sama', 'content' => 'x', 'preacher' => 'A', 'preached_at' => now(), 'status' => 'draft']);

        $this->assertSame('judul-sama-2', Sermon::uniqueSlug('Judul Sama'));
    }

    public function test_toggle_status_draft_ke_published_mengisi_tanggal(): void
    {
        $sermon = Sermon::create([
            'title' => 'Toggle', 'slug' => 'toggle', 'content' => '<p>x</p>',
            'preacher' => 'A', 'preached_at' => now(), 'status' => 'draft',
        ]);

        Livewire::test(SermonTable::class)
            ->call('toggleStatus', $sermon->id)
            ->assertSet('pesan', 'Khotbah diterbitkan.');

        $sermon->refresh();
        $this->assertSame('published', $sermon->status);
        $this->assertNotNull($sermon->published_at);
    }

    public function test_halaman_publik_hanya_menampilkan_published(): void
    {
        Sermon::create([
            'title' => 'Terbit', 'slug' => 'terbit', 'content' => '<p>isi</p>',
            'preacher' => 'A', 'preached_at' => now(), 'status' => 'published', 'published_at' => now(),
        ]);
        Sermon::create([
            'title' => 'Draft Saja', 'slug' => 'draft-saja', 'content' => '<p>isi</p>',
            'preacher' => 'B', 'preached_at' => now(), 'status' => 'draft',
        ]);

        $res = $this->get(route('kegiatan.index'))->assertOk();
        $res->assertSee('Terbit');
        $res->assertDontSee('Draft Saja');
    }

    public function test_halaman_detail_menampilkan_pembahasan(): void
    {
        $sermon = Sermon::create([
            'title' => 'Detail', 'slug' => 'detail', 'content' => '<h3>Poin Utama</h3><p>Penjelasan rinci.</p>',
            'preacher' => 'A', 'preached_at' => now(), 'status' => 'published', 'published_at' => now(),
        ]);

        $this->get(route('kegiatan.khotbah.show', $sermon->slug))->assertOk()
            ->assertSee('Poin Utama')
            ->assertSee('Penjelasan rinci.');
    }

    public function test_halaman_detail_draft_tidak_bisa_diakses_publik(): void
    {
        $sermon = Sermon::create([
            'title' => 'Draft', 'slug' => 'draft', 'content' => '<p>x</p>',
            'preacher' => 'A', 'preached_at' => now(), 'status' => 'draft',
        ]);

        $this->get(route('kegiatan.khotbah.show', $sermon->slug))->assertNotFound();
    }
}
