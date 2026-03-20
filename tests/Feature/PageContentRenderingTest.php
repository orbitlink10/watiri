<?php

namespace Tests\Feature;

use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageContentRenderingTest extends TestCase
{
    use RefreshDatabase;

    public function test_plain_text_page_content_is_rendered_as_structured_article_markup(): void
    {
        $page = Page::create([
            'type' => 'page',
            'title' => 'Kikuyu Ruracio Attire Styles',
            'slug' => 'kikuyu-ruracio-attire-styles',
            'heading_2' => 'Gorgeous Kikuyu Ruracio Attire Styles for Weddings',
            'content' => <<<'TEXT'
Introduction: The Beauty and Significance of Kikuyu Ruracio Attire

Kikuyu ruracio attire is one of the most vibrant cultural expressions in Kenya.
The attire worn during this event communicates:
Respect for traditions
Unity between families
TEXT,
            'is_published' => true,
            'published_at' => now(),
        ]);

        $response = $this->get(route('pages.show', $page));

        $response->assertOk();
        $response->assertSee('page-content', false);
        $response->assertSee('<h2>Introduction: The Beauty and Significance of Kikuyu Ruracio Attire</h2>', false);
        $response->assertSee('<p>Kikuyu ruracio attire is one of the most vibrant cultural expressions in Kenya.</p>', false);
        $response->assertSee('<li>Respect for traditions</li>', false);
        $response->assertSee('<li>Unity between families</li>', false);
    }
}
