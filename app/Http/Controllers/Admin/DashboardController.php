<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get date range from request or default to last 6 months
        $startDate = $request->input('start_date', Carbon::now()->subMonths(6)->startOfMonth());
        $endDate = $request->input('end_date', Carbon::now()->endOfDay());

        // Convert string dates to Carbon instances if needed
        if (is_string($startDate)) {
            $startDate = Carbon::parse($startDate);
        }
        if (is_string($endDate)) {
            $endDate = Carbon::parse($endDate);
        }

        // Total Products
        $totalProducts = Product::count();

        // Low Stock Products (less than 10 items)
        $lowStockProducts = Product::where('stock', '<', 10)->count();

        // Total Categories
        $totalCategories = Product::distinct('category')->count();

        // Total Inventory Value
        $totalValue = Product::sum(DB::raw('price * stock'));

        // Recent Products
        $recentProducts = Product::latest()->take(5)->get();

        // Category Distribution
        $categoryDistribution = Product::select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();

        // Sales Statistics with date filter
        $monthlySales = Order::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total_amount) as total_sales')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Popular Products (based on order items) with date filter
        $popularProducts = Product::select('products.*', DB::raw('COUNT(order_items.id) as order_count'))
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->groupBy('products.id')
            ->orderBy('order_count', 'desc')
            ->take(5)
            ->get();

        // Stock Value by Category
        $stockValueByCategory = Product::select('category', DB::raw('SUM(price * stock) as total_value'))
            ->groupBy('category')
            ->orderBy('total_value', 'desc')
            ->get();

        // Recent Orders with date filter
        $recentOrders = Order::with(['items.product'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->take(5)
            ->get();

        // Additional statistics for the date range
        $dateRangeStats = [
            'total_sales' => Order::whereBetween('created_at', [$startDate, $endDate])->sum('total_amount'),
            'total_orders' => Order::whereBetween('created_at', [$startDate, $endDate])->count(),
            'average_order_value' => Order::whereBetween('created_at', [$startDate, $endDate])->avg('total_amount'),
        ];

        return view('admin.dashboard', compact(
            'totalProducts',
            'lowStockProducts',
            'totalCategories',
            'totalValue',
            'recentProducts',
            'categoryDistribution',
            'monthlySales',
            'popularProducts',
            'stockValueByCategory',
            'recentOrders',
            'dateRangeStats',
            'startDate',
            'endDate'
        ));
    }

    public function export(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subMonths(6)->startOfMonth());
        $endDate = $request->input('end_date', Carbon::now()->endOfDay());

        // Convert string dates to Carbon instances if needed
        if (is_string($startDate)) {
            $startDate = Carbon::parse($startDate);
        }
        if (is_string($endDate)) {
            $endDate = Carbon::parse($endDate);
        }

        // Get sales data
        $salesData = Order::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total_amount) as total_sales')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Get product performance data
        $productPerformance = Product::select(
                'products.name',
                'products.category',
                DB::raw('COUNT(order_items.id) as total_orders'),
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue')
            )
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->groupBy('products.id', 'products.name', 'products.category')
            ->orderBy('total_revenue', 'desc')
            ->get();

        // Create CSV content
        $csv = "Date,Total Orders,Total Sales\n";
        foreach ($salesData as $sale) {
            $csv .= "{$sale->date},{$sale->total_orders},{$sale->total_sales}\n";
        }

        $csv .= "\nProduct Performance\n";
        $csv .= "Product Name,Category,Total Orders,Total Quantity,Total Revenue\n";
        foreach ($productPerformance as $product) {
            $csv .= "{$product->name},{$product->category},{$product->total_orders},{$product->total_quantity},{$product->total_revenue}\n";
        }

        // Generate filename
        $filename = "sales_report_{$startDate->format('Y-m-d')}_to_{$endDate->format('Y-m-d')}.csv";

        // Return CSV file
        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }
} 