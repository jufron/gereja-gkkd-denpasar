<?php

namespace Tests\Feature;

use App\Models\Badge;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class JadwalIbadahTest extends TestCase
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
            ->get(route('jadwal'))
            ->assertOk()
            ->assertSeeText('Badge Kategori Jadwal')
            ->assertSeeText('Daftar Jadwal');
    }

    public function test_halaman_ditolak_untuk_user_tanpa_permission(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Staff');

        $this->actingAs($user)
            ->get(route('jadwal'))
            ->assertForbidden();
    }

    public function test_bisa_menambah_badge(): void
    {
        Livewire::actingAs($this->admin)
            ->test('dashboard.badge-manager')
            ->call('bukaFormTambah')
            ->set('name', 'Tim Doa')
            ->call('simpan')
            ->assertHasNoErrors()
            ->assertSet('formOpen', false);

        $this->assertDatabaseHas('badges', ['name' => 'Tim Doa', 'slug' => 'tim-doa']);
    }

    public function test_nama_badge_wajib_diisi(): void
    {
        Livewire::actingAs($this->admin)
            ->test('dashboard.badge-manager')
            ->set('name', '')
            ->call('simpan')
            ->assertHasErrors(['name']);
    }

    public function test_bisa_mengubah_badge(): void
    {
        $badge = Badge::create(['name' => 'Tim Lama', 'slug' => 'tim-lama', 'color' => 'bg-accent/10 text-accent']);

        Livewire::actingAs($this->admin)
            ->test('dashboard.badge-manager')
            ->call('bukaFormUbah', $badge->id)
            ->assertSet('formOpen', true)
            ->set('name', 'Tim Baru')
            ->call('simpan')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('badges', ['id' => $badge->id, 'name' => 'Tim Baru', 'slug' => 'tim-baru']);
    }

    public function test_badge_yang_masih_dipakai_tidak_bisa_dihapus(): void
    {
        $badge = Badge::create(['name' => 'Dipakai', 'slug' => 'dipakai']);
        Schedule::create([
            'badge_id' => $badge->id,
            'title' => 'Ibadah Uji',
            'time' => 'Pukul 09.00 WITA',
            'day' => 'Minggu',
            'description' => 'Deskripsi uji.',
        ]);

        Livewire::actingAs($this->admin)
            ->test('dashboard.badge-manager')
            ->call('bukaKonfirmasiHapus', $badge->id)
            ->call('hapus')
            ->assertOk();

        $this->assertDatabaseHas('badges', ['id' => $badge->id]);
    }

    public function test_bisa_menambah_jadwal(): void
    {
        $badge = Badge::create(['name' => 'Tim Pelayanan Uji', 'slug' => 'tim-pelayanan-uji']);

        Livewire::actingAs($this->admin)
            ->test('dashboard.jadwal-manager')
            ->call('bukaFormTambah')
            ->set('badgeId', $badge->id)
            ->set('title', 'Doa Fajar')
            ->set('day', 'Rabu')
            ->set('time', 'Pukul 05.00 WITA')
            ->set('description', 'Doa pagi bersama jemaat.')
            ->set('sortOrder', 5)
            ->call('simpan')
            ->assertHasNoErrors()
            ->assertSet('formOpen', false);

        $this->assertDatabaseHas('schedules', [
            'badge_id' => $badge->id,
            'title' => 'Doa Fajar',
            'is_active' => true,
        ]);
    }

    public function test_validasi_jadwal_wajib_lengkap(): void
    {
        Livewire::actingAs($this->admin)
            ->test('dashboard.jadwal-manager')
            ->set('badgeId', null)
            ->set('title', '')
            ->call('simpan')
            ->assertHasErrors(['badgeId', 'title', 'day', 'time', 'description']);
    }

    public function test_bisa_toggle_status_jadwal(): void
    {
        $badge = Badge::create(['name' => 'Toggle', 'slug' => 'toggle']);
        $schedule = Schedule::create([
            'badge_id' => $badge->id,
            'title' => 'Jadwal Toggle',
            'time' => 'Pukul 10.00 WITA',
            'day' => 'Sabtu',
            'description' => 'Deskripsi.',
            'is_active' => true,
        ]);

        Livewire::actingAs($this->admin)
            ->test('dashboard.jadwal-manager')
            ->call('toggleAktif', $schedule->id)
            ->assertOk();

        $this->assertFalse($schedule->fresh()->is_active);
    }

    public function test_bisa_menghapus_jadwal(): void
    {
        $badge = Badge::create(['name' => 'Hapus', 'slug' => 'hapus']);
        $schedule = Schedule::create([
            'badge_id' => $badge->id,
            'title' => 'Jadwal Hapus',
            'time' => 'Pukul 11.00 WITA',
            'day' => 'Jumat',
            'description' => 'Deskripsi.',
        ]);

        Livewire::actingAs($this->admin)
            ->test('dashboard.jadwal-manager')
            ->call('bukaKonfirmasiHapus', $schedule->id)
            ->call('hapus')
            ->assertOk();

        $this->assertDatabaseMissing('schedules', ['id' => $schedule->id]);
    }

    public function test_perubahan_jadwal_dicatat_di_activity_log(): void
    {
        $badge = Badge::create(['name' => 'Log', 'slug' => 'log']);

        Livewire::actingAs($this->admin)
            ->test('dashboard.jadwal-manager')
            ->call('bukaFormTambah')
            ->set('badgeId', $badge->id)
            ->set('title', 'Jadwal Log')
            ->set('day', 'Senin')
            ->set('time', 'Pukul 08.00 WITA')
            ->set('description', 'Deskripsi log.')
            ->call('simpan');

        $this->assertDatabaseHas('activity_log', [
            'log_name' => 'jadwal',
            'description' => 'Tambah jadwal ibadah',
            'causer_id' => $this->admin->id,
        ]);
    }
}
