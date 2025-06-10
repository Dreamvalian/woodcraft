@props(['categories' => [], 'priceRange' => ['min' => 0, 'max' => 1000]])

<div x-data="{ 
    searchQuery: '',
    selectedCategories: [],
    priceRange: {
        min: {{ $priceRange['min'] }},
        max: {{ $priceRange['max'] }}
    },
    sortBy: 'newest',
    isFilterOpen: false,
    
    // Debounced search
    debouncedSearch: null,
    search() {
        clearTimeout(this.debouncedSearch);
        this.debouncedSearch = setTimeout(() => {
            this.$dispatch('search', {
                query: this.searchQuery,
                categories: this.selectedCategories,
                priceRange: this.priceRange,
                sortBy: this.sortBy
            });
        }, 300);
    },
    
    // Reset filters
    resetFilters() {
        this.searchQuery = '';
        this.selectedCategories = [];
        this.priceRange = {
            min: {{ $priceRange['min'] }},
            max: {{ $priceRange['max'] }}
        };
        this.sortBy = 'newest';
        this.search();
    }
}" class="search-filter">
    {{-- Search Bar --}}
    <div class="mb-6">
        <div class="relative">
            <input 
                type="text"
                x-model="searchQuery"
                @input="search()"
                placeholder="Search products..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-wood focus:border-transparent"
            >
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
        </div>
    </div>

    {{-- Filter Toggle (Mobile) --}}
    <div class="md:hidden mb-4">
        <button 
            @click="isFilterOpen = !isFilterOpen"
            class="w-full flex items-center justify-between px-4 py-2 border border-gray-300 rounded-lg"
        >
            <span class="text-gray-700">Filters</span>
            <i class="fas" :class="isFilterOpen ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
        </button>
    </div>

    {{-- Filters --}}
    <div 
        x-show="isFilterOpen || window.innerWidth >= 768"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="space-y-6"
    >
        {{-- Price Range --}}
        <div>
            <h3 class="text-lg font-medium text-gray-900 mb-3">Price Range</h3>
            <div class="space-y-4">
                <div class="flex items-center space-x-4">
                    <div class="flex-1">
                        <label class="block text-sm text-gray-700">Min</label>
                        <input 
                            type="number"
                            x-model.number="priceRange.min"
                            @change="search()"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-wood focus:ring-wood sm:text-sm"
                        >
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm text-gray-700">Max</label>
                        <input 
                            type="number"
                            x-model.number="priceRange.max"
                            @change="search()"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-wood focus:ring-wood sm:text-sm"
                        >
                    </div>
                </div>
                <div class="relative">
                    <div class="h-2 bg-gray-200 rounded-full">
                        <div 
                            class="absolute h-2 bg-wood rounded-full"
                            style="`left: ${(priceRange.min / {{ $priceRange['max'] }}) * 100}%; right: ${100 - (priceRange.max / {{ $priceRange['max'] }}) * 100}%`"
                        ></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sort By --}}
        <div>
            <h3 class="text-lg font-medium text-gray-900 mb-3">Sort By</h3>
            <select 
                x-model="sortBy"
                @change="search()"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-wood focus:ring-wood sm:text-sm"
            >
                <option value="newest">Newest</option>
                <option value="price_asc">Price: Low to High</option>
                <option value="price_desc">Price: High to Low</option>
                <option value="name_asc">Name: A to Z</option>
                <option value="name_desc">Name: Z to A</option>
            </select>
        </div>

        {{-- Reset Filters --}}
        <button 
            @click="resetFilters()"
            class="w-full px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-wood focus:ring-offset-2"
        >
            Reset Filters
        </button>
    </div>
</div>

@push('scripts')
<script>
    // Initialize price range slider
    document.addEventListener('alpine:init', () => {
        Alpine.data('priceRangeSlider', () => ({
            init() {
                const slider = this.$el;
                const minInput = this.$refs.minInput;
                const maxInput = this.$refs.maxInput;
                const range = this.$refs.range;
                
                // Update range bar position
                const updateRange = () => {
                    const min = parseInt(minInput.value);
                    const max = parseInt(maxInput.value);
                    const percent1 = (min / {{ $priceRange['max'] }}) * 100;
                    const percent2 = (max / {{ $priceRange['max'] }}) * 100;
                    range.style.left = `${percent1}%`;
                    range.style.right = `${100 - percent2}%`;
                };
                
                // Handle input changes
                minInput.addEventListener('input', updateRange);
                maxInput.addEventListener('input', updateRange);
                
                // Initial update
                updateRange();
            }
        }));
    });
</script>
@endpush 