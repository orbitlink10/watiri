<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $bySlug = Category::query()->get()->keyBy('slug');

        $products = [
            [
                'category_slug' => 'hair-accessories',
                'name' => 'Pearl Vine Hair Piece',
                'slug' => 'pearl-vine-hair-piece',
                'price' => 2500,
                'stock' => 12,
                'description' => 'Flexible pearl vine with pins for secure styling.',
            ],
            [
                'category_slug' => 'hair-accessories',
                'name' => 'Crystal Bridal Comb',
                'slug' => 'crystal-bridal-comb',
                'price' => 1800,
                'stock' => 10,
                'description' => 'Sparkling comb for buns and half-up styles.',
            ],
            [
                'category_slug' => 'veils',
                'name' => 'Soft Tulle Veil (Fingertip)',
                'slug' => 'soft-tulle-veil-fingertip',
                'price' => 3500,
                'stock' => 8,
                'description' => 'Lightweight tulle veil with a clean finish.',
            ],
            [
                'category_slug' => 'veils',
                'name' => 'Pearl Edge Veil (Cathedral)',
                'slug' => 'pearl-edge-veil-cathedral',
                'price' => 6500,
                'stock' => 4,
                'description' => 'Cathedral length veil with pearl trim detail.',
            ],
            [
                'category_slug' => 'bridal-jewellery',
                'name' => 'Crystal Drop Earrings',
                'slug' => 'crystal-drop-earrings',
                'price' => 1800,
                'stock' => 15,
                'description' => 'Photo-ready sparkle with a comfortable fit.',
            ],
            [
                'category_slug' => 'bridal-jewellery',
                'name' => 'Pearl Necklace Set',
                'slug' => 'pearl-necklace-set',
                'price' => 4200,
                'stock' => 6,
                'description' => 'Classic pearl set for a timeless bridal look.',
            ],
            [
                'category_slug' => 'garters',
                'name' => 'Lace Bridal Garter',
                'slug' => 'lace-bridal-garter',
                'price' => 1200,
                'stock' => 20,
                'description' => 'Soft lace garter with satin bow detail.',
            ],
            [
                'category_slug' => 'cover-ups',
                'name' => 'Champagne Bridal Shawl',
                'slug' => 'champagne-bridal-shawl',
                'price' => 2800,
                'stock' => 7,
                'description' => 'Elegant cover up for cool evenings and ceremonies.',
            ],
            [
                'category_slug' => 'gifts',
                'name' => 'Bridesmaid Gift Box',
                'slug' => 'bridesmaid-gift-box',
                'price' => 3200,
                'stock' => 5,
                'description' => 'A ready-to-gift box for your bridal party.',
            ],
        ];

        foreach ($products as $product) {
            $category = $bySlug->get($product['category_slug']);
            if (! $category) {
                continue;
            }

            Product::query()->firstOrCreate(
                ['slug' => $product['slug']],
                [
                    'category_id' => $category->id,
                    'name' => $product['name'],
                    'description' => $product['description'] ?? null,
                    'price' => $product['price'],
                    'stock' => $product['stock'],
                    'is_active' => true,
                ]
            );
        }
    }
}

