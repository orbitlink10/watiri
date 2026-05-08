<?php

namespace Tests\Feature;

use App\Models\HomeContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeWhatsAppLinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_normalizes_a_legacy_raw_whatsapp_number_before_rendering(): void
    {
        HomeContent::create([
            'consult_secondary_label' => 'WhatsApp',
            'consult_secondary_link' => '0707 396 751',
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('href="https://wa.me/254707396751"', false);
    }

    public function test_admin_homepage_update_normalizes_raw_whatsapp_numbers(): void
    {
        $payload = HomeContent::defaults();
        $payload['consult_secondary_link'] = '0707 396 751';

        $this
            ->withSession(['admin_logged_in' => true])
            ->put(route('admin.homepage.update'), $payload)
            ->assertRedirect(route('admin.homepage.edit'));

        $this->assertSame(
            'https://wa.me/254707396751',
            HomeContent::query()->firstOrFail()->consult_secondary_link,
        );
    }
}
