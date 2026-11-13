<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SermonSectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_has_balanced_section_tags(): void
    {
        $html = $this->get('/')->getContent();

        $this->assertSame(
            substr_count($html, '<section'),
            substr_count($html, '</section>'),
            'Jumlah <section> dan </section> harus sama (tidak ada nesting invalid).'
        );
    }

    public function test_sermon_section_renders_editorial_layout(): void
    {
        $html = $this->get('/')->getContent();

        // Header punya id aria-labelledby + link "Semua Khotbah".
        $this->assertStringContainsString('id="heading-rangkuman-khotbah"', $html);
        $this->assertStringContainsString('Semua Khotbah', $html);

        // Tidak ada link mati href="#" di section Rangkuman Khotbah.
        $section = $this->extractSermonSection($html);
        $this->assertStringNotContainsString('href="#"', $section);
        $this->assertStringNotContainsString('download', $section);

        // Layout editorial: grid 12 kolom + blockquote ayat.
        $this->assertStringContainsString('lg:grid-cols-12', $html);
        $this->assertStringContainsString('<blockquote', $html);

        // CTA punya focus ring.
        $this->assertStringContainsString('focus-visible:ring-accent', $html);
    }

    /**
     * Ambil blok HTML section Rangkuman Khotbah: dari id heading
     * sampai sebelum heading section Berita berikutnya.
     */
    private function extractSermonSection(string $html): string
    {
        $start = strpos($html, 'id="heading-rangkuman-khotbah"');
        $end = strpos($html, 'Kabar & Berita Terkini', $start);

        $this->assertNotFalse($start, 'Heading Rangkuman Khotbah tidak ditemukan.');
        $this->assertNotFalse($end, 'Heading Berita tidak ditemukan setelah section khotbah.');

        return substr($html, $start, $end - $start);
    }
}
