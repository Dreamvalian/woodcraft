@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <nav class="flex mb-12" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-2">
      <li class="inline-flex items-center">
      <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700 transition-colors duration-200">
        <i class="fas fa-home mr-2"></i>
        Home
      </a>
      </li>
      <li>
      <div class="flex items-center">
        <i class="fas fa-chevron-right text-gray-400 mx-2 text-sm"></i>
        <span class="text-gray-900">Search Results</span>
      </div>
      </li>
    </ol>
    </nav>

    <div class="lg:grid lg:grid-cols-12 lg:gap-x-12">
    <!-- Filters -->
    <aside class="hidden lg:block lg:col-span-3">
      <form action="{{ route('search') }}" method="GET" x-data="{
      priceRange: [{{ $minPrice ?? 0 }}, {{ $maxPrice ?? 1000 }}],
      submitForm() {
      this.$el.submit();
      }
      }" class="space-y-8">
      <!-- Search -->
      <div class="flex">
        <input type="text" name="q" placeholder="Search our shops..."
        class="flex-1 min-w-0 block w-full px-4 py-1 rounded-l-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-wood focus:border-transparent"
        value="{{ $query }}">
        <x-button type="submit" class="rounded-l-none">
        <i class="fas fa-search"></i>
        </x-button>
      </div>

      <!-- Sort Dropdown -->
      <div class="relative">
        <select name="sort_by"
        class="w-full rounded-lg border-gray-200 text-sm focus:border-gray-300 focus:ring-0 appearance-none pl-10">
        <option value="newest" {{ $sortBy === 'newest' ? 'selected' : '' }}>Newest</option>
        <option value="price_asc" {{ $sortBy === 'price_asc' ? 'selected' : '' }}>Price: Low to High
        </option>
        <option value="price_desc" {{ $sortBy === 'price_desc' ? 'selected' : '' }}>Price: High to Low
        </option>
        <option value="name_asc" {{ $sortBy === 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
        <option value="name_desc" {{ $sortBy === 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
        </select>
        <i class="fas fa-sort absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs"></i>
      </div>

      <!-- Price Range -->
      <div class="bg-gray-50 rounded-lg p-4">
        <h3 class="text-sm font-medium text-gray-900 mb-4">Price Range</h3>
        <div class="grid grid-cols-2 gap-4">
        <div>
          <label for="min_price" class="block text-xs text-gray-500 mb-1">Min Price</label>
          <input type="number" name="min_price" id="min_price" value="{{ $minPrice }}"
          class="w-full rounded-lg border-gray-200 text-sm focus:border-gray-300 focus:ring-0" placeholder="0">
        </div>
        <div>
          <label for="max_price" class="block text-xs text-gray-500 mb-1">Max Price</label>
          <input type="number" name="max_price" id="max_price" value="{{ $maxPrice }}"
          class="w-full rounded-lg border-gray-200 text-sm focus:border-gray-300 focus:ring-0" placeholder="1000">
        </div>
        </div>
      </div>

      <!-- Apply Filters Button -->
      <x-button type="submit" class="w-full justify-center">
        Apply Filters
      </x-button>

      <!-- Clear Filters -->
      @if(request()->hasAny(['q', 'min_price', 'max_price', 'sort_by']))
      <a href="{{ route('search') }}"
      class="block text-center text-sm text-gray-600 hover:text-gray-900 transition-colors duration-200">
      Clear all filters
      </a>
    @endif
      </form>
    </aside>

    <!-- Product Grid -->
    <div class="mt-8 lg:mt-0 lg:col-span-9">
      <!-- Results Count -->
      <div class="mb-8">
      <h1 class="text-2xl font-medium text-gray-900">
        @if($query)
      Search Results for "{{ $query }}"
      @else
      All Products
      @endif
      </h1>
      <p class="text-sm text-gray-600">
        Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of
        {{ $products->total() }} results
      </p>
      </div>

      <!-- Products Grid -->
      <div class="grid grid-cols-1 gap-y-12 gap-x-6 sm:grid-cols-2 lg:grid-cols-3">
      @forelse($products as $product)
      <div class="group">
      <a href="{{ route('products.show', $product->slug) }}"
      class="block relative overflow-hidden rounded-lg bg-gray-50">
      <img src="{{ $product->images->first()->url }}" alt="{{ $product->name }}"
        class="w-full aspect-square object-cover transform transition-transform duration-500 group-hover:scale-105">
      </a>
      <div class="mt-4 space-y-2">
      <a href="{{ route('products.show', $product->slug) }}"
        class="text-base font-medium text-gray-900 hover:text-gray-600 transition-colors duration-200">
        {{ $product->name }}
      </a>
      <p class="text-gray-600">${{ number_format($product->price, 2) }}</p>
      </div>
      <div class="mt-4">
      <form action="{{ route('cart.add', $product) }}" method="POST">
        @csrf
        <x-button type="submit" class="w-full justify-center">
        Add to Cart
        </x-button>
      </form>
      </div>
      </div>
    @empty
      <div class="col-span-full text-center py-12">
      <i class="fas fa-search text-gray-400 text-4xl mb-4"></i>
      <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
      <p class="text-gray-600">Try adjusting your search or filter criteria</p>
      </div>
    @endforelse
      </div>

      <!-- Pagination -->
      <div class="mt-12">
      {{ $products->links() }}
      </div>
    </div>
    </div>
  </div>
@endsection