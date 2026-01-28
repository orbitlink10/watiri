<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class HomeContent extends Model
{
    protected $fillable = [
        'seo_title',
        'seo_description',
        'hero_badge',
        'hero_heading',
        'hero_heading_highlight',
        'hero_description',
        'hero_primary_label',
        'hero_primary_link',
        'hero_secondary_label',
        'hero_secondary_link',
        'delivery_points',
        'categories_title',
        'categories_subtitle',
        'bestsellers_title',
        'bestsellers_subtitle',
        'consult_title',
        'consult_body',
        'consult_primary_label',
        'consult_primary_link',
        'consult_secondary_label',
        'consult_secondary_link',
        'newsletter_title',
        'newsletter_body',
        'hero_image_path',
    ];

    protected $casts = [
        'delivery_points' => 'array',
    ];

    public static function defaults(): array
    {
        return [
            'seo_title' => 'Watiri Designs — Bridal Accessories in Kenya',
            'seo_description' => 'From statement hair pieces and timeless veils to jewellery that photographs beautifully—Watiri Designs helps you complete your bridal look with confidence.',
            'hero_badge' => 'Bridal Accessories in Kenya',
            'hero_heading' => 'Wedding day details,',
            'hero_heading_highlight' => 'perfectly finished.',
            'hero_description' => 'From statement hair pieces and timeless veils to jewellery that photographs beautifully—Watiri Designs helps you complete your bridal look with confidence.',
            'hero_primary_label' => 'Shop collections',
            'hero_primary_link' => '/shop',
            'hero_secondary_label' => 'Book a styling consult',
            'hero_secondary_link' => '#consult',
            'delivery_points' => [
                'Nairobi pickup available',
                'Nationwide delivery',
                '7-day returns',
            ],
            'categories_title' => 'Shop by category',
            'categories_subtitle' => 'Curated pieces that complement your dress, venue, and hairstyle.',
            'bestsellers_title' => 'Bestsellers',
            'bestsellers_subtitle' => 'Popular picks for brides, bridesmaids, and traditional ceremonies.',
            'consult_title' => 'Not sure what suits your dress?',
            'consult_body' => 'Send us your dress style, venue, and hair inspo—we’ll recommend accessories that match your look and budget.',
            'consult_primary_label' => 'Talk to us',
            'consult_primary_link' => '#contact',
            'consult_secondary_label' => 'WhatsApp',
            'consult_secondary_link' => 'https://wa.me/254700000000',
            'newsletter_title' => 'Get updates + new arrivals',
            'newsletter_body' => 'Join the list for restocks, styling tips, and bridal offers.',
            'hero_image_path' => null,
        ];
    }

    public static function viewData(): array
    {
        $defaults = static::defaults();
        $record = static::query()->first();
        if (! $record) {
            return $defaults;
        }

        $payload = $record->only(array_keys($defaults));

        return array_merge($defaults, $payload);
    }
}
