<?php

namespace Tests\Feature;

use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class KategoriBeritaTest extends TestCase
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

    public function test_halaman_dapat_diakses_oleh_administrator(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.kategori-berita'))
            ->assertOk()
            ->assertSeeText('Kategori Berita')
            ->assertSeeText('Tambah Kategori');
    }

    public function test_halaman_ditolak_untuk_user_tanpa_permission(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Tim Pelayanan');

        $this->actingAs($user)
            ->get(route('admin.kategori-berita'))
            ->assertForbidden();
    }

    public function test_halaman_ditolak_untuk_permission_kelola_berita_di_luar_area_admin(): void
    {
        // Grup route /admin dibatasi role:Administrator, jadi Pendeta & Bendahara
        // (yang punya permission "Kelola Berita") tetap ditolak di level area admin.
        foreach (['Pendeta', 'Bendahara'] as $role) {
            $user = User::factory()->create();
            $user->assignRole($role);

            $this->assertTrue($user->can('Kelola Berita'));

            $this->actingAs($user)
                ->get(route('admin.kategori-berita'))
                ->assertForbidden();
        }
    }

    public function test_komponen_menolak_user_tanpa_permission(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Tim Pelayanan');

        Livewire::actingAs($user)
            ->test('dashboard.kategori-berita-manager')
            ->assertForbidden();
    }

    public function test_kategori_awal_ter_seed(): void
    {
        $this->assertDatabaseHas('news_categories', ['name' => 'Renungan', 'slug' => 'renungan']);
        $this->assertDatabaseHas('news_categories', ['name' => 'Aksi Kasih', 'slug' => 'aksi-kasih']);
    }

    public function test_bisa_menambah_kategori(): void
    {
        Livewire::actingAs($this->admin)
            ->test('dashboard.kategori-berita-manager')
            ->call('bukaFormTambah')
            ->assertSet('formOpen', true)
            ->set('name', 'Kabar Pemuda')
            ->set('description', 'Berita seputar pelayanan pemuda.')
            ->set('sortOrder', 7)
            ->call('simpan')
            ->assertHasNoErrors()
            ->assertSet('formOpen', false);

        $this->assertDatabaseHas('news_categories', [
            'name' => 'Kabar Pemuda',
            'slug' => 'kabar-pemuda',
            'description' => 'Berita seputar pelayanan pemuda.',
            'sort_order' => 7,
            'is_active' => true,
        ]);
    }

    public function test_nama_kategori_wajib_diisi(): void
    {
        Livewire::actingAs($this->admin)
            ->test('dashboard.kategori-berita-manager')
            ->set('name', '')
            ->call('simpan')
            ->assertHasErrors(['name']);
    }

    public function test_nama_kategori_minimal_tiga_karakter(): void
    {
        Livewire::actingAs($this->admin)
            ->test('dashboard.kategori-berita-manager')
            ->set('name', 'ab')
            ->call('simpan')
            ->assertHasErrors(['name' => 'min']);
    }

    public function test_bisa_mengubah_kategori(): void
    {
        $kategori = NewsCategory::create(['name' => 'Kategori Lama', 'slug' => 'kategori-lama']);

        Livewire::actingAs($this->admin)
            ->test('dashboard.kategori-berita-manager')
            ->call('bukaFormUbah', $kategori->id)
            ->assertSet('formOpen', true)
            ->assertSet('name', 'Kategori Lama')
            ->set('name', 'Kategori Baru')
            ->call('simpan')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('news_categories', [
            'id' => $kategori->id,
            'name' => 'Kategori Baru',
            'slug' => 'kategori-baru',
        ]);
    }

    public function test_slug_dibuat_unik_saat_nama_bentrok(): void
    {
        NewsCategory::create(['name' => 'Kabar Lomba', 'slug' => 'kabar-lomba']);

        Livewire::actingAs($this->admin)
            ->test('dashboard.kategori-berita-manager')
            ->call('bukaFormTambah')
            ->set('name', 'Kabar Lomba')
            ->call('simpan')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('news_categories', ['slug' => 'kabar-lomba-2']);
    }

    public function test_slug_kategori_sendiri_tidak_dianggap_bentrok_saat_diubah(): void
    {
        $kategori = NewsCategory::create(['name' => 'Kabar Lomba', 'slug' => 'kabar-lomba']);

        Livewire::actingAs($this->admin)
            ->test('dashboard.kategori-berita-manager')
            ->call('bukaFormUbah', $kategori->id)
            ->set('name', 'Kabar Lomba')
            ->set('description', 'Diperbarui.')
            ->call('simpan')
            ->assertHasNoErrors();

        $this->assertSame('kabar-lomba', $kategori->fresh()->slug);
    }

    public function test_bisa_toggle_status_kategori(): void
    {
        $kategori = NewsCategory::create(['name' => 'Toggle', 'slug' => 'toggle', 'is_active' => true]);

        Livewire::actingAs($this->admin)
            ->test('dashboard.kategori-berita-manager')
            ->call('toggleAktif', $kategori->id)
            ->assertOk();

        $this->assertFalse($kategori->fresh()->is_active);
    }

    public function test_bisa_menghapus_kategori(): void
    {
        $kategori = NewsCategory::create(['name' => 'Akan Dihapus', 'slug' => 'akan-dihapus']);

        Livewire::actingAs($this->admin)
            ->test('dashboard.kategori-berita-manager')
            ->call('bukaKonfirmasiHapus', $kategori->id)
            ->assertSet('hapusOpen', true)
            ->call('hapus')
            ->assertOk()
            ->assertSet('hapusOpen', false);

        $this->assertDatabaseMissing('news_categories', ['id' => $kategori->id]);
    }

    public function test_pencarian_memfilter_kategori(): void
    {
        NewsCategory::create(['name' => 'Kabar Pemuda', 'slug' => 'kabar-pemuda']);
        NewsCategory::create(['name' => 'Kabar Lansia', 'slug' => 'kabar-lansia']);

        Livewire::actingAs($this->admin)
            ->test('dashboard.kategori-berita-manager')
            ->set('cari', 'Pemuda')
            ->assertSee('Kabar Pemuda')
            ->assertDontSee('Kabar Lansia');
    }

    public function test_pencarian_juga_mencocokkan_deskripsi(): void
    {
        NewsCategory::create(['name' => 'Kabar Pemuda', 'slug' => 'kabar-pemuda']);
        NewsCategory::create([
            'name' => 'Kabar Lansia',
            'slug' => 'kabar-lansia',
            'description' => 'Pelayanan untuk jemaat senior.',
        ]);

        Livewire::actingAs($this->admin)
            ->test('dashboard.kategori-berita-manager')
            ->set('cari', 'senior')
            ->assertSee('Kabar Lansia')
            ->assertDontSee('Kabar Pemuda');
    }

    public function test_filter_status_nonaktif(): void
    {
        NewsCategory::create(['name' => 'Kategori Aktif', 'slug' => 'kategori-aktif', 'is_active' => true]);
        NewsCategory::create(['name' => 'Kategori Mati', 'slug' => 'kategori-mati', 'is_active' => false]);

        Livewire::actingAs($this->admin)
            ->test('dashboard.kategori-berita-manager')
            ->set('filterStatus', 'nonaktif')
            ->assertSee('Kategori Mati')
            ->assertDontSee('Kategori Aktif');
    }

    public function test_reset_filter_mengosongkan_pencarian_dan_status(): void
    {
        Livewire::actingAs($this->admin)
            ->test('dashboard.kategori-berita-manager')
            ->set('cari', 'renungan')
            ->set('filterStatus', 'aktif')
            ->call('resetFilter')
            ->assertSet('cari', '')
            ->assertSet('filterStatus', '');
    }

    public function test_perubahan_kategori_dicatat_di_activity_log(): void
    {
        Livewire::actingAs($this->admin)
            ->test('dashboard.kategori-berita-manager')
            ->call('bukaFormTambah')
            ->set('name', 'Kategori Log')
            ->call('simpan');

        $this->assertDatabaseHas('activity_log', [
            'log_name' => 'berita',
            'description' => 'Tambah kategori berita',
            'causer_id' => $this->admin->id,
        ]);
    }

    public function test_sidebar_menautkan_halaman_kategori_berita(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.index'))
            ->assertOk()
            ->assertSee(route('admin.kategori-berita'), false);
    }
}
