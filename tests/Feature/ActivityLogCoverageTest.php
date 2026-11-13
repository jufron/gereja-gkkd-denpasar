<?php

namespace Tests\Feature;

use App\Livewire\Dashboard\BannerManager;
use App\Livewire\Dashboard\SermonEvaluationTable;
use App\Models\HeroBanner;
use App\Models\PrayerRequest;
use App\Models\SermonEvaluation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

class ActivityLogCoverageTest extends TestCase
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

    private function buatDoa(): PrayerRequest
    {
        return PrayerRequest::create([
            'nama_lengkap' => 'Yohanes Budi',
            'jenis_kelamin' => 'L',
            'nomor_hp' => '081234567890',
            'alamat' => 'Jl. Gatot Subroto 12, Denpasar',
            'kategori' => 'kesehatan',
            'isi_doa' => 'Mohon doa untuk kesembuhan ibu saya yang sedang sakit.',
            'boleh_dihubungi' => true,
            'persetujuan' => true,
        ]);
    }

    public function test_status_doa_dicatat_tanpa_isi_doa(): void
    {
        $doa = $this->buatDoa();

        $this->actingAs($this->admin)
            ->patch(route('admin.doa.status', $doa), ['status' => 'selesai'])
            ->assertRedirect();

        $this->assertDatabaseHas('activity_log', [
            'log_name' => 'doa',
            'description' => 'Ubah status doa',
        ]);

        $activity = Activity::where('log_name', 'doa')
            ->where('description', 'Ubah status doa')
            ->latest('id')->first();

        $dumped = json_encode($activity->properties);
        $this->assertStringNotContainsString('Mohon doa untuk kesembuhan', $dumped);
        $this->assertStringNotContainsString('081234567890', $dumped);
    }

    public function test_doa_baru_masuk_dicatat(): void
    {
        $this->buatDoa();

        $this->assertDatabaseHas('activity_log', [
            'log_name' => 'doa',
            'description' => 'Doa baru masuk',
        ]);
    }

    public function test_hapus_permanen_doa_dicatat(): void
    {
        $doa = $this->buatDoa();
        $doa->delete();

        $this->actingAs($this->admin)
            ->delete(route('admin.doa.forceDelete', $doa->id))
            ->assertRedirect(route('admin.doa.index'));

        $this->assertDatabaseHas('activity_log', [
            'log_name' => 'doa',
            'description' => 'Doa dihapus permanen',
        ]);
    }

    public function test_catatan_internal_doa_dicatat_tanpa_isi(): void
    {
        $doa = $this->buatDoa();

        $this->actingAs($this->admin)
            ->patch(route('admin.doa.catatan', $doa), ['catatan_internal' => 'Hubungi jemaat Jumat.'])
            ->assertRedirect();

        $activity = Activity::where('log_name', 'doa')
            ->where('description', 'Ubah catatan internal doa')
            ->latest('id')->first();

        $this->assertNotNull($activity);
        $this->assertStringNotContainsString('Hubungi jemaat Jumat.', json_encode($activity->properties));
    }

    public function test_hapus_evaluasi_dicatat(): void
    {
        $evaluasi = SermonEvaluation::create([
            'bulan' => 11,
            'tahun' => 2026,
            'nama' => 'Maria Wati',
            'rating' => 4,
            'berkesan' => 'Khotbah menyentuh.',
            'masukan' => 'Contoh nyata.',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'phpunit',
        ]);

        Livewire::actingAs($this->admin)
            ->test(SermonEvaluationTable::class)
            ->call('bukaKonfirmasiHapus', $evaluasi->id)
            ->call('hapus');

        $this->assertDatabaseHas('activity_log', [
            'log_name' => 'evaluasi',
            'description' => 'Hapus evaluasi khotbah',
        ]);

        $activity = Activity::where('log_name', 'evaluasi')->latest('id')->first();
        $this->assertStringNotContainsString('Khotbah menyentuh.', json_encode($activity->properties));
    }

    public function test_toggle_banner_dicatat(): void
    {
        $banner = HeroBanner::create([
            'media_id' => 1,
            'badge' => 'Ibadah Raya',
            'caption' => 'Selamat datang',
            'alt' => 'Banner',
            'link_url' => null,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Livewire::actingAs($this->admin)
            ->test(BannerManager::class)
            ->call('toggleAktif', $banner->id);

        $this->assertDatabaseHas('activity_log', [
            'log_name' => 'beranda',
            'description' => 'Ubah status banner',
        ]);
    }
}
