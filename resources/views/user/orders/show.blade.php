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

      <div class="flex items-center space-x-4 mb-6">
      <a href="{{ route('orders.index') }}"
        class="text-[#2C3E50] hover:text-[#E67E22] transition-colors duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
      </a>
      <h4 class="text-sm text-[#E67E22] uppercase tracking-widest font-light">Order Details</h4>
      </div>
      <h1 class="text-6xl font-light mb-6 leading-tight text-[#2C3E50]">Order #{{ $order->id }}</h1>
      <p class="text-gray-600 mb-8 text-lg max-w-md leading-relaxed font-light">
      Placed on {{ $order->placed_at->format('F d, Y \a\t h:i A') }}
      </p>
    </div>
    </div>

    <!-- Order Details Content Section -->
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
      <!-- Order Status and Details -->
      <div class="bg-white rounded-lg shadow-lg overflow-hidden relative">
      {{-- Hand-drawn frame decoration --}}
      <div class="absolute inset-0 border-2 border-[#E67E22]/30 rounded-lg transform rotate-1"></div>
      <div class="absolute inset-0 border-2 border-[#E67E22]/20 rounded-lg transform -rotate-1"></div>
      {{-- Decorative corner elements --}}
      <div class="absolute -top-2 -left-2 w-4 h-4 border-t-2 border-l-2 border-[#E67E22]/30"></div>
      <div class="absolute -top-2 -right-2 w-4 h-4 border-t-2 border-r-2 border-[#E67E22]/30"></div>
      <div class="absolute -bottom-2 -left-2 w-4 h-4 border-b-2 border-l-2 border-[#E67E22]/30"></div>
      <div class="absolute -bottom-2 -right-2 w-4 h-4 border-b-2 border-r-2 border-[#E67E22]/30"></div>

      <div class="p-6">
        <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-light text-[#2C3E50]">Order Status</h2>
        <span class="px-3 py-1 rounded-full text-sm font-semibold
                @if($order->status === 'completed') bg-green-100 text-green-800
          @elseif($order->status === 'cancelled') bg-red-100 text-red-800
          @else bg-yellow-100 text-yellow-800
          @endif">
          {{ ucfirst($order->status) }}
        </span>
        </div>

        <div class="space-y-4">
        <div>
          <h3 class="text-sm font-medium text-gray-500">Shipping Address</h3>
          <p class="mt-1 text-gray-900 font-light">{{ $order->shipping_address }}</p>
        </div>
        <div>
          <h3 class="text-sm font-medium text-gray-500">Billing Address</h3>
          <p class="mt-1 text-gray-900 font-light">{{ $order->billing_address }}</p>
        </div>
        <div>
          <h3 class="text-sm font-medium text-gray-500">Payment Method</h3>
          <p class="mt-1 text-gray-900 font-light">{{ ucfirst($order->payment_method) }}</p>
        </div>
        <div>
          <h3 class="text-sm font-medium text-gray-500">Payment Status</h3>
          <p class="mt-1 text-gray-900 font-light">{{ ucfirst($order->payment_status) }}</p>
        </div>
        </div>

        @if($order->status === 'pending' || $order->status === 'processing')
      <div class="mt-6">
      <form action="{{ route('orders.cancel', $order) }}" method="POST" class="inline">
        @csrf
        @method('PATCH')
        <button type="submit"
        class="relative bg-transparent border-2 border-red-600 text-red-600 uppercase tracking-wider px-8 py-2 hover:bg-red-600 hover:text-white transition-all duration-300 font-light focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2"
        onclick="return confirm('Are you sure you want to cancel this order?')">
        Cancel Order
        </button>
      </form>
      </div>
      @endif
      </div>
      </div>

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

      <div class="p-6">
        <h2 class="text-xl font-light text-[#2C3E50] mb-6">Order Items</h2>
        <div class="space-y-6">
        @foreach($order->items as $item)
        <div class="flex items-center space-x-4">
        @if($item->product->images->isNotEmpty())
        <div class="relative w-20 h-20">
        <img src="{{ $item->product->images->first()->image_url }}" alt="{{ $item->product->name }}"
        class="w-full h-full object-cover rounded">
        {{-- Hand-drawn frame decoration --}}
        <div class="absolute inset-0 border border-[#E67E22]/30 rounded transform rotate-1"></div>
        <div class="absolute inset-0 border border-[#E67E22]/20 rounded transform -rotate-1"></div>
        </div>
      @endif
        <div class="flex-1">
        <h3 class="text-sm font-medium text-[#2C3E50]">{{ $item->product->name }}</h3>
        <p class="text-sm text-gray-500 font-light">Quantity: {{ $item->quantity }}</p>
        <p class="text-sm text-gray-900 font-light">${{ number_format($item->price, 2) }} each</p>
        </div>
        <div class="text-right">
        <p class="text-sm font-medium text-[#2C3E50]">${{ number_format($item->price * $item->quantity, 2) }}
        </p>
        </div>
        </div>
      @endforeach
        </div>

        <div class="mt-6 pt-6 border-t border-gray-200">
        <div class="flex justify-between text-lg font-light">
          <span class="text-[#2C3E50]">Total</span>
          <span class="text-[#2C3E50]">${{ number_format($order->total, 2) }}</span>
        </div>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
@endsection