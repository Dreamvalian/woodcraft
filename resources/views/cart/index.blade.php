@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="max-w-3xl mx-auto">
                <h1 class="text-2xl font-light text-gray-900 mb-8">Shopping Cart</h1>

                @if(session('success'))
                    <div class="mb-6 bg-white border border-green-100 rounded-lg p-4">
                        <div class="flex items-center text-green-600">
                            <i class="fas fa-check-circle mr-2"></i>
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-white border border-red-100 rounded-lg p-4">
                        <div class="flex items-center text-red-600">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @if($cart->items->count() > 0)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <!-- Cart Items -->
                        <div class="divide-y divide-gray-100">
                            @foreach($cart->items as $item)
                                <div class="p-6">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-20 h-20">
                                            <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}"
                                                class="w-full h-full object-cover rounded-md">
                                        </div>

                                        <div class="ml-6 flex-1">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h3 class="text-sm font-medium text-gray-900">
                                                        <a href="{{ route('shops.show', $item->product->slug) }}"
                                                            class="hover:text-gray-600">
                                                            {{ $item->product->name }}
                                                        </a>
                                                    </h3>
                                                    <p class="mt-1 text-sm text-gray-500">
                                                        ${{ number_format($item->price, 2) }}
                                                    </p>
                                                </div>

                                                <div class="flex items-center space-x-4">
                                                    <form action="{{ route('cart.update', $item->id) }}" method="POST"
                                                        class="flex items-center">
                                                        @csrf
                                                        <div class="flex items-center border border-gray-200 rounded-md">
                                                            <button type="button" onclick="decrementQuantity(this)"
                                                                class="px-3 py-1 text-gray-400 hover:text-gray-600">
                                                                <i class="fas fa-minus text-xs"></i>
                                                            </button>
                                                            <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                                min="1" max="{{ $item->product->stock }}"
                                                                class="w-12 text-center border-0 focus:ring-0 text-sm"
                                                                onchange="this.form.submit()">
                                                            <button type="button" onclick="incrementQuantity(this)"
                                                                class="px-3 py-1 text-gray-400 hover:text-gray-600">
                                                                <i class="fas fa-plus text-xs"></i>
                                                            </button>
                                                        </div>
                                                    </form>

                                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="text-gray-400 hover:text-red-500">
                                                            <i class="fas fa-trash-alt text-sm"></i>
                                                        </button>
                                                    </form>

                                                    <p class="text-sm font-medium text-gray-900">
                                                        ${{ number_format($item->subtotal, 2) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Order Summary -->
                        <div class="border-t border-gray-100 bg-gray-50 p-6">
                            <div class="space-y-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="text-gray-900">${{ number_format($cart->subtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="text-gray-900">Calculated at checkout</span>
                                </div>
                                <div class="border-t border-gray-200 pt-4">
                                    <div class="flex justify-between">
                                        <span class="text-base font-medium text-gray-900">Total</span>
                                        <span
                                            class="text-base font-medium text-gray-900">${{ number_format($cart->subtotal, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 space-y-4">
                                <a href="{{ route('checkout.index') }}"
                                    class="block w-full bg-gray-900 text-white text-center px-6 py-3 rounded-md hover:bg-gray-800 transition text-sm font-medium">
                                    Proceed to Checkout
                                </a>

                                <div class="flex justify-between items-center">
                                    <form action="{{ route('cart.clear') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">
                                            Clear Cart
                                        </button>
                                    </form>
                                    <a href="{{ route('shops.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
                                        Continue Shopping
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-16 bg-white rounded-lg shadow-sm">
                        <div class="w-16 h-16 mx-auto mb-4 text-gray-300">
                            <i class="fas fa-shopping-cart text-4xl"></i>
                        </div>
                        <h2 class="text-lg font-medium text-gray-900 mb-2">Your cart is empty</h2>
                        <p class="text-sm text-gray-500 mb-6">Looks like you haven't added any items to your cart yet.</p>
                        <a href="{{ route('shops.index') }}"
                            class="inline-block bg-gray-900 text-white px-6 py-3 rounded-md hover:bg-gray-800 transition text-sm font-medium">
                            Start Shopping
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function incrementQuantity(button) {
                const input = button.parentElement.querySelector('input');
                const max = parseInt(input.getAttribute('max'));
                const currentValue = parseInt(input.value);

                if (currentValue < max) {
                    input.value = currentValue + 1;
                    input.form.submit();
                }
            }

            function decrementQuantity(button) {
                const input = button.parentElement.querySelector('input');
                const min = parseInt(input.getAttribute('min'));
                const currentValue = parseInt(input.value);

                if (currentValue > min) {
                    input.value = currentValue - 1;
                    input.form.submit();
                }
            }
        </script>
    @endpush
@endsection