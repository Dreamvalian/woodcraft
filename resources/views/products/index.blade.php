@extends('layouts.app')

@section('content')
<div class="bg-white font-sans">
    <!-- Our Products Section -->
    <section id="products" class="bg-white py-20 px-6 md:px-24">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h4 class="text-sm text-[#E67E22] uppercase mb-3 tracking-widest font-light">Crafting Excellence</h4>
                <h2 class="text-3xl md:text-4xl font-light text-[#2C3E50] mb-6">Our Products</h2>
                <div class="w-24 h-1 bg-[#E67E22] mx-auto"></div>
            </div>
            
            <!-- Search and Filter Section -->
            <div class="mb-8">
                <form action="{{ route('products.index') }}" method="GET" class="space-y-4">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Search products..." 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
                        </div>
                        <div class="flex gap-4">
                            <select name="category" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="sort" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                            </select>
                            <button type="submit" class="bg-[#E67E22] text-white px-6 py-2 rounded-lg hover:bg-[#2C3E50] transition">
                                Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center mb-16">
                <p class="text-gray-600 text-lg leading-relaxed font-light">
                    Introducing our specialized line of WoodCraft solutions, a testament to the timeless beauty and craftsmanship of artisan wood products. Each piece in our collection is handcrafted by skilled artisans who are deeply connected to nature and their passion for precision.
                    <br><br>
                    Our Forest Wood Craft products are created using carefully selected and sustainable wood sourced from responsibly managed forests. From the warm hue of traditional teak to unique grain, you're sure to find materials and pieces promoting environmental conservation.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @foreach($products as $product)
                <div class="group bg-white rounded-lg shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl">
                    <div class="relative">
                        <a href="{{ route('products.show', $product->id) }}" class="block relative overflow-hidden">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-64 object-cover transform transition-transform duration-500 group-hover:scale-110">
                            <div class="absolute inset-0 bg-[#2C3E50]/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <span class="text-white text-lg font-light border-2 border-white px-8 py-3 hover:bg-white hover:text-[#2C3E50] transition-all duration-300">View Details</span>
                            </div>
                        </a>
                        <button onclick="openQuickView({{ $product->id }})" 
                                class="absolute top-4 right-4 bg-white p-2 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#2C3E50]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-6">
                        <div class="mb-4">
                            <a href="{{ route('products.show', $product->id) }}" class="text-xl font-light text-[#2C3E50] hover:text-[#E67E22] transition">{{ $product->name }}</a>
                            <p class="text-[#7f8c8d] mt-1 mb-2 font-light">{{ $product->category }}</p>
                            <p class="text-[#E67E22] font-light text-lg mb-4">{{ $product->formatted_price }}</p>
                        </div>
                        <div class="flex items-center justify-between">
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="flex items-center gap-1 px-4 py-2 rounded text-[#E67E22] border border-[#E67E22] hover:bg-[#E67E22] hover:text-white transition font-light">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Add to Cart
                                </button>
                            </form>
                            <a href="{{ route('products.show', $product->id) }}" class="inline-block bg-transparent border border-[#E67E22] text-[#E67E22] px-4 py-2 rounded hover:bg-[#E67E22] hover:text-white transition-all duration-300 font-light focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:ring-offset-2">View Details</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $products->links() }}
            </div>
        </div>
    </section>

    <!-- Quick View Modal -->
    <div id="quickViewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-2xl font-light text-[#2C3E50]">Quick View</h3>
                    <button onclick="closeQuickView()" class="text-gray-500 hover:text-[#E67E22]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div id="quickViewContent" class="grid md:grid-cols-2 gap-8">
                    <!-- Content will be loaded dynamically -->
                </div>
            </div>
        </div>
    </div>

    <!-- Our Works Section -->
    <section class="bg-[#f8f6f3] py-20 px-6 md:px-24">
        <div class="max-w-7xl mx-auto text-center">
            <h4 class="text-sm text-[#E67E22] uppercase mb-3 tracking-widest font-light">Our Portfolio</h4>
            <h2 class="text-3xl md:text-4xl font-light text-[#2C3E50] mb-4">Our Works</h2>
            <p class="text-gray-600 text-lg mb-12 font-light max-w-2xl mx-auto">
                Hasil pekerjaan Wood Craft dan digunakan untuk<br>
                desain interior rumah clients kita
            </p>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="group overflow-hidden rounded-xl relative">
                    <img src="/image/product-4.jpg" alt="Work 1" class="w-full h-[400px] object-cover transform transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-[#2C3E50]/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-xl font-light mb-2 group-hover:text-[#E67E22] transition-colors duration-300">Modern Interior</h3>
                            <p class="text-sm font-light">Living Room Design</p>
                        </div>
                    </div>
                </div>
                <div class="group overflow-hidden rounded-xl relative">
                    <img src="/image/product-4.jpg" alt="Work 2" class="w-full h-[400px] object-cover transform transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-[#2C3E50]/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-xl font-light mb-2 group-hover:text-[#E67E22] transition-colors duration-300">Classic Design</h3>
                            <p class="text-sm font-light">Bedroom Furniture</p>
                        </div>
                    </div>
                </div>
                <div class="group overflow-hidden rounded-xl relative">
                    <img src="/image/product-4.jpg" alt="Work 3" class="w-full h-[400px] object-cover transform transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-[#2C3E50]/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="text-xl font-light mb-2 group-hover:text-[#E67E22] transition-colors duration-300">Minimalist Style</h3>
                            <p class="text-sm font-light">Office Space</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
function openQuickView(productId) {
    const modal = document.getElementById('quickViewModal');
    const content = document.getElementById('quickViewContent');
    
    // Show loading state
    content.innerHTML = '<div class="col-span-2 text-center py-8">Loading...</div>';
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    // Fetch product details
    fetch(`/api/products/${productId}/quick-view`)
        .then(response => response.json())
        .then(data => {
            content.innerHTML = `
                <div>
                    <img src="${data.image_url}" alt="${data.name}" class="w-full h-96 object-cover rounded-lg">
                </div>
                <div class="space-y-4">
                    <h2 class="text-2xl font-light text-[#2C3E50]">${data.name}</h2>
                    <p class="text-[#E67E22] font-light text-xl">${data.formatted_price}</p>
                    <p class="text-gray-600">${data.description}</p>
                    <form action="/cart/add/${data.id}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-[#2C3E50] mb-1">Quantity</label>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" 
                                   class="w-24 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
                        </div>
                        <button type="submit" class="w-full bg-[#E67E22] text-white px-6 py-3 rounded-lg shadow hover:bg-[#2C3E50] transition">
                            Add to Cart
                        </button>
                    </form>
                    <a href="/products/${data.id}" class="block text-center text-[#E67E22] hover:underline">
                        View Full Details
                    </a>
                </div>
            `;
        })
        .catch(error => {
            content.innerHTML = '<div class="col-span-2 text-center py-8 text-red-500">Error loading product details</div>';
        });
}

function closeQuickView() {
    const modal = document.getElementById('quickViewModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
@endpush
@endsection