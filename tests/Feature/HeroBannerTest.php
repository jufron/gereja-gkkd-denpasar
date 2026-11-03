<?php

namespace Tests\Feature;

use App\Models\AssetLibrary;
use App\Models\HeroBanner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Testing\File;
use Livewire\Livewire;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\TestCase;

class HeroBannerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->admin = User::factory()->create();
        $this->admin->assignRole('Administrator');
    }

    private function mediaBanner(string $name = 'banner.png'): Media
    {
        return AssetLibrary::singleton()
            ->addMedia(File::image($name, 800, 600))
            ->toMediaCollection('hero-banner');
    }

    private function buatBanner(array $attributes = []): HeroBanner
    {
        return HeroBanner::factory()->create([
            'media_id' => $this->mediaBanner()->id,
            ...$attributes,
        ]);
    }

    public function test_halaman_banner_dapat_diakses_administrator(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.banner-beranda'))
            ->assertOk()
            ->assertSeeText('Banner Beranda')
            ->assertSeeText('Banner Slider Beranda');
    }

    public function test_halaman_ditolak_untuk_user_tanpa_permission(): void
    {
        $bendahara = User::factory()->create();
        $bendahara->assignRole('Bendahara');

        $this->actingAs($bendahara)
            ->get(route('admin.banner-beranda'))
            ->assertForbidden();
    }

    public function test_permission_kelola_beranda_dimiliki_administrator_dan_pendeta(): void
    {
        $pendeta = User::factory()->create();
        $pendeta->assignRole('Pendeta');
        $timPelayanan = User::factory()->create();
        $timPelayanan->assignRole('Tim Pelayanan');

        $this->assertTrue($this->admin->hasPermissionTo('Kelola Beranda'));
        $this->assertTrue($pendeta->hasPermissionTo('Kelola Beranda'));
        $this->assertFalse($timPelayanan->hasPermissionTo('Kelola Beranda'));
    }

    public function test_bisa_menambah_banner(): void
    {
        $sebelum = HeroBanner::query()->count();

        Livewire::actingAs($this->admin)
            ->test('dashboard.banner-manager')
            ->call('bukaFormTambah')
            ->set('badge', 'Aksi Kasih di Bali')
            ->set('caption', 'Melayani sesama dengan kepedulian yang tulus')
            ->set('alt', 'Aksi Kasih Pelayanan Masyarakat Bali')
            ->set('linkUrl', '')
            ->set('foto', File::image('outreach.png', 800, 600))
            ->call('simpan')
            ->assertHasNoErrors()
            ->assertSet('formOpen', false);

        $this->assertDatabaseHas('hero_banners', [
            'badge' => 'Aksi Kasih di Bali',
            'caption' => 'Melayani sesama dengan kepedulian yang tulus',
            'is_active' => true,
        ]);

        $this->assertSame($sebelum + 1, HeroBanner::query()->count());
    }

    public function test_banner_wajib_punya_gambar(): void
    {
        $sebelum = HeroBanner::query()->count();

        Livewire::actingAs($this->admin)
            ->test('dashboard.banner-manager')
            ->call('bukaFormTambah')
            ->set('badge', 'Test Badge')
            ->set('caption', 'Test caption cukup panjang')
            ->set('alt', 'Test alt')
            ->call('simpan')
            ->assertHasErrors('foto');

        $this->assertSame($sebelum, HeroBanner::query()->count());
    }

    public function test_validasi_field_wajib(): void
    {
        Livewire::actingAs($this->admin)
            ->test('dashboard.banner-manager')
            ->call('bukaFormTambah')
            ->set('badge', '')
            ->set('caption', '')
            ->set('alt', '')
            ->call('simpan')
            ->assertHasErrors(['badge', 'caption', 'alt']);
    }

    public function test_bisa_mengubah_banner(): void
    {
        $banner = $this->buatBanner();

        Livewire::actingAs($this->admin)
            ->test('dashboard.banner-manager')
            ->call('bukaFormUbah', $banner->id)
            ->set('badge', 'Sanctuary Baru')
            ->call('simpan')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('hero_banners', ['id' => $banner->id, 'badge' => 'Sanctuary Baru']);
    }

    public function test_urutan_naik_turun(): void
    {
        $pertama = $this->buatBanner(['sort_order' => 10]);
        $kedua = $this->buatBanner(['sort_order' => 20]);

        Livewire::actingAs($this->admin)
            ->test('dashboard.banner-manager')
            ->call('naik', $kedua->id);

        $this->assertDatabaseHas('hero_banners', ['id' => $pertama->id, 'sort_order' => 20]);
        $this->assertDatabaseHas('hero_banners', ['id' => $kedua->id, 'sort_order' => 10]);
    }

    public function test_toggle_aktif(): void
    {
        $banner = $this->buatBanner();

        Livewire::actingAs($this->admin)
            ->test('dashboard.banner-manager')
            ->call('toggleAktif', $banner->id);

        $this->assertDatabaseHas('hero_banners', ['id' => $banner->id, 'is_active' => 0]);
    }

    public function test_hapus_banner(): void
    {
        $banner = $this->buatBanner();

        Livewire::actingAs($this->admin)
            ->test('dashboard.banner-manager')
            ->call('bukaKonfirmasiHapus', $banner->id)
            ->call('hapus');

        $this->assertDatabaseMissing('hero_banners', ['id' => $banner->id]);
    }

    public function test_hero_hanya_menampilkan_banner_aktif_dan_urut(): void
    {
        $aktif1 = $this->buatBanner(['sort_order' => 1, 'caption' => 'Caption aktif satu']);
        $nonaktif = $this->buatBanner(['sort_order' => 2, 'is_active' => false, 'caption' => 'Caption nonaktif']);
        $aktif2 = $this->buatBanner(['sort_order' => 3, 'caption' => 'Caption aktif dua']);

        $this->actingAs($this->admin)
            ->get(route('home'))
            ->assertOk()
            ->assertSeeInOrder([$aktif1->caption, $aktif2->caption])
            ->assertDontSee($nonaktif->caption);
    }

    public function test_prune_tidak_menghapus_media_banner(): void
    {
        $banner = $this->buatBanner();
        $media = $banner->media;
        $media->update(['created_at' => now()->subDays(30)]);

        $this->artisan('media:prune', ['--days' => 0]);

        $this->assertDatabaseHas('media', ['id' => $media->id]);
    }

    public function test_prune_tetap_menghapus_media_orphan(): void
    {
        $media = $this->mediaBanner('orphan.png');
        $media->update(['created_at' => now()->subDays(30)]);

        $this->artisan('media:prune', ['--days' => 0]);

        $this->assertDatabaseMissing('media', ['id' => $media->id]);
    }
}
