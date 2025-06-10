@extends('layouts.app')

@section('content')
<div class="bg-white font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-wood-900 mb-8">Shopping Cart</h1>

        @if(count($items) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($items as $item)
                        <div class="flex items-center space-x-4 p-4 bg-white rounded-lg shadow">
                            <img src="{{ $item['shop']->image_url }}" alt="{{ $item['shop']->name }}" class="w-24 h-24 object-cover rounded">
                            <div class="flex-1">
                                <h3 class="text-lg font-medium text-wood-900">
                                    <a href="{{ route('shops.show', $item['shop']) }}" class="hover:text-wood-600">
                                        {{ $item['shop']->name }}
                                    </a>
                                </h3>
                                <p class="text-wood-600">{{ $item['shop']->formatted_price }}</p>
                            </div>
                            <div class="flex items-center space-x-4">
                                <form action="{{ route('cart.update') }}" method="POST" class="flex items-center">
                                    @csrf
                                    <input type="hidden" name="shop_id" value="{{ $item['shop']->id }}">
                                    <div class="flex items-center border border-wood-200 rounded-lg">
                                        <button 
                                            type="button"
                                            onclick="this.form.quantity.value = Math.max(1, parseInt(this.form.quantity.value) - 1)"
                                            class="px-3 py-2 text-wood-600 hover:text-wood-700"
                                        >
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input 
                                            type="number" 
                                            name="quantity"
                                            value="{{ $item['quantity'] }}"
                                            min="1"
                                            max="{{ $item['shop']->stock }}"
                                            class="w-16 text-center border-0 focus:ring-0"
                                            onchange="this.form.submit()"
                                        >
                                        <button 
                                            type="button"
                                            onclick="this.form.quantity.value = Math.min({{ $item['shop']->stock }}, parseInt(this.form.quantity.value) + 1)"
                                            class="px-3 py-2 text-wood-600 hover:text-wood-700"
                                        >
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </form>
                                <form action="{{ route('cart.remove', $item['shop']->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-medium text-wood-900">${{ number_format($item['subtotal'], 2) }}</p>
                            </div>
                        </div>
                    @endforeach

                    <div class="flex justify-between items-center pt-4">
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-wood-600 hover:text-wood-700">
                                Clear Cart
                            </button>
                        </form>
                        <a href="{{ route('shops.index') }}" class="text-wood-600 hover:text-wood-700">
                            Continue Shopping
                        </a>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-wood-50 rounded-lg p-6">
                        <h2 class="text-lg font-medium text-wood-900 mb-4">Order Summary</h2>
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-wood-600">Subtotal</span>
                                <span class="text-wood-900">${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-wood-600">Shipping</span>
                                <span class="text-wood-900">Calculated at checkout</span>
                            </div>
                            <div class="border-t border-wood-200 pt-4">
                                <div class="flex justify-between">
                                    <span class="text-lg font-medium text-wood-900">Total</span>
                                    <span class="text-lg font-medium text-wood-900">${{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <button class="w-full mt-6 bg-wood-600 text-white px-6 py-3 rounded-lg hover:bg-wood-700 transition-colors duration-200">
                            Proceed to Checkout
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <h2 class="text-2xl font-medium text-wood-900 mb-4">Your cart is empty</h2>
                <p class="text-wood-600 mb-8">Looks like you haven't added any items to your cart yet.</p>
                <a href="{{ route('shops.index') }}" class="inline-block bg-wood-600 text-white px-6 py-3 rounded-lg hover:bg-wood-700 transition-colors duration-200">
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
</div>
@endsection 