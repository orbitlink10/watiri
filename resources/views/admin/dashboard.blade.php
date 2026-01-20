@extends('layouts.admin')

@section('title', 'Dashboard — Admin')

@section('content')
    <div class="grid gap-4 md:grid-cols-4">
        <div class="rounded-2xl bg-white p-6 watiri-ring">
            <div class="text-sm text-zinc-600">Orders</div>
            <div class="mt-2 text-2xl font-semibold text-zinc-900">{{ number_format($totalOrders) }}</div>
        </div>
        <div class="rounded-2xl bg-white p-6 watiri-ring">
            <div class="text-sm text-zinc-600">Pending</div>
            <div class="mt-2 text-2xl font-semibold text-zinc-900">{{ number_format($pendingOrders) }}</div>
        </div>
        <div class="rounded-2xl bg-white p-6 watiri-ring">
            <div class="text-sm text-zinc-600">Products</div>
            <div class="mt-2 text-2xl font-semibold text-zinc-900">{{ number_format($totalProducts) }}</div>
        </div>
        <div class="rounded-2xl bg-white p-6 watiri-ring">
            <div class="text-sm text-zinc-600">Sales (processing/completed)</div>
            <div class="mt-2 text-2xl font-semibold text-zinc-900">KES {{ number_format($totalSales) }}</div>
        </div>
    </div>

    <div class="mt-8 grid gap-4 lg:grid-cols-3">
        <div class="rounded-2xl bg-white p-6 watiri-ring lg:col-span-2">
            <div class="flex items-center justify-between">
                <div class="text-sm font-semibold text-zinc-900">Recent orders</div>
                <a class="text-sm text-zinc-600 hover:text-zinc-900" href="{{ route('admin.orders.index') }}">View all</a>
            </div>
            <div class="mt-4 divide-y divide-zinc-200/70">
                @forelse ($recentOrders as $order)
                    <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center justify-between gap-4 py-3 text-sm hover:bg-zinc-50">
                        <div class="min-w-0">
                            <div class="font-medium text-zinc-900">{{ $order->order_number }}</div>
                            <div class="text-zinc-500">{{ $order->customer_name }} • {{ $order->customer_phone }}</div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-medium text-zinc-800">{{ strtoupper($order->status) }}</span>
                            <span class="font-medium text-zinc-900">KES {{ number_format($order->total) }}</span>
                        </div>
                    </a>
                @empty
                    <div class="py-6 text-sm text-zinc-600">No orders yet.</div>
                @endforelse
            </div>
        </div>

        <div class="rounded-2xl bg-white p-6 watiri-ring">
            <div class="text-sm font-semibold text-zinc-900">Orders by status</div>
            <div class="mt-4 space-y-2 text-sm">
                @forelse ($ordersByStatus as $row)
                    <div class="flex items-center justify-between">
                        <span class="text-zinc-700">{{ strtoupper($row->status) }}</span>
                        <span class="font-medium text-zinc-900">{{ number_format($row->total) }}</span>
                    </div>
                @empty
                    <div class="text-zinc-600">No data.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

