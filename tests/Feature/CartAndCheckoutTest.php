<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartAndCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_add_and_view(): void
    {
        $category = Category::create([
            'name' => 'Hair Accessories',
            'slug' => 'hair-accessories',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Pearl Vine Hair Piece',
            'slug' => 'pearl-vine-hair-piece',
            'price' => 2500,
            'stock' => 5,
            'is_active' => true,
        ]);

        $this->post(route('cart.add', $product), ['quantity' => 2])->assertRedirect();

        $this->get(route('cart.index'))
            ->assertOk()
            ->assertSee($product->name)
            ->assertSee('KES 5,000');
    }

    public function test_checkout_creates_order_and_items(): void
    {
        $category = Category::create([
            'name' => 'Veils',
            'slug' => 'veils',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Soft Tulle Veil',
            'slug' => 'soft-tulle-veil',
            'price' => 3500,
            'stock' => 10,
            'is_active' => true,
        ]);

        $this->post(route('cart.add', $product), ['quantity' => 1])->assertRedirect();

        $response = $this->post(route('checkout.store'), [
            'customer_name' => 'Jane Doe',
            'customer_phone' => '+254700000000',
            'customer_email' => 'jane@example.com',
            'delivery_address' => 'Nairobi',
            'notes' => 'Call before delivery.',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseCount((new Order())->getTable(), 1);
        $this->assertDatabaseCount((new OrderItem())->getTable(), 1);

        $order = Order::query()->firstOrFail();
        $this->assertSame(3500, $order->total);

        $item = $order->items()->firstOrFail();
        $this->assertSame($product->id, $item->product_id);
        $this->assertSame(3500, $item->line_total);
    }
}

