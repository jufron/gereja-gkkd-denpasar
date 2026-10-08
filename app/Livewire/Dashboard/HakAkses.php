<?php

namespace App\Livewire\Dashboard;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Halaman "Hak Akses" — kelola role, permission, dan user pemilik role.
 *
 * Pola master-detail: tabel role di atas sebagai daftar utama, lalu panel
 * detail di bawah untuk mengatur permission dan user dari role terpilih.
 *
 * Akses dibatasi hanya untuk user ber-role Administrator (lihat mount()).
 */
final class HakAkses extends Component
{
    // ─────────────────────────────────────────────────────────────────────
    // State komponen
    // ─────────────────────────────────────────────────────────────────────

    /** Id role yang sedang dikelola di panel detail. */
    #[Locked]
    public ?int $roleId = null;

    /** Nama role pada modal tambah/edit. */
    public string $nama = '';

    /** Id user yang akan di-assign ke role terpilih. */
    public ?int $userId = null;

    /** Id role yang menunggu konfirmasi penghapusan. */
    public ?int $hapusId = null;

    /** State modal form tambah/ubah role (di-entangle ke Alpine). */
    public bool $formRoleOpen = false;

    /** State modal konfirmasi hapus (di-entangle ke Alpine). */
    public bool $hapusOpen = false;

    /** Pesan notifikasi sementara (success/error) untuk view. */
    public ?string $pesan = null;

    public string $pesanTone = 'success';

    // ─────────────────────────────────────────────────────────────────────
    // Aturan bisnis
    // ─────────────────────────────────────────────────────────────────────

    /** Role dasar yang tidak boleh dihapus. */
    private const ROLE_TERKUNCI = ['Administrator'];

    /** Permission yang tidak boleh dicabut dari role tertentu (jaga akses admin). */
    private const PERMISSION_TERKUNCI = [
        'Administrator' => ['Hak Akses'],
    ];

    // ─────────────────────────────────────────────────────────────────────
    // Siklus hidup & helper
    // ─────────────────────────────────────────────────────────────────────

    /** Batasi halaman hanya untuk Administrator. */
    public function mount(): void
    {
        abort_unless(auth()->user()?->hasRole('Administrator'), 403);
    }

    /** Simpan notifikasi sementara untuk ditampilkan di view. */
    public function setPesan(string $pesan, string $tone = 'success'): void
    {
        $this->pesan = $pesan;
        $this->pesanTone = $tone;
    }

    // ─────────────────────────────────────────────────────────────────────
    // Data (computed)
    // ─────────────────────────────────────────────────────────────────────

    /** Semua role beserta permission-nya dan jumlah user. */
    #[Computed]
    public function roles(): Collection
    {
        return Role::with('permissions')
            ->withCount('users')
            ->orderBy('name')
            ->get();
    }

    /** Semua permission yang terdaftar. */
    #[Computed]
    public function permissions(): Collection
    {
        return Permission::orderBy('name')->get();
    }

    /** Role yang sedang dipilih di panel detail. */
    public function roleTerpilih(): ?Role
    {
        return $this->roleId
            ? $this->roles->firstWhere('id', $this->roleId)
            : null;
    }

    /** User yang belum memiliki role terpilih, untuk pilihan assign. */
    #[Computed]
    public function kandidatUser(): Collection
    {
        if (! $this->roleId) {
            return collect();
        }

        return User::whereDoesntHave('roles', fn ($q) => $q->where('roles.id', $this->roleId))
            ->orderBy('name')
            ->get();
    }

    // ─────────────────────────────────────────────────────────────────────
    // Aksi: pilih role
    // ─────────────────────────────────────────────────────────────────────

    /** Pilih role untuk dikelola di panel detail. */
    public function pilihRole(int $roleId): void
    {
        $this->roleId = $roleId;
        $this->reset('nama', 'userId');
        $this->formRoleOpen = false;
    }

    // ─────────────────────────────────────────────────────────────────────
    // Aksi CRUD role
    // ─────────────────────────────────────────────────────────────────────

    /** Buka modal dalam mode tambah role baru. */
    public function bukaFormTambah(): void
    {
        $this->reset('nama', 'roleId');
        $this->formRoleOpen = true;
    }

    /** Buka modal dalam mode ubah nama role. */
    public function bukaFormUbah(int $roleId): void
    {
        $role = Role::findOrFail($roleId);

        $this->roleId = $roleId;
        $this->nama = $role->name;

        $this->formRoleOpen = true;
    }

