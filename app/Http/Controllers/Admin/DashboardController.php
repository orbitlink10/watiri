<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $totalOrders = Order::query()->count();
        $pendingOrders = Order::query()->where('status', 'pending')->count();
        $totalProducts = Product::query()->count();

        $totalSales = (int) Order::query()
            ->whereIn('status', ['processing', 'completed'])
            ->sum('total');

        $recentOrders = Order::query()
            ->latest()
            ->take(8)
            ->get();

        $ordersByStatus = Order::query()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->orderByDesc('total')
            ->get();

        return view('admin.dashboard', [
            'totalOrders' => $totalOrders,
            'pendingOrders' => $pendingOrders,
            'totalProducts' => $totalProducts,
            'totalSales' => $totalSales,
            'recentOrders' => $recentOrders,
            'ordersByStatus' => $ordersByStatus,
        ]);
    }
}

