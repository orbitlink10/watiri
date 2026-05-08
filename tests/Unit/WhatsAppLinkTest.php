<?php

namespace Tests\Unit;

use App\Support\WhatsAppLink;
use PHPUnit\Framework\TestCase;

class WhatsAppLinkTest extends TestCase
{
    public function test_it_normalizes_raw_kenyan_phone_numbers_into_wa_me_links(): void
    {
        $this->assertSame(
            'https://wa.me/254707396751',
            WhatsAppLink::maybeNormalize('0707 396 751'),
        );
    }

    public function test_it_normalizes_whatsapp_urls_that_use_local_phone_format(): void
    {
        $this->assertSame(
            'https://wa.me/254707396751',
            WhatsAppLink::maybeNormalize('https://wa.me/0707-396-751'),
        );
    }

    public function test_it_leaves_non_whatsapp_links_untouched(): void
    {
        $this->assertSame(
            '/contact',
            WhatsAppLink::maybeNormalize('/contact'),
        );
    }
}