    /** Simpan role (buat baru atau perbarui nama). */
    public function simpanRole(): void
    {
        $data = $this->validate([
            'nama' => ['required', 'string', 'min:3', 'max:50'],
        ]);

        $nama = trim($data['nama']);

        // Nama role harus unik per guard, kecuali untuk role yang sedang diubah.
        $sudahDipakai = Role::query()
            ->where('name', $nama)
            ->where('guard_name', 'web')
            ->when($this->roleId, fn ($query) => $query->where('id', '!=', $this->roleId))
            ->exists();

        if ($sudahDipakai) {
            $this->addError('nama', 'Nama role sudah digunakan.');

            return;
        }

        if ($this->roleId) {
            $role = Role::findOrFail($this->roleId);
            $namaLama = $role->name;
            $role->update(['name' => $nama]);

            activity('hak-akses')
                ->on($role)
                ->withProperties(['lama' => $namaLama, 'baru' => $nama])
                ->log('Ubah nama role');

            $this->setPesan('Role berhasil diperbarui.', 'success');
        } else {
            $role = Role::create(['name' => $nama, 'guard_name' => 'web']);

            activity('hak-akses')
                ->on($role)
                ->withProperties(['nama' => $nama])
                ->log('Tambah role');

            $this->setPesan('Role baru berhasil ditambahkan.', 'success');
        }

        // Reset cache computed agar daftar role diperbarui.
        unset($this->roles);

        $this->reset('nama');
        $this->formRoleOpen = false;
    }

    /** Buka modal konfirmasi hapus role. */
    public function bukaKonfirmasiHapus(int $rowId): void
    {
        $this->hapusId = $rowId;
        $this->hapusOpen = true;
    }

    /** Hapus role, dengan penjagaan role dasar dan role yang masih dipakai. */
    public function hapusRole(): void
    {
        $role = Role::withCount('users')->findOrFail($this->hapusId);

        if (in_array($role->name, self::ROLE_TERKUNCI, true)) {
            $this->setPesan("Role \"{$role->name}\" tidak boleh dihapus.", 'error');

            $this->hapusOpen = false;

            return;
        }

        if ($role->users_count > 0) {
            $this->setPesan("Role \"{$role->name}\" masih dipakai {$role->users_count} user. Lepaskan dulu.", 'error');

            $this->hapusOpen = false;

            return;
        }

        $role->delete();

        activity('hak-akses')->withProperties(['nama' => $role->name])->log('Hapus role');

        if ($this->roleId === (int) $role->id) {
            $this->roleId = null;
        }

        unset($this->roles, $this->hapusId);

        $this->hapusOpen = false;

        $this->setPesan('Role berhasil dihapus.', 'success');
    }

    // ─────────────────────────────────────────────────────────────────────
    // Aksi: permission role
    // ─────────────────────────────────────────────────────────────────────

    /** Cek apakah sebuah permission tidak boleh dicabut dari role ini. */
    public function permissionTerkunci(Role $role, string $namaPermission): bool
    {
        return in_array($namaPermission, self::PERMISSION_TERKUNCI[$role->name] ?? [], true);
    }

    /** Toggle satu permission pada role terpilih, langsung tersimpan. */
    public function togglePermission(string $namaPermission): void
    {
        $role = $this->roleTerpilih();

        abort_unless($role !== null, 404);

        // Cegah pencabutan permission yang dikunci untuk role tersebut.
        if ($this->permissionTerkunci($role, $namaPermission) && $role->hasPermissionTo($namaPermission)) {
            $this->setPesan("Permission \"{$namaPermission}\" pada role \"{$role->name}\" permanen dan tidak bisa dicabut.", 'error');

            return;
        }

        if ($role->hasPermissionTo($namaPermission)) {
            $role->revokePermissionTo($namaPermission);
            $aksi = 'Cabut permission';
        } else {
            $role->givePermissionTo($namaPermission);
            $aksi = 'Berikan permission';
        }

        activity('hak-akses')
            ->on($role)
            ->withProperties(['role' => $role->name, 'permission' => $namaPermission])
            ->log($aksi);

        unset($this->roles);
    }

    // ─────────────────────────────────────────────────────────────────────
    // Aksi: user pemilik role
    // ─────────────────────────────────────────────────────────────────────

    /** Assign user terpilih ke role yang sedang dikelola. */
    public function assignUser(): void
    {
        $role = $this->roleTerpilih();

        abort_unless($role !== null, 404);

        $data = $this->validate([
            'userId' => ['required', 'exists:users,id'],
        ]);

        $user = User::find($data['userId']);
        $user->assignRole($role);

        activity('hak-akses')
            ->on($user)
            ->withProperties(['user' => $user->name, 'role' => $role->name])
            ->log('Assign user ke role');

        $this->reset('userId');
        unset($this->roles, $this->kandidatUser);

        $this->setPesan("User \"{$user->name}\" ditambahkan ke role \"{$role->name}\".", 'success');
    }

    /** Lepas user dari role yang sedang dikelola. */
    public function lepasUser(int $userId): void
    {
        $role = $this->roleTerpilih();

        abort_unless($role !== null, 404);

        $user = User::findOrFail($userId);
        $user->removeRole($role);

        activity('hak-akses')
            ->on($user)
            ->withProperties(['user' => $user->name, 'role' => $role->name])
            ->log('Lepas user dari role');

        unset($this->roles, $this->kandidatUser);

        $this->setPesan("User \"{$user->name}\" dilepas dari role \"{$role->name}\".", 'success');
    }

    // ─────────────────────────────────────────────────────────────────────
    // Render
    // ─────────────────────────────────────────────────────────────────────

    public function render()
    {
        return view('livewire.hak-akses');
    }
}
