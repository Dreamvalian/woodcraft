@extends('layouts.app')

@section('title', 'My Profile - WoodCraft')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Profile Header -->
    <div class="bg-[#2C3E50] text-white py-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center gap-6">
                <div class="w-24 h-24 rounded-full bg-white/10 flex items-center justify-center">
                    <i class="fas fa-user text-4xl text-white/80"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-light mb-2">{{ auth()->user()->name }}</h1>
                    <p class="text-white/80">Member since {{ auth()->user()->created_at->format('F Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Profile Info -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Profile Card -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-medium text-[#2C3E50] mb-4">Profile Information</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-light text-gray-600 mb-1">Full Name</label>
                            <p class="text-[#2C3E50]">{{ auth()->user()->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-light text-gray-600 mb-1">Email Address</label>
                            <p class="text-[#2C3E50]">{{ auth()->user()->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-light text-gray-600 mb-1">Phone Number</label>
                            <p class="text-[#2C3E50]">{{ auth()->user()->phone ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-light text-gray-600 mb-1">Address</label>
                            <p class="text-[#2C3E50]">{{ auth()->user()->address ?? 'Not provided' }}</p>
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="/profile/edit" class="inline-flex items-center gap-2 px-4 py-2 bg-[#2C3E50] text-white rounded-lg hover:bg-[#E67E22] transition duration-300">
                            <i class="fas fa-edit"></i>
                            <span>Edit Profile</span>
                        </a>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-medium text-[#2C3E50] mb-4">Quick Stats</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-light text-[#E67E22] mb-1">0</div>
                            <div class="text-sm text-gray-600">Total Orders</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="text-2xl font-light text-[#E67E22] mb-1">0</div>
                            <div class="text-sm text-gray-600">Wishlist Items</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Orders -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium text-[#2C3E50]">Recent Orders</h3>
                        <a href="/orders" class="text-sm text-[#E67E22] hover:text-[#2C3E50] transition duration-300">View All</a>
                    </div>

                    @if(count($orders ?? []) > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b">
                                        <th class="text-left py-3 px-4 text-sm font-light text-gray-600">Order ID</th>
                                        <th class="text-left py-3 px-4 text-sm font-light text-gray-600">Date</th>
                                        <th class="text-left py-3 px-4 text-sm font-light text-gray-600">Total</th>
                                        <th class="text-left py-3 px-4 text-sm font-light text-gray-600">Status</th>
                                        <th class="text-left py-3 px-4 text-sm font-light text-gray-600">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @foreach($orders ?? [] as $order)
                                        <tr>
                                            <td class="py-4 px-4 text-sm text-[#2C3E50]">#{{ $order->id }}</td>
                                            <td class="py-4 px-4 text-sm text-[#2C3E50]">{{ $order->created_at->format('M d, Y') }}</td>
                                            <td class="py-4 px-4 text-sm text-[#2C3E50]">${{ number_format($order->total, 2) }}</td>
                                            <td class="py-4 px-4">
                                                <span class="px-3 py-1 text-xs rounded-full 
                                                    @if($order->status === 'completed') bg-green-100 text-green-800
                                                    @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="py-4 px-4">
                                                <a href="/orders/{{ $order->id }}" class="text-[#E67E22] hover:text-[#2C3E50] transition duration-300 text-sm">View Details</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-shopping-bag text-2xl text-gray-400"></i>
                            </div>
                            <h4 class="text-lg font-medium text-[#2C3E50] mb-2">No Orders Yet</h4>
                            <p class="text-gray-600 mb-6">Start shopping to see your orders here</p>
                            <a href="/products" class="inline-flex items-center gap-2 px-6 py-3 bg-[#2C3E50] text-white rounded-lg hover:bg-[#E67E22] transition duration-300">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Browse Products</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection