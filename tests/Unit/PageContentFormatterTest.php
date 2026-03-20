<?php

namespace Tests\Unit;

use App\Support\PageContentFormatter;
use PHPUnit\Framework\TestCase;

class PageContentFormatterTest extends TestCase
{
    public function test_it_formats_plain_text_into_article_markup(): void
    {
        $html = PageContentFormatter::format(<<<'TEXT'
Introduction: The Beauty and Significance of Kikuyu Ruracio Attire

Kikuyu ruracio attire is one of the most vibrant cultural expressions in Kenya.
The attire worn during this event communicates:
Respect for traditions
Unity between families
TEXT);

        $this->assertStringContainsString('<h2>Introduction: The Beauty and Significance of Kikuyu Ruracio Attire</h2>', $html);
        $this->assertStringContainsString('<p>Kikuyu ruracio attire is one of the most vibrant cultural expressions in Kenya.</p>', $html);
        $this->assertStringContainsString('<ul><li>Respect for traditions</li><li>Unity between families</li></ul>', $html);
    }

    public function test_it_keeps_existing_html_content_intact(): void
    {
        $content = '<h2>Styled title</h2><p><strong>Formatted</strong> copy.</p>';

        $this->assertSame($content, PageContentFormatter::format($content));
    }
}
