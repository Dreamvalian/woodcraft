@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-semibold mb-8">Checkout</h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Checkout Form --}}
            <div>
                <form action="{{ route('checkout.process') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Shipping Address --}}
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold mb-4">Shipping Address</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                <input type="text" 
                                       name="shipping_address[name]" 
                                       id="name"
                                       value="{{ old('shipping_address.name') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-wood focus:ring-wood sm:text-sm"
                                       required>
                            </div>

                            <div>
                                <label for="street" class="block text-sm font-medium text-gray-700">Street Address</label>
                                <input type="text" 
                                       name="shipping_address[street]" 
                                       id="street"
                                       value="{{ old('shipping_address.street') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-wood focus:ring-wood sm:text-sm"
                                       required>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                    <input type="text" 
                                           name="shipping_address[city]" 
                                           id="city"
                                           value="{{ old('shipping_address.city') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-wood focus:ring-wood sm:text-sm"
                                           required>
                                </div>

                                <div>
                                    <label for="state" class="block text-sm font-medium text-gray-700">State</label>
                                    <input type="text" 
                                           name="shipping_address[state]" 
                                           id="state"
                                           value="{{ old('shipping_address.state') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-wood focus:ring-wood sm:text-sm"
                                           required>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="zip" class="block text-sm font-medium text-gray-700">ZIP Code</label>
                                    <input type="text" 
                                           name="shipping_address[zip]" 
                                           id="zip"
                                           value="{{ old('shipping_address.zip') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-wood focus:ring-wood sm:text-sm"
                                           required>
                                </div>

                                <div>
                                    <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                                    <input type="text" 
                                           name="shipping_address[country]" 
                                           id="country"
                                           value="{{ old('shipping_address.country', 'United States') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-wood focus:ring-wood sm:text-sm"
                                           required>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Method --}}
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold mb-4">Payment Method</h2>
                        
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="radio" 
                                       name="payment_method" 
                                       id="credit_card"
                                       value="credit_card"
                                       {{ old('payment_method') === 'credit_card' ? 'checked' : '' }}
                                       class="h-4 w-4 text-wood focus:ring-wood border-gray-300">
                                <label for="credit_card" class="ml-3 block text-sm font-medium text-gray-700">
                                    Credit Card
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="radio" 
                                       name="payment_method" 
                                       id="paypal"
                                       value="paypal"
                                       {{ old('payment_method') === 'paypal' ? 'checked' : '' }}
                                       class="h-4 w-4 text-wood focus:ring-wood border-gray-300">
                                <label for="paypal" class="ml-3 block text-sm font-medium text-gray-700">
                                    PayPal
                                </label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" 
                            class="w-full bg-wood text-white px-6 py-3 rounded-md hover:bg-wood-dark transition">
                        Place Order
                    </button>
                </form>
            </div>

            {{-- Order Summary --}}
            <div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold mb-4">Order Summary</h2>

                    <div class="space-y-4">
                        @foreach($cart as $item)
                            <div class="flex items-center space-x-4">
                                <img src="{{ $item->product->images->first()->url }}" 
                                     alt="{{ $item->product->name }}"
                                     class="w-16 h-16 object-cover rounded">
                                <div class="flex-1">
                                    <h3 class="text-sm font-medium">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-500">Quantity: {{ $item->quantity }}</p>
                                </div>
                                <div class="text-sm font-medium">
                                    ${{ number_format($item->quantity * $item->product->price, 2) }}
                                </div>
                            </div>
                        @endforeach

                        <div class="border-t pt-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span>Subtotal</span>
                                <span>${{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Shipping</span>
                                <span>${{ number_format($shipping, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Tax</span>
                                <span>${{ number_format($tax, 2) }}</span>
                            </div>
                            <div class="flex justify-between font-medium">
                                <span>Total</span>
                                <span>${{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 