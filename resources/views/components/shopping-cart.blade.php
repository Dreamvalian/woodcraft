@props(['items' => [], 'total' => 0])

<div x-data="{ 
    items: @entangle('items'),
    total: @entangle('total'),
    isOpen: false,
    updateQuantity(itemId, newQuantity) {
        if (newQuantity < 1) return;
        
        // Show loading state
        const item = this.items.find(i => i.id === itemId);
        if (item) {
            item.loading = true;
        }
        
        // Update quantity
        fetch(`/cart/update/${itemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ quantity: newQuantity })
        })
        .then(response => response.json())
        .then(data => {
            this.items = data.items;
            this.total = data.total;
        })
        .finally(() => {
            if (item) {
                item.loading = false;
            }
        });
    },
    removeItem(itemId) {
        // Show loading state
        const item = this.items.find(i => i.id === itemId);
        if (item) {
            item.loading = true;
        }
        
        // Remove item
        fetch(`/cart/remove/${itemId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            this.items = data.items;
            this.total = data.total;
        })
        .finally(() => {
            if (item) {
                item.loading = false;
            }
        });
    }
}" class="relative">
    {{-- Cart Button --}}
    <button 
        @click="isOpen = !isOpen"
        class="relative text-gray-700 hover:text-wood transition"
    >
        <i class="fas fa-shopping-cart"></i>
        <span 
            x-show="items.length > 0"
            class="absolute -top-2 -right-2 bg-wood text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"
            x-text="items.length"
        ></span>
    </button>

    {{-- Cart Dropdown --}}
    <div 
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        @click.away="isOpen = false"
        class="absolute right-0 mt-2 w-96 bg-white rounded-lg shadow-xl z-50"
    >
        <div class="p-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Shopping Cart</h3>
                <button @click="isOpen = false" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Cart Items --}}
            <div class="space-y-4 max-h-96 overflow-y-auto">
                <template x-if="items.length === 0">
                    <div class="text-center py-8 text-gray-500">
                        Your cart is empty
                    </div>
                </template>

                <template x-for="item in items" :key="item.id">
                    <div class="flex items-center space-x-4">
                        {{-- Item Image --}}
                        <div class="flex-shrink-0 w-20 h-20">
                            <img 
                                :src="item.image" 
                                :alt="item.name"
                                class="w-full h-full object-cover rounded-lg"
                            >
                        </div>

                        {{-- Item Details --}}
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-900" x-text="item.name"></h4>
                            <p class="text-sm text-gray-500" x-text="item.variant"></p>
                            <div class="mt-1 flex items-center space-x-2">
                                <button 
                                    @click="updateQuantity(item.id, item.quantity - 1)"
                                    class="text-gray-500 hover:text-wood transition"
                                    :disabled="item.loading"
                                >
                                    <i class="fas fa-minus"></i>
                                </button>
                                <span class="text-gray-700" x-text="item.quantity"></span>
                                <button 
                                    @click="updateQuantity(item.id, item.quantity + 1)"
                                    class="text-gray-500 hover:text-wood transition"
                                    :disabled="item.loading"
                                >
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Price and Remove --}}
                        <div class="flex flex-col items-end space-y-2">
                            <span class="text-sm font-medium text-gray-900" x-text="'$' + item.price"></span>
                            <button 
                                @click="removeItem(item.id)"
                                class="text-red-500 hover:text-red-700 transition"
                                :disabled="item.loading"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Cart Summary --}}
            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-base font-medium text-gray-900">Total</span>
                    <span class="text-base font-medium text-gray-900" x-text="'$' + total"></span>
                </div>

                <div class="space-y-2">
                    <a 
                        href="{{ route('cart') }}"
                        class="block w-full bg-wood text-white text-center py-2 px-4 rounded-md hover:bg-wood-dark transition"
                    >
                        View Cart
                    </a>
                    <a 
                        href="{{ route('checkout') }}"
                        class="block w-full bg-gray-900 text-white text-center py-2 px-4 rounded-md hover:bg-gray-800 transition"
                    >
                        Checkout
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Add to cart animation
    document.addEventListener('alpine:init', () => {
        Alpine.data('addToCart', (productId) => ({
            async addToCart() {
                const button = this.$el;
                const originalText = button.innerHTML;
                
                // Show loading state
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                button.disabled = true;
                
                try {
                    const response = await fetch('/cart/add', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ product_id: productId })
                    });
                    
                    const data = await response.json();
                    
                    // Update cart state
                    window.dispatchEvent(new CustomEvent('cart-updated', {
                        detail: data
                    }));
                    
                    // Show success message
                    button.innerHTML = '<i class="fas fa-check"></i> Added!';
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }, 2000);
                } catch (error) {
                    // Show error message
                    button.innerHTML = '<i class="fas fa-times"></i> Error';
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }, 2000);
                }
            }
        }));
    });
</script>
@endpush 