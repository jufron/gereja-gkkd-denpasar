<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NavigationPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_navbar_routes_are_accessible(): void
    {
        $routes = [
            '/',
            '/tentang',
            '/kegiatan',
            '/kegiatan/pelayanan',
            '/kegiatan/komsel',
            '/kegiatan/retret-camp',
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
