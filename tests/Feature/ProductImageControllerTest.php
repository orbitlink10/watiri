<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductImageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_image_route_serves_uploaded_file(): void
    {
        Storage::fake('public');

        $category = Category::create([
            'name' => 'Cover Ups',
            'slug' => 'cover-ups',
        ]);

        $imagePath = 'products/shawl.png';

        Storage::disk('public')->put($imagePath, base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO7Z0X8AAAAASUVORK5CYII='
        ));

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Champagne Bridal Shawl',
            'slug' => 'champagne-bridal-shawl',
            'description' => 'Elegant cover up for cool evenings and ceremonies.',
            'price' => 2800,
            'stock' => 3,
            'image_url' => $imagePath,
            'is_active' => true,
        ]);

        $response = $this->get(route('products.image', $product));

        $response->assertOk();
        $response->assertHeader('content-type', 'image/png');
    }
}
