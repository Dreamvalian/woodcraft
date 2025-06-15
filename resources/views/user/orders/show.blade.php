@extends('layouts.app')

@section('content')
  <div class="bg-white font-sans">
    <!-- Order Details Header Section -->
    <div class="relative flex flex-col md:flex-row justify-between items-center px-6 md:px-24 py-16 gap-12 bg-white">
    {{-- Background Wood Grain Pattern --}}
    <div class="absolute inset-0 opacity-[0.02] pointer-events-none">
      <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
      <pattern id="wood-grain" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
        <path d="M0,0 L100,0 L100,100 L0,100 Z" fill="none" stroke="currentColor" stroke-width="0.5" />
        <path d="M0,20 Q25,15 50,20 T100,20" stroke="currentColor" fill="none" stroke-width="0.3" />
        <path d="M0,40 Q25,35 50,40 T100,40" stroke="currentColor" fill="none" stroke-width="0.3" />
        <path d="M0,60 Q25,55 50,60 T100,60" stroke="currentColor" fill="none" stroke-width="0.3" />
        <path d="M0,80 Q25,75 50,80 T100,80" stroke="currentColor" fill="none" stroke-width="0.3" />
      </pattern>
      <rect x="0" y="0" width="100" height="100" fill="url(#wood-grain)" />
      </svg>
    </div>

    <div class="md:w-1/2 relative">
      {{-- Decorative corner elements --}}
      <div class="absolute -top-4 -left-4 w-8 h-8 opacity-10">
      <svg viewBox="0 0 100 100" class="w-full h-full">
        <path d="M0,0 L100,0 L0,100" stroke="currentColor" fill="none" stroke-width="2" />
        <path d="M20,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
        <path d="M40,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
      </svg>
      </div>
      <div class="absolute -bottom-4 -right-4 w-8 h-8 opacity-10">
      <svg viewBox="0 0 100 100" class="w-full h-full">
        <path d="M0,0 L100,0 L0,100" stroke="currentColor" fill="none" stroke-width="2" />
        <path d="M20,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
        <path d="M40,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
      </svg>
      </div>

      <h4 class="text-sm text-[#E67E22] uppercase mb-3 tracking-widest font-light">Order Details</h4>
      <h1 class="text-6xl font-light mb-6 leading-tight text-[#2C3E50]">Order #{{ $order->order_number }}</h1>
      <p class="text-gray-600 mb-8 text-lg max-w-md leading-relaxed font-light">
      Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}
      </p>
    </div>
    </div>

    <!-- Order Details Section -->
    <div class="relative px-6 md:px-24 py-12">
    {{-- Background Wood Grain Pattern --}}
    <div class="absolute inset-0 opacity-[0.02] pointer-events-none">
      <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
      <pattern id="wood-grain-details" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
        <path d="M0,0 L100,0 L100,100 L0,100 Z" fill="none" stroke="currentColor" stroke-width="0.5" />
        <path d="M0,20 Q25,15 50,20 T100,20" stroke="currentColor" fill="none" stroke-width="0.3" />
        <path d="M0,40 Q25,35 50,40 T100,40" stroke="currentColor" fill="none" stroke-width="0.3" />
        <path d="M0,60 Q25,55 50,60 T100,60" stroke="currentColor" fill="none" stroke-width="0.3" />
        <path d="M0,80 Q25,75 50,80 T100,80" stroke="currentColor" fill="none" stroke-width="0.3" />
      </pattern>
      <rect x="0" y="0" width="100" height="100" fill="url(#wood-grain-details)" />
      </svg>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <!-- Order Items -->
      <div class="bg-white rounded-lg shadow-lg overflow-hidden relative">
      {{-- Hand-drawn frame decoration --}}
      <div class="absolute inset-0 border-2 border-[#E67E22]/30 rounded-lg transform rotate-1"></div>
      <div class="absolute inset-0 border-2 border-[#E67E22]/20 rounded-lg transform -rotate-1"></div>
      {{-- Decorative corner elements --}}
      <div class="absolute -top-2 -left-2 w-4 h-4 border-t-2 border-l-2 border-[#E67E22]/30"></div>
      <div class="absolute -top-2 -right-2 w-4 h-4 border-t-2 border-r-2 border-[#E67E22]/30"></div>
      <div class="absolute -bottom-2 -left-2 w-4 h-4 border-b-2 border-l-2 border-[#E67E22]/30"></div>
      <div class="absolute -bottom-2 -right-2 w-4 h-4 border-b-2 border-r-2 border-[#E67E22]/30"></div>

      <div class="p-8">
        <h2 class="text-2xl font-light text-[#2C3E50] mb-6">Order Items</h2>
        <div class="space-y-6">
        @foreach($order->items as $item)
        <div class="flex items-center space-x-6">
        @if($item->product->image_url)
        <div class="flex-shrink-0">
        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}"
        class="h-24 w-24 object-cover rounded-lg">
        </div>
      @endif
        <div class="flex-1 min-w-0">
        <p class="text-lg font-light text-[#2C3E50]">{{ $item->product->name }}</p>
        <p class="text-gray-600">Quantity: {{ $item->quantity }}</p>
        <p class="text-gray-600">Price: ${{ number_format($item->price, 2) }}</p>
        </div>
        <div class="text-right">
        <p class="text-xl font-light text-[#2C3E50]">${{ number_format($item->price * $item->quantity, 2) }}</p>
        </div>
        </div>
      @endforeach
        </div>

        <div class="mt-6 pt-6 border-t border-gray-200">
        <div class="flex justify-between items-center">
          <div class="text-gray-600">
          <p class="font-light">Subtotal</p>
          <p class="font-light">Shipping</p>
          <p class="font-light mt-2">Total</p>
          </div>
          <div class="text-right">
          <p class="font-light">${{ number_format($order->total - $order->shipping_cost, 2) }}</p>
          <p class="font-light">${{ number_format($order->shipping_cost, 2) }}</p>
          <p class="text-xl font-light text-[#2C3E50] mt-2">${{ number_format($order->total, 2) }}</p>
          </div>
        </div>
        </div>
      </div>
      </div>

      <!-- Order Information -->
      <div class="space-y-8">
      <!-- Status -->
      <div class="bg-white rounded-lg shadow-lg overflow-hidden relative">
        {{-- Hand-drawn frame decoration --}}
        <div class="absolute inset-0 border-2 border-[#E67E22]/30 rounded-lg transform rotate-1"></div>
        <div class="absolute inset-0 border-2 border-[#E67E22]/20 rounded-lg transform -rotate-1"></div>
        {{-- Decorative corner elements --}}
        <div class="absolute -top-2 -left-2 w-4 h-4 border-t-2 border-l-2 border-[#E67E22]/30"></div>
        <div class="absolute -top-2 -right-2 w-4 h-4 border-t-2 border-r-2 border-[#E67E22]/30"></div>
        <div class="absolute -bottom-2 -left-2 w-4 h-4 border-b-2 border-l-2 border-[#E67E22]/30"></div>
        <div class="absolute -bottom-2 -right-2 w-4 h-4 border-b-2 border-r-2 border-[#E67E22]/30"></div>

        <div class="p-8">
        <h2 class="text-2xl font-light text-[#2C3E50] mb-6">Order Status</h2>
        <div class="flex items-center justify-between">
          <div>
          <p class="text-gray-600">Status</p>
          <p class="text-gray-600">Payment Method</p>
          <p class="text-gray-600">Shipping Method</p>
          </div>
          <div class="text-right">
          <span class="px-4 py-2 rounded-full text-sm font-light
            @if($order->status === 'completed') bg-green-100 text-green-800
        @elseif($order->status === 'cancelled') bg-red-100 text-red-800
      @else bg-yellow-100 text-yellow-800
      @endif">
            {{ ucfirst($order->status) }}
          </span>
          <p class="text-gray-600 mt-2">{{ ucfirst($order->payment_method) }}</p>
          <p class="text-gray-600">{{ ucfirst($order->shipping_method) }}</p>
          </div>
        </div>
        </div>
      </div>

      <!-- Shipping Address -->
      <div class="bg-white rounded-lg shadow-lg overflow-hidden relative">
        {{-- Hand-drawn frame decoration --}}
        <div class="absolute inset-0 border-2 border-[#E67E22]/30 rounded-lg transform rotate-1"></div>
        <div class="absolute inset-0 border-2 border-[#E67E22]/20 rounded-lg transform -rotate-1"></div>
        {{-- Decorative corner elements --}}
        <div class="absolute -top-2 -left-2 w-4 h-4 border-t-2 border-l-2 border-[#E67E22]/30"></div>
        <div class="absolute -top-2 -right-2 w-4 h-4 border-t-2 border-r-2 border-[#E67E22]/30"></div>
        <div class="absolute -bottom-2 -left-2 w-4 h-4 border-b-2 border-l-2 border-[#E67E22]/30"></div>
        <div class="absolute -bottom-2 -right-2 w-4 h-4 border-b-2 border-r-2 border-[#E67E22]/30"></div>

        <div class="p-8">
        <h2 class="text-2xl font-light text-[#2C3E50] mb-6">Shipping Address</h2>
        <div class="text-gray-600">
          <p>{{ $order->shippingAddress->name }}</p>
          <p>{{ $order->shippingAddress->address_line1 }}</p>
          @if($order->shippingAddress->address_line2)
        <p>{{ $order->shippingAddress->address_line2 }}</p>
      @endif
          <p>{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }}
          {{ $order->shippingAddress->postal_code }}
          </p>
          <p>{{ $order->shippingAddress->country }}</p>
          <p class="mt-2">{{ $order->shippingAddress->phone }}</p>
        </div>
        </div>
      </div>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-8 flex justify-end space-x-4">
      <a href="{{ route('orders.index') }}"
      class="relative bg-transparent border-2 border-[#2C3E50] text-[#2C3E50] uppercase tracking-wider px-8 py-3 hover:bg-[#2C3E50] hover:text-white transition-all duration-300 font-light focus:outline-none focus:ring-2 focus:ring-[#2C3E50] focus:ring-offset-2 inline-block">
      Back to Orders
      </a>
      @if($order->status === 'pending')
      <form action="{{ route('orders.cancel', $order) }}" method="POST" class="inline">
      @csrf
      <button type="submit"
      class="relative bg-transparent border-2 border-red-500 text-red-500 uppercase tracking-wider px-8 py-3 hover:bg-red-500 hover:text-white transition-all duration-300 font-light focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
      Cancel Order
      </button>
      </form>
    @endif
    </div>
    </div>
  </div>
@endsection