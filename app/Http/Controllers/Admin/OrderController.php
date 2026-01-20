<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $ordersQuery = Order::query()->latest();

        if ($request->filled('status')) {
            $ordersQuery->where('status', $request->string('status')->toString());
        }

        $orders = $ordersQuery->paginate(20)->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'status' => $request->string('status')->toString(),
        ]);
    }

    public function show(Order $order)
    {
        $order->load('items');

        return view('admin.orders.show', [
            'order' => $order,
        ]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,processing,completed,cancelled'],
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        return back()->with('status', 'Order status updated.');
    }
}
