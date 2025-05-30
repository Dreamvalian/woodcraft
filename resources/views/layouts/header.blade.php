<header x-data="{ 
    mobileMenuOpen: false,
    searchOpen: false,
    searchQuery: '',
    searchResults: [],
    loading: false,
    async search() {
        if (this.searchQuery.length < 2) {
            this.searchResults = [];
            return;
        }
        
        this.loading = true;
        try {
            const response = await fetch(`/api/search?q=${encodeURIComponent(this.searchQuery)}`);
            const data = await response.json();
            this.searchResults = data;
        } catch (error) {
            console.error('Search failed:', error);
        }
        this.loading = false;
    }
}" class="bg-white shadow-sm">
    <!-- Top Bar -->
    <div class="bg-wood-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-10">
                <div class="flex items-center space-x-4">
                    <a href="tel:+1234567890" class="text-sm hover:text-wood-200">
                        <i class="fas fa-phone-alt mr-2"></i>
                        +1 (234) 567-890
                    </a>
                    <a href="mailto:info@woodcraft.com" class="text-sm hover:text-wood-200">
                        <i class="fas fa-envelope mr-2"></i>
                        info@woodcraft.com
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('about') }}" class="text-sm hover:text-wood-200">About Us</a>
                    <a href="{{ route('contact') }}" class="text-sm hover:text-wood-200">Contact</a>
                    @auth
                        <a href="{{ route('profile') }}" class="text-sm hover:text-wood-200">My Account</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm hover:text-wood-200">Login</a>
                        <a href="{{ route('register') }}" class="text-sm hover:text-wood-200">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex-shrink-0">
                <img class="h-12 w-auto" src="{{ asset('images/logo.png') }}" alt="Woodcraft">
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('home') }}" class="text-wood-600 hover:text-wood-900">Home</a>
                <div x-data="{ open: false }" class="relative">
                    <button 
                        @click="open = !open"
                        @click.away="open = false"
                        class="text-wood-600 hover:text-wood-900 inline-flex items-center"
                    >
                        Shop
                        <i class="fas fa-chevron-down ml-1 text-xs"></i>
                    </button>
                    <div 
                        x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="absolute z-10 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
                    >
                        <div class="py-1">
                            @foreach($categories as $category)
                                <a 
                                    href="{{ route('category', $category) }}"
                                    class="block px-4 py-2 text-sm text-wood-600 hover:bg-wood-50 hover:text-wood-900"
                                >
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <a href="{{ route('about') }}" class="text-wood-600 hover:text-wood-900">About</a>
                <a href="{{ route('contact') }}" class="text-wood-600 hover:text-wood-900">Contact</a>
            </nav>

            <!-- Search and Cart -->
            <div class="flex items-center space-x-4">
                <!-- Search -->
                <div class="relative">
                    <button 
                        @click="searchOpen = !searchOpen"
                        class="text-wood-600 hover:text-wood-900"
                    >
                        <i class="fas fa-search"></i>
                    </button>
                    <div 
                        x-show="searchOpen"
                        @click.away="searchOpen = false"
                        class="absolute right-0 mt-2 w-96 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
                    >
                        <div class="p-4">
                            <div class="relative">
                                <input 
                                    type="text"
                                    x-model="searchQuery"
                                    @input.debounce.300ms="search"
                                    placeholder="Search products..."
                                    class="w-full rounded-lg border-wood-300 shadow-sm focus:border-wood-500 focus:ring-wood-500"
                                >
                                <div 
                                    x-show="loading"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2"
                                >
                                    <div class="animate-spin rounded-full h-5 w-5 border-2 border-wood-500 border-t-transparent"></div>
                                </div>
                            </div>
                            <div 
                                x-show="searchResults.length > 0"
                                class="mt-2 max-h-96 overflow-y-auto"
                            >
                                <template x-for="result in searchResults" :key="result.id">
                                    <a 
                                        :href="'/products/' + result.id"
                                        class="flex items-center space-x-4 p-2 hover:bg-wood-50 rounded-lg"
                                    >
                                        <img :src="result.image_url" :alt="result.name" class="w-12 h-12 object-cover rounded">
                                        <div>
                                            <h4 class="text-sm font-medium text-wood-900" x-text="result.name"></h4>
                                            <p class="text-sm text-wood-500" x-text="result.formatted_price"></p>
                                        </div>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="relative text-wood-600 hover:text-wood-900">
                    <i class="fas fa-shopping-cart"></i>
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-wood-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <!-- Mobile Menu Button -->
                <button 
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    class="md:hidden text-wood-600 hover:text-wood-900"
                >
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div 
        x-show="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform -translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-2"
        class="md:hidden"
    >
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-wood-600 hover:text-wood-900 hover:bg-wood-50">Home</a>
            <div x-data="{ open: false }">
                <button 
                    @click="open = !open"
                    class="w-full flex items-center justify-between px-3 py-2 rounded-md text-base font-medium text-wood-600 hover:text-wood-900 hover:bg-wood-50"
                >
                    Shop
                    <i class="fas fa-chevron-down text-xs"></i>
                </button>
                <div 
                    x-show="open"
                    class="pl-4 space-y-1"
                >
                    @foreach($categories as $category)
                        <a 
                            href="{{ route('category', $category) }}"
                            class="block px-3 py-2 rounded-md text-base font-medium text-wood-600 hover:text-wood-900 hover:bg-wood-50"
                        >
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
            <a href="{{ route('about') }}" class="block px-3 py-2 rounded-md text-base font-medium text-wood-600 hover:text-wood-900 hover:bg-wood-50">About</a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-md text-base font-medium text-wood-600 hover:text-wood-900 hover:bg-wood-50">Contact</a>
        </div>
    </div>
</header>
