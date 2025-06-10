@extends('layouts.app')

@section('content')
  <div class="min-h-screen bg-[#f9f9f9]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
      <!-- Header Section -->
      <div class="px-6 py-5 border-b border-gray-100">
      <div class="flex justify-between items-center">
        <h2 class="text-2xl font-light text-[#2C3E50]">Products</h2>
        <a href="{{ route('admin.products.create') }}"
        class="inline-flex items-center px-4 py-2 bg-[#2C3E50] text-white text-sm font-light rounded-md hover:bg-[#1a252f] transition duration-200 uppercase tracking-wider">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        Add Product
        </a>
      </div>
      </div>

      @if(session('success'))
      <div class="px-6 py-4 bg-green-50 border-b border-green-100">
      <div class="flex items-center text-green-700">
      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
      </svg>
      {{ session('success') }}
      </div>
      </div>
    @endif

      <!-- Filters Section -->
      <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
      <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..."
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:border-[#E67E22] transition duration-200 font-light">
        </div>
        <div class="flex gap-4">
        <select name="sort" onchange="this.form.submit()"
          class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:border-[#E67E22] transition duration-200 font-light">
          <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
          <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
          <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price (Low-High)</option>
          <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price (High-Low)</option>
          <option value="created_desc" {{ request('sort') == 'created_desc' ? 'selected' : '' }}>Newest First</option>
          <option value="created_asc" {{ request('sort') == 'created_asc' ? 'selected' : '' }}>Oldest First</option>
        </select>
        <button type="submit"
          class="px-4 py-2 bg-[#2C3E50] text-white rounded-md hover:bg-[#1a252f] transition duration-200 font-light uppercase tracking-wider">
          Filter
        </button>
        </div>
      </form>
      </div>

      <!-- Products Table -->
      <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
        <tr>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
          Product</th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
          Price</th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
          Stock</th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
          Status</th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
          Created</th>
          <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
          Actions</th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        @forelse($products as $product)
        <tr>
        <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center">
          <div class="h-10 w-10 flex-shrink-0">
          <img class="h-10 w-10 rounded-lg object-cover" src="{{ $product->image_url }}"
          alt="{{ $product->name }}">
          </div>
          <div class="ml-4">
          <div class="text-sm font-medium text-[#2C3E50]">{{ $product->name }}</div>
          <div class="text-sm text-gray-500">{{ $product->sku }}</div>
          </div>
        </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm text-[#2C3E50]">${{ number_format($product->price, 2) }}</div>
        @if($product->sale_price)
        <div class="text-sm text-[#E67E22]">${{ number_format($product->sale_price, 2) }}</div>
      @endif
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm text-[#2C3E50]">{{ $product->stock }}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
        <span
          class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
          {{ $product->is_active ? 'Active' : 'Inactive' }}
        </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ $product->created_at->format('M d, Y') }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <div class="flex justify-end space-x-4">
          <a href="{{ route('admin.products.edit', $product) }}"
          class="inline-flex items-center justify-center w-8 h-8 text-[#2C3E50] hover:text-[#E67E22] transition duration-200 rounded-full hover:bg-gray-100">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
          </svg>
          <span class="sr-only">Edit</span>
          </a>
          <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
          @csrf
          @method('DELETE')
          <button type="submit" onclick="return confirm('Are you sure you want to delete this product?')"
          class="inline-flex items-center justify-center w-8 h-8 text-[#2C3E50] hover:text-red-600 transition duration-200 rounded-full hover:bg-gray-100">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
          </svg>
          <span class="sr-only">Delete</span>
          </button>
          </form>
        </div>
        </td>
        </tr>
      @empty
      <tr>
        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
        No products found.
        </td>
      </tr>
      @endforelse
        </tbody>
      </table>
      </div>

      <!-- Pagination -->
      @if($products->hasPages())
      <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
      {{ $products->links() }}
      </div>
    @endif
    </div>
    </div>
  </div>

  <!-- Image Preview Modal -->
  <div id="image-preview-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl max-w-2xl max-h-[90vh] overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
      <h3 class="text-lg font-medium text-gray-900">Image Preview</h3>
      <button onclick="closeImagePreview()" class="text-gray-400 hover:text-gray-500 transition-colors">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
      </button>
    </div>
    <div class="p-6">
      <img id="preview-image" src="" alt="Preview" class="max-w-full h-auto rounded-lg">
    </div>
    </div>
  </div>

  @push('scripts')
    <script>
    // Bulk Actions
    document.getElementById('bulk-action').addEventListener('change', function () {
    const stockInput = document.getElementById('stock-input');
    stockInput.classList.toggle('hidden', this.value !== 'update-stock');
    });

    // Select All Checkbox
    document.getElementById('select-all').addEventListener('change', function () {
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
    </script>
  @endpush
@endsection