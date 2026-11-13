<?php

namespace Tests\Feature;

use App\Livewire\Dashboard\SermonEvaluationTable;
use App\Models\SermonEvaluation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SermonEvaluationDashboardTest extends TestCase
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

    private function buatEvaluasi(array $overrides = []): SermonEvaluation
    {
        return SermonEvaluation::create(array_merge([
            'bulan' => (int) now()->month,
            'tahun' => (int) now()->year,
            'nama' => 'Maria Wati',
            'rating' => 4,
            'berkesan' => 'Khotbah menyentuh.',
            'masukan' => 'Contoh nyata.',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'phpunit',
        ], $overrides));
    }

    public function test_dashboard_evaluasi_diakses_administrator(): void
    {
        $this->buatEvaluasi();

        $this->actingAs($this->admin)
            ->get(route('admin.evaluasi-khotbah.index'))
            ->assertOk()
            ->assertSeeText('Evaluasi Khotbah');
    }

    public function test_dashboard_evaluasi_ditolak_user_non_administrator(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Tim Pelayanan');

        $this->actingAs($user)
            ->get(route('admin.evaluasi-khotbah.index'))
            ->assertForbidden();
    }

    public function test_detail_evaluasi_dapat_dibuka_administrator(): void
    {
        $evaluasi = $this->buatEvaluasi();

        $this->actingAs($this->admin)
            ->get(route('admin.evaluasi-khotbah.show', $evaluasi))
            ->assertOk()
            ->assertSeeText('Khotbah menyentuh.')
            ->assertSeeText('Contoh nyata.');
    }

    public function test_filter_bulan_tahun_memfilter_baris(): void
    {
        $this->buatEvaluasi(['bulan' => 1, 'tahun' => 2026, 'nama' => 'Januari 2026']);
        $this->buatEvaluasi(['bulan' => 2, 'tahun' => 2026, 'nama' => 'Februari 2026']);

        Livewire::actingAs($this->admin)
            ->test(SermonEvaluationTable::class)
            ->set('bulan', '1')
            ->set('tahun', '2026')
            ->assertSee('Januari 2026')
            ->assertDontSee('Februari 2026');
    }

    public function test_rata_rata_rating_tampil_benar(): void
    {
        $this->buatEvaluasi(['rating' => 4]);
        $this->buatEvaluasi(['rating' => 5]);

        Livewire::actingAs($this->admin)
            ->test(SermonEvaluationTable::class)
            ->assertSee('4,5')
            ->assertSee('/ 5');
    }

    public function test_hapus_evaluasi_hanya_administrator(): void
    {
        $evaluasi = $this->buatEvaluasi();

        Livewire::actingAs($this->admin)
            ->test(SermonEvaluationTable::class)
            ->call('bukaKonfirmasiHapus', $evaluasi->id)
            ->assertSet('hapusOpen', true)
            ->call('hapus');

        $this->assertDatabaseMissing('sermon_evaluations', ['id' => $evaluasi->id]);
    }

    public function test_komponen_evaluasi_ditolak_user_non_administrator(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Tim Pelayanan');

        Livewire::actingAs($user)
            ->test(SermonEvaluationTable::class)
            ->assertForbidden();
    }
}
