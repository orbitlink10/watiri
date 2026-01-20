@extends('layouts.app')

@section('title', 'Order placed — Watiri Designs')

@section('content')
    <div class="mx-auto max-w-2xl">
        <div class="rounded-2xl bg-white p-8 watiri-ring">
            <div class="inline-flex items-center gap-2 rounded-full bg-brand-100 px-4 py-2 text-xs font-medium text-brand-800">
                Order received
            </div>

            <h1 class="mt-4 text-3xl font-semibold tracking-tight text-zinc-900 font-serif">Thank you!</h1>
            <p class="mt-2 text-sm text-zinc-700">
                Your order number is <span class="font-semibold">{{ $order->order_number }}</span>. We’ll contact you to confirm delivery and payment.
            </p>

            <div class="mt-6 rounded-xl bg-zinc-50 p-5 watiri-ring">
                <div class="text-sm font-semibold text-zinc-900">Order summary</div>
                <div class="mt-3 divide-y divide-zinc-200/70">
                    @foreach ($order->items as $item)
                        <div class="flex items-center justify-between gap-4 py-3 text-sm">
                            <div class="min-w-0">
                                <div class="font-medium text-zinc-900">{{ $item->product_name }}</div>
                                <div class="text-zinc-500">Qty {{ $item->quantity }}</div>
                            </div>
                            <div class="font-medium text-zinc-900">KES {{ number_format($item->line_total) }}</div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 flex items-center justify-between text-sm">
                    <span class="text-zinc-600">Total</span>
                    <span class="font-semibold text-zinc-900">KES {{ number_format($order->total) }}</span>
                </div>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('shop.index') }}" class="rounded-md bg-zinc-900 px-5 py-3 text-sm font-medium text-white hover:bg-zinc-800">
                    Continue shopping
                </a>
                <a href="{{ route('home') }}" class="rounded-md bg-white px-5 py-3 text-sm font-medium text-zinc-900 watiri-ring hover:bg-zinc-50">
                    Back home
                </a>
            </div>
        </div>
    </div>
@endsection

