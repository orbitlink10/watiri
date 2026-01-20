<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()->orderBy('name')->get();

        $productsQuery = Product::query()
            ->with('category')
            ->orderByDesc('id');

        if ($request->filled('category_id')) {
            $productsQuery->where('category_id', $request->integer('category_id'));
        }

        if ($request->filled('q')) {
            $q = $request->string('q')->toString();
            $productsQuery->where('name', 'like', "%{$q}%");
        }

        $products = $productsQuery->paginate(20)->withQueryString();

        return view('admin.products.index', [
            'products' => $products,
            'categories' => $categories,
            'categoryId' => (int) $request->integer('category_id'),
            'q' => $request->string('q')->toString(),
        ]);
    }

    public function create()
    {
        $categories = Category::query()->orderBy('name')->get();

        return view('admin.products.create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'price' => ['required', 'integer', 'min:0', 'max:2000000'],
            'stock' => ['required', 'integer', 'min:0', 'max:100000'],
            'image_url' => ['nullable', 'url', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $slug = $this->uniqueSlug(Product::class, $validated['name']);

        Product::create([
            'category_id' => (int) $validated['category_id'],
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'price' => (int) $validated['price'],
            'stock' => (int) $validated['stock'],
            'image_url' => $validated['image_url'] ?? null,
            'is_active' => (bool) ($validated['is_active'] ?? true),
        ]);

        Cache::forget('home.featured_products');

        return redirect()->route('admin.products.index')->with('status', 'Product created.');
    }

    public function edit(Product $product)
    {
        $categories = Category::query()->orderBy('name')->get();

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'price' => ['required', 'integer', 'min:0', 'max:2000000'],
            'stock' => ['required', 'integer', 'min:0', 'max:100000'],
            'image_url' => ['nullable', 'url', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $slug = $this->uniqueSlug(Product::class, $validated['name'], $product->id);

        $product->update([
            'category_id' => (int) $validated['category_id'],
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'price' => (int) $validated['price'],
            'stock' => (int) $validated['stock'],
            'image_url' => $validated['image_url'] ?? null,
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        Cache::forget('home.featured_products');

        return redirect()->route('admin.products.index')->with('status', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        Cache::forget('home.featured_products');

        return redirect()->route('admin.products.index')->with('status', 'Product deleted.');
    }

    private function uniqueSlug(string $modelClass, string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $counter = 2;

        while ($modelClass::query()
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()
        ) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
