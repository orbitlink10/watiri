@extends('layouts.admin')

@section('title', $order->order_number . ' — Admin')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 font-serif">{{ $order->order_number }}</h1>
            <p class="mt-1 text-sm text-zinc-600">Placed {{ $order->created_at->format('M j, Y g:i A') }}</p>
        </div>
        <a class="text-sm text-zinc-600 hover:text-zinc-900" href="{{ route('admin.orders.index') }}">Back to orders</a>
    </div>

    <div class="mt-6 grid gap-4 lg:grid-cols-3">
        <div class="rounded-2xl bg-white p-6 watiri-ring lg:col-span-2">
            <div class="text-sm font-semibold text-zinc-900">Items</div>
            <div class="mt-4 divide-y divide-zinc-200/70">
                @foreach ($order->items as $item)
                    <div class="flex items-center justify-between gap-4 py-3 text-sm">
                        <div class="min-w-0">
                            <div class="font-medium text-zinc-900">{{ $item->product_name }}</div>
                            <div class="text-zinc-500">Qty {{ $item->quantity }} • Unit KES {{ number_format($item->unit_price) }}</div>
                        </div>
                        <div class="font-medium text-zinc-900">KES {{ number_format($item->line_total) }}</div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 flex items-center justify-between text-sm">
                <span class="text-zinc-600">Subtotal</span>
                <span class="font-medium text-zinc-900">KES {{ number_format($order->subtotal) }}</span>
            </div>
            <div class="mt-2 flex items-center justify-between text-sm text-zinc-600">
                <span>Delivery fee</span>
                <span>KES {{ number_format($order->delivery_fee) }}</span>
            </div>
            <div class="mt-2 flex items-center justify-between text-sm">
                <span class="text-zinc-600">Total</span>
                <span class="font-semibold text-zinc-900">KES {{ number_format($order->total) }}</span>
            </div>
        </div>

        <div class="space-y-4">
            <div class="rounded-2xl bg-white p-6 watiri-ring">
                <div class="text-sm font-semibold text-zinc-900">Customer</div>
                <div class="mt-3 space-y-1 text-sm text-zinc-700">
                    <div><span class="text-zinc-500">Name:</span> {{ $order->customer_name }}</div>
                    <div><span class="text-zinc-500">Phone:</span> {{ $order->customer_phone }}</div>
                    @if ($order->customer_email)
                        <div><span class="text-zinc-500">Email:</span> {{ $order->customer_email }}</div>
                    @endif
                    @if ($order->delivery_address)
                        <div><span class="text-zinc-500">Address:</span> {{ $order->delivery_address }}</div>
                    @endif
                </div>
                @if ($order->notes)
                    <div class="mt-4 rounded-xl bg-zinc-50 p-4 text-sm text-zinc-700 watiri-ring">
                        {{ $order->notes }}
                    </div>
                @endif
            </div>

            <div class="rounded-2xl bg-white p-6 watiri-ring">
                <div class="text-sm font-semibold text-zinc-900">Status</div>
                <form class="mt-4 space-y-3" method="post" action="{{ route('admin.orders.status', $order) }}">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40">
                        <option value="pending" @selected($order->status === 'pending')>Pending</option>
                        <option value="processing" @selected($order->status === 'processing')>Processing</option>
                        <option value="completed" @selected($order->status === 'completed')>Completed</option>
                        <option value="cancelled" @selected($order->status === 'cancelled')>Cancelled</option>
                    </select>
                    @error('status') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
                    <button class="w-full rounded-md bg-zinc-900 px-5 py-3 text-sm font-medium text-white hover:bg-zinc-800">Update status</button>
                </form>
            </div>
        </div>
    </div>
@endsection

