<x-app-layout>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <h1 class="text-2xl font-bold mb-6">Checkout</h1>

          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left Column: Order Form -->
            <div class="space-y-6">
              <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form" class="space-y-6">
                @csrf

                <!-- Shipping Information -->
                <div class="border rounded-lg p-4">
                  <h2 class="text-lg font-semibold mb-4">Shipping Information</h2>

                  @if($addresses->count() > 0)
              <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-2">Select a saved address</label>
              <select name="address_id"
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @foreach($addresses as $address)
            <option value="{{ $address->id }}">
            {{ $address->full_name }} - {{ $address->address_line1 }}, {{ $address->city }}
            </option>
          @endforeach
              </select>
              </div>
          @endif

                  <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                      <div>
                        <label class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="full_name" required
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                      </div>
                      <div>
                        <label class="block text-sm font-medium text-gray-700">Phone</label>
                        <input type="tel" name="phone" required
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                      </div>
                      <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Address Line 1</label>
                        <input type="text" name="address_line1" required
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                      </div>
                      <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Address Line 2</label>
                        <input type="text" name="address_line2"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                      </div>
                      <div>
                        <label class="block text-sm font-medium text-gray-700">City</label>
                        <input type="text" name="city" required
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                      </div>
                      <div>
                        <label class="block text-sm font-medium text-gray-700">State/Province</label>
                        <input type="text" name="state" required
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                      </div>
                      <div>
                        <label class="block text-sm font-medium text-gray-700">Postal Code</label>
                        <input type="text" name="postal_code" required
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                      </div>
                      <div>
                        <label class="block text-sm font-medium text-gray-700">Country</label>
                        <input type="text" name="country" required
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Shipping Method -->
                <div class="border rounded-lg p-4">
                  <h2 class="text-lg font-semibold mb-4">Shipping Method</h2>
                  <div class="space-y-4">
                    <label class="flex items-center space-x-3">
                      <input type="radio" name="shipping_method" value="standard" checked
                        data-cost="{{ $standardShippingCost }}"
                        class="rounded-full border-gray-300 text-blue-600 focus:ring-blue-500">
                      <span>Standard Shipping (3-5 business days) -
                        ${{ number_format($standardShippingCost, 2) }}</span>
                    </label>
                    <label class="flex items-center space-x-3">
                      <input type="radio" name="shipping_method" value="express" data-cost="{{ $expressShippingCost }}"
                        class="rounded-full border-gray-300 text-blue-600 focus:ring-blue-500">
                      <span>Express Shipping (1-2 business days) - ${{ number_format($expressShippingCost, 2) }}</span>
                    </label>
                    <label class="flex items-center space-x-3">
                      <input type="radio" name="shipping_method" value="overnight"
                        data-cost="{{ $overnightShippingCost }}"
                        class="rounded-full border-gray-300 text-blue-600 focus:ring-blue-500">
                      <span>Overnight Shipping (Next business day) -
                        ${{ number_format($overnightShippingCost, 2) }}</span>
                    </label>
                  </div>
                </div>

                <!-- Payment Method -->
                <div class="border rounded-lg p-4">
                  <h2 class="text-lg font-semibold mb-4">Payment Method</h2>
                  <div class="space-y-4">
                    <label class="flex items-center space-x-3">
                      <input type="radio" name="payment_method" value="credit_card" checked
                        class="rounded-full border-gray-300 text-blue-600 focus:ring-blue-500">
                      <span>Credit Card</span>
                    </label>
                    <label class="flex items-center space-x-3">
                      <input type="radio" name="payment_method" value="bank_transfer"
                        class="rounded-full border-gray-300 text-blue-600 focus:ring-blue-500">
                      <span>Bank Transfer</span>
                    </label>
                    <label class="flex items-center space-x-3">
                      <input type="radio" name="payment_method" value="e_wallet"
                        class="rounded-full border-gray-300 text-blue-600 focus:ring-blue-500">
                      <span>E-Wallet</span>
                    </label>
                  </div>
                </div>
              </form>
            </div>

            <!-- Right Column: Order Summary -->
            <div class="space-y-6">
              <div class="border rounded-lg p-4">
                <h2 class="text-lg font-semibold mb-4">Order Summary</h2>
                <div class="space-y-4">
                  @foreach($cart->items as $item)
            <div class="flex justify-between items-center">
            <div>
              <span class="font-medium">{{ $item->name }}</span>
              <span class="text-gray-600">x{{ $item->quantity }}</span>
            </div>
            <span>${{ number_format($item->subtotal, 2) }}</span>
            </div>
          @endforeach

                  <div class="border-t pt-4 space-y-2">
                    <div class="flex justify-between">
                      <span>Subtotal</span>
                      <span>${{ number_format($cart->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                      <span>Shipping</span>
                      <span id="shipping-cost">${{ number_format($standardShippingCost, 2) }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg">
                      <span>Total</span>
                      <span id="total-cost">${{ number_format($cart->subtotal + $standardShippingCost, 2) }}</span>
                    </div>
                  </div>

                  <button type="submit" form="checkout-form"
                    class="w-full bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 font-medium">
                    Place Order
                  </button>
                </div>
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
</x-app-layout>