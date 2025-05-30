@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-8">
        {{-- Filters Sidebar --}}
        <div class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-lg font-semibold mb-4">Filters</h2>
                
                {{-- Search Form --}}
                <form action="{{ route('search') }}" method="GET" class="space-y-4">
                    <div>
                        <label for="q" class="block text-sm font-medium text-gray-700">Search</label>
                        <input type="text" 
                               name="q" 
                               id="q"
                               value="{{ $query }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-wood focus:ring-wood sm:text-sm"
                               placeholder="Search products...">
                    </div>

                    {{-- Price Range --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Price Range</label>
                        <div class="mt-1 grid grid-cols-2 gap-2">
                            <input type="number" 
                                   name="min_price" 
                                   value="{{ $minPrice }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-wood focus:ring-wood sm:text-sm"
                                   placeholder="Min">
                            <input type="number" 
                                   name="max_price" 
                                   value="{{ $maxPrice }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-wood focus:ring-wood sm:text-sm"
                                   placeholder="Max">
                        </div>
                    </div>

                    {{-- Sort By --}}
                    <div>
                        <label for="sort_by" class="block text-sm font-medium text-gray-700">Sort By</label>
                        <select name="sort_by" 
                                id="sort_by"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-wood focus:ring-wood sm:text-sm">
                            <option value="newest" {{ $sortBy === 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="price_asc" {{ $sortBy === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ $sortBy === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name_asc" {{ $sortBy === 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                            <option value="name_desc" {{ $sortBy === 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                        </select>
                    </div>

                    <button type="submit" 
                            class="w-full bg-wood text-white px-4 py-2 rounded-md hover:bg-wood-dark transition">
                        Apply Filters
                    </button>
                </form>
            </div>
        </div>

        {{-- Search Results --}}
        <div class="flex-1">
            <div class="mb-4">
                <h1 class="text-2xl font-semibold">
                    @if($query)
                        Search Results for "{{ $query }}"
                    @else
                        All Products
                    @endif
                </h1>
                <p class="text-gray-600">
                    {{ $products->total() }} results found
                </p>
            </div>

            @if($products->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500">No products found matching your criteria.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <a href="{{ route('products.show', $product->slug) }}" class="block relative">
                                <img src="{{ $product->images->first()->url }}" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-48 object-cover">
                            </a>
                            <div class="p-4">
                                <h3 class="text-lg font-medium">
                                    <a href="{{ route('products.show', $product->slug) }}" 
                                       class="text-gray-900 hover:text-wood">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <p class="mt-1 text-gray-500 text-sm">
                                    {{ Str::limit($product->description, 100) }}
                                </p>
                                <div class="mt-4 flex items-center justify-between">
                                    <span class="text-lg font-medium text-gray-900">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                    <form action="{{ route('cart.add', $product) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="bg-wood text-white px-4 py-2 rounded-md hover:bg-wood-dark transition">
                                            Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 