@extends('layouts.app')

@section('title', $product->name . ' — Watiri Designs')

@section('content')
    <div class="grid gap-8 lg:grid-cols-2 lg:items-start">
        <div class="rounded-2xl bg-white p-6 watiri-ring">
            @if ($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-[420px] w-full rounded-xl object-cover watiri-ring" />
            @else
                <div class="h-[420px] rounded-xl bg-gradient-to-br from-brand-50 via-white to-champagne-100 watiri-ring"></div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl bg-white p-6 watiri-ring">
                <div class="flex flex-wrap items-center gap-2">
                    <a class="text-sm text-zinc-600 hover:text-zinc-900" href="{{ route('shop.index') }}">Shop</a>
                    <span class="text-zinc-400">/</span>
                    <a class="text-sm text-zinc-600 hover:text-zinc-900" href="{{ route('shop.index', ['category' => $product->category?->slug]) }}">
                        {{ $product->category?->name ?? 'Category' }}
                    </a>
                </div>

                <h1 class="mt-3 text-3xl font-semibold tracking-tight text-zinc-900 font-serif">
                    {{ $product->name }}
                </h1>
                <div class="mt-2 text-lg text-zinc-900">
                    KES {{ number_format($product->price) }}
                </div>

                @if ($product->description)
                    <p class="mt-4 text-sm leading-relaxed text-zinc-700">
                        {{ $product->description }}
                    </p>
                @endif

                <div class="mt-6 flex flex-wrap items-center gap-3">
                    <form method="post" action="{{ route('cart.add', $product) }}" class="flex items-center gap-3">
                        @csrf
                        <input
                            type="number"
                            name="quantity"
                            min="1"
                            max="99"
                            value="1"
                            class="w-24 rounded-md bg-white px-3 py-2 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40"
                        />
                        <button class="rounded-md bg-zinc-900 px-5 py-2 text-sm font-medium text-white hover:bg-zinc-800">
                            Add to cart
                        </button>
                    </form>
                    <a href="{{ route('cart.index') }}" class="rounded-md bg-white px-5 py-2 text-sm font-medium text-zinc-900 watiri-ring hover:bg-zinc-50">
                        View cart
                    </a>
                </div>
            </div>

            <div class="rounded-2xl bg-white p-6 watiri-ring">
                <div class="text-sm font-semibold text-zinc-900">Delivery</div>
                <ul class="mt-3 list-disc space-y-2 pl-5 text-sm text-zinc-700">
                    <li>Nairobi pickup available.</li>
                    <li>Nationwide delivery via courier.</li>
                    <li>7-day returns on unused items.</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

