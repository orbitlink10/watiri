<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (count($cart) === 0) {
            return redirect()->route('cart.index');
        }

        return view('checkout.index');
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        if (count($cart) === 0) {
            return redirect()->route('cart.index');
        }

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'delivery_address' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $productIds = array_keys($cart);
        $products = Product::query()
            ->whereIn('id', $productIds)
            ->where('is_active', true)
            ->get()
            ->keyBy('id');

        $items = [];
        $subtotal = 0;

        foreach ($cart as $productId => $quantity) {
            $product = $products->get((int) $productId);
            if (! $product) {
                continue;
            }

            $quantity = max(1, (int) $quantity);
            $lineTotal = $product->price * $quantity;
            $subtotal += $lineTotal;

            $items[] = [
                'product' => $product,
                'quantity' => $quantity,
                'unit_price' => $product->price,
                'line_total' => $lineTotal,
            ];
        }

        if (count($items) === 0) {
            session()->forget('cart');
            return redirect()->route('cart.index');
        }

        $order = DB::transaction(function () use ($validated, $items, $subtotal) {
            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'status' => 'pending',
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_email' => $validated['customer_email'] ?? null,
                'delivery_address' => $validated['delivery_address'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'subtotal' => $subtotal,
                'delivery_fee' => 0,
                'total' => $subtotal,
                'currency' => 'KES',
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'product_name' => $item['product']->name,
                    'unit_price' => $item['unit_price'],
                    'quantity' => $item['quantity'],
                    'line_total' => $item['line_total'],
                ]);
            }

            return $order;
        });

        session()->forget('cart');

        return redirect()->route('checkout.thankyou', $order)->with('order_placed', true);
    }

    public function thankyou(Order $order)
    {
        $order->load('items');

        return view('checkout.thankyou', [
            'order' => $order,
        ]);
    }

    private function generateOrderNumber(): string
    {
        $prefix = 'WD-'.now()->format('ymd').'-';
        $attempts = 0;

        do {
            $attempts++;
            $candidate = $prefix.Str::upper(Str::random(6));
        } while ($attempts < 10 && Order::query()->where('order_number', $candidate)->exists());

        return $candidate;
    }
}

