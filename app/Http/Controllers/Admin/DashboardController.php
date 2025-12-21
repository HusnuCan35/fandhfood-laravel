<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Today's stats
        $todayOrders = Order::whereDate('created_at', today())->count();
        $todayRevenue = Order::whereDate('created_at', today())->sum('order_total');

        // This week stats
        $weekOrders = Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $weekRevenue = Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('order_total');

        // This month stats
        $monthOrders = Order::whereMonth('created_at', now()->month)->count();
        $monthRevenue = Order::whereMonth('created_at', now()->month)->sum('order_total');

        // Totals
        $totalProducts = Product::count();
        $totalUsers = User::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('order_total');

        // Recent orders
        $recentOrders = Order::with(['user', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Daily revenue for last 7 days (for chart)
        $dailyRevenue = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(order_total) as total'),
            DB::raw('COUNT(*) as count')
        )
            ->whereBetween('created_at', [now()->subDays(7), now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Order status distribution
        $ordersByStatus = Order::select('order_status', DB::raw('count(*) as count'))
            ->groupBy('order_status')
            ->get()
            ->pluck('count', 'order_status');

        return view('admin.dashboard', compact(
            'todayOrders',
            'todayRevenue',
            'weekOrders',
            'weekRevenue',
            'monthOrders',
            'monthRevenue',
            'totalProducts',
            'totalUsers',
            'totalOrders',
            'totalRevenue',
            'recentOrders',
            'dailyRevenue',
            'ordersByStatus'
        ));
    }
}
