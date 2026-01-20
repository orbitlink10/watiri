@extends('layouts.admin')

@section('title', 'Orders — Admin')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 font-serif">Orders</h1>
            <p class="mt-1 text-sm text-zinc-600">Manage incoming orders.</p>
        </div>
    </div>

    <form class="mt-6 grid gap-3 rounded-2xl bg-white p-6 watiri-ring sm:grid-cols-3" method="get" action="{{ route('admin.orders.index') }}">
        <div class="space-y-1">
            <label class="text-sm font-medium text-zinc-900" for="status">Status</label>
            <select id="status" name="status" class="w-full rounded-md bg-white px-4 py-3 text-sm text-zinc-900 watiri-ring focus:outline-none focus:ring-2 focus:ring-brand-400/40">
                <option value="">All</option>
                <option value="pending" @selected($status === 'pending')>Pending</option>
                <option value="processing" @selected($status === 'processing')>Processing</option>
                <option value="completed" @selected($status === 'completed')>Completed</option>
                <option value="cancelled" @selected($status === 'cancelled')>Cancelled</option>
            </select>
        </div>
        <div class="flex items-end sm:col-span-2">
            <button class="w-full rounded-md bg-zinc-900 px-5 py-3 text-sm font-medium text-white hover:bg-zinc-800">Filter</button>
        </div>
    </form>

    <div class="mt-6 rounded-2xl bg-white watiri-ring">
        <div class="divide-y divide-zinc-200/70">
            @forelse ($orders as $order)
                <a href="{{ route('admin.orders.show', $order) }}" class="flex flex-col gap-3 p-5 hover:bg-zinc-50 sm:flex-row sm:items-center sm:justify-between">
                    <div class="min-w-0">
                        <div class="font-medium text-zinc-900">{{ $order->order_number }}</div>
                        <div class="text-sm text-zinc-500">{{ $order->customer_name }} • {{ $order->customer_phone }}</div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-medium text-zinc-800">{{ strtoupper($order->status) }}</span>
                        <span class="text-sm font-medium text-zinc-900">KES {{ number_format($order->total) }}</span>
                    </div>
                </a>
            @empty
                <div class="p-10 text-center text-sm text-zinc-600">No orders yet.</div>
            @endforelse
        </div>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
@endsection

