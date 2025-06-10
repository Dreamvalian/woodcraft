@extends('layouts.app')

@section('content')
  <div class="bg-[#f8f6f3] min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-sm p-6">
      <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold text-[#2C3E50]">Add New Product</h2>
      <a href="{{ route('admin.products.index') }}" class="text-[#E67E22] hover:text-[#2C3E50] transition">
        Back to Products
      </a>
      </div>

      @if($errors->any())
      <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
      <ul class="list-disc list-inside">
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
      </ul>
      </div>
    @endif

      <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
      @csrf

      <div>
        <label for="name" class="block text-sm font-medium text-[#2C3E50] mb-1">Product Name</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" required
        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
      </div>

      <div>
        <label for="slug" class="block text-sm font-medium text-[#2C3E50] mb-1">Slug</label>
        <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required
        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
      </div>

      <div>
        <label for="description" class="block text-sm font-medium text-[#2C3E50] mb-1">Description</label>
        <textarea name="description" id="description" rows="4" required
        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">{{ old('description') }}</textarea>
      </div>

      <div class="grid grid-cols-2 gap-6">
        <div>
        <label for="price" class="block text-sm font-medium text-[#2C3E50] mb-1">Price</label>
        <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" required
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
        </div>

        <div>
        <label for="sale_price" class="block text-sm font-medium text-[#2C3E50] mb-1">Sale Price</label>
        <input type="number" name="sale_price" id="sale_price" value="{{ old('sale_price') }}" step="0.01"
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
        </div>
      </div>

      <div class="grid grid-cols-2 gap-6">
        <div>
        <label for="stock" class="block text-sm font-medium text-[#2C3E50] mb-1">Stock</label>
        <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" required
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
        </div>

        <div>
        <label for="sku" class="block text-sm font-medium text-[#2C3E50] mb-1">SKU</label>
        <input type="text" name="sku" id="sku" value="{{ old('sku') }}"
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
        </div>
      </div>

      {{-- <div>
        <label for="category_id" class="block text-sm font-medium text-[#2C3E50] mb-1">Category</label>
        <select name="category_id" id="category_id" required
        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
        <option value="">Select Category</option>
        @foreach($categories as $category)
      <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
        {{ $category->name }}
      </option>
      @endforeach
        </select>
      </div> --}}

      <div class="grid grid-cols-2 gap-6">
        <div>
        <label for="weight" class="block text-sm font-medium text-[#2C3E50] mb-1">Weight (kg)</label>
        <input type="number" name="weight" id="weight" value="{{ old('weight') }}" step="0.01"
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
        </div>

        <div>
        <label for="dimensions" class="block text-sm font-medium text-[#2C3E50] mb-1">Dimensions (LxWxH)</label>
        <input type="text" name="dimensions" id="dimensions" value="{{ old('dimensions') }}"
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
        </div>
      </div>

      <div>
        <label for="material" class="block text-sm font-medium text-[#2C3E50] mb-1">Material</label>
        <input type="text" name="material" id="material" value="{{ old('material') }}"
        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
      </div>

      <div class="grid grid-cols-2 gap-6">
        <div>
        <label for="min_order_quantity" class="block text-sm font-medium text-[#2C3E50] mb-1">Min Order
          Quantity</label>
        <input type="number" name="min_order_quantity" id="min_order_quantity"
          value="{{ old('min_order_quantity', 1) }}"
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
        </div>

        <div>
        <label for="max_order_quantity" class="block text-sm font-medium text-[#2C3E50] mb-1">Max Order
          Quantity</label>
        <input type="number" name="max_order_quantity" id="max_order_quantity"
          value="{{ old('max_order_quantity') }}"
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
        </div>
      </div>

      <div>
        <label for="features" class="block text-sm font-medium text-[#2C3E50] mb-1">Features (JSON)</label>
        <textarea name="features" id="features" rows="3"
        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">{{ old('features') }}</textarea>
        <p class="mt-1 text-sm text-[#7f8c8d]">Enter features as a JSON object, e.g., {"color": "natural", "style":
        "modern"}</p>
      </div>

      <div>
        <label for="image" class="block text-sm font-medium text-[#2C3E50] mb-1">Product Image</label>
        <input type="file" name="image" id="image" accept="image/*"
        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
      </div>

      <div class="flex items-center">
        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}
        class="rounded border-gray-300 text-[#E67E22] focus:ring-[#E67E22]">
        <label for="is_active" class="ml-2 block text-sm text-[#2C3E50]">Active</label>
      </div>

      <div class="flex justify-end">
        <button type="submit" class="bg-[#E67E22] text-white px-6 py-2 rounded shadow hover:bg-[#2C3E50] transition">
        Create Product
        </button>
      </div>
      </form>
    </div>
    </div>
  </div>
@endsection