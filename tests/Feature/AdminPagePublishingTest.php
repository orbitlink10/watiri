<?php

namespace Tests\Feature;

use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPagePublishingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        putenv('ADMIN_USER=admin');
        putenv('ADMIN_PASSWORD=secret');
        $_ENV['ADMIN_USER'] = 'admin';
        $_ENV['ADMIN_PASSWORD'] = 'secret';
    }

    public function test_admin_can_create_an_unpublished_page_without_checkbox_input(): void
    {
        $response = $this
            ->withSession(['admin_logged_in' => true])
            ->post(route('admin.pages.store'), [
                'type' => 'page',
                'title' => 'About Watiri',
                'content' => 'Brand story.',
            ]);

        $page = Page::query()->firstOrFail();

        $response->assertRedirect(route('admin.pages.edit', $page));
        $this->assertFalse($page->is_published);
        $this->assertNull($page->published_at);
    }

    public function test_admin_can_unpublish_a_page_without_checkbox_input(): void
    {
        $page = Page::create([
            'type' => 'page',
            'title' => 'Terms and Conditions',
            'slug' => 'terms-and-conditions',
            'content' => 'Terms copy.',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $response = $this
            ->withSession(['admin_logged_in' => true])
            ->put(route('admin.pages.update', $page), [
                'type' => 'page',
                'title' => 'Terms and Conditions',
                'content' => 'Updated terms copy.',
            ]);

        $response->assertRedirect(route('admin.pages.index'));

        $page->refresh();

        $this->assertFalse($page->is_published);
        $this->assertNull($page->published_at);
    }

    public function test_admin_can_preview_an_unpublished_page_while_public_route_stays_hidden(): void
    {
        $page = Page::create([
            'type' => 'page',
            'title' => 'Kikuyu Ruracio Attire Styles',
            'slug' => 'kikuyu-ruracio-attire-styles',
            'content' => 'Draft copy.',
            'is_published' => false,
        ]);

        $this->get(route('pages.show', $page))->assertNotFound();
        $this->assertSame(url('/preview/kikuyu-ruracio-attire-styles'), route('pages.preview', $page));

        $this
            ->withSession(['admin_logged_in' => true])
            ->get(route('pages.preview', $page))
            ->assertOk()
            ->assertSee('Kikuyu Ruracio Attire Styles')
            ->assertSee('Draft copy.');
    }

    public function test_published_page_uses_root_slug_url_and_old_pages_url_redirects(): void
    {
        $page = Page::create([
            'type' => 'page',
            'title' => 'Bridal Styling Tips',
            'slug' => 'bridal-styling-tips',
            'content' => 'Published copy.',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $this->assertSame(url('/bridal-styling-tips'), route('pages.show', $page));

        $this->get('/bridal-styling-tips')
            ->assertOk()
            ->assertSee('Bridal Styling Tips');

        $this->get('/pages/bridal-styling-tips')
            ->assertRedirect('/bridal-styling-tips');
    }

    public function test_reserved_slug_is_shifted_to_avoid_conflicting_with_root_routes(): void
    {
        $response = $this
            ->withSession(['admin_logged_in' => true])
            ->post(route('admin.pages.store'), [
                'type' => 'page',
                'title' => 'Shop',
                'slug' => 'shop',
                'content' => 'Reserved slug copy.',
                'is_published' => '1',
            ]);

        $page = Page::query()->firstOrFail();

        $response->assertRedirect(route('admin.pages.edit', $page));
        $this->assertSame('shop-2', $page->slug);
        $this->get('/shop')->assertOk();
        $this->get('/shop-2')->assertOk()->assertSee('Reserved slug copy.');
    }
}
