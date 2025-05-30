@extends('layouts.app')

@section('title', 'Product Categories')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-semibold mb-8">Product Categories</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $category)
            <a href="{{ route('category', $category->slug) }}" 
               class="group block bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition">
                <div class="relative aspect-w-16 aspect-h-9">
                    <img src="{{ $category->image_url }}" 
                         alt="{{ $category->name }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    <div class="absolute inset-0 bg-black bg-opacity-40 group-hover:bg-opacity-30 transition"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <h2 class="text-2xl font-semibold text-white">{{ $category->name }}</h2>
                    </div>
                </div>
                <div class="p-4">
                    <p class="text-gray-600">
                        {{ $category->products_count }} products
                    </p>
                    <p class="mt-2 text-gray-500">
                        {{ Str::limit($category->description, 100) }}
                    </p>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection 