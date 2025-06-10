{{-- Main Navigation Component --}}
<nav x-data="{ 
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
  {{-- Main Navigation Bar --}}
  <div class="container mx-auto px-6 py-6">
    <div class="flex justify-between items-center">
      {{-- Brand Section --}}
      <a href="{{ route('home') }}" class="flex items-center gap-3 group">
        <img src="{{ asset('image/logo2.svg') }}" alt="WoodCraft Logo"
          class="w-12 transition-transform duration-300 group-hover:scale-105">
        <span class="text-2xl font-light text-[#2C3E50]">WoodCraft</span>
      </a>

      {{-- Primary Navigation Links --}}
      <div class="flex items-center space-x-10">
        <a href="{{ route('home') }}"
          class="text-[#2C3E50] hover:text-[#E67E22] transition-colors duration-300 font-light {{ request()->routeIs('home') ? 'text-[#E67E22]' : '' }}">
          Home
        </a>
        <a href="{{ route('shops.index') }}"
          class="text-[#2C3E50] hover:text-[#E67E22] transition-colors duration-300 font-light {{ request()->routeIs('shops.*') ? 'text-[#E67E22]' : '' }}">
          Shops
        </a>
        <a href="{{ route('about') }}"
          class="text-[#2C3E50] hover:text-[#E67E22] transition-colors duration-300 font-light {{ request()->routeIs('about') ? 'text-[#E67E22]' : '' }}">
          About
        </a>
        <a href="{{ route('contact') }}"
          class="text-[#2C3E50] hover:text-[#E67E22] transition-colors duration-300 font-light {{ request()->routeIs('contact') ? 'text-[#E67E22]' : '' }}">
          Contact
        </a>
      </div>

      {{-- Utility Icons Section --}}
      <div class="flex items-center space-x-8">
        {{-- Search --}}
        <div class="relative">
          <button @click="searchOpen = !searchOpen"
            class="text-[#2C3E50] hover:text-[#E67E22] transition-colors duration-300" title="Search">
            <i class="fas fa-search text-lg"></i>
          </button>

          {{-- Search Dropdown --}}
          <div x-show="searchOpen" @click.away="searchOpen = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="absolute right-0 mt-2 w-96 bg-white rounded-lg shadow-lg py-1 z-50 border border-gray-100">
            <div class="p-4">
              <div class="relative">
                <input type="text" x-model="searchQuery" @input.debounce.300ms="search" placeholder="Search shops..."
                  class="w-full rounded-lg border-gray-200 text-[#2C3E50] placeholder-gray-400 focus:ring-[#E67E22] focus:border-[#E67E22]">
                <div x-show="loading" class="absolute right-3 top-1/2 transform -translate-y-1/2">
                  <div class="animate-spin rounded-full h-5 w-5 border-2 border-[#E67E22] border-t-transparent"></div>
                </div>
              </div>
              <div x-show="searchResults.length > 0" class="mt-2 max-h-96 overflow-y-auto">
                <template x-for="result in searchResults" :key="result . id">
                  <a :href="'/shops/' + result . id"
                    class="flex items-center space-x-4 p-2 hover:bg-gray-50 rounded-lg transition-colors duration-300">
                    <img :src="result . image_url" :alt="result . name" class="w-12 h-12 object-cover rounded">
                    <div>
                      <h4 class="text-sm font-light text-[#2C3E50]" x-text="result.name"></h4>
                      <p class="text-sm text-gray-500" x-text="result.formatted_price"></p>
                    </div>
                  </a>
                </template>
              </div>
            </div>
          </div>
        </div>

        {{-- Shopping Cart --}}
        <a href="{{ route('cart.index') }}"
          class="text-[#2C3E50] hover:text-[#E67E22] transition-colors duration-300 relative" title="Shopping Cart">
          <i class="fas fa-shopping-cart text-lg"></i>
          @if($cartCount > 0)
        <span
        class="absolute -top-2 -right-2 bg-[#E67E22] text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-light">
        {{ $cartCount }}
        </span>
      @endif
        </a>

        {{-- User Profile Dropdown --}}
        @auth
      <div x-data="{ open: false }" class="relative">
        <button @click="open = !open"
        class="text-[#2C3E50] hover:text-[#E67E22] transition-colors duration-300 flex items-center space-x-2"
        title="Account">
        <i class="fas fa-user text-lg"></i>
        <span class="font-light">{{ Auth::user()->name }}</span>
        <i class="fas fa-chevron-down text-xs"></i>
        </button>

        {{-- Dropdown Menu --}}
        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg py-1 z-50 border border-gray-100">

        {{-- Profile Links --}}
        <a href="{{ route('profile') }}"
          class="block px-4 py-2 text-sm text-[#2C3E50] hover:bg-gray-50 transition-colors duration-300 font-light">
          <i class="fas fa-user-circle mr-2"></i> Profile
        </a>
        <a href="{{ route('orders.index') }}"
          class="block px-4 py-2 text-sm text-[#2C3E50] hover:bg-gray-50 transition-colors duration-300 font-light">
          <i class="fas fa-shopping-bag mr-2"></i> Orders
        </a>
        <a href="{{ route('notifications.index') }}"
          class="block px-4 py-2 text-sm text-[#2C3E50] hover:bg-gray-50 transition-colors duration-300 font-light">
          <i class="fas fa-bell mr-2"></i> Notifications
        </a>

        {{-- Divider --}}
        <div class="border-t border-gray-100 my-1"></div>

        {{-- Logout Form --}}
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit"
          class="w-full text-left px-4 py-2 text-sm text-[#2C3E50] hover:bg-gray-50 transition-colors duration-300 font-light">
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </button>
        </form>
        </div>
      </div>
    @endauth
      </div>
    </div>
  </div>
</nav>