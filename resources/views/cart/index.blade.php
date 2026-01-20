@extends('layouts.app')

@section('title', 'Cart — Watiri Designs')

@section('content')
    <div class="flex flex-col gap-8 lg:flex-row lg:items-start">
        <div class="flex-1">
            <div class="rounded-2xl bg-white p-6 watiri-ring">
                <div class="flex items-center justify-between gap-4">
                    <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 font-serif">Your cart</h1>
                    @if (count($items) > 0)
                        <form method="post" action="{{ route('cart.clear') }}">
                            @csrf
                            <button class="text-sm text-zinc-600 hover:text-zinc-900">Clear cart</button>
                        </form>
                    @endif
                </div>

                @if (count($items) === 0)
                    <div class="mt-8 rounded-xl bg-zinc-50 p-10 text-center watiri-ring">
                        <div class="text-sm font-semibold text-zinc-900">Your cart is empty</div>
                        <p class="mt-2 text-sm text-zinc-600">Browse our bridal accessories and add your favorites.</p>
                        <a href="{{ route('shop.index') }}" class="mt-5 inline-flex items-center rounded-md bg-zinc-900 px-5 py-3 text-sm font-medium text-white hover:bg-zinc-800">
                            Go to shop
                        </a>
                    </div>
                @else
                    <form id="cart-update" class="mt-6 space-y-4" method="post" action="{{ route('cart.update') }}">
                        @csrf

                        @foreach ($items as $item)
                            <div class="flex flex-col gap-4 rounded-xl bg-white p-4 watiri-ring sm:flex-row sm:items-center sm:justify-between">
                                <div class="min-w-0">
                                    <a href="{{ route('products.show', $item['product']) }}" class="text-sm font-semibold text-zinc-900 hover:underline">
                                        {{ $item['product']->name }}
                                    </a>
                                    <div class="mt-1 text-sm text-zinc-600">
                                        KES {{ number_format($item['product']->price) }}
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input
                                        type="number"
                                        min="0"
                                        max="99"
                                        name="quantities[{{ $item['product']->id }}]"
                                        value="{{ $item['quantity'] }}"
                                        class="w-24 rounded-md bg-white px-3 py-2 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40"
                                    />
                                    <div class="w-28 text-right text-sm font-medium text-zinc-900">
                                        KES {{ number_format($item['line_total']) }}
                                    </div>
                                    <button
                                        type="submit"
                                        form="remove-{{ $item['product']->id }}"
                                        class="rounded-md bg-zinc-100 px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-200 hover:text-zinc-900"
                                    >
                                        Remove
                                    </button>
                                </div>
                            </div>
                        @endforeach

                        <div class="flex justify-end">
                            <button class="rounded-md bg-zinc-900 px-5 py-3 text-sm font-medium text-white hover:bg-zinc-800">
                                Update cart
                            </button>
                        </div>
                    </form>

                    @foreach ($items as $item)
                        <form id="remove-{{ $item['product']->id }}" method="post" action="{{ route('cart.remove', $item['product']) }}">
                            @csrf
                        </form>
                    @endforeach
                @endif
            </div>
        </div>

        <aside class="w-full lg:w-80">
            <div class="rounded-2xl bg-white p-6 watiri-ring">
                <div class="text-sm font-semibold text-zinc-900">Summary</div>
                <div class="mt-4 space-y-2 text-sm text-zinc-700">
                    <div class="flex items-center justify-between">
                        <span>Subtotal</span>
                        <span class="font-medium text-zinc-900">KES {{ number_format($subtotal) }}</span>
                    </div>
                    <div class="flex items-center justify-between text-zinc-500">
                        <span>Delivery</span>
                        <span>Calculated at checkout</span>
                    </div>
                </div>
                <a
                    href="{{ route('checkout.index') }}"
                    class="{{ count($items) === 0 ? 'pointer-events-none mt-6 block rounded-md bg-zinc-200 px-5 py-3 text-center text-sm font-medium text-zinc-500' : 'mt-6 block rounded-md bg-brand-600 px-5 py-3 text-center text-sm font-medium text-white hover:bg-brand-700' }}"
                >
                    Checkout
                </a>
            </div>
        </aside>
    </div>
@endsection
