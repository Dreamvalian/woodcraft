@extends('layouts.app')

@section('content')
    {{-- {{ dd($product) }} --}}
    <div class="bg-white font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Shop Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                <!-- Image Gallery -->
                <div x-data="{
                        activeImage: '{{ $product->image_url }}',
                        images: [
                            '{{ $product->image_url }}',
                            {{-- @foreach($product->images as $image)
                                '{{ $image->url }}',
                            @endforeach --}}
                        ],
                        zoom: false,
                        zoomX: 0,
                        zoomY: 0
                    }" class="space-y-6">
                    <!-- Main Image -->
                    <div class="relative aspect-square rounded-lg overflow-hidden bg-gray-50">
                        <img :src="activeImage" :alt="$product->name" class="w-full h-full object-cover"
                            @mousemove="zoom = true; zoomX = $event.offsetX / $event.target.offsetWidth * 100; zoomY = $event.offsetY / $event.target.offsetHeight * 100"
                            @mouseleave="zoom = false">
                        <!-- Zoom Overlay -->
                        <div x-show="zoom" class="absolute inset-0 bg-gray-100 opacity-50"
                            :style="`background-image: url(${activeImage}); background-position: ${zoomX}% ${zoomY}%; background-size: 200%;`">
                        </div>
                    </div>

                    <!-- Thumbnail Gallery -->
                    <div class="grid grid-cols-4 gap-4">
                        <template x-for="(image, index) in images" :key="index">
                            <button @click="activeImage = image"
                                class="aspect-square rounded-lg overflow-hidden bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-900"
                                :class="{ 'ring-2 ring-gray-900': activeImage === image }">
                                <img :src="image" :alt="$product->name" class="w-full h-full object-cover">
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Shop Details -->
                <div class="space-y-8">
                    <div>
                        <h1 class="text-3xl font-medium text-gray-900">{{ $product->name }}</h1>
                        <p class="mt-3 text-2xl text-gray-600">{{ $product->formatted_price }}</p>
                    </div>

                    <div class="prose prose-gray max-w-none">
                        <p class="text-gray-600">{{ $product->description }}</p>
                    </div>

                    <div class="border-t border-gray-200 pt-8">
                        <dl class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-900">Material</dt>
                                <dd class="mt-1 text-sm text-gray-600">{{ $product->material }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-900">Dimensions</dt>
                                <dd class="mt-1 text-sm text-gray-600">{{ $product->dimensions }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-900">Weight</dt>
                                <dd class="mt-1 text-sm text-gray-600">{{ $product->weight }} kg</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-900">Availability</dt>
                                <dd class="mt-1 text-sm">
                                    @if($product->stock > 0)
                                        <span class="text-green-600">In Stock ({{ $product->stock }} available)</span>
                                    @else
                                        <span class="text-red-600">Out of Stock</span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Add to Cart -->
                    <div class="mt-8">
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center border border-gray-200 rounded-lg">
                                    <button type="button" @click="quantity = Math.max(1, quantity - 1)"
                                        class="px-3 py-2 text-gray-600 hover:text-gray-900 transition-colors duration-200">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" name="quantity" x-model.number="quantity" min="1"
                                        max="{{ $product->stock }}" value="1"
                                        class="w-16 text-center border-0 focus:ring-0 text-sm">
                                    <button type="button" @click="quantity = Math.min({{ $product->stock }}, quantity + 1)"
                                        class="px-3 py-2 text-gray-600 hover:text-gray-900 transition-colors duration-200">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <span class="text-sm text-gray-600">
                                    {{ $product->stock }} available
                                </span>
                            </div>

                            <button type="submit"
                                class="w-full bg-gray-900 text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition-colors duration-200 text-sm font-medium"
                                :class="{ 'opacity-50 cursor-not-allowed': loading }"
                                :disabled="loading || {{ $product->stock === 0 ? 'true' : 'false' }}">
                                <span x-show="!loading">Add to Cart</span>
                                <span x-show="loading" class="flex items-center justify-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Adding...
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Related Shops -->
            @if($relatedProducts->isNotEmpty())
                <div class="mt-20">
                    <h2 class="text-2xl font-medium text-gray-900 mb-8">Related Items</h2>
                    <div class="grid grid-cols-1 gap-y-12 gap-x-6 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach($relatedProducts as $relatedProduct)
                            <div class="group">
                                <a href="{{ route('shops.show', $relatedProduct) }}"
                                    class="block relative overflow-hidden rounded-lg bg-gray-50">
                                    <img src="{{ $relatedProduct->image_url }}" alt="{{ $relatedProduct->name }}"
                                        class="w-full aspect-square object-cover transform transition-transform duration-500 group-hover:scale-105">
                                </a>
                                <div class="mt-4 space-y-2">
                                    <a href="{{ route('shops.show', $relatedProduct) }}"
                                        class="text-base font-medium text-gray-900 hover:text-gray-600 transition-colors duration-200">
                                        {{ $relatedProduct->name }}
                                    </a>
                                    <p class="text-gray-600">{{ $relatedProduct->formatted_price }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection