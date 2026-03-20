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

        $this
            ->withSession(['admin_logged_in' => true])
            ->get(route('admin.pages.preview', $page))
            ->assertOk()
            ->assertSee('Kikuyu Ruracio Attire Styles')
            ->assertSee('Draft copy.');
    }
}
