<?php

namespace Tests\Feature;

use Tests\TestCase;

class NavigationPagesTest extends TestCase
{
    public function test_all_navbar_routes_are_accessible(): void
    {
        $routes = [
            '/',
            '/tentang',
            '/kegiatan',
            '/kegiatan/ibadah-raya',
            '/kegiatan/doa-bersama',
            '/kegiatan/sekolah-minggu',
            '/kegiatan/persekutuan-wilayah',
            '/berita',
            '/galeri',
            '/kontak',
        ];

        foreach ($routes as $url) {
            $response = $this->get($url);
            $response->assertStatus(200);
        }
    }
}
