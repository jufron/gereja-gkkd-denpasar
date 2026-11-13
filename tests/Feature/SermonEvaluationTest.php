<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SermonEvaluationTest extends TestCase
{
    use RefreshDatabase;

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'bulan' => (int) now()->month,
            'tahun' => (int) now()->year,
            'nama' => 'Maria Wati',
            'rating' => '4',
            'berkesan' => 'Khotbah tentang pengampunan sangat menyentuh.',
            'masukan' => 'Boleh lebih banyak contoh nyata.',
            'persetujuan' => '1',
        ], $overrides);
    }

    public function test_halaman_evaluasi_dapat_diakses(): void
    {
        $this->get(route('evaluasi-khotbah'))
            ->assertOk()
            ->assertSeeText('Evaluasi Khotbah Bulanan')
            ->assertSeeText('Penilaian keseluruhan');
    }

    public function test_submit_evaluasi_sah_tersimpan(): void
    {
        $this->post(route('evaluasi-khotbah.kirim'), $this->payload())
            ->assertRedirect(route('evaluasi-khotbah'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('sermon_evaluations', [
            'rating' => 4,
            'bulan' => (int) now()->month,
            'tahun' => (int) now()->year,
        ]);
    }

    public function test_submit_tanpa_rating_ditolak(): void
    {
        $this->post(route('evaluasi-khotbah.kirim'), $this->payload(['rating' => null]))
            ->assertSessionHasErrors('rating');

        $this->assertDatabaseCount('sermon_evaluations', 0);
    }

    public function test_submit_tanpa_persetujuan_ditolak(): void
    {
        $this->post(route('evaluasi-khotbah.kirim'), $this->payload(['persetujuan' => null]))
            ->assertSessionHasErrors('persetujuan');

        $this->assertDatabaseCount('sermon_evaluations', 0);
    }

    public function test_honeypot_terisi_menolak_tanpa_menyimpan(): void
    {
        $this->post(route('evaluasi-khotbah.kirim'), $this->payload(['website' => 'http://spam.example']))
            ->assertRedirect(route('evaluasi-khotbah'))
            ->assertSessionHas('success');

        $this->assertDatabaseCount('sermon_evaluations', 0);
    }
}
