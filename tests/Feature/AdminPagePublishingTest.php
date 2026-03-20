<?php

namespace Tests\Feature;

use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
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

        $response = $this
            ->withSession(['admin_logged_in' => true])
            ->get(route('admin.pages.preview', $page));

        $response->assertRedirect(route('pages.show', $page));

        $this
            ->followingRedirects()
            ->withSession(['admin_logged_in' => true])
            ->get(route('admin.pages.preview', $page))
            ->assertOk()
            ->assertSee('Kikuyu Ruracio Attire Styles')
            ->assertSee('Draft copy.');
    }

    public function test_legacy_signed_preview_url_redirects_to_clean_page_url(): void
    {
        $page = Page::create([
            'type' => 'page',
            'title' => 'Kikuyu Ruracio Attire Styles',
            'slug' => 'kikuyu-ruracio-attire-styles',
            'content' => 'Draft copy.',
            'is_published' => false,
        ]);

        $signedPreviewUrl = URL::temporarySignedRoute('pages.show', now()->addMinutes(30), [
            'page' => $page,
            'preview' => 1,
        ]);

        $response = $this->get($signedPreviewUrl);

        $response->assertRedirect(route('pages.show', $page));
        $page->refresh();
        $this->assertTrue($page->preview_expires_at?->isFuture() === true);

        $this->followingRedirects()
            ->get($signedPreviewUrl)
            ->assertOk()
            ->assertSee('Kikuyu Ruracio Attire Styles')
            ->assertSee('Draft copy.');
    }

    public function test_legacy_pages_path_redirects_to_clean_url_when_preview_access_exists(): void
    {
        $page = Page::create([
            'type' => 'page',
            'title' => 'Kikuyu Ruracio Attire Styles',
            'slug' => 'kikuyu-ruracio-attire-styles',
            'content' => 'Draft copy.',
            'is_published' => false,
        ]);

        $response = $this
            ->withSession(['admin_logged_in' => true])
            ->get(route('admin.pages.preview', $page));

        $response->assertRedirect(route('pages.show', $page));

        $response = $this
            ->get('/pages/kikuyu-ruracio-attire-styles');

        $response->assertRedirect(route('pages.show', $page));
    }

    public function test_clean_page_url_works_in_a_fresh_context_after_admin_preview(): void
    {
        $page = Page::create([
            'type' => 'page',
            'title' => 'Kikuyu Ruracio Attire Styles',
            'slug' => 'kikuyu-ruracio-attire-styles',
            'content' => 'Draft copy.',
            'is_published' => false,
        ]);

        $this
            ->withSession(['admin_logged_in' => true])
            ->get(route('admin.pages.preview', $page))
            ->assertRedirect(route('pages.show', $page));

        $page->refresh();
        $this->assertTrue($page->preview_expires_at?->isFuture() === true);

        $this->get(route('pages.show', $page))
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
