@extends('layouts.app')

@section('content')
  <div class="min-h-screen bg-[#f9f9f9]">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
      <!-- Header Section -->
      <div class="px-6 py-5 border-b border-gray-100">
      <div class="flex justify-between items-center">
        <h2 class="text-2xl font-light text-[#2C3E50]">Edit Product</h2>
        <a href="{{ route('admin.products.index') }}"
        class="inline-flex items-center text-sm font-light text-gray-600 hover:text-[#2C3E50] transition duration-200">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Products
        </a>
      </div>
      </div>

      @if($errors->any())
      <div class="px-6 py-4 bg-red-50 border-b border-red-100">
      <div class="flex items-center text-red-700">
      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      <div>
      <p class="font-light">Please fix the following errors:</p>
      <ul class="mt-1 list-disc list-inside text-sm">
        @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
      </ul>
      </div>
      </div>
      </div>
    @endif

      <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
      class="divide-y divide-gray-100">
      @csrf
      @method('PUT')

      <!-- Basic Information -->
      <div class="px-6 py-5 space-y-6">
        <h3 class="text-lg font-light text-[#2C3E50]">Basic Information</h3>

        <div>
        <label for="name" class="block text-sm font-light text-gray-700">Product Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:border-[#E67E22] transition duration-200 font-light">
        </div>

        <div>
        <label for="slug" class="block text-sm font-light text-gray-700">Slug</label>
        <input type="text" name="slug" id="slug" value="{{ old('slug', $product->slug) }}" required
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:border-[#E67E22] transition duration-200 font-light">
        </div>

        <div>
        <label for="description" class="block text-sm font-light text-gray-700">Description</label>
        <textarea name="description" id="description" rows="4" required
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:border-[#E67E22] transition duration-200 font-light">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-6">
        <div>
          <label for="price" class="block text-sm font-light text-gray-700">Price</label>
          <div class="mt-1 relative rounded-md shadow-sm">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <span class="text-gray-500 sm:text-sm">$</span>
          </div>
          <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01"
            required
            class="block w-full pl-7 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:border-[#E67E22] transition duration-200 font-light">
          </div>
        </div>

        <div>
          <label for="sale_price" class="block text-sm font-light text-gray-700">Sale Price</label>
          <div class="mt-1 relative rounded-md shadow-sm">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <span class="text-gray-500 sm:text-sm">$</span>
          </div>
          <input type="number" name="sale_price" id="sale_price"
            value="{{ old('sale_price', $product->sale_price) }}" step="0.01"
            class="block w-full pl-7 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:border-[#E67E22] transition duration-200 font-light">
          </div>
        </div>
        </div>
      </div>

      <!-- Inventory -->
      <div class="px-6 py-5 space-y-6">
        <h3 class="text-lg font-light text-[#2C3E50]">Inventory</h3>

        <div class="grid grid-cols-2 gap-6">
        <div>
          <label for="stock" class="block text-sm font-light text-gray-700">Stock</label>
          <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" required
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:border-[#E67E22] transition duration-200 font-light">
        </div>

        <div>
          <label for="min_order_quantity" class="block text-sm font-light text-gray-700">Min Order Quantity</label>
          <input type="number" name="min_order_quantity" id="min_order_quantity"
          value="{{ old('min_order_quantity', $product->min_order_quantity) }}"
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:border-[#E67E22] transition duration-200 font-light">
        </div>
        </div>

        <div>
        <label for="max_order_quantity" class="block text-sm font-light text-gray-700">Max Order Quantity</label>
        <input type="number" name="max_order_quantity" id="max_order_quantity"
          value="{{ old('max_order_quantity', $product->max_order_quantity) }}"
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:border-[#E67E22] transition duration-200 font-light">
        </div>
      </div>

      <!-- Product Details -->
      <div class="px-6 py-5 space-y-6">
        <h3 class="text-lg font-medium text-[#2C3E50]">Product Details</h3>
      </div>

      <!-- Media -->
      <div class="px-6 py-5 space-y-6">
        <h3 class="text-lg font-light text-[#2C3E50]">Media</h3>

        <div>
        <label for="image" class="block text-sm font-light text-gray-700">Product Image</label>
        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
          <div class="space-y-1 text-center">
          @if($product->image_url)
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
        class="mx-auto h-32 w-32 object-cover rounded-md">
      @else
        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
        <path
        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      @endif
          <div class="flex text-sm text-gray-600">
            <label for="image"
            class="relative cursor-pointer bg-white rounded-md font-light text-[#E67E22] hover:text-[#2C3E50] focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-[#E67E22]">
            <span>Upload a file</span>
            <input id="image" name="image" type="file" class="sr-only" accept="image/*">
            </label>
            <p class="pl-1">or drag and drop</p>
          </div>
          <p class="text-xs text-gray-500 font-light">PNG, JPG, GIF up to 2MB</p>
          </div>
        </div>
        </div>
      </div>

      <!-- Status -->
      <div class="px-6 py-5 bg-gray-50">
        <div class="flex items-center">
        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-[#E67E22] focus:ring-[#E67E22]">
        <label for="is_active" class="ml-2 block text-sm font-light text-gray-700">Active</label>
        </div>
      </div>

      <!-- Form Actions -->
      <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end">
        <button type="submit"
        class="w-full bg-[#2C3E50] hover:bg-[#1a252f] text-white font-light py-3 rounded-md transition duration-200 uppercase tracking-wider">
        Update Product
        </button>
      </div>
      </form>
    </div>
    </div>
  </div>

  @push('scripts')
    <script>
    // Auto-generate slug from name
    document.getElementById('name').addEventListener('input', function () {
    const slug = this.value
      .toLowerCase()
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/(^-|-$)/g, '');
    document.getElementById('slug').value = slug;
    });

    // Preview image before upload
    document.getElementById('image').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
      const preview = document.createElement('img');
      preview.src = e.target.result;
      preview.className = 'mx-auto h-32 w-32 object-cover rounded-md';

      const container = document.querySelector('.border-dashed');
      const existingPreview = container.querySelector('img');
      if (existingPreview) {
      container.removeChild(existingPreview);
      }
      container.insertBefore(preview, container.firstChild);
      }
      reader.readAsDataURL(file);
    }
    });
    </script>
  @endpush
@endsection