<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FloatingWhatsAppWidgetTest extends TestCase
{
    use RefreshDatabase;

    public function test_storefront_layout_renders_the_floating_whatsapp_widget(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('WhatsApp Watiri Designs');
        $response->assertSee('aria-label="Chat with Watiri Designs on WhatsApp"', false);
        $response->assertSee(
            'href="https://wa.me/254113838291?text=Hello%20Watiri%20Designs%2C%20I%20would%20like%20to%20enquire%20about%20your%20bridal%20accessories."',
            false,
        );
    }
}
