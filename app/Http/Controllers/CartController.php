<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $productIds = array_keys($cart);

        $products = Product::query()
            ->whereIn('id', $productIds)
            ->where('is_active', true)
            ->get()
            ->keyBy('id');

        $items = [];
        $subtotal = 0;
        $cleanCart = [];

        foreach ($cart as $productId => $quantity) {
            $product = $products->get((int) $productId);
            if (! $product) {
                continue;
            }

            $quantity = max(1, (int) $quantity);
            $cleanCart[$product->id] = $quantity;
            $lineTotal = $product->price * $quantity;
            $subtotal += $lineTotal;

            $items[] = [
                'product' => $product,
                'quantity' => $quantity,
                'line_total' => $lineTotal,
            ];
        }

        if ($cleanCart !== $cart) {
            session()->put('cart', $cleanCart);
        }

        return view('cart.index', [
            'items' => $items,
            'subtotal' => $subtotal,
        ]);
    }

    public function add(Request $request, Product $product)
    {
        if (! $product->is_active) {
            abort(404);
        }

        $validated = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1', 'max:99'],
        ]);

        $quantity = (int) ($validated['quantity'] ?? 1);

        $cart = session()->get('cart', []);
        $cart[$product->id] = min(99, ((int) ($cart[$product->id] ?? 0)) + $quantity);
        session()->put('cart', $cart);

        return back()->with('cart_updated', true);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'quantities' => ['required', 'array'],
            'quantities.*' => ['integer', 'min:0', 'max:99'],
        ]);

        $cart = session()->get('cart', []);

        foreach ($validated['quantities'] as $productId => $quantity) {
            $productId = (int) $productId;
            $quantity = (int) $quantity;

            if ($quantity <= 0) {
                unset($cart[$productId]);
                continue;
            }

            $cart[$productId] = $quantity;
        }

        session()->put('cart', $cart);

        return back()->with('cart_updated', true);
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);
        unset($cart[$product->id]);
        session()->put('cart', $cart);

        return back()->with('cart_updated', true);
    }

    public function clear()
    {
        session()->forget('cart');

        return back()->with('cart_updated', true);
    }
}
