<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Seed the default roles and permissions for the GKKD dashboard.
     */
    public function run(): void
    {
        $permissions = collect([
            'Kelola User',
            'Hak Akses',
            'Kelola Berita',
            'Kelola Jadwal',
            'Kelola Keuangan',
            'Pengaturan',
        ])->map(fn (string $name) => Permission::firstOrCreate(
            ['name' => $name, 'guard_name' => 'web'],
        )->name);

        $matrix = [
            'Administrator' => $permissions->all(),
            'Pendeta' => ['Kelola Berita', 'Kelola Jadwal'],
            'Staff' => ['Kelola Berita', 'Kelola Keuangan'],
        ];

        foreach ($matrix as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);

            $role->syncPermissions($rolePermissions);
        }

        // ponytail: cleanup role lama (Volunteer/Jemaat) dari versi seeder sebelumnya.
        // Aman hanya jika tidak ada user yang memilikinya; jika ada, skip agar tidak putus akses.
        Role::whereIn('name', ['Volunteer', 'Jemaat'])
            ->whereDoesntHave('users')
            ->delete();
    }
}
