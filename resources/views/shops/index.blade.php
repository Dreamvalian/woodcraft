@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="text-wood-600 hover:text-wood-900">
                    <i class="fas fa-home mr-2"></i>
                    Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-wood-400 mx-2"></i>
                    <span class="text-wood-900">Products</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="lg:grid lg:grid-cols-12 lg:gap-x-8">
        <!-- Filters -->
        <aside class="hidden lg:block lg:col-span-3">
            <div x-data="{
                priceRange: [{{ request('min_price', 0) }}, {{ request('max_price', 1000) }}]
            }" class="space-y-6">
                <!-- Search -->
                <div class="relative">
                    <input
                        type="text"
                        placeholder="Search products..."
                        class="w-full rounded-lg border-wood-300 shadow-sm focus:border-wood-500 focus:ring-wood-500"
                        value="{{ request('search') }}"
                        name="search"
                    >
                    <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-wood-600">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <!-- Price Range -->
                <div>
                    <h3 class="text-lg font-medium text-wood-900">Price Range</h3>
                    <div class="mt-2">
                        <input type="range" x-model="priceRange[0]" min="0" max="1000" class="w-full" name="min_price">
                        <input type="range" x-model="priceRange[1]" min="0" max="1000" class="w-full" name="max_price">
                        <div class="flex justify-between mt-2">
                            <span x-text="'$' + priceRange[0]"></span>
                            <span x-text="'$' + priceRange[1]"></span>
                        </div>
                    </div>
                </div>
                <!-- Material Filter -->
                <div>
                    <h3 class="text-lg font-medium text-wood-900">Material</h3>
                    <div class="mt-2 space-y-2">
                        @foreach($materials as $material)
                            <label class="flex items-center">
                                <input type="radio" name="material" value="{{ $material }}" class="form-radio text-wood-600" {{ request('material') == $material ? 'checked' : '' }}>
                                <span class="ml-2 text-wood-700">{{ $material }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <!-- Availability Filter -->
                <div>
                    <h3 class="text-lg font-medium text-wood-900">Availability</h3>
                    <div class="mt-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="in_stock" value="1" class="form-checkbox text-wood-600" {{ request('in_stock') ? 'checked' : '' }}>
                            <span class="ml-2 text-wood-700">In Stock</span>
                        </label>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Product Grid -->
        <div class="mt-6 lg:mt-0 lg:col-span-9">
            <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
                @foreach($shops as $shop)
                    <div class="group relative">
                        <a href="{{ route('shops.show', $shop) }}" class="block relative overflow-hidden">
                            <img src="{{ $shop->image_url }}" alt="{{ $shop->name }}" 
                                 class="w-full h-48 object-cover transform transition-transform duration-500 group-hover:scale-110">
                        </a>
                        <div class="p-4">
                            <a href="{{ route('shops.show', $shop) }}" 
                               class="text-lg font-light text-[#2C3E50] hover:text-[#E67E22] transition">
                                {{ $shop->name }}
                            </a>
                            <p class="text-[#E67E22] font-light mt-1">{{ $shop->formatted_price }}</p>
                        </div>
                        <div class="mt-4">
                            <button 
                                @click="addToCart({{ $shop->id }})"
                                class="w-full bg-wood-600 text-white px-4 py-2 rounded-lg hover:bg-wood-700 transition-colors duration-200"
                                :class="{ 'opacity-50 cursor-not-allowed': loading }"
                                :disabled="loading"
                            >
                                <span x-show="!loading">Add to Cart</span>
                                <span x-show="loading" class="flex items-center justify-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Adding...
                                </span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $shops->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Quick View Modal -->
<div 
    x-show="quickView"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
>
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div 
            x-show="quickView"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 transition-opacity"
            aria-hidden="true"
        >
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div 
            x-show="quickView"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6"
        >
            <div class="absolute top-0 right-0 pt-4 pr-4">
                <button 
                    @click="quickView = null"
                    class="bg-white rounded-md text-wood-400 hover:text-wood-500 focus:outline-none"
                >
                    <span class="sr-only">Close</span>
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="sm:flex sm:items-start">
                <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                    <template x-if="quickView">
                        <div>
                            <img 
                                :src="shops.find(s => s.id === quickView).image_url"
                                :alt="shops.find(s => s.id === quickView).name"
                                class="w-full h-64 object-cover rounded-lg"
                            >
                            <h3 class="mt-4 text-lg font-medium text-wood-900" x-text="shops.find(s => s.id === quickView).name"></h3>
                            <p class="mt-2 text-lg font-medium text-wood-900">$<span x-text="shops.find(s => s.id === quickView).price"></span></p>
                            <p class="mt-2 text-sm text-wood-600" x-text="shops.find(s => s.id === quickView).description"></p>
                            <div class="mt-4">
                                <button 
                                    @click="addToCart(quickView)"
                                    class="w-full bg-wood-600 text-white px-4 py-2 rounded-lg hover:bg-wood-700 transition-colors duration-200"
                                    :class="{ 'opacity-50 cursor-not-allowed': loading }"
                                    :disabled="loading"
                                >
                                    <span x-show="!loading">Add to Cart</span>
                                    <span x-show="loading" class="flex items-center justify-center">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Adding...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection