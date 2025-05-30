@extends('layouts.app')

@section('content')
<div class="bg-[#f8f6f3] min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-[#2C3E50]">Edit Product</h2>
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

            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="name" class="block text-sm font-medium text-[#2C3E50] mb-1">Product Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-[#2C3E50] mb-1">Description</label>
                    <textarea name="description" id="description" rows="4" 
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label for="price" class="block text-sm font-medium text-[#2C3E50] mb-1">Price</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
                    </div>

                    <div>
                        <label for="stock" class="block text-sm font-medium text-[#2C3E50] mb-1">Stock</label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
                    </div>
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-[#2C3E50] mb-1">Image URL</label>
                    <input type="text" name="image" id="image" value="{{ old('image', $product->image) }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-[#2C3E50] mb-1">Category</label>
                    <input type="text" name="category" id="category" value="{{ old('category', $product->category) }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
                </div>

                <div>
                    <label for="model" class="block text-sm font-medium text-[#2C3E50] mb-1">Model</label>
                    <input type="text" name="model" id="model" value="{{ old('model', $product->model) }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">
                </div>

                <div>
                    <label for="features" class="block text-sm font-medium text-[#2C3E50] mb-1">Features (JSON)</label>
                    <textarea name="features" id="features" rows="3" 
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#E67E22] focus:border-transparent">{{ old('features', json_encode($product->features)) }}</textarea>
                    <p class="mt-1 text-sm text-[#7f8c8d]">Enter features as a JSON array, e.g., ["Feature 1", "Feature 2"]</p>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-[#E67E22] text-white px-6 py-2 rounded shadow hover:bg-[#2C3E50] transition">
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 