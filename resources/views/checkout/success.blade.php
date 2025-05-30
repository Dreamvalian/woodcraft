<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-center">
                        <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <h2 class="mt-4 text-2xl font-semibold text-gray-900">Order Placed Successfully!</h2>
                        <p class="mt-2 text-gray-600">Thank you for your purchase. Your order has been received.</p>
                        <p class="mt-1 text-gray-600">Order Number: {{ $order->order_number }}</p>
                    </div>

                    <div class="mt-8 border-t pt-8">
                        <h3 class="text-lg font-medium text-gray-900">Order Details</h3>
                        <div class="mt-4 space-y-6">
                            <!-- Order Items -->
                            <div class="border rounded-lg overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($order->items as $item)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}">
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->quantity }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->formatted_price }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->formatted_total }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Order Summary -->
                            <div class="border rounded-lg p-4">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h4>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Subtotal</span>
                                        <span class="text-gray-900">{{ $order->formatted_subtotal }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Shipping</span>
                                        <span class="text-gray-900">{{ $order->formatted_shipping_cost }}</span>
                                    </div>
                                    <div class="flex justify-between font-medium text-lg pt-2 border-t">
                                        <span>Total</span>
                                        <span>{{ $order->formatted_total }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Shipping Information -->
                            <div class="border rounded-lg p-4">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Shipping Information</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <h5 class="text-sm font-medium text-gray-500">Shipping Address</h5>
                                        <div class="mt-2 text-sm text-gray-900">
                                            <p>{{ $order->shippingAddress->full_name }}</p>
                                            <p>{{ $order->shippingAddress->address_line1 }}</p>
                                            @if($order->shippingAddress->address_line2)
                                                <p>{{ $order->shippingAddress->address_line2 }}</p>
                                            @endif
                                            <p>{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }} {{ $order->shippingAddress->postal_code }}</p>
                                            <p>{{ $order->shippingAddress->country }}</p>
                                            <p>{{ $order->shippingAddress->phone }}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="text-sm font-medium text-gray-500">Shipping Method</h5>
                                        <p class="mt-2 text-sm text-gray-900">{{ ucfirst($order->shipping_method) }} Shipping</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Information -->
                            <div class="border rounded-lg p-4">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Payment Information</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <h5 class="text-sm font-medium text-gray-500">Payment Method</h5>
                                        <p class="mt-2 text-sm text-gray-900">{{ ucfirst($order->payment_method) }}</p>
                                    </div>
                                    <div>
                                        <h5 class="text-sm font-medium text-gray-500">Payment Status</h5>
                                        <p class="mt-2 text-sm text-gray-900">{{ ucfirst($order->payment_status) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-center space-x-4">
                        <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            View Order Details
                        </a>
                        <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 