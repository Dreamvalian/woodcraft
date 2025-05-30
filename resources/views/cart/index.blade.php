@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

    @if($cart->items->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <h2 class="text-xl font-semibold text-gray-700 mb-2">Your cart is empty</h2>
            <p class="text-gray-500 mb-6">Looks like you haven't added any items to your cart yet.</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                Continue Shopping
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <div class="space-y-6">
                            @foreach($cart->items as $item)
                                <div class="flex items-center space-x-4" id="cart-item-{{ $item->id }}">
                                    <!-- Product Image -->
                                    <div class="flex-shrink-0 w-24 h-24">
                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-md">
                                    </div>

                                    <!-- Product Details -->
                                    <div class="flex-1">
                                        <h3 class="text-lg font-medium text-gray-900">
                                            <a href="{{ route('products.show', $item->product) }}" class="hover:text-indigo-600">
                                                {{ $item->product->name }}
                                            </a>
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            {{ Str::limit($item->product->description, 100) }}
                                        </p>
                                        <div class="mt-2 flex items-center justify-between">
                                            <div class="flex items-center space-x-4">
                                                <!-- Quantity Selector -->
                                                <div class="flex items-center border rounded-md">
                                                    <button type="button" 
                                                            class="quantity-btn px-3 py-1 text-gray-600 hover:text-gray-700"
                                                            data-action="decrease"
                                                            data-item-id="{{ $item->id }}">
                                                        -
                                                    </button>
                                                    <input type="number" 
                                                           class="quantity-input w-12 text-center border-0 focus:ring-0"
                                                           value="{{ $item->quantity }}"
                                                           min="1"
                                                           max="{{ $item->product->stock }}"
                                                           data-item-id="{{ $item->id }}">
                                                    <button type="button"
                                                            class="quantity-btn px-3 py-1 text-gray-600 hover:text-gray-700"
                                                            data-action="increase"
                                                            data-item-id="{{ $item->id }}">
                                                        +
                                                    </button>
                                                </div>
                                                <span class="text-gray-600">×</span>
                                                <span class="text-gray-900 font-medium">${{ number_format($item->price, 2) }}</span>
                                            </div>
                                            <div class="flex items-center space-x-4">
                                                <span class="text-lg font-medium text-gray-900">${{ number_format($item->subtotal, 2) }}</span>
                                                <button type="button"
                                                        class="remove-item text-red-600 hover:text-red-800"
                                                        data-item-id="{{ $item->id }}">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="text-gray-900 font-medium">${{ number_format($summary['total'], 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Shipping</span>
                            <span class="text-gray-900 font-medium">Calculated at checkout</span>
                        </div>
                        <div class="border-t pt-4">
                            <div class="flex justify-between">
                                <span class="text-lg font-medium text-gray-900">Total</span>
                                <span class="text-lg font-medium text-gray-900">${{ number_format($summary['total'], 2) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('checkout.index') }}" class="w-full flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Proceed to Checkout
                        </a>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('products.index') }}" class="w-full flex justify-center items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quantity buttons
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            const input = document.querySelector(`.quantity-input[data-item-id="${itemId}"]`);
            const currentValue = parseInt(input.value);
            const action = this.dataset.action;
            
            if (action === 'increase') {
                input.value = currentValue + 1;
            } else {
                input.value = Math.max(1, currentValue - 1);
            }
            
            updateCartItem(itemId, input.value);
        });
    });

    // Quantity input
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const itemId = this.dataset.itemId;
            const value = parseInt(this.value);
            
            if (value < 1) {
                this.value = 1;
            }
            
            updateCartItem(itemId, this.value);
        });
    });

    // Remove item
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            removeCartItem(itemId);
        });
    });

    function updateCartItem(itemId, quantity) {
        fetch(`/cart/update/${itemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartSummary();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the cart.');
        });
    }

    function removeCartItem(itemId) {
        if (!confirm('Are you sure you want to remove this item?')) {
            return;
        }

        fetch(`/cart/remove/${itemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`cart-item-${itemId}`).remove();
                updateCartSummary();
                
                // If cart is empty, reload the page to show empty cart message
                if (data.cart.items.length === 0) {
                    window.location.reload();
                }
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while removing the item.');
        });
    }

    function updateCartSummary() {
        fetch('/cart/summary')
            .then(response => response.json())
            .then(data => {
                // Update the summary section with new totals
                document.querySelector('.text-gray-900.font-medium').textContent = 
                    `$${parseFloat(data.total).toFixed(2)}`;
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
});
</script>
@endpush
@endsection 