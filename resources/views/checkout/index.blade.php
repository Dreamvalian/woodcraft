@extends('layouts.app')

@section('content')
  <div class="min-h-screen bg-white">
    <!-- Background Wood Grain Pattern -->
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

    <div class="max-w-7xl mx-auto px-6 md:px-24 py-16">
    <div class="relative">
      <!-- Decorative corner elements -->
      <div class="absolute -top-4 -left-4 w-8 h-8 opacity-10">
      <svg viewBox="0 0 100 100" class="w-full h-full">
        <path d="M0,0 L100,0 L0,100" stroke="currentColor" fill="none" stroke-width="2" />
        <path d="M20,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
        <path d="M40,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
      </svg>
      </div>
      <div class="absolute -top-4 -right-4 w-8 h-8 opacity-10">
      <svg viewBox="0 0 100 100" class="w-full h-full">
        <path d="M0,0 L100,0 L0,100" stroke="currentColor" fill="none" stroke-width="2" />
        <path d="M20,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
        <path d="M40,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
      </svg>
      </div>

      <h4 class="text-sm text-[#E67E22] uppercase mb-3 tracking-widest font-light">Complete Your Order</h4>
      <h1 class="text-4xl font-light text-[#2C3E50] mb-12">Checkout</h1>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
      <!-- Left Column: Order Form -->
      <div class="space-y-8">
        <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form" class="space-y-8">
        @csrf

        <!-- Shipping Information -->
        <div
          class="bg-white rounded-xl border border-gray-100 p-8 shadow-sm transition-all duration-200 hover:shadow-md">
          <h2 class="text-xl font-light text-[#2C3E50] mb-6">Shipping Information</h2>

          @if($addresses->count() > 0)
        <div class="mb-6">
        <label class="block text-sm font-light text-gray-700 mb-2">Select a saved address</label>
        <select name="address_id"
          class="w-full rounded-lg border-gray-200 bg-white/50 backdrop-blur-sm focus:border-[#E67E22] focus:ring-[#E67E22] transition duration-200">
          @foreach($addresses as $address)
        <option value="{{ $address->id }}">
        {{ $address->full_name }} - {{ $address->address_line1 }}, {{ $address->city }}
        </option>
        @endforeach
        </select>
        </div>
      @endif

          <div class="space-y-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
            <label class="block text-sm font-light text-gray-700 mb-2">Full Name</label>
            <input type="text" name="full_name" required
              class="w-full rounded-lg border-gray-200 bg-white/50 backdrop-blur-sm focus:border-[#E67E22] focus:ring-[#E67E22] transition duration-200">
            </div>
            <div>
            <label class="block text-sm font-light text-gray-700 mb-2">Phone</label>
            <input type="tel" name="phone" required
              class="w-full rounded-lg border-gray-200 bg-white/50 backdrop-blur-sm focus:border-[#E67E22] focus:ring-[#E67E22] transition duration-200">
            </div>
            <div class="md:col-span-2">
            <label class="block text-sm font-light text-gray-700 mb-2">Address Line 1</label>
            <input type="text" name="address_line1" required
              class="w-full rounded-lg border-gray-200 bg-white/50 backdrop-blur-sm focus:border-[#E67E22] focus:ring-[#E67E22] transition duration-200">
            </div>
            <div class="md:col-span-2">
            <label class="block text-sm font-light text-gray-700 mb-2">Address Line 2</label>
            <input type="text" name="address_line2"
              class="w-full rounded-lg border-gray-200 bg-white/50 backdrop-blur-sm focus:border-[#E67E22] focus:ring-[#E67E22] transition duration-200">
            </div>
            <div>
            <label class="block text-sm font-light text-gray-700 mb-2">City</label>
            <input type="text" name="city" required
              class="w-full rounded-lg border-gray-200 bg-white/50 backdrop-blur-sm focus:border-[#E67E22] focus:ring-[#E67E22] transition duration-200">
            </div>
            <div>
            <label class="block text-sm font-light text-gray-700 mb-2">State/Province</label>
            <input type="text" name="state" required
              class="w-full rounded-lg border-gray-200 bg-white/50 backdrop-blur-sm focus:border-[#E67E22] focus:ring-[#E67E22] transition duration-200">
            </div>
            <div>
            <label class="block text-sm font-light text-gray-700 mb-2">Postal Code</label>
            <input type="text" name="postal_code" required
              class="w-full rounded-lg border-gray-200 bg-white/50 backdrop-blur-sm focus:border-[#E67E22] focus:ring-[#E67E22] transition duration-200">
            </div>
            <div>
            <label class="block text-sm font-light text-gray-700 mb-2">Country</label>
            <input type="text" name="country" required
              class="w-full rounded-lg border-gray-200 bg-white/50 backdrop-blur-sm focus:border-[#E67E22] focus:ring-[#E67E22] transition duration-200">
            </div>
          </div>
          </div>
        </div>

        <!-- Shipping Method -->
        <div
          class="bg-white rounded-xl border border-gray-100 p-8 shadow-sm transition-all duration-200 hover:shadow-md">
          <h2 class="text-xl font-light text-[#2C3E50] mb-6">Shipping Method</h2>
          <div class="space-y-4">
          <label
            class="flex items-center space-x-4 p-4 rounded-lg border border-gray-100 hover:border-[#E67E22] transition duration-200 cursor-pointer">
            <input type="radio" name="shipping_method" value="standard" checked
            data-cost="{{ $standardShippingCost }}"
            class="w-5 h-5 text-[#E67E22] focus:ring-[#E67E22] border-gray-300 transition duration-200">
            <span class="text-gray-700 font-light">Standard Shipping (3-5 business days) - <span
              class="font-medium text-[#E67E22]">${{ number_format($standardShippingCost, 2) }}</span></span>
          </label>
          <label
            class="flex items-center space-x-4 p-4 rounded-lg border border-gray-100 hover:border-[#E67E22] transition duration-200 cursor-pointer">
            <input type="radio" name="shipping_method" value="express" data-cost="{{ $expressShippingCost }}"
            class="w-5 h-5 text-[#E67E22] focus:ring-[#E67E22] border-gray-300 transition duration-200">
            <span class="text-gray-700 font-light">Express Shipping (1-2 business days) - <span
              class="font-medium text-[#E67E22]">${{ number_format($expressShippingCost, 2) }}</span></span>
          </label>
          <label
            class="flex items-center space-x-4 p-4 rounded-lg border border-gray-100 hover:border-[#E67E22] transition duration-200 cursor-pointer">
            <input type="radio" name="shipping_method" value="overnight" data-cost="{{ $overnightShippingCost }}"
            class="w-5 h-5 text-[#E67E22] focus:ring-[#E67E22] border-gray-300 transition duration-200">
            <span class="text-gray-700 font-light">Overnight Shipping (Next business day) - <span
              class="font-medium text-[#E67E22]">${{ number_format($overnightShippingCost, 2) }}</span></span>
          </label>
          </div>
        </div>

        <!-- Payment Method -->
        <div
          class="bg-white rounded-xl border border-gray-100 p-8 shadow-sm transition-all duration-200 hover:shadow-md">
          <h2 class="text-xl font-light text-[#2C3E50] mb-6">Payment Method</h2>
          <div class="space-y-4">
          <label
            class="flex items-center space-x-4 p-4 rounded-lg border border-gray-100 hover:border-[#E67E22] transition duration-200 cursor-pointer">
            <input type="radio" name="payment_method" value="credit_card" checked
            class="w-5 h-5 text-[#E67E22] focus:ring-[#E67E22] border-gray-300 transition duration-200">
            <span class="text-gray-700 font-light">Credit Card</span>
          </label>
          <label
            class="flex items-center space-x-4 p-4 rounded-lg border border-gray-100 hover:border-[#E67E22] transition duration-200 cursor-pointer">
            <input type="radio" name="payment_method" value="bank_transfer"
            class="w-5 h-5 text-[#E67E22] focus:ring-[#E67E22] border-gray-300 transition duration-200">
            <span class="text-gray-700 font-light">Bank Transfer</span>
          </label>
          <label
            class="flex items-center space-x-4 p-4 rounded-lg border border-gray-100 hover:border-[#E67E22] transition duration-200 cursor-pointer">
            <input type="radio" name="payment_method" value="e_wallet"
            class="w-5 h-5 text-[#E67E22] focus:ring-[#E67E22] border-gray-300 transition duration-200">
            <span class="text-gray-700 font-light">E-Wallet</span>
          </label>
          </div>
        </div>
        </form>
      </div>

      <!-- Right Column: Order Summary -->
      <div class="space-y-8">
        <div class="bg-white rounded-xl border border-gray-100 p-8 shadow-sm">
        <h2 class="text-xl font-light text-[#2C3E50] mb-6">Order Summary</h2>
        <div class="space-y-6">
          @foreach($cart->items as $item)
        <div class="flex justify-between items-center py-4 border-b border-gray-100">
        <div>
        <span class="font-light text-gray-900">{{ $item->product->name }}</span>
        <span class="text-gray-500 text-sm block font-light">Quantity: {{ $item->quantity }}</span>
        </div>
        <span class="font-light text-[#E67E22]">${{ number_format($item->subtotal, 2) }}</span>
        </div>
      @endforeach

          <div class="space-y-4 pt-4">
          <div class="flex justify-between text-gray-600 font-light">
            <span>Subtotal</span>
            <span>${{ number_format($cart->subtotal, 2) }}</span>
          </div>
          <div class="flex justify-between text-gray-600 font-light">
            <span>Shipping</span>
            <span id="shipping-cost">${{ number_format($standardShippingCost, 2) }}</span>
          </div>
          <div class="flex justify-between text-lg font-light text-[#2C3E50] pt-4 border-t border-gray-100">
            <span>Total</span>
            <span id="total-cost">${{ number_format($cart->subtotal + $standardShippingCost, 2) }}</span>
          </div>
          </div>

          <button type="submit" form="checkout-form"
          class="w-full bg-transparent border-2 border-[#2C3E50] text-[#2C3E50] uppercase tracking-wider px-12 py-4 hover:bg-[#2C3E50] hover:text-white transition-all duration-300 font-light focus:outline-none focus:ring-2 focus:ring-[#2C3E50] focus:ring-offset-2">
          Place Order
          </button>
        </div>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>

  @push('scripts')
    <script>
    document.querySelectorAll('input[name="shipping_method"]').forEach(radio => {
    radio.addEventListener('change', function () {
      const shippingCost = parseFloat(this.dataset.cost);
      const subtotal = {{ $cart->subtotal }};
      document.getElementById('shipping-cost').textContent = `$${shippingCost.toFixed(2)}`;
      document.getElementById('total-cost').textContent = `$${(subtotal + shippingCost).toFixed(2)}`;
    });
    });
    </script>
  @endpush
@endsection