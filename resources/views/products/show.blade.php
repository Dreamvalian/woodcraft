@extends('layouts.app')

@section('content')
<div class="bg-white font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="text-wood-600 hover:text-wood-700">
                        <i class="fas fa-home mr-2"></i>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-wood-400 mx-2"></i>
                        <a href="{{ route('categories.show', $product->category) }}" class="text-wood-600 hover:text-wood-700">
                            {{ $product->category->name }}
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-wood-400 mx-2"></i>
                        <span class="text-wood-800">{{ $product->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Product Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Image Gallery -->
            <div x-data="{ 
                activeImage: '{{ $product->image_url }}',
                images: [
                    '{{ $product->image_url }}',
                    @foreach($product->images as $image)
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
                        :alt="$product->name"
                        class="w-full h-full object-cover"
                        @mousemove="zoom = true; zoomX = $event.offsetX / $event.target.offsetWidth * 100; zoomY = $event.offsetY / $event.target.offsetHeight * 100"
                        @mouseleave="zoom = false"
                    >
                    <!-- Zoom Overlay -->
                    <div 
                        x-show="zoom"
                        class="absolute inset-0 pointer-events-none"
                        :style="'background-image: url(' + activeImage + '); background-size: 200%; background-position: ' + zoomX + '% ' + zoomY + '%;'"
                    ></div>
                </div>

                <!-- Thumbnails -->
                <div class="grid grid-cols-5 gap-4">
                    <template x-for="(image, index) in images" :key="index">
                        <button 
                            @click="activeImage = image"
                            class="aspect-square rounded-lg overflow-hidden bg-wood-50 focus:outline-none focus:ring-2 focus:ring-wood-500"
                            :class="{ 'ring-2 ring-wood-500': activeImage === image }"
                        >
                            <img :src="image" :alt="$product->name" class="w-full h-full object-cover">
                        </button>
                    </template>
                </div>
            </div>

            <!-- Product Info -->
            <div class="space-y-8">
                <!-- Title and Rating -->
                <div>
                    <h1 class="text-3xl font-medium text-wood-900 mb-2">{{ $product->name }}</h1>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $product->average_rating ? 'text-yellow-400' : 'text-wood-200' }}"></i>
                            @endfor
                            <span class="ml-2 text-wood-600">({{ $product->total_reviews }} reviews)</span>
                        </div>
                        <span class="text-wood-500">SKU: {{ $product->sku }}</span>
                    </div>
                </div>

                <!-- Price -->
                <div class="space-y-2">
                    @if($product->is_on_sale)
                        <div class="flex items-center space-x-4">
                            <span class="text-3xl font-medium text-wood-900">{{ $product->formatted_sale_price }}</span>
                            <span class="text-xl text-wood-500 line-through">{{ $product->formatted_price }}</span>
                            <span class="px-2 py-1 text-sm font-medium text-white bg-red-500 rounded-full">
                                -{{ $product->discount_percentage }}%
                            </span>
                        </div>
                    @else
                        <span class="text-3xl font-medium text-wood-900">{{ $product->formatted_price }}</span>
                    @endif
                </div>

                <!-- Description -->
                <div class="prose prose-wood max-w-none">
                    {!! $product->description !!}
                </div>

                <!-- Product Options -->
                @if($product->features)
                    <div x-data="{ selectedOptions: {} }" class="space-y-6">
                        @foreach($product->features as $key => $options)
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-wood-700">
                                    {{ ucfirst($key) }}
                                </label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($options as $option)
                                        <button 
                                            @click="selectedOptions['{{ $key }}'] = '{{ $option }}'"
                                            class="px-4 py-2 border rounded-lg text-sm font-medium transition-colors duration-200"
                                            :class="selectedOptions['{{ $key }}'] === '{{ $option }}' 
                                                ? 'border-wood-500 bg-wood-50 text-wood-700' 
                                                : 'border-wood-200 text-wood-600 hover:border-wood-300'"
                                        >
                                            {{ $option }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Add to Cart -->
                <div x-data="{ 
                    quantity: 1,
                    loading: false,
                    addToCart() {
                        this.loading = true;
                        // Add to cart logic here
                        setTimeout(() => {
                            this.loading = false;
                            window.dispatchEvent(new CustomEvent('notify', {
                                detail: { 
                                    message: 'Product added to cart successfully!',
                                    type: 'success'
                                }
                            }));
                        }, 1000);
                    }
                }" class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center border border-wood-200 rounded-lg">
                            <button 
                                @click="quantity = Math.max(1, quantity - 1)"
                                class="px-3 py-2 text-wood-600 hover:text-wood-700"
                            >
                                <i class="fas fa-minus"></i>
                            </button>
                            <input 
                                type="number" 
                                x-model.number="quantity"
                                min="1"
                                class="w-16 text-center border-0 focus:ring-0"
                            >
                            <button 
                                @click="quantity = Math.min({{ $product->stock }}, quantity + 1)"
                                class="px-3 py-2 text-wood-600 hover:text-wood-700"
                            >
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <span class="text-sm text-wood-600">
                            {{ $product->stock }} available
                        </span>
                    </div>

                    <button 
                        @click="addToCart"
                        :disabled="loading"
                        class="w-full flex items-center justify-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-wood-600 hover:bg-wood-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-wood-500 transition-colors duration-200"
                    >
                        <i class="fas fa-shopping-cart mr-2"></i>
                        <span x-text="loading ? 'Adding...' : 'Add to Cart'"></span>
                    </button>
                </div>

                <!-- Additional Info -->
                <div class="border-t border-wood-200 pt-6 space-y-4">
                    <div class="flex items-center text-sm text-wood-600">
                        <i class="fas fa-truck mr-2"></i>
                        Free shipping on orders over Rp 1.000.000
                    </div>
                    <div class="flex items-center text-sm text-wood-600">
                        <i class="fas fa-undo mr-2"></i>
                        30-day return policy
                    </div>
                    <div class="flex items-center text-sm text-wood-600">
                        <i class="fas fa-shield-alt mr-2"></i>
                        2-year warranty
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details Tabs -->
        <div x-data="{ activeTab: 'description' }" class="mt-16">
            <div class="border-b border-wood-200">
                <nav class="-mb-px flex space-x-8">
                    <button 
                        @click="activeTab = 'description'"
                        :class="{ 'border-wood-500 text-wood-600': activeTab === 'description' }"
                        class="border-transparent text-wood-500 hover:text-wood-700 hover:border-wood-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                    >
                        Description
                    </button>
                    <button 
                        @click="activeTab = 'specifications'"
                        :class="{ 'border-wood-500 text-wood-600': activeTab === 'specifications' }"
                        class="border-transparent text-wood-500 hover:text-wood-700 hover:border-wood-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                    >
                        Specifications
                    </button>
                    <button 
                        @click="activeTab = 'reviews'"
                        :class="{ 'border-wood-500 text-wood-600': activeTab === 'reviews' }"
                        class="border-transparent text-wood-500 hover:text-wood-700 hover:border-wood-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                    >
                        Reviews ({{ $product->total_reviews }})
                    </button>
                </nav>
            </div>

            <div class="py-8">
                <!-- Description Tab -->
                <div x-show="activeTab === 'description'" class="prose prose-wood max-w-none">
                    {!! $product->description !!}
                </div>

                <!-- Specifications Tab -->
                <div x-show="activeTab === 'specifications'" class="space-y-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-wood-500">Material</dt>
                            <dd class="mt-1 text-sm text-wood-900">{{ $product->material }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-wood-500">Dimensions</dt>
                            <dd class="mt-1 text-sm text-wood-900">
                                {{ $product->dimensions['length'] ?? 'N/A' }} x 
                                {{ $product->dimensions['width'] ?? 'N/A' }} x 
                                {{ $product->dimensions['height'] ?? 'N/A' }} cm
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-wood-500">Weight</dt>
                            <dd class="mt-1 text-sm text-wood-900">{{ $product->weight }} kg</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-wood-500">Care Instructions</dt>
                            <dd class="mt-1 text-sm text-wood-900">{{ $product->care_instructions }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Reviews Tab -->
                <div x-show="activeTab === 'reviews'" class="space-y-8">
                    <!-- Review Form -->
                    @auth
                        <form action="{{ route('products.reviews.store', $product) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-wood-700">Rating</label>
                                <div class="flex items-center space-x-2 mt-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button" class="text-wood-300 hover:text-yellow-400">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    @endfor
                                </div>
                            </div>
                            <div>
                                <label for="comment" class="block text-sm font-medium text-wood-700">Review</label>
                                <textarea 
                                    id="comment" 
                                    name="comment" 
                                    rows="4" 
                                    class="mt-1 block w-full rounded-lg border-wood-300 shadow-sm focus:border-wood-500 focus:ring-wood-500"
                                ></textarea>
                            </div>
                            <button type="submit" class="px-4 py-2 bg-wood-600 text-white rounded-lg hover:bg-wood-700">
                                Submit Review
                            </button>
                        </form>
                    @else
                        <p class="text-wood-600">
                            Please <a href="{{ route('login') }}" class="text-wood-600 hover:text-wood-700">login</a> to write a review.
                        </p>
                    @endauth

                    <!-- Reviews List -->
                    <div class="space-y-8">
                        @foreach($product->reviews as $review)
                            <div class="border-b border-wood-200 pb-8">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-wood-900">{{ $review->user->name }}</h4>
                                        <div class="flex items-center mt-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-wood-200' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <span class="text-sm text-wood-500">
                                        {{ $review->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="mt-4 text-wood-600">{{ $review->comment }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <div class="mt-16">
            <h2 class="text-2xl font-medium text-wood-900 mb-8">Related Products</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="group">
                        <div class="relative aspect-square rounded-lg overflow-hidden bg-wood-50">
                            <img 
                                src="{{ $relatedProduct->image_url }}" 
                                alt="{{ $relatedProduct->name }}"
                                class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-105"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="absolute bottom-4 left-4 right-4">
                                    <a href="{{ route('products.show', $relatedProduct) }}" 
                                       class="text-white text-sm font-medium bg-wood-500/90 px-4 py-2 rounded-full inline-block">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-sm font-medium text-wood-900">
                                <a href="{{ route('products.show', $relatedProduct) }}">
                                    {{ $relatedProduct->name }}
                                </a>
                            </h3>
                            <p class="mt-1 text-sm text-wood-500">{{ $relatedProduct->formatted_price }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection 