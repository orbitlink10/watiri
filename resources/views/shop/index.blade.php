@extends('layouts.app')

@section('title', 'Shop — Watiri Designs')

@section('content')
    <div class="flex flex-col gap-8 lg:flex-row lg:items-start">
        <aside class="w-full lg:w-64">
            <div class="rounded-2xl bg-white p-6 watiri-ring">
                <div class="text-sm font-semibold text-zinc-900">Categories</div>
                <div class="mt-3 grid gap-2 text-sm">
                    <a
                        href="{{ route('shop.index') }}"
                        class="{{ $activeCategory ? 'text-zinc-700 hover:text-zinc-900' : 'font-medium text-zinc-900' }}"
                    >
                        All products
                    </a>
                    @foreach ($categories as $category)
                        <a
                            href="{{ route('shop.index', ['category' => $category->slug, 'q' => $q ?: null]) }}"
                            class="{{ $activeCategory === $category->slug ? 'font-medium text-zinc-900' : 'text-zinc-700 hover:text-zinc-900' }}"
                        >
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </aside>

        <div class="flex-1 space-y-6">
            <div class="rounded-2xl bg-white p-6 watiri-ring">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="space-y-1">
                        <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 font-serif">Shop</h1>
                        <p class="text-sm text-zinc-600">Bridal accessories curated for brides in Kenya.</p>
                    </div>

                    <form method="get" action="{{ route('shop.index') }}" class="flex w-full max-w-md gap-2">
                        @if ($activeCategory)
                            <input type="hidden" name="category" value="{{ $activeCategory }}" />
                        @endif
                        <input
                            name="q"
                            value="{{ $q }}"
                            placeholder="Search products…"
                            class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 placeholder:text-zinc-400 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40"
                        />
                        <button class="rounded-md bg-zinc-900 px-4 py-3 text-sm font-medium text-white hover:bg-zinc-800">
                            Search
                        </button>
                    </form>
                </div>
            </div>

            @if ($products->count() === 0)
                <div class="rounded-2xl bg-white p-10 text-center watiri-ring">
                    <div class="text-sm font-semibold text-zinc-900">No products found</div>
                    <p class="mt-2 text-sm text-zinc-600">Try a different category or search term.</p>
                </div>
            @endif

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($products as $product)
                    <div class="group rounded-2xl bg-white p-5 watiri-ring hover:bg-zinc-50">
                        <a href="{{ route('products.show', $product) }}" class="block">
                            <div class="flex items-center justify-between gap-3">
                                <span class="inline-flex items-center rounded-full bg-brand-100 px-3 py-1 text-xs font-medium text-brand-800">
                                    {{ $product->category?->name ?? 'Category' }}
                                </span>
                                @if ($product->stock > 0)
                                    <span class="text-xs text-zinc-500">In stock</span>
                                @else
                                    <span class="text-xs font-medium text-zinc-900">Preorder</span>
                                @endif
                            </div>

                            @if ($product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="mt-6 h-40 w-full rounded-xl object-cover watiri-ring" />
                            @else
                                <div class="mt-6 h-40 rounded-xl bg-gradient-to-br from-brand-50 via-white to-champagne-100 watiri-ring"></div>
                            @endif

                            <div class="mt-4 space-y-1">
                                <div class="text-sm font-semibold text-zinc-900 group-hover:underline">
                                    {{ $product->name }}
                                </div>
                                <div class="text-sm text-zinc-700">
                                    KES {{ number_format($product->price) }}
                                </div>
                            </div>
                        </a>

                        <form class="mt-4" method="post" action="{{ route('cart.add', $product) }}">
                            @csrf
                            <button class="w-full rounded-md bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-800">
                                Add to cart
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div>
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection

