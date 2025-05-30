@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Category Header --}}
    <div class="mb-8">
        <div class="relative h-64 rounded-lg overflow-hidden">
            <img src="{{ $category->image_url }}" 
                 alt="{{ $category->name }}"
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-40"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <h1 class="text-4xl font-bold text-white">{{ $category->name }}</h1>
            </div>
        </div>
        @if($category->description)
            <p class="mt-4 text-gray-600 text-center max-w-3xl mx-auto">
                {{ $category->description }}
            </p>
        @endif
    </div>

    {{-- Products Grid --}}
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
</div>
@endsection 