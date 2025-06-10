@extends('layouts.app')

@section('content')
<div class="bg-white font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Shop Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Image Gallery -->
            <div x-data="{
                activeImage: '{{ $shop->image_url }}',
                images: [
                    '{{ $shop->image_url }}',
                    @foreach($shop->images as $image)
                        '{{ $image->url }}',
                    @endforeach
                ],
                zoom: false,
                zoomX: 0,
                zoomY: 0
            }" class="space-y-4">
                <!-- Main Image -->
                <div class="relative aspect-square rounded-lg overflow-hidden bg-wood-50">
                    <img
                        :src="activeImage"
                        :alt="$shop->name"
                        class="w-full h-full object-cover"
                        @mousemove="zoom = true; zoomX = $event.offsetX / $event.target.offsetWidth * 100; zoomY = $event.offsetY / $event.target.offsetHeight * 100"
                        @mouseleave="zoom = false"
                    >
                    <!-- Zoom Overlay -->
                    <div
                        x-show="zoom"
                        class="absolute inset-0 bg-wood-100 opacity-50"
                        :style="`background-image: url(${activeImage}); background-position: ${zoomX}% ${zoomY}%; background-size: 200%;`"
                    ></div>
                </div>

                <!-- Thumbnail Gallery -->
                <div class="grid grid-cols-4 gap-4">
                    <template x-for="(image, index) in images" :key="index">
                        <button
                            @click="activeImage = image"
                            class="aspect-square rounded-lg overflow-hidden bg-wood-50 focus:outline-none focus:ring-2 focus:ring-wood-500"
                            :class="{ 'ring-2 ring-wood-500': activeImage === image }"
                        >
                            <img :src="image" :alt="$shop->name" class="w-full h-full object-cover">
                        </button>
                    </template>
                </div>
            </div>

            <!-- Shop Details -->
            <div class="space-y-8">
                <div>
                    <h1 class="text-3xl font-bold text-wood-900">{{ $shop->name }}</h1>
                    <p class="mt-2 text-2xl text-wood-600">{{ $shop->formatted_price }}</p>
                </div>

                <div class="prose prose-wood max-w-none">
                    <p>{{ $shop->description }}</p>
                </div>

                <div class="border-t border-wood-200 pt-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-wood-500">Material</dt>
                            <dd class="mt-1 text-sm text-wood-900">{{ $shop->material }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-wood-500">Dimensions</dt>
                            <dd class="mt-1 text-sm text-wood-900">{{ $shop->dimensions }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-wood-500">Weight</dt>
                            <dd class="mt-1 text-sm text-wood-900">{{ $shop->weight }} kg</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-wood-500">Availability</dt>
                            <dd class="mt-1 text-sm text-wood-900">
                                @if($shop->stock > 0)
                                    <span class="text-green-600">In Stock ({{ $shop->stock }} available)</span>
                                @else
                                    <span class="text-red-600">Out of Stock</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Add to Cart -->
                <div class="mt-8">
                    <form action="{{ route('cart.add') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center border border-wood-200 rounded-lg">
                                <button 
                                    type="button"
                                    @click="quantity = Math.max(1, quantity - 1)"
                                    class="px-3 py-2 text-wood-600 hover:text-wood-700"
                                >
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input 
                                    type="number" 
                                    name="quantity"
                                    x-model.number="quantity"
                                    min="1"
                                    max="{{ $shop->stock }}"
                                    value="1"
                                    class="w-16 text-center border-0 focus:ring-0"
                                >
                                <button 
                                    type="button"
                                    @click="quantity = Math.min({{ $shop->stock }}, quantity + 1)"
                                    class="px-3 py-2 text-wood-600 hover:text-wood-700"
                                >
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <span class="text-sm text-wood-600">
                                {{ $shop->stock }} available
                            </span>
                        </div>

                        <button 
                            type="submit"
                            class="w-full bg-wood-600 text-white px-6 py-3 rounded-lg hover:bg-wood-700 transition-colors duration-200"
                            :class="{ 'opacity-50 cursor-not-allowed': loading }"
                            :disabled="loading || {{ $shop->stock === 0 ? 'true' : 'false' }}"
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
                    </form>
                </div>
            </div>
        </div>

        <!-- Related Shops -->
        @if($relatedShops->isNotEmpty())
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-wood-900 mb-8">Related Items</h2>
                <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($relatedShops as $relatedShop)
                        <div class="group relative">
                            <a href="{{ route('shops.show', $relatedShop) }}" class="block relative overflow-hidden">
                                <img src="{{ $relatedShop->image_url }}" alt="{{ $relatedShop->name }}" 
                                     class="w-full h-48 object-cover transform transition-transform duration-500 group-hover:scale-110">
                            </a>
                            <div class="p-4">
                                <a href="{{ route('shops.show', $relatedShop) }}" 
                                   class="text-lg font-light text-[#2C3E50] hover:text-[#E67E22] transition">
                                    {{ $relatedShop->name }}
                                </a>
                                <p class="text-[#E67E22] font-light mt-1">{{ $relatedShop->formatted_price }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 