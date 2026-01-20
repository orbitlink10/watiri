<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()
            ->orderBy('name')
            ->get();

        $productsQuery = Product::query()
            ->with('category')
            ->where('is_active', true)
            ->orderByDesc('id');

        if ($request->filled('category')) {
            $productsQuery->whereHas('category', function ($query) use ($request) {
                $query->where('slug', $request->string('category')->toString());
            });
        }

        if ($request->filled('q')) {
            $q = $request->string('q')->toString();
            $productsQuery->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $products = $productsQuery->paginate(12)->withQueryString();

        return view('shop.index', [
            'categories' => $categories,
            'products' => $products,
            'activeCategory' => $request->string('category')->toString(),
            'q' => $request->string('q')->toString(),
        ]);
    }

    public function show(Product $product)
    {
        if (! $product->is_active) {
            abort(404);
        }

        $product->load('category');

        return view('shop.show', [
            'product' => $product,
        ]);
    }
}
