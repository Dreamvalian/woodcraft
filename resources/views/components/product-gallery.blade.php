@props(['product'])

<div x-data="{ 
    activeImage: 0,
    lightboxOpen: false,
    zoomLevel: 1,
    zoomPosition: { x: 0, y: 0 }
}" class="product-gallery">
  {{-- Main Image Display --}}
  <div class="relative aspect-square bg-gray-100 rounded-lg overflow-hidden mb-4">
    <img src="{{ $product->images[$activeImage] }}" alt="{{ $product->name }}"
      class="w-full h-full object-cover cursor-zoom-in" @click="lightboxOpen = true" @mousemove="
                if (zoomLevel > 1) {
                    const rect = $event.target.getBoundingClientRect();
                    const x = ($event.clientX - rect.left) / rect.width;
                    const y = ($event.clientY - rect.top) / rect.height;
                    zoomPosition = { x, y };
                }
            " :style="zoomLevel > 1 ? `
                transform: scale(${zoomLevel});
                transform-origin: ${zoomPosition . x * 100}% ${zoomPosition . y * 100}%;
            ` : ''">
    <div class="absolute bottom-4 right-4 bg-white rounded-full p-2 shadow-lg">
      <button @click="zoomLevel = zoomLevel === 1 ? 2 : 1" class="text-gray-700 hover:text-wood transition">
        <i class="fas" :class="zoomLevel === 1 ? 'fa-search-plus' : 'fa-search-minus'"></i>
      </button>
    </div>
  </div>

  {{-- Thumbnail Gallery --}}
  <div class="grid grid-cols-5 gap-2">
    @foreach($product->images as $index => $image)
    <button @click="activeImage = {{ $index }}" class="aspect-square rounded-lg overflow-hidden border-2 transition"
      class="activeImage === {{ $index }} ? 'border-wood' : 'border-transparent hover:border-gray-300'">
      <img src="{{ $image }}" alt="{{ $product->name }} - Thumbnail {{ $index + 1 }}"
      class="w-full h-full object-cover">
    </button>
  @endforeach
  </div>

  {{-- Lightbox --}}
  <div x-show="lightboxOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center"
    @click.self="lightboxOpen = false">
    <div class="relative max-w-7xl mx-auto px-4">
      {{-- Close Button --}}
      <button @click="lightboxOpen = false" class="absolute top-4 right-4 text-white hover:text-wood transition">
        <i class="fas fa-times text-2xl"></i>
      </button>

      {{-- Navigation Buttons --}}
      <button @click="activeImage = (activeImage - 1 + {{ count($product->images) }}) % {{ count($product->images) }}"
        class="absolute left-4 top-1/2 -translate-y-1/2 text-white hover:text-wood transition">
        <i class="fas fa-chevron-left text-2xl"></i>
      </button>
      <button @click="activeImage = (activeImage + 1) % {{ count($product->images) }}"
        class="absolute right-4 top-1/2 -translate-y-1/2 text-white hover:text-wood transition">
        <i class="fas fa-chevron-right text-2xl"></i>
      </button>

      {{-- Main Image --}}
      <img src="{{ $product->images[$activeImage] }}" alt="{{ $product->name }}"
        class="max-h-[80vh] max-w-full object-contain">

      {{-- Thumbnails --}}
      <div class="flex justify-center gap-2 mt-4">
        @foreach($product->images as $index => $image)
<<<<<<< HEAD
      <button @click="activeImage = {{ $index }}" class="w-16 h-16 rounded-lg overflow-hidden border-2 transition"
        class="activeImage === {{ $index }} ? 'border-wood' : 'border-transparent hover:border-gray-300'">
        <img src="{{ $image }}" alt="{{ $product->name }} - Thumbnail {{ $index + 1 }}"
        class="w-full h-full object-cover">
      </button>
    @endforeach
      </div>
=======
            <button 
                @click="activeImage = {{ $index }}"
                class="aspect-square rounded-lg overflow-hidden border-2 transition"
                class="activeImage === {{ $index }} ? 'border-wood' : 'border-transparent hover:border-gray-300'"
            >
                <img 
                    src="{{ $image }}" 
                    alt="{{ $product->name }} - Thumbnail {{ $index + 1 }}"
                    class="w-full h-full object-cover"
                >
            </button>
        @endforeach
    </div>

    {{-- Lightbox --}}
    <div 
        x-show="lightboxOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center"
        @click.self="lightboxOpen = false"
    >
        <div class="relative max-w-7xl mx-auto px-4">
            {{-- Close Button --}}
            <button 
                @click="lightboxOpen = false"
                class="absolute top-4 right-4 text-white hover:text-wood transition"
            >
                <i class="fas fa-times text-2xl"></i>
            </button>

            {{-- Navigation Buttons --}}
            <button 
                @click="activeImage = (activeImage - 1 + {{ count($product->images) }}) % {{ count($product->images) }}"
                class="absolute left-4 top-1/2 -translate-y-1/2 text-white hover:text-wood transition"
            >
                <i class="fas fa-chevron-left text-2xl"></i>
            </button>
            <button 
                @click="activeImage = (activeImage + 1) % {{ count($product->images) }}"
                class="absolute right-4 top-1/2 -translate-y-1/2 text-white hover:text-wood transition"
            >
                <i class="fas fa-chevron-right text-2xl"></i>
            </button>

            {{-- Main Image --}}
            <img 
                src="{{ $product->images[$activeImage] }}" 
                alt="{{ $product->name }}"
                class="max-h-[80vh] max-w-full object-contain"
            >

            {{-- Thumbnails --}}
            <div class="flex justify-center gap-2 mt-4">
                @foreach($product->images as $index => $image)
                    <button 
                        @click="activeImage = {{ $index }}"
                        class="w-16 h-16 rounded-lg overflow-hidden border-2 transition"
                        class="activeImage === {{ $index }} ? 'border-wood' : 'border-transparent hover:border-gray-300'"
                    >
                        <img 
                            src="{{ $image }}" 
                            alt="{{ $product->name }} - Thumbnail {{ $index + 1 }}"
                            class="w-full h-full object-cover"
                        >
                    </button>
                @endforeach
            </div>
        </div>
>>>>>>> ad484e0144e9c8627f52bb0e0aba79edc31ac7bb
    </div>
  </div>
</div>

@push('scripts')
  <script>
    // Keyboard navigation for lightbox
    document.addEventListener('keydown', (e) => {
    if (window.Alpine.store('lightboxOpen')) {
      if (e.key === 'Escape') {
      window.Alpine.store('lightboxOpen', false);
      } else if (e.key === 'ArrowLeft') {
      window.Alpine.store('activeImage', (window.Alpine.store('activeImage') - 1 + window.Alpine.store('totalImages')) % window.Alpine.store('totalImages'));
      } else if (e.key === 'ArrowRight') {
      window.Alpine.store('activeImage', (window.Alpine.store('activeImage') + 1) % window.Alpine.store('totalImages'));
      }
    }
    });
  </script>
@endpush