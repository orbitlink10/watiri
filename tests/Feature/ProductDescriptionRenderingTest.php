<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductDescriptionRenderingTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_page_renders_structured_description_markup(): void
    {
        $category = Category::create([
            'name' => 'Forehead accessories',
            'slug' => 'forehead-accessories',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Cowrie Shells',
            'slug' => 'cowrie-shells',
            'description' => <<<'TEXT'
Product Overview

Cowrie shells are small, smooth, and naturally glossy shells used in adornment and styling.

Key Features

- Authentic natural shells
- Lightweight and durable

Common Uses

1. Hair accessories
2. Jewellery making
TEXT,
            'price' => 2000,
            'stock' => 4,
            'is_active' => true,
        ]);

        $response = $this->get(route('products.show', $product));

        $response->assertOk();
        $response->assertSee('product-description', false);
        $response->assertSee('<h2>Product Overview</h2>', false);
        $response->assertSee('<h2>Key Features</h2>', false);
        $response->assertSee('<ul><li>Authentic natural shells</li><li>Lightweight and durable</li></ul>', false);
        $response->assertSee('<ol><li>Hair accessories</li><li>Jewellery making</li></ol>', false);
    }
}
