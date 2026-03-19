<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminProductImageUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        putenv('ADMIN_USER=admin');
        putenv('ADMIN_PASSWORD=secret');
        $_ENV['ADMIN_USER'] = 'admin';
        $_ENV['ADMIN_PASSWORD'] = 'secret';
    }

    public function test_admin_can_create_product_with_uploaded_image(): void
    {
        Storage::fake('public');

        $category = Category::create([
            'name' => 'Hair Accessories',
            'slug' => 'hair-accessories',
        ]);

        $response = $this
            ->withSession(['admin_logged_in' => true])
            ->post(route('admin.products.store'), [
                'category_id' => $category->id,
                'name' => 'Pearl Vine Hair Piece',
                'description' => 'Flexible pearl vine with pins.',
                'price' => 2500,
                'stock' => 12,
                'is_active' => '1',
                'image' => UploadedFile::fake()->create('pearl-vine.jpg', 100, 'image/jpeg'),
            ]);

        $response->assertRedirect(route('admin.products.index'));

        $product = Product::query()->firstOrFail();

        $this->assertNotNull($product->getRawOriginal('image_url'));
        Storage::disk('public')->assertExists($product->getRawOriginal('image_url'));
        $this->assertStringStartsWith('/storage/', $product->image_src);
    }

    public function test_admin_can_replace_an_uploaded_product_image(): void
    {
        Storage::fake('public');

        $category = Category::create([
            'name' => 'Veils',
            'slug' => 'veils',
        ]);

        Storage::disk('public')->put('products/old-image.jpg', 'old');

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Soft Tulle Veil',
            'slug' => 'soft-tulle-veil',
            'description' => 'A soft fingertip veil.',
            'price' => 3500,
            'stock' => 8,
            'image_url' => 'products/old-image.jpg',
            'is_active' => true,
        ]);

        $response = $this
            ->withSession(['admin_logged_in' => true])
            ->put(route('admin.products.update', $product), [
                'category_id' => $category->id,
                'name' => 'Soft Tulle Veil',
                'description' => 'A soft fingertip veil.',
                'price' => 3500,
                'stock' => 8,
                'is_active' => '1',
                'image' => UploadedFile::fake()->create('new-image.jpg', 100, 'image/jpeg'),
            ]);

        $response->assertRedirect(route('admin.products.index'));

        $product->refresh();

        Storage::disk('public')->assertMissing('products/old-image.jpg');
        Storage::disk('public')->assertExists($product->getRawOriginal('image_url'));
        $this->assertNotSame('products/old-image.jpg', $product->getRawOriginal('image_url'));
    }
}
