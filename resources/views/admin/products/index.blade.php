@extends('layouts.admin')

@section('title', 'Products — Admin')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 font-serif">Products</h1>
            <p class="mt-1 text-sm text-zinc-600">Create and manage your product catalog.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center rounded-md bg-zinc-900 px-5 py-3 text-sm font-medium text-white hover:bg-zinc-800">
            Add product
        </a>
    </div>

    <form class="mt-6 grid gap-3 rounded-2xl bg-white p-6 watiri-ring sm:grid-cols-3" method="get" action="{{ route('admin.products.index') }}">
        <div class="space-y-1">
            <label class="text-sm font-medium text-zinc-900" for="q">Search</label>
            <input id="q" name="q" value="{{ $q }}" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40" />
        </div>
        <div class="space-y-1">
            <label class="text-sm font-medium text-zinc-900" for="category_id">Category</label>
            <select id="category_id" name="category_id" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40">
                <option value="">All</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected($categoryId === $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end">
            <button class="w-full rounded-md bg-zinc-900 px-5 py-3 text-sm font-medium text-white hover:bg-zinc-800">Filter</button>
        </div>
    </form>

    <div class="mt-6 rounded-2xl bg-white watiri-ring">
        <div class="divide-y divide-zinc-200/70">
            @forelse ($products as $product)
                <div class="flex flex-col gap-3 p-5 sm:flex-row sm:items-center sm:justify-between">
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <div class="font-medium text-zinc-900">{{ $product->name }}</div>
                            @if (! $product->is_active)
                                <span class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-medium text-zinc-700">Inactive</span>
                            @endif
                        </div>
                        <div class="text-sm text-zinc-500">
                            {{ $product->category?->name ?? 'Category' }} • KES {{ number_format($product->price) }} • Stock {{ number_format($product->stock) }}
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('products.show', $product) }}" class="rounded-md bg-zinc-100 px-4 py-2 text-sm text-zinc-800 hover:bg-zinc-200">
                            View
                        </a>
                        <a href="{{ route('admin.products.edit', $product) }}" class="rounded-md bg-zinc-100 px-4 py-2 text-sm text-zinc-800 hover:bg-zinc-200">
                            Edit
                        </a>
                        <form method="post" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button class="rounded-md bg-brand-600 px-4 py-2 text-sm font-medium text-white hover:bg-brand-700">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-10 text-center text-sm text-zinc-600">No products yet.</div>
            @endforelse
        </div>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
@endsection

