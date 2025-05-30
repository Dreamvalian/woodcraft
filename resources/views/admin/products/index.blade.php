@extends('layouts.app')

@section('content')
<div class="bg-[#f8f6f3] min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-[#2C3E50]">Manage Products</h2>
                <a href="{{ route('admin.products.create') }}" class="bg-[#E67E22] text-white px-4 py-2 rounded shadow hover:bg-[#2C3E50] transition">
                    Add New Product
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <!-- Search and Filter Section -->
            <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                <form action="{{ route('admin.products.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-[#2C3E50] mb-1">Search</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                               placeholder="Search by name or description"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-medium text-[#2C3E50] mb-1">Category</label>
                        <select name="category" id="category" 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="sort" class="block text-sm font-medium text-[#2C3E50] mb-1">Sort By</label>
                        <select name="sort" id="sort" 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
                            <option value="stock_asc" {{ request('sort') == 'stock_asc' ? 'selected' : '' }}>Stock (Low to High)</option>
                            <option value="stock_desc" {{ request('sort') == 'stock_desc' ? 'selected' : '' }}>Stock (High to Low)</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-[#2C3E50] text-white px-4 py-2 rounded shadow hover:bg-[#E67E22] transition w-full">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Bulk Actions -->
            <form id="bulk-action-form" action="{{ route('admin.products.bulk-action') }}" method="POST" class="mb-6">
                @csrf
                <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-lg">
                    <div class="flex-1">
                        <select name="action" id="bulk-action" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
                            <option value="">Bulk Actions</option>
                            <option value="delete">Delete Selected</option>
                            <option value="update-stock">Update Stock</option>
                        </select>
                    </div>
                    <div id="stock-input" class="hidden flex-1">
                        <input type="number" name="stock" placeholder="Enter stock quantity" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
                    </div>
                    <button type="submit" class="bg-[#2C3E50] text-white px-4 py-2 rounded shadow hover:bg-[#E67E22] transition">
                        Apply
                    </button>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="pb-3 text-[#2C3E50]">
                                <input type="checkbox" id="select-all" class="rounded border-gray-300 text-[#E67E22] focus:ring-[#E67E22]">
                            </th>
                            <th class="pb-3 text-[#2C3E50]">Image</th>
                            <th class="pb-3 text-[#2C3E50]">Name</th>
                            <th class="pb-3 text-[#2C3E50]">Category</th>
                            <th class="pb-3 text-[#2C3E50]">Price</th>
                            <th class="pb-3 text-[#2C3E50]">Stock</th>
                            <th class="pb-3 text-[#2C3E50]">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr class="border-b hover:bg-[#f8f6f3] transition">
                            <td class="py-4">
                                <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" 
                                       class="product-checkbox rounded border-gray-300 text-[#E67E22] focus:ring-[#E67E22]">
                            </td>
                            <td class="py-4">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                     class="w-16 h-16 object-cover rounded cursor-pointer"
                                     onclick="showImagePreview(this.src)">
                            </td>
                            <td class="py-4">
                                <div class="font-semibold text-[#2C3E50]">{{ $product->name }}</div>
                                <div class="text-sm text-[#7f8c8d]">{{ Str::limit($product->description, 50) }}</div>
                            </td>
                            <td class="py-4 text-[#2C3E50]">{{ $product->category }}</td>
                            <td class="py-4 text-[#E67E22] font-semibold">{{ $product->formatted_price }}</td>
                            <td class="py-4">
                                <span class="px-2 py-1 rounded-full text-sm {{ $product->stock > 10 ? 'bg-green-100 text-green-800' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td class="py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" 
                                       class="text-[#E67E22] hover:text-[#2C3E50] transition"
                                       title="Edit Product">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transition" 
                                                onclick="return confirm('Are you sure you want to delete this product?')"
                                                title="Delete Product">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-[#7f8c8d]">
                                No products found. <a href="{{ route('admin.products.create') }}" class="text-[#E67E22] hover:underline">Add your first product</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div id="image-preview-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-4 rounded-lg max-w-2xl max-h-[90vh] overflow-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-[#2C3E50]">Image Preview</h3>
            <button onclick="closeImagePreview()" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <img id="preview-image" src="" alt="Preview" class="max-w-full h-auto">
    </div>
</div>

@push('scripts')
<script>
    // Bulk Actions
    document.getElementById('bulk-action').addEventListener('change', function() {
        const stockInput = document.getElementById('stock-input');
        stockInput.classList.toggle('hidden', this.value !== 'update-stock');
    });

    // Select All Checkbox
    document.getElementById('select-all').addEventListener('change', function() {
        document.querySelectorAll('.product-checkbox').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Image Preview
    function showImagePreview(src) {
        const modal = document.getElementById('image-preview-modal');
        const previewImage = document.getElementById('preview-image');
        previewImage.src = src;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeImagePreview() {
        const modal = document.getElementById('image-preview-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Close modal when clicking outside
    document.getElementById('image-preview-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeImagePreview();
        }
    });
</script>
@endpush
@endsection 