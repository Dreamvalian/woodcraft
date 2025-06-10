@extends('layouts.app')

@section('content')
<div class="bg-[#f8f6f3] min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-[#2C3E50]">Dashboard</h2>
            
            <!-- Date Range Filter -->
            <form action="{{ route('admin.dashboard') }}" method="GET" class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <label for="start_date" class="text-sm text-[#7f8c8d]">From:</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" 
                           class="rounded-md border-gray-300 shadow-sm focus:border-[#E67E22] focus:ring focus:ring-[#E67E22] focus:ring-opacity-50">
                </div>
                <div class="flex items-center space-x-2">
                    <label for="end_date" class="text-sm text-[#7f8c8d]">To:</label>
                    <input type="date" id="end_date" name="end_date" value="{{ $endDate->format('Y-m-d') }}"
                           class="rounded-md border-gray-300 shadow-sm focus:border-[#E67E22] focus:ring focus:ring-[#E67E22] focus:ring-opacity-50">
                </div>
                <button type="submit" class="px-4 py-2 bg-[#E67E22] text-white rounded-md hover:bg-[#d35400] transition-colors">
                    Apply Filter
                </button>
                <a href="{{ route('admin.dashboard.export', ['start_date' => $startDate->format('Y-m-d'), 'end_date' => $endDate->format('Y-m-d')]) }}" 
                   class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                    Export Report
                </a>
            </form>
        </div>

        <!-- Date Range Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-[#7f8c8d]">Total Sales (Period)</p>
                        <p class="text-2xl font-semibold text-[#2C3E50]">Rp {{ number_format($dateRangeStats['total_sales'], 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-[#7f8c8d]">Total Orders (Period)</p>
                        <p class="text-2xl font-semibold text-[#2C3E50]">{{ number_format($dateRangeStats['total_orders']) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-[#7f8c8d]">Average Order Value</p>
                        <p class="text-2xl font-semibold text-[#2C3E50]">Rp {{ number_format($dateRangeStats['average_order_value'], 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Products -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-[#E67E22] bg-opacity-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#E67E22]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-[#7f8c8d]">Total Products</p>
                        <p class="text-2xl font-semibold text-[#2C3E50]">{{ $totalProducts }}</p>
                    </div>
                </div>
            </div>

            <!-- Low Stock Products -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-[#7f8c8d]">Low Stock Products</p>
                        <p class="text-2xl font-semibold text-[#2C3E50]">{{ $lowStockProducts }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Categories -->
            {{-- <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-[#7f8c8d]">Total Categories</p>
                        <p class="text-2xl font-semibold text-[#2C3E50]">{{ $totalCategories }}</p>
                    </div>
                </div>
            </div> --}}

            <!-- Total Value -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-[#7f8c8d]">Total Inventory Value</p>
                        <p class="text-2xl font-semibold text-[#2C3E50]">{{ $totalValue }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Chart -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h3 class="text-lg font-semibold text-[#2C3E50] mb-6">Sales Trend</h3>
            <canvas id="salesChart" height="100"></canvas>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Popular Products -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-[#2C3E50]">Popular Products</h3>
                </div>
                <div class="space-y-4">
                    @foreach($popularProducts as $product)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded">
                            <div class="ml-4">
                                <p class="font-medium text-[#2C3E50]">{{ $product->name }}</p>
                                <p class="text-sm text-[#7f8c8d]">{{ $product->category }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-[#E67E22] font-semibold">{{ $product->formatted_price }}</p>
                            <p class="text-sm text-[#7f8c8d]">{{ $product->order_count }} orders</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-[#2C3E50]">Recent Orders</h3>
                </div>
                <div class="space-y-4">
                    @foreach($recentOrders as $order)
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="font-medium text-[#2C3E50]">Order #{{ $order->id }}</p>
                                <p class="text-sm text-[#7f8c8d]">{{ $order->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            <span class="px-2 py-1 text-sm rounded-full {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="text-sm text-[#7f8c8d]">
                            {{ $order->items->count() }} items • Total: {{ $order->formatted_total }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Stock Value by Category -->
        {{-- <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-[#2C3E50] mb-6">Stock Value by Category</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($stockValueByCategory as $category)
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-[#2C3E50] font-medium">{{ $category->category }}</span>
                        <span class="text-[#E67E22] font-semibold">{{ number_format($category->total_value, 2) }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-[#E67E22] h-2 rounded-full" style="width: {{ ($category->total_value / $totalValue) * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div> --}}
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Sales Chart
const salesCtx = document.getElementById('salesChart').getContext('2d');
const salesData = @json($monthlySales);

new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: salesData.map(item => item.month),
        datasets: [{
            label: 'Total Sales',
            data: salesData.map(item => item.total_sales),
            borderColor: '#E67E22',
            backgroundColor: 'rgba(230, 126, 34, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString();
                    }
                }
            }
        }
    }
});

// Date range picker initialization
document.addEventListener('DOMContentLoaded', function() {
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');

    // Set max date for end date to today
    endDate.max = new Date().toISOString().split('T')[0];

    // Update end date min when start date changes
    startDate.addEventListener('change', function() {
        endDate.min = this.value;
    });

    // Update start date max when end date changes
    endDate.addEventListener('change', function() {
        startDate.max = this.value;
    });
});
</script>
@endpush
@endsection
