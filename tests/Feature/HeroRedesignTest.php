<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HeroRedesignTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_hero_renders_new_cinematic_markup(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Gereja Kristen Kemah Daud');
        $response->assertSee('Rumah untuk bertumbuh');
        $response->assertSee('hero-captions');
        $response->assertSee('ken-burns');
        $response->assertSee('autoplay-progress-running');

        // Hero full-bleed di atas navbar (hanya di halaman home).
        $response->assertSee('data-over-hero');
    }
}
