<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_returns_valid_xml(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', false)
            ->assertSee('<loc>', false);
    }

    public function test_sitemap_includes_static_pages(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertSee('/terms', false)
            ->assertSee('/privacy', false);
    }

    public function test_public_pages_render_ok(): void
    {
        $this->get('/')->assertOk();
        $this->get('/terms')->assertOk();
        $this->get('/privacy')->assertOk();
    }
}
