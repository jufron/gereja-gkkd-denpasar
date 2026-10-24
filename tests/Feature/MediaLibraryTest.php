<?php

namespace Tests\Feature;

use App\Contracts\Services\NewsManagementServiceInterface;
use App\Models\AssetLibrary;
use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaLibraryTest extends TestCase
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

    private function uploadInline(string $name = 'inline.png'): int
    {
        $res = $this->postJson(route('admin.berita.upload-gambar'), [
            'upload' => File::image($name, 200, 200),
        ]);

        $res->assertOk()->assertJsonStructure(['url', 'id']);

        return (int) $res->json('id');
    }

    private function newsPayload(int $mediaId, string $status = 'draft'): array
    {
        $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::findOrFail($mediaId);

        return [
            'title' => 'Berita Media',
            'category_id' => null,
            'content' => '<p>Isi</p><img src="'.$media->getUrl().'">',
            'status' => $status,
            'banner' => null,
            'hapus_banner' => null,
            'published_at' => null,
        ];
    }

    public function test_upload_endpoint_membuat_media(): void
    {
        Storage::fake('public');
        $mediaId = $this->uploadInline();

        $this->assertDatabaseHas('media', [
            'id' => $mediaId,
            'collection_name' => 'news-content',
        ]);
    }

    public function test_simpan_berita_mencatat_pemakaian_gambar_konten(): void
    {
        Storage::fake('public');
        $mediaId = $this->uploadInline();

        $news = $this->service()->create($this->newsPayload($mediaId));

        $this->assertDatabaseHas('asset_usages', [
            'news_id' => $news->id,
            'media_id' => $mediaId,
            'kind' => 'content',
        ]);
    }

    public function test_hapus_gambar_dari_editor_melepas_pemakaian_tapi_media_tetap(): void
    {
        Storage::fake('public');
        $mediaId = $this->uploadInline();
        $news = $this->service()->create($this->newsPayload($mediaId));

        // Edit: gambar dihapus dari konten.
        $news = $this->service()->update($news, [
            'title' => 'Berita Media',
            'category_id' => null,
            'content' => '<p>Tanpa gambar</p>',
            'status' => 'draft',
            'banner' => null,
            'hapus_banner' => null,
            'published_at' => null,
        ]);

        $this->assertDatabaseMissing('asset_usages', [
            'news_id' => $news->id,
            'media_id' => $mediaId,
        ]);
        $this->assertDatabaseHas('media', ['id' => $mediaId]); // masih ada, menunggu prune
    }

    public function test_prune_menghapus_media_yatim_tapi_menjaga_yang_dipakai(): void
    {
        Storage::fake('public');
        $usedId = $this->uploadInline('used.png');
        $orphanId = $this->uploadInline('orphan.png');
        $news = $this->service()->create($this->newsPayload($usedId));

        // Yatim: tidak direferensikan berita mana pun, umur di atas batas.
        DB::table('media')->where('id', $orphanId)->update(['created_at' => now()->subDays(30)]);

        $this->artisan('media:prune', ['--days' => 7])->assertSuccessful();

        $this->assertDatabaseMissing('media', ['id' => $orphanId]);
        $this->assertDatabaseHas('media', ['id' => $usedId]);
        $this->assertDatabaseHas('asset_usages', [
            'news_id' => $news->id,
            'media_id' => $usedId,
        ]);
    }

    public function test_hapus_berita_menghapus_pemakaian_tapi_media_bertahan(): void
    {
        Storage::fake('public');
        $mediaId = $this->uploadInline();
        $news = $this->service()->create($this->newsPayload($mediaId));

        $this->service()->delete($news);

        $this->assertDatabaseMissing('asset_usages', ['news_id' => $news->id]);
        $this->assertDatabaseHas('media', ['id' => $mediaId]);
    }

    public function test_pustaka_media_ditolak_tanpa_permission(): void
    {
        Storage::fake('public');
        $media = AssetLibrary::singleton()->addMedia(File::image('priv.png'))->toMediaCollection('news-content');

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->getJson(route('admin.media.index'))->assertForbidden();
        $this->deleteJson(route('admin.media.destroy', $media->id))->assertForbidden();
    }

    public function test_media_yang_dipakai_tidak_bisa_dihapus(): void
    {
        Storage::fake('public');
        $mediaId = $this->uploadInline();
        $this->service()->create($this->newsPayload($mediaId));

        $this->deleteJson(route('admin.media.destroy', $mediaId))->assertStatus(422);

        $this->assertDatabaseHas('media', ['id' => $mediaId]);
    }

    public function test_url_media_publik_dapat_diakses_tanpa_auth(): void
    {
        Storage::fake('public');
        $mediaId = $this->uploadInline();
        $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::findOrFail($mediaId);

        // URL selalu berbentuk /media/{id}/{file}, lepas dari disk aktif.
        $this->assertStringStartsWith('/media/'.$mediaId, $media->getUrl());

        $this->get($media->getUrl())->assertOk()->assertHeader('Content-Type', 'image/png');
    }
}
