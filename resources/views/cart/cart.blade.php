@extends('layouts.app')

@section('title', 'Shopping Cart - WoodCraft')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Cart Header -->
    <div class="bg-[#2C3E50] text-white py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-xl text-white/80"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-light mb-2">Shopping Cart</h1>
                    <p class="text-white/80">Review your items and proceed to checkout</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 py-12">
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if($cartItems->count())
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="p-6 border-b">
                            <h2 class="text-lg font-medium text-[#2C3E50]">Cart Items ({{ $cartItems->count() }})</h2>
                        </div>
                        <div class="divide-y">
                            @foreach($cartItems as $item)
                                <div class="p-6 hover:bg-gray-50 transition duration-300">
                                    <div class="flex items-center gap-6">
                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" 
                                             class="w-24 h-24 object-cover rounded-lg shadow-sm">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-medium text-[#2C3E50] mb-2">{{ $item->product->name }}</h3>
                                            <p class="text-sm text-gray-600 mb-4">{{ $item->product->formatted_price }}</p>
                                            <div class="flex items-center gap-4">
                                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="flex items-center border rounded-lg">
                                                        <button type="button" class="px-3 py-1 text-gray-600 hover:text-[#E67E22] transition" 
                                                                onclick="decrementQuantity(this)">-</button>
                                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" 
                                                               max="{{ $item->product->stock }}" 
                                                               class="w-12 text-center border-x py-1 focus:outline-none">
                                                        <button type="button" class="px-3 py-1 text-gray-600 hover:text-[#E67E22] transition"
                                                                onclick="incrementQuantity(this)">+</button>
                                                    </div>
                                                    <button type="submit" class="text-sm text-[#E67E22] hover:text-[#2C3E50] transition">
                                                        Update
                                                    </button>
                                                </form>
                                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-sm text-red-500 hover:text-red-700 transition">
                                                        <i class="fas fa-trash-alt"></i> Remove
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-lg font-medium text-[#2C3E50]">
                                                Rp {{ number_format($item->total, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm p-6 sticky top-6">
                        <h3 class="text-lg font-medium text-[#2C3E50] mb-6">Order Summary</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="text-[#2C3E50]">Rp {{ number_format($cartItems->sum('total'), 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Shipping</span>
                                <span class="text-[#2C3E50]">Calculated at checkout</span>
                            </div>
                            <div class="border-t pt-4 mt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-medium text-[#2C3E50]">Total</span>
                                    <span class="text-2xl font-medium text-[#E67E22]">
                                        Rp {{ number_format($cartItems->sum('total'), 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 space-y-4">
                            <a href="{{ route('checkout') }}" 
                               class="block w-full py-3 px-4 bg-[#2C3E50] text-white text-center rounded-lg hover:bg-[#E67E22] transition duration-300">
                                Proceed to Checkout
                            </a>
                            <a href="{{ route('products.index') }}" 
                               class="block w-full py-3 px-4 border border-[#2C3E50] text-[#2C3E50] text-center rounded-lg hover:bg-[#2C3E50] hover:text-white transition duration-300">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="max-w-2xl mx-auto text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-shopping-cart text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-2xl font-medium text-[#2C3E50] mb-3">Your cart is empty</h3>
                <p class="text-gray-600 mb-8">Looks like you haven't added anything to your cart yet.</p>
                <a href="{{ route('products.index') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-[#2C3E50] text-white rounded-lg hover:bg-[#E67E22] transition duration-300">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Start Shopping</span>
                </a>
            </div>
        @endif
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
        }
    }

    function decrementQuantity(button) {
        const input = button.parentElement.querySelector('input');
        const currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
        }
    }
</script>
@endpush
@endsection
