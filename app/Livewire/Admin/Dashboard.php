<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    #[Computed]
    public function todayRevenue()
    {
        return Order::whereDate('created_at', today())
            ->where('payment_status', 'paid')
            ->sum('total');
    }

    #[Computed]
    public function totalOrders()
    {
        return Order::count();
    }

    #[Computed]
    public function pendingOrders()
    {
        return Order::where('status', 'pending')->count();
    }

    #[Computed]
    public function totalRevenue()
    {
        return Order::where('payment_status', 'paid')->sum('total');
    }

    #[Computed]
    public function lowStockProducts()
    {
        return Product::where('stock_quantity', '<=', 10)
            ->where('stock_quantity', '>', 0)
            ->active()
            ->count();
    }

    #[Computed]
    public function outOfStockProducts()
    {
        return Product::where('stock_quantity', '<=', 0)->active()->count();
    }

    #[Computed]
    public function recentOrders()
    {
        return Order::with('items')->latest()->limit(8)->get();
    }

    #[Computed]
    public function topProducts()
    {
        return Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->limit(5)
            ->get();
    }

    #[Computed]
    public function totalProducts()
    {
        return Product::active()->count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard')
            ->layout('layouts.admin', ['title' => 'Dashboard']);
    }
}
