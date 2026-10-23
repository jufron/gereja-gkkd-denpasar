<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RolePermissionSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_role_default_dan_permission_bendahara_terdaftar(): void
    {
        $this->seed(RolePermissionSeeder::class);

        foreach (['Administrator', 'Pendeta', 'Bendahara', 'Tim Pelayanan', 'User'] as $role) {
            $this->assertDatabaseHas('roles', ['name' => $role, 'guard_name' => 'web']);
        }

        $timPelayanan = Role::where('name', 'Tim Pelayanan')->firstOrFail();

        $this->assertSame(['Kelola Jadwal'], $timPelayanan->permissions->pluck('name')->all());

        $bendahara = Role::where('name', 'Bendahara')->firstOrFail();

        $this->assertEqualsCanonicalizing(
            ['Kelola Berita', 'Kelola Keuangan'],
            $bendahara->permissions->pluck('name')->all(),
        );

        $this->assertCount(0, Role::where('name', 'User')->firstOrFail()->permissions);
    }

    public function test_role_staff_lama_dipindahkan_ke_bendahara(): void
    {
        $staff = Role::create(['name' => 'Staff', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole($staff);

        $this->seed(RolePermissionSeeder::class);

        $this->assertDatabaseMissing('roles', ['name' => 'Staff']);
        $this->assertTrue($user->fresh()->hasRole('Bendahara'));
    }
}
