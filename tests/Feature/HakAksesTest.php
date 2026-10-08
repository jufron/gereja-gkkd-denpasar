<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class HakAksesTest extends TestCase
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
            ->get(route('hak-akses'))
            ->assertOk()
            ->assertSeeText('Daftar Role');
    }

    public function test_halaman_ditolak_untuk_user_bukan_administrator(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Staff');

        $this->actingAs($user)
            ->get(route('hak-akses'))
            ->assertForbidden();
    }

    public function test_halaman_dapat_diakses_meski_permission_hak_akses_dicabut(): void
    {
        $role = Role::where('name', 'Administrator')->first();
        $role->revokePermissionTo('Hak Akses');

        $this->actingAs($this->admin)
            ->get(route('hak-akses'))
            ->assertOk();
    }

    public function test_bisa_menambah_role_kustom(): void
    {
        Livewire::actingAs($this->admin)
            ->test('dashboard.hak-akses')
            ->call('bukaFormTambah')
            ->set('nama', 'Multimedia')
            ->call('simpanRole')
            ->assertOk();

        $this->assertDatabaseHas('roles', [
            'name' => 'Multimedia',
            'guard_name' => 'web',
        ]);
    }

    public function test_nama_role_wajib_unik(): void
    {
        Livewire::actingAs($this->admin)
            ->test('dashboard.hak-akses')
            ->set('nama', 'Administrator')
            ->call('simpanRole')
            ->assertHasErrors(['nama']);
    }

    public function test_bisa_mengubah_nama_role(): void
    {
        $role = Role::create(['name' => 'Singer', 'guard_name' => 'web']);

        Livewire::actingAs($this->admin)
            ->test('dashboard.hak-akses')
            ->call('bukaFormUbah', $role->id)
            ->assertSet('formRoleOpen', true)
            ->set('nama', 'Worship Team')
            ->call('simpanRole')
            ->assertSet('formRoleOpen', false)
            ->assertOk();

        $role->refresh();

        $this->assertSame('Worship Team', $role->name);
    }

    public function test_ubah_role_dengan_nama_sama_tidak_ditolak(): void
    {
        $role = Role::create(['name' => 'Singer', 'guard_name' => 'web']);

        Livewire::actingAs($this->admin)
            ->test('dashboard.hak-akses')
            ->call('bukaFormUbah', $role->id)
            ->set('nama', 'Singer')
            ->call('simpanRole')
            ->assertHasNoErrors()
            ->assertSet('formRoleOpen', false);

        $this->assertDatabaseHas('roles', ['id' => $role->id, 'name' => 'Singer']);
    }

    public function test_form_tambah_membuka_modal(): void
    {
        Livewire::actingAs($this->admin)
            ->test('dashboard.hak-akses')
            ->call('bukaFormTambah')
            ->assertSet('formRoleOpen', true)
            ->assertSet('roleId', null);
    }

    public function test_hapus_role_dengan_user_ditolak(): void
    {
        $role = Role::create(['name' => 'Singer', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole($role);

        Livewire::actingAs($this->admin)
            ->test('dashboard.hak-akses')
            ->call('bukaKonfirmasiHapus', $role->id)
            ->call('hapusRole')
            ->assertOk();

        $this->assertDatabaseHas('roles', ['id' => $role->id]);
    }

    public function test_role_dasar_tidak_bisa_dihapus(): void
    {
        $role = Role::where('name', 'Administrator')->first();

        Livewire::actingAs($this->admin)
            ->test('dashboard.hak-akses')
            ->call('bukaKonfirmasiHapus', $role->id)
            ->call('hapusRole')
            ->assertOk();

        $this->assertDatabaseHas('roles', ['id' => $role->id]);
    }

    public function test_bisa_toggle_permission_pada_role(): void
    {
        $role = Role::create(['name' => 'Singer', 'guard_name' => 'web']);
        $permission = Permission::firstOrCreate(['name' => 'Kelola Berita', 'guard_name' => 'web']);

        Livewire::actingAs($this->admin)
            ->test('dashboard.hak-akses')
            ->call('pilihRole', $role->id)
            ->call('togglePermission', 'Kelola Berita')
            ->assertOk();

        $this->assertTrue($role->fresh()->hasPermissionTo('Kelola Berita'));

        Livewire::actingAs($this->admin)
            ->test('dashboard.hak-akses')
            ->call('pilihRole', $role->id)
            ->call('togglePermission', 'Kelola Berita')
            ->assertOk();

        $this->assertFalse($role->fresh()->hasPermissionTo('Kelola Berita'));

        unset($permission);
    }

    public function test_bisa_assign_dan_lepas_user_dari_role(): void
    {
        $role = Role::create(['name' => 'Singer', 'guard_name' => 'web']);
        $user = User::factory()->create();

        Livewire::actingAs($this->admin)
            ->test('dashboard.hak-akses')
            ->call('pilihRole', $role->id)
            ->set('userId', $user->id)
            ->call('assignUser')
            ->assertOk();

        $this->assertTrue($user->fresh()->hasRole($role));

        Livewire::actingAs($this->admin)
            ->test('dashboard.hak-akses')
            ->call('pilihRole', $role->id)
            ->call('lepasUser', $user->id)
            ->assertOk();

        $this->assertFalse($user->fresh()->hasRole($role));
    }

    public function test_setiap_perubahan_dicatat_di_activity_log(): void
    {
        Livewire::actingAs($this->admin)
            ->test('dashboard.hak-akses')
            ->set('nama', 'Multimedia')
            ->call('simpanRole')
            ->assertOk();

        $this->assertDatabaseHas('activity_log', [
            'log_name' => 'hak-akses',
            'description' => 'Tambah role',
            'causer_id' => $this->admin->id,
        ]);
    }

    public function test_permission_hak_akses_pada_administrator_permanen(): void
    {
        $role = Role::where('name', 'Administrator')->first();

        Livewire::actingAs($this->admin)
            ->test('dashboard.hak-akses')
            ->call('pilihRole', $role->id)
            ->call('togglePermission', 'Hak Akses')
            ->assertOk();

        $this->assertTrue($role->fresh()->hasPermissionTo('Hak Akses'));

        $this->assertDatabaseMissing('activity_log', [
            'log_name' => 'hak-akses',
            'description' => 'Cabut permission',
            'subject_id' => $role->id,
        ]);
    }

    public function test_permission_biasa_masih_bisa_dicabut(): void
    {
        $role = Role::where('name', 'Administrator')->first();

        Livewire::actingAs($this->admin)
            ->test('dashboard.hak-akses')
            ->call('pilihRole', $role->id)
            ->call('togglePermission', 'Kelola Berita')
            ->assertOk();

        $this->assertFalse($role->fresh()->hasPermissionTo('Kelola Berita'));

        Livewire::actingAs($this->admin)
            ->test('dashboard.hak-akses')
            ->call('pilihRole', $role->id)
            ->call('togglePermission', 'Kelola Berita')
            ->assertOk();

        $this->assertTrue($role->fresh()->hasPermissionTo('Kelola Berita'));
    }
}
