@extends('layouts.app')

@section('content')
<div class="bg-[#f8f6f3] min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-[#7f8c8d] hover:text-[#E67E22]">Home</a></li>
                <li class="text-[#7f8c8d]">/</li>
                <li><a href="{{ route('products.index') }}" class="text-[#7f8c8d] hover:text-[#E67E22]">Products</a></li>
                <li class="text-[#7f8c8d]">/</li>
                <li class="text-[#2C3E50]">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6">
                <!-- Product Images -->
                <div class="space-y-4">
                    <div class="relative aspect-square rounded-lg overflow-hidden">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                             id="mainImage"
                             class="w-full h-full object-cover">
                        @if($product->sale_price)
                            <div class="absolute top-4 right-4 bg-[#E67E22] text-white px-3 py-1 rounded-full text-sm font-medium">
                                Sale
                            </div>
                        @endif
                        <button onclick="toggleZoom()" class="absolute bottom-4 right-4 bg-white p-2 rounded-full shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#2C3E50]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m4-3H6" />
                            </svg>
                        </button>
                    </div>
                    @if($product->images && $product->images->count() > 0)
                        <div class="grid grid-cols-4 gap-2">
                            <div class="aspect-square rounded-lg overflow-hidden cursor-pointer border-2 border-[#E67E22]">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                     onclick="changeMainImage(this.src)"
                                     class="w-full h-full object-cover">
                            </div>
                            @foreach($product->images as $image)
                                <div class="aspect-square rounded-lg overflow-hidden cursor-pointer hover:opacity-75 transition"
                                     onclick="changeMainImage('{{ $image->image_url }}')">
                                    <img src="{{ $image->image_url }}" alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="space-y-6">
                    <div>
                        <h1 class="text-3xl font-bold text-[#2C3E50]">{{ $product->name }}</h1>
                        <p class="text-sm text-[#7f8c8d] mt-1">SKU: {{ $product->sku }}</p>
                    </div>

                    <div class="flex items-baseline space-x-4">
                        @if($product->sale_price)
                            <span class="text-2xl font-bold text-[#E67E22]">${{ number_format($product->sale_price, 2) }}</span>
                            <span class="text-lg text-[#7f8c8d] line-through">${{ number_format($product->price, 2) }}</span>
                        @else
                            <span class="text-2xl font-bold text-[#2C3E50]">${{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>

                    <!-- Social Share -->
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-[#7f8c8d]">Share:</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                           target="_blank" class="text-[#3b5998] hover:text-[#E67E22]">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($product->name) }}" 
                           target="_blank" class="text-[#1da1f2] hover:text-[#E67E22]">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(request()->url()) }}&media={{ urlencode($product->image_url) }}&description={{ urlencode($product->name) }}" 
                           target="_blank" class="text-[#bd081c] hover:text-[#E67E22]">
                            <i class="fab fa-pinterest-p"></i>
                        </a>
                    </div>

                    <div class="prose max-w-none">
                        {!! $product->description !!}
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-[#2C3E50]">Material:</span>
                            <span class="text-[#7f8c8d]">{{ $product->material }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-[#2C3E50]">Weight:</span>
                            <span class="text-[#7f8c8d]">{{ $product->weight }} kg</span>
                        </div>
                        <div>
                            <span class="font-medium text-[#2C3E50]">Dimensions:</span>
                            <span class="text-[#7f8c8d]">{{ $product->dimensions }}</span>
                        </div>
                    </div>

                    @if($product->features)
                        <div>
                            <h3 class="text-lg font-medium text-[#2C3E50] mb-2">Features</h3>
                            <div class="grid grid-cols-2 gap-4">
                                @foreach($product->features as $key => $value)
                                    <div>
                                        <span class="font-medium text-[#2C3E50]">{{ ucfirst($key) }}:</span>
                                        <span class="text-[#7f8c8d]">{{ $value }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('cart.add', $product) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-[#2C3E50] mb-1">Quantity</label>
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center border border-gray-300 rounded-lg">
                                    <button type="button" onclick="decrementQuantity()" class="px-4 py-2 text-[#7f8c8d] hover:text-[#E67E22]">-</button>
                                    <input type="number" name="quantity" id="quantity" value="1" min="{{ $product->min_order_quantity }}" 
                                           max="{{ $product->max_order_quantity }}" required
                                           class="w-16 text-center border-0 focus:ring-0">
                                    <button type="button" onclick="incrementQuantity()" class="px-4 py-2 text-[#7f8c8d] hover:text-[#E67E22]">+</button>
                                </div>
                                <p class="text-sm text-[#7f8c8d]">
                                    Min: {{ $product->min_order_quantity }}, Max: {{ $product->max_order_quantity }}
                                </p>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-[#E67E22] text-white px-6 py-3 rounded-lg shadow hover:bg-[#2C3E50] transition">
                            Add to Cart
                        </button>
                    </form>

                    @if($product->stock <= 0)
                        <div class="text-red-600 text-center font-medium">
                            Out of Stock
                        </div>
                    @endif
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="border-t border-gray-200 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-[#2C3E50]">Customer Reviews</h2>
                    <div class="flex items-center space-x-4">
                        <select id="reviewSort" onchange="sortReviews(this.value)" 
                                class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
                            <option value="newest">Newest First</option>
                            <option value="oldest">Oldest First</option>
                            <option value="highest">Highest Rating</option>
                            <option value="lowest">Lowest Rating</option>
                        </select>
                    </div>
                </div>
                
                @if($product->reviews->count() > 0)
                    <div id="reviewsContainer" class="space-y-6">
                        @foreach($product->reviews as $review)
                            <div class="border-b border-gray-200 pb-6 last:border-0 review-item" 
                                 data-date="{{ $review->created_at->timestamp }}"
                                 data-rating="{{ $review->rating }}">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center space-x-2">
                                        <span class="font-medium text-[#2C3E50]">{{ $review->user->name }}</span>
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-[#E67E22]' : 'text-gray-300' }}" 
                                                     fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <span class="text-sm text-[#7f8c8d]">{{ $review->created_at->format('M d, Y') }}</span>
                                </div>
                                <p class="text-[#2C3E50]">{{ $review->comment }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-[#7f8c8d]">No reviews yet.</p>
                @endif

                @auth
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-[#2C3E50] mb-4">Write a Review</h3>
                        @if(Route::has('reviews.store'))
                            <form action="{{ route('reviews.store', $product) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="rating" class="block text-sm font-medium text-[#2C3E50] mb-1">Rating</label>
                                    <div class="flex items-center space-x-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <button type="button" onclick="setRating({{ $i }})" class="text-2xl text-gray-300 hover:text-[#E67E22] rating-star">
                                                ★
                                            </button>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="rating" id="rating" required>
                                </div>

                                <div>
                                    <label for="comment" class="block text-sm font-medium text-[#2C3E50] mb-1">Comment</label>
                                    <textarea name="comment" id="comment" rows="4" required
                                              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent"></textarea>
                                </div>

                                <button type="submit" class="bg-[#E67E22] text-white px-6 py-2 rounded-lg shadow hover:bg-[#2C3E50] transition">
                                    Submit Review
                                </button>
                            </form>
                        @else
                            <p class="text-[#7f8c8d]">Review functionality is currently unavailable. Please check back later.</p>
                        @endif
                    </div>
                @else
                    <div class="mt-8 text-center">
                        <p class="text-[#7f8c8d]">Please <a href="{{ route('login') }}" class="text-[#E67E22] hover:underline">login</a> to write a review.</p>
                    </div>
                @endauth
            </div>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div class="border-t border-gray-200 p-6">
                    <h2 class="text-2xl font-bold text-[#2C3E50] mb-6">Related Products</h2>
                    <div class="grid md:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $relatedProduct)
                            <div class="group bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-300 hover:shadow-lg">
                                <a href="{{ route('products.show', $relatedProduct->id) }}" class="block relative overflow-hidden">
                                    <img src="{{ $relatedProduct->image_url }}" alt="{{ $relatedProduct->name }}" 
                                         class="w-full h-48 object-cover transform transition-transform duration-500 group-hover:scale-110">
                                </a>
                                <div class="p-4">
                                    <a href="{{ route('products.show', $relatedProduct->id) }}" 
                                       class="text-lg font-light text-[#2C3E50] hover:text-[#E67E22] transition">
                                        {{ $relatedProduct->name }}
                                    </a>
                                    <p class="text-[#E67E22] font-light mt-1">{{ $relatedProduct->formatted_price }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Image Zoom Modal -->
<div id="zoomModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50">
    <div class="max-w-4xl w-full mx-4">
        <div class="relative">
            <img id="zoomedImage" src="" alt="" class="w-full h-auto">
            <button onclick="closeZoom()" class="absolute top-4 right-4 text-white hover:text-[#E67E22]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Image Gallery
function changeMainImage(src) {
    document.getElementById('mainImage').src = src;
    document.getElementById('zoomedImage').src = src;
}

// Image Zoom
function toggleZoom() {
    const modal = document.getElementById('zoomModal');
    const mainImage = document.getElementById('mainImage');
    const zoomedImage = document.getElementById('zoomedImage');
    
    zoomedImage.src = mainImage.src;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeZoom() {
    const modal = document.getElementById('zoomModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Quantity Controls
function incrementQuantity() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.getAttribute('max'));
    const currentValue = parseInt(input.value);
    
    if (currentValue < max) {
        input.value = currentValue + 1;
    }
}

function decrementQuantity() {
    const input = document.getElementById('quantity');
    const min = parseInt(input.getAttribute('min'));
    const currentValue = parseInt(input.value);
    
    if (currentValue > min) {
        input.value = currentValue - 1;
    }
}

// Review Rating
function setRating(rating) {
    const stars = document.querySelectorAll('.rating-star');
    const ratingInput = document.getElementById('rating');
    
    stars.forEach((star, index) => {
        if (index < rating) {
            star.classList.remove('text-gray-300');
            star.classList.add('text-[#E67E22]');
        } else {
            star.classList.remove('text-[#E67E22]');
            star.classList.add('text-gray-300');
        }
    });
    
    ratingInput.value = rating;
}

// Review Sorting
function sortReviews(sortBy) {
    const container = document.getElementById('reviewsContainer');
    const reviews = Array.from(container.getElementsByClassName('review-item'));
    
    reviews.sort((a, b) => {
        switch(sortBy) {
            case 'newest':
                return b.dataset.date - a.dataset.date;
            case 'oldest':
                return a.dataset.date - b.dataset.date;
            case 'highest':
                return b.dataset.rating - a.dataset.rating;
            case 'lowest':
                return a.dataset.rating - b.dataset.rating;
            default:
                return 0;
        }
    });
    
    reviews.forEach(review => container.appendChild(review));
}
</script>
@endpush
@endsection
