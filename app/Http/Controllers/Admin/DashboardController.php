<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Order, Product, User, Category};

class DashboardController extends Controller {
    public function index() {
        $stats = [
            'total_orders'    => Order::count(),
            'pending_orders'  => Order::where('status', 'pending')->count(),
            'total_revenue'   => Order::where('status', '!=', 'cancelled')->sum('total'),
            'total_products'  => Product::count(),
            'total_users'     => User::where('role', 'user')->count(),
            'low_stock'       => Product::where('stock', '<', 5)->count(),
        ];
        $recent_orders   = Order::with('user')->latest()->take(5)->get();
        $top_products    = Product::withCount('orderItems')->orderByDesc('order_items_count')->take(5)->get();
        return view('admin.dashboard', compact('stats', 'recent_orders', 'top_products'));
    }
}
