<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HomeFeaturedProductsTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_bestseller_cards_render_uploaded_product_images(): void
    {
        Storage::fake('public');
        Cache::flush();

        $category = Category::create([
            'name' => 'Cover Ups',
            'slug' => 'cover-ups',
        ]);

        $imagePath = 'products/champagne-bridal-shawl.png';

        Storage::disk('public')->put($imagePath, base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO7Z0X8AAAAASUVORK5CYII='
        ));

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Champagne Bridal Shawl',
            'slug' => 'champagne-bridal-shawl',
            'description' => 'Elegant cover up for cool evenings and ceremonies.',
            'price' => 2800,
            'stock' => 5,
            'image_url' => $imagePath,
            'is_active' => true,
        ]);

        $expectedImageSrc = route('products.image', [
            'product' => $product,
            'v' => Storage::disk('public')->lastModified($imagePath),
        ], false);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee($expectedImageSrc)
            ->assertSee('Champagne Bridal Shawl');
    }
}
