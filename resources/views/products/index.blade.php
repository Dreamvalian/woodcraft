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
                priceRange: [{{ request('min_price', 0) }}, {{ request('max_price', 1000) }}],
                categories: @json($categories),
                selectedCategories: @json(request('categories', [])),
                selectedFeatures: @json(request('features', [])),
                features: @json($features)
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

                <!-- Categories -->
                <div>
                    <h3 class="text-lg font-medium text-wood-900 mb-4">Categories</h3>
                    <div class="space-y-2">
                        <template x-for="category in categories" :key="category.id">
                            <label class="flex items-center">
                                <input 
                                    type="checkbox"
                                    :value="category.id"
                                    x-model="selectedCategories"
                                    name="categories[]"
                                    class="rounded border-wood-300 text-wood-600 focus:ring-wood-500"
                                >
                                <span class="ml-2 text-wood-600" x-text="category.name"></span>
                            </label>
                        </template>
                    </div>
                </div>

                <!-- Price Range -->
                <div>
                    <h3 class="text-lg font-medium text-wood-900 mb-4">Price Range</h3>
                    <div class="px-2">
                        <div class="relative">
                            <div class="h-2 bg-wood-200 rounded-full">
                                <div 
                                    class="absolute h-2 bg-wood-600 rounded-full"
                                    :style="`left: ${priceRange[0]}%; right: ${100 - priceRange[1]}%`"
                                ></div>
                            </div>
                            <input 
                                type="range"
                                x-model="priceRange[0]"
                                min="0"
                                max="1000"
                                step="10"
                                name="min_price"
                                class="absolute w-full h-2 opacity-0 cursor-pointer"
                            >
                            <input 
                                type="range"
                                x-model="priceRange[1]"
                                min="0"
                                max="1000"
                                step="10"
                                name="max_price"
                                class="absolute w-full h-2 opacity-0 cursor-pointer"
                            >
                        </div>
                        <div class="flex justify-between mt-2 text-sm text-wood-600">
                            <span>$<span x-text="priceRange[0]"></span></span>
                            <span>$<span x-text="priceRange[1]"></span></span>
                        </div>
                    </div>
                </div>

                <!-- Features -->
                <div>
                    <h3 class="text-lg font-medium text-wood-900 mb-4">Features</h3>
                    <div class="space-y-2">
                        <template x-for="feature in features" :key="feature.id">
                            <label class="flex items-center">
                                <input 
                                    type="checkbox"
                                    :value="feature.id"
                                    x-model="selectedFeatures"
                                    name="features[]"
                                    class="rounded border-wood-300 text-wood-600 focus:ring-wood-500"
                                >
                                <span class="ml-2 text-wood-600" x-text="feature.name"></span>
                            </label>
                        </template>
                    </div>
                </div>

                <!-- Sort -->
                <div>
                    <h3 class="text-lg font-medium text-wood-900 mb-4">Sort By</h3>
                    <select 
                        name="sort"
                        class="w-full rounded-lg border-wood-300 shadow-sm focus:border-wood-500 focus:ring-wood-500"
                    >
                        <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                        <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                    </select>
                </div>

                <!-- Active Filters -->
                <div x-show="selectedCategories.length > 0 || selectedFeatures.length > 0 || priceRange[0] > 0 || priceRange[1] < 1000">
                    <h3 class="text-lg font-medium text-wood-900 mb-4">Active Filters</h3>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="categoryId in selectedCategories" :key="'cat-' + categoryId">
                            <div class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-wood-100 text-wood-800">
                                <span x-text="categories.find(c => c.id === categoryId).name"></span>
                                <button 
                                    @click="selectedCategories = selectedCategories.filter(id => id !== categoryId)"
                                    class="ml-2 text-wood-600 hover:text-wood-900"
                                >
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </template>
                        <template x-for="featureId in selectedFeatures" :key="'feat-' + featureId">
                            <div class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-wood-100 text-wood-800">
                                <span x-text="features.find(f => f.id === featureId).name"></span>
                                <button 
                                    @click="selectedFeatures = selectedFeatures.filter(id => id !== featureId)"
                                    class="ml-2 text-wood-600 hover:text-wood-900"
                                >
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </template>
                        <template x-if="priceRange[0] > 0 || priceRange[1] < 1000">
                            <div class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-wood-100 text-wood-800">
                                <span>$<span x-text="priceRange[0]"></span> - $<span x-text="priceRange[1]"></span></span>
                                <button 
                                    @click="priceRange = [0, 1000]"
                                    class="ml-2 text-wood-600 hover:text-wood-900"
                                >
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Product Grid -->
        <div class="mt-6 lg:mt-0 lg:col-span-9">
            <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
                @foreach($products as $product)
                    <div class="group relative">
                        <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-wood-100">
                            <img 
                                src="{{ $product->image_url }}" 
                                alt="{{ $product->name }}"
                                class="h-full w-full object-cover object-center group-hover:opacity-75"
                            >
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300"></div>
                            <button 
                                @click="quickView = {{ $product->id }}"
                                class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                            >
                                <span class="bg-white bg-opacity-90 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium text-wood-900">
                                    Quick View
                                </span>
                            </button>
                        </div>
                        <div class="mt-4 flex justify-between">
                            <div>
                                <h3 class="text-sm text-wood-700">
                                    <a href="{{ route('products.show', $product) }}">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <p class="mt-1 text-sm text-wood-500">{{ $product->category->name }}</p>
                            </div>
                            <p class="text-sm font-medium text-wood-900">${{ number_format($product->price, 2) }}</p>
                        </div>
                        <div class="mt-4">
                            <button 
                                @click="addToCart({{ $product->id }})"
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
                {{ $products->links() }}
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
                                :src="products.find(p => p.id === quickView).image_url"
                                :alt="products.find(p => p.id === quickView).name"
                                class="w-full h-64 object-cover rounded-lg"
                            >
                            <h3 class="mt-4 text-lg font-medium text-wood-900" x-text="products.find(p => p.id === quickView).name"></h3>
                            <p class="mt-1 text-sm text-wood-500" x-text="products.find(p => p.id === quickView).category.name"></p>
                            <p class="mt-2 text-lg font-medium text-wood-900">$<span x-text="products.find(p => p.id === quickView).price"></span></p>
                            <p class="mt-2 text-sm text-wood-600" x-text="products.find(p => p.id === quickView).description"></p>
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