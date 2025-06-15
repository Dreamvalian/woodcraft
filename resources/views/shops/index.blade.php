@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-white">
        <!-- Hero Section -->
        <div class="relative bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="text-center">
                    <h1 class="text-4xl font-light text-gray-900 mb-4">Handcrafted Wooden Products</h1>
                    <p class="text-lg text-gray-500 max-w-2xl mx-auto">Discover our collection of meticulously crafted
                        wooden pieces, each telling its own unique story.</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Search -->
            <div class="mb-12">
                <form action="{{ route('shops.index') }}" method="GET" class="max-w-xl mx-auto">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search our collection..."
                            class="w-full pl-10 pr-4 py-3 text-sm border-0 bg-gray-50 rounded-lg focus:ring-2 focus:ring-gray-200">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($products as $product)
                    <div class="group">
                        <a href="{{ route('shops.show', $product->slug) }}" class="block">
                            <div class="relative aspect-square mb-4 overflow-hidden rounded-lg bg-gray-50">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110">
                                @if($product->sale_price)
                                    <div
                                        class="absolute top-4 right-4 bg-white text-gray-900 px-3 py-1 text-xs font-medium rounded-full shadow-sm">
                                        Sale
                                    </div>
                                @endif
                                @if($product->stock <= 0)
                                    <div class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
                                        <span class="text-sm font-medium text-gray-900">Out of Stock</span>
                                    </div>
                                @endif
                            </div>
                            <div class="space-y-2">
                                <h3
                                    class="text-sm font-medium text-gray-900 group-hover:text-gray-600 transition-colors duration-200">
                                    {{ $product->name }}
                                </h3>
                                <div class="flex items-center space-x-2">
                                    @if($product->sale_price)
                                        <span class="text-sm font-medium text-gray-900">
                                            {{ $product->formatted_sale_price }}
                                        </span>
                                        <span class="text-sm text-gray-400 line-through">
                                            {{ $product->formatted_price }}
                                        </span>
                                    @else
                                        <span class="text-sm font-medium text-gray-900">
                                            {{ $product->formatted_price }}
                                        </span>
                                    @endif
                                </div>
                                @if($product->stock > 0)
                                    <p class="text-xs text-gray-500">
                                        {{ $product->stock }} in stock
                                    </p>
                                @endif
                            </div>
                        </a>
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-4">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit"
                                    class="w-full bg-gray-900 text-white px-4 py-2.5 rounded-lg hover:bg-gray-800 transition-colors duration-200 text-sm font-medium flex items-center justify-center space-x-2">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span>Add to Cart</span>
                                </button>
                            </form>
                        @else
                            <button type="button" disabled
                                class="w-full mt-4 bg-gray-200 text-gray-500 px-4 py-2.5 rounded-lg cursor-not-allowed text-sm font-medium flex items-center justify-center space-x-2">
                                <i class="fas fa-ban"></i>
                                <span>Out of Stock</span>
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="mt-12">
                    {{ $products->links() }}
                </div>
            @endif

            <!-- Empty State -->
            @if($products->isEmpty())
                <div class="text-center py-16">
                    <div class="w-16 h-16 mx-auto mb-4 text-gray-300">
                        <i class="fas fa-box-open text-4xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                    <p class="text-sm text-gray-500 mb-6">Try adjusting your search criteria</p>
                    <a href="{{ route('shops.index') }}"
                        class="inline-block px-6 py-3 text-sm text-white bg-gray-900 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                        Clear Search
                    </a>
                </div>
            @endif
        </div>
    </div>

    @push('styles')
        <style>
            /* Custom scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }

            ::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            ::-webkit-scrollbar-thumb {
                background: #888;
                border-radius: 4px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #555;
            }
        </style>
    @endpush
@endsection