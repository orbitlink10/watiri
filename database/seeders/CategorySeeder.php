<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Hair Accessories',
                'slug' => 'hair-accessories',
                'description' => 'Combs, pins, headbands and crowns.',
            ],
            [
                'name' => 'Veils',
                'slug' => 'veils',
                'description' => 'Simple tulle, pearl and lace veils.',
            ],
            [
                'name' => 'Bridal Jewellery',
                'slug' => 'bridal-jewellery',
                'description' => 'Earrings, necklaces and matching sets.',
            ],
            [
                'name' => 'Garters',
                'slug' => 'garters',
                'description' => 'Classic satin and lace garters.',
            ],
            [
                'name' => 'Cover Ups',
                'slug' => 'cover-ups',
                'description' => 'Shawls, capes and sleeves.',
            ],
            [
                'name' => 'Gifts',
                'slug' => 'gifts',
                'description' => 'Bridal party gifts and keepsakes.',
            ],
        ];

        foreach ($categories as $category) {
            Category::query()->firstOrCreate(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                ]
            );
        }
    }
}

