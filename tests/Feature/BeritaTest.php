<?php

namespace Tests\Feature;

use Tests\TestCase;

class BeritaTest extends TestCase
{
    public function test_halaman_berita_memuat_sorotan_dan_grid(): void
    {
        $response = $this->get(route('berita'));

        $response->assertStatus(200);
        $response->assertSee('Sorotan Minggu Ini');
        $response->assertSee('Warta & Informasi Pelayanan', false);
    }

    public function test_pencarian_memfilter_artikel(): void
    {
        $response = $this->get(route('berita', ['q' => 'donor darah']));

        $response->assertStatus(200);
        $response->assertSee('Bakti Sosial & Donor Darah Kasih Bersama PMI');
        $response->assertDontSee('Pembukaan Kelompok Sel Baru Wilayah Kuta');
    }

    public function test_filter_kategori_hanya_menampilkan_kategori_dipilih(): void
    {
        $response = $this->get(route('berita', ['kategori' => 'Renungan']));

        $response->assertStatus(200);
        $response->assertSee('Membangun Kebiasaan Doa Fajar di Awal Pekan');
        $response->assertDontSee('Pembukaan Kelompok Sel Baru Wilayah Kuta');
    }

    public function test_kategori_tidak_valid_dianggap_semua(): void
    {
        $response = $this->get(route('berita', ['kategori' => 'TidakAda']));

        $response->assertStatus(200);
        $response->assertSee('14 artikel');
    }

    public function test_halaman_kedua_berita_dapat_diakses(): void
    {
        $response = $this->get(route('berita', ['page' => 2]));

        $response->assertStatus(200);
        $response->assertSee('Pelatihan Guru Sekolah Minggu');
    }
}
