<?php

namespace Tests\Feature;

use App\Models\PrayerRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PrayerRequestTest extends TestCase
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

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'nama_lengkap' => 'Yohanes Budi',
            'jenis_kelamin' => 'L',
            'nomor_hp' => '081234567890',
            'alamat' => 'Jl. Gatot Subroto 12, Denpasar',
            'kategori' => 'kesehatan',
            'isi_doa' => 'Mohon doa untuk kesembuhan ibu saya yang sedang sakit.',
            'boleh_dihubungi' => '1',
            'persetujuan' => '1',
        ], $overrides);
    }

    public function test_halaman_doa_publik_dapat_diakses(): void
    {
        $this->get(route('doa'))
            ->assertOk()
            ->assertSeeText('Permohonan Doa')
            ->assertSeeText('Nama Lengkap');
    }

    public function test_halaman_kebijakan_privasi_dapat_diakses(): void
    {
        $this->get(route('kebijakan-privasi'))
            ->assertOk()
            ->assertSeeText('Kebijakan Privasi')
            ->assertSeeText('Data yang kami kumpulkan');
    }

    public function test_submit_doa_sah_tersimpan(): void
    {
        $this->post(route('doa.kirim'), $this->payload())
            ->assertRedirect(route('doa'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('prayer_requests', [
            'nama_lengkap' => 'Yohanes Budi',
            'status' => 'baru',
        ]);
    }

    public function test_submit_tanpa_persetujuan_ditolak(): void
    {
        $this->post(route('doa.kirim'), $this->payload(['persetujuan' => null]))
            ->assertSessionHasErrors('persetujuan');

        $this->assertDatabaseCount('prayer_requests', 0);
    }

    public function test_submit_tanpa_isi_doa_ditolak(): void
    {
        $this->post(route('doa.kirim'), $this->payload(['isi_doa' => '']))
            ->assertSessionHasErrors('isi_doa');
    }

    public function test_honeypot_terisi_menolak_tanpa_menyimpan(): void
    {
        $this->post(route('doa.kirim'), $this->payload(['website' => 'http://spam.example']))
            ->assertRedirect(route('doa'))
            ->assertSessionHas('success');

        $this->assertDatabaseCount('prayer_requests', 0);
    }

    public function test_dashboard_doa_diakses_administrator(): void
    {
        PrayerRequest::create($this->payload());

        $this->actingAs($this->admin)
            ->get(route('admin.doa.index'))
            ->assertOk()
            ->assertSeeText('Permohonan Doa');
    }

    public function test_dashboard_doa_ditolak_user_non_administrator(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Tim Pelayanan');

        $this->actingAs($user)
            ->get(route('admin.doa.index'))
            ->assertForbidden();
    }

    public function test_administrator_bisa_mengubah_status(): void
    {
        $doa = PrayerRequest::create($this->payload());

        $this->actingAs($this->admin)
            ->patch(route('admin.doa.status', $doa), ['status' => 'selesai'])
            ->assertRedirect();

        $this->assertDatabaseHas('prayer_requests', [
            'id' => $doa->id,
            'status' => 'selesai',
        ]);
    }

    public function test_administrator_bisa_menghapus_soft_delete(): void
    {
        $doa = PrayerRequest::create($this->payload());

        $this->actingAs($this->admin)
            ->delete(route('admin.doa.destroy', $doa))
            ->assertRedirect();

        $this->assertSoftDeleted('prayer_requests', ['id' => $doa->id]);
    }

    public function test_administrator_bisa_menyimpan_catatan_internal(): void
    {
        $doa = PrayerRequest::create($this->payload());

        $this->actingAs($this->admin)
            ->patch(route('admin.doa.catatan', $doa), ['catatan_internal' => 'Hubungi jemaat Jumat.'])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('prayer_requests', [
            'id' => $doa->id,
            'catatan_internal' => 'Hubungi jemaat Jumat.',
        ]);
    }

    public function test_administrator_bisa_memulihkan_doa_terhapus(): void
    {
        $doa = PrayerRequest::create($this->payload());
        $doa->delete();

        $this->actingAs($this->admin)
            ->patch(route('admin.doa.pulihkan', $doa->id))
            ->assertRedirect(route('admin.doa.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('prayer_requests', ['id' => $doa->id]);
        $this->assertNotSoftDeleted('prayer_requests', ['id' => $doa->id]);
    }

    public function test_administrator_bisa_menghapus_permanen(): void
    {
        $doa = PrayerRequest::create($this->payload());
        $doa->delete();

        $this->actingAs($this->admin)
            ->delete(route('admin.doa.forceDelete', $doa->id))
            ->assertRedirect(route('admin.doa.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('prayer_requests', ['id' => $doa->id]);
    }
}
