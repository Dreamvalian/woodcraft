<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div x-data="checkout()" class="space-y-8">
                        <!-- Progress Steps -->
                        <div class="flex justify-between items-center">
                            <template x-for="(step, index) in steps" :key="index">
                                <div class="flex items-center">
                                    <div :class="{
                                        'bg-blue-600': currentStep >= index,
                                        'bg-gray-200': currentStep < index
                                    }" class="w-8 h-8 rounded-full flex items-center justify-center text-white">
                                        <span x-text="index + 1"></span>
                                    </div>
                                    <span class="ml-2" x-text="step"></span>
                                    <div x-show="index < steps.length - 1" class="w-24 h-1 mx-4" :class="{
                                        'bg-blue-600': currentStep > index,
                                        'bg-gray-200': currentStep <= index
                                    }"></div>
                                </div>
                            </template>
                        </div>

                        <!-- Step 1: Shipping Address -->
                        <div x-show="currentStep === 0">
                            <h2 class="text-2xl font-semibold mb-4">Shipping Address</h2>
                            
                            <!-- Saved Addresses -->
                            <div class="mb-6">
                                <h3 class="text-lg font-medium mb-2">Saved Addresses</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($addresses as $address)
                                        <div class="border rounded-lg p-4 cursor-pointer hover:border-blue-500"
                                             :class="{'border-blue-500': selectedShippingAddress === {{ $address->id }}}"
                                             @click="selectShippingAddress({{ $address->id }})">
                                            <div class="font-medium" x-text="'{{ $address->full_name }}'"></div>
                                            <div class="text-gray-600">
                                                <p x-text="'{{ $address->address_line1 }}'"></p>
                                                <p x-text="'{{ $address->address_line2 }}'"></p>
                                                <p x-text="'{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}'"></p>
                                                <p x-text="'{{ $address->country }}'"></p>
                                                <p x-text="'{{ $address->phone }}'"></p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- New Address Form -->
                            <div class="mt-6">
                                <h3 class="text-lg font-medium mb-2">Add New Address</h3>
                                <form @submit.prevent="saveAddress" class="space-y-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Full Name</label>
                                            <input type="text" x-model="newAddress.full_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Phone</label>
                                            <input type="text" x-model="newAddress.phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700">Address Line 1</label>
                                            <input type="text" x-model="newAddress.address_line1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700">Address Line 2</label>
                                            <input type="text" x-model="newAddress.address_line2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">City</label>
                                            <input type="text" x-model="newAddress.city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">State/Province</label>
                                            <input type="text" x-model="newAddress.state" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Postal Code</label>
                                            <input type="text" x-model="newAddress.postal_code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Country</label>
                                            <input type="text" x-model="newAddress.country" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" x-model="newAddress.is_default" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <label class="ml-2 block text-sm text-gray-900">Set as default address</label>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                            Save Address
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Step 2: Shipping Method -->
                        <div x-show="currentStep === 1">
                            <h2 class="text-2xl font-semibold mb-4">Shipping Method</h2>
                            <div class="space-y-4">
                                <div class="border rounded-lg p-4 cursor-pointer hover:border-blue-500"
                                     :class="{'border-blue-500': selectedShippingMethod === 'standard'}"
                                     @click="selectShippingMethod('standard')">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h3 class="font-medium">Standard Shipping</h3>
                                            <p class="text-gray-600">3-5 business days</p>
                                        </div>
                                        <div class="text-lg font-medium" x-text="formatPrice(standardShippingCost)"></div>
                                    </div>
                                </div>
                                <div class="border rounded-lg p-4 cursor-pointer hover:border-blue-500"
                                     :class="{'border-blue-500': selectedShippingMethod === 'express'}"
                                     @click="selectShippingMethod('express')">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h3 class="font-medium">Express Shipping</h3>
                                            <p class="text-gray-600">1-2 business days</p>
                                        </div>
                                        <div class="text-lg font-medium" x-text="formatPrice(expressShippingCost)"></div>
                                    </div>
                                </div>
                                <div class="border rounded-lg p-4 cursor-pointer hover:border-blue-500"
                                     :class="{'border-blue-500': selectedShippingMethod === 'overnight'}"
                                     @click="selectShippingMethod('overnight')">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h3 class="font-medium">Overnight Shipping</h3>
                                            <p class="text-gray-600">Next business day</p>
                                        </div>
                                        <div class="text-lg font-medium" x-text="formatPrice(overnightShippingCost)"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Payment Method -->
                        <div x-show="currentStep === 2">
                            <h2 class="text-2xl font-semibold mb-4">Payment Method</h2>
                            <div class="space-y-4">
                                <div class="border rounded-lg p-4 cursor-pointer hover:border-blue-500"
                                     :class="{'border-blue-500': selectedPaymentMethod === 'credit_card'}"
                                     @click="selectPaymentMethod('credit_card')">
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                        <span>Credit Card</span>
                                    </div>
                                </div>
                                <div class="border rounded-lg p-4 cursor-pointer hover:border-blue-500"
                                     :class="{'border-blue-500': selectedPaymentMethod === 'bank_transfer'}"
                                     @click="selectPaymentMethod('bank_transfer')">
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                        <span>Bank Transfer</span>
                                    </div>
                                </div>
                                <div class="border rounded-lg p-4 cursor-pointer hover:border-blue-500"
                                     :class="{'border-blue-500': selectedPaymentMethod === 'e_wallet'}"
                                     @click="selectPaymentMethod('e_wallet')">
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <span>E-Wallet</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Review Order -->
                        <div x-show="currentStep === 3">
                            <h2 class="text-2xl font-semibold mb-4">Review Order</h2>
                            <div class="space-y-6">
                                <!-- Order Summary -->
                                <div class="border rounded-lg p-4">
                                    <h3 class="text-lg font-medium mb-4">Order Summary</h3>
                                    <div class="space-y-2">
                                        <template x-for="item in summary.items" :key="item.id">
                                            <div class="flex justify-between">
                                                <div>
                                                    <span x-text="item.name"></span>
                                                    <span class="text-gray-600" x-text="'x' + item.quantity"></span>
                                                </div>
                                                <span x-text="item.formatted_subtotal"></span>
                                            </div>
                                        </template>
                                        <div class="border-t pt-2 mt-2">
                                            <div class="flex justify-between">
                                                <span>Subtotal</span>
                                                <span x-text="summary.formatted_subtotal"></span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span>Shipping</span>
                                                <span x-text="formatPrice(selectedShippingCost)"></span>
                                            </div>
                                            <div class="flex justify-between font-medium">
                                                <span>Total</span>
                                                <span x-text="formatPrice(summary.total + selectedShippingCost)"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Shipping Address -->
                                <div class="border rounded-lg p-4">
                                    <h3 class="text-lg font-medium mb-2">Shipping Address</h3>
                                    <div x-text="getSelectedAddressDetails()"></div>
                                </div>

                                <!-- Shipping Method -->
                                <div class="border rounded-lg p-4">
                                    <h3 class="text-lg font-medium mb-2">Shipping Method</h3>
                                    <div x-text="getSelectedShippingMethodDetails()"></div>
                                </div>

                                <!-- Payment Method -->
                                <div class="border rounded-lg p-4">
                                    <h3 class="text-lg font-medium mb-2">Payment Method</h3>
                                    <div x-text="getSelectedPaymentMethodDetails()"></div>
                                </div>

                                <!-- Order Notes -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Order Notes (Optional)</label>
                                    <textarea x-model="orderNotes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="flex justify-between mt-8">
                            <button x-show="currentStep > 0" @click="previousStep" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                                Back
                            </button>
                            <button x-show="currentStep < steps.length - 1" @click="nextStep" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                Continue
                            </button>
                            <button x-show="currentStep === steps.length - 1" @click="placeOrder" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                                Place Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function checkout() {
            return {
                steps: ['Shipping Address', 'Shipping Method', 'Payment Method', 'Review Order'],
                currentStep: 0,
                selectedShippingAddress: null,
                selectedShippingMethod: null,
                selectedPaymentMethod: null,
                selectedShippingCost: 0,
                standardShippingCost: 10,
                expressShippingCost: 20,
                overnightShippingCost: 30,
                orderNotes: '',
                summary: @json($summary),
                newAddress: {
                    type: 'shipping',
                    full_name: '',
                    phone: '',
                    address_line1: '',
                    address_line2: '',
                    city: '',
                    state: '',
                    postal_code: '',
                    country: '',
                    is_default: false
                },

                nextStep() {
                    if (this.validateCurrentStep()) {
                        this.currentStep++;
                    }
                },

                previousStep() {
                    this.currentStep--;
                },

                validateCurrentStep() {
                    switch (this.currentStep) {
                        case 0:
                            if (!this.selectedShippingAddress) {
                                alert('Please select or add a shipping address');
                                return false;
                            }
                            break;
                        case 1:
                            if (!this.selectedShippingMethod) {
                                alert('Please select a shipping method');
                                return false;
                            }
                            break;
                        case 2:
                            if (!this.selectedPaymentMethod) {
                                alert('Please select a payment method');
                                return false;
                            }
                            break;
                    }
                    return true;
                },

                selectShippingAddress(addressId) {
                    this.selectedShippingAddress = addressId;
                    this.calculateShipping();
                },

                selectShippingMethod(method) {
                    this.selectedShippingMethod = method;
                    this.calculateShipping();
                },

                selectPaymentMethod(method) {
                    this.selectedPaymentMethod = method;
                },

                calculateShipping() {
                    if (this.selectedShippingAddress && this.selectedShippingMethod) {
                        fetch('/checkout/calculate-shipping', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                address_id: this.selectedShippingAddress,
                                shipping_method: this.selectedShippingMethod
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.selectedShippingCost = data.shipping_cost;
                                this.summary.total = data.total;
                                this.summary.formatted_total = data.formatted_total;
                            }
                        });
                    }
                },

                saveAddress() {
                    fetch('/checkout/address', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(this.newAddress)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.selectedShippingAddress = data.address.id;
                            this.calculateShipping();
                            // Reset form
                            this.newAddress = {
                                type: 'shipping',
                                full_name: '',
                                phone: '',
                                address_line1: '',
                                address_line2: '',
                                city: '',
                                state: '',
                                postal_code: '',
                                country: '',
                                is_default: false
                            };
                        }
                    });
                },

                placeOrder() {
                    fetch('/checkout/process-payment', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            shipping_address_id: this.selectedShippingAddress,
                            payment_method: this.selectedPaymentMethod,
                            shipping_method: this.selectedShippingMethod,
                            shipping_cost: this.selectedShippingCost,
                            notes: this.orderNotes
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = data.redirect_url;
                        } else {
                            alert(data.message);
                        }
                    });
                },

                formatPrice(price) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
                },

                getSelectedAddressDetails() {
                    const address = @json($addresses).find(a => a.id === this.selectedShippingAddress);
                    if (!address) return '';
                    return `${address.full_name}\n${address.address_line1}\n${address.address_line2 ? address.address_line2 + '\n' : ''}${address.city}, ${address.state} ${address.postal_code}\n${address.country}\n${address.phone}`;
                },

                getSelectedShippingMethodDetails() {
                    const methods = {
                        standard: 'Standard Shipping (3-5 business days)',
                        express: 'Express Shipping (1-2 business days)',
                        overnight: 'Overnight Shipping (Next business day)'
                    };
                    return methods[this.selectedShippingMethod] || '';
                },

                getSelectedPaymentMethodDetails() {
                    const methods = {
                        credit_card: 'Credit Card',
                        bank_transfer: 'Bank Transfer',
                        e_wallet: 'E-Wallet'
                    };
                    return methods[this.selectedPaymentMethod] || '';
                }
            }
        }
    </script>
    @endpush
</x-app-layout> 