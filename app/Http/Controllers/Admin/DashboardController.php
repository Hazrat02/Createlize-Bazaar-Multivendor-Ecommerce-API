<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $stats = [
            'orders_total' => Order::count(),
            'orders_created' => Order::where('order_status', 'created')->count(),
            'orders_processing' => Order::where('order_status', 'processing')->count(),
            'orders_delivered' => Order::where('order_status', 'delivered')->count(),
            'orders_canceled' => Order::where('order_status', 'canceled')->count(),
            'revenue_total' => (float) Order::where('payment_status', 'paid')->sum('total'),
            'products_total' => Product::count(),
            'categories_total' => Category::count(),
            'vendors_total' => User::role('Vendor')->count(),
            'customers_total' => User::role('Customer')->count(),
        ];

        $recentOrders = Order::with(['customer', 'vendor'])
            ->latest()
            ->take(8)
            ->get([
                'id',
                'order_number',
                'customer_id',
                'vendor_id',
                'total',
                'currency',
                'payment_status',
                'order_status',
                'created_at',
            ]);

        $from = Carbon::now()->subDays(6)->startOfDay();
        $to = Carbon::now()->endOfDay();
        $dailyOrders = Order::query()
            ->selectRaw('DATE(created_at) as day, COUNT(*) as count')
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('day')
            ->pluck('count', 'day');

        $trafficLabels = [];
        $trafficValues = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i)->format('Y-m-d');
            $trafficLabels[] = Carbon::now()->subDays($i)->format('D');
            $trafficValues[] = (int) ($dailyOrders[$day] ?? 0);
        }

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'traffic' => [
                'labels' => $trafficLabels,
                'values' => $trafficValues,
            ],
        ]);
    }
}
