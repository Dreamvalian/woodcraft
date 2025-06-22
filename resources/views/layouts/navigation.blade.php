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
}" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300" x-init="window.addEventListener('scroll', () => {
       if (window.scrollY > 50) {
           $el.classList.add('bg-white/95', 'backdrop-blur-sm', 'shadow-lg');
           $el.classList.remove('bg-transparent');
       } else {
           $el.classList.remove('bg-white/95', 'backdrop-blur-sm', 'shadow-lg');
           $el.classList.add('bg-transparent');
       }
   })">
  {{-- Main Navigation Bar --}}
  <div class="container mx-auto px-6 py-4">
    <div class="flex justify-between items-center relative">
      {{-- Background Wood Grain Pattern --}}
      <div class="absolute inset-0 opacity-[0.02] pointer-events-none">
        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
          <pattern id="nav-wood-grain" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
            <path d="M0,0 L100,0 L100,100 L0,100 Z" fill="none" stroke="currentColor" stroke-width="0.5" />
            <path d="M0,20 Q25,15 50,20 T100,20" stroke="currentColor" fill="none" stroke-width="0.3" />
            <path d="M0,40 Q25,35 50,40 T100,40" stroke="currentColor" fill="none" stroke-width="0.3" />
            <path d="M0,60 Q25,55 50,60 T100,60" stroke="currentColor" fill="none" stroke-width="0.3" />
            <path d="M0,80 Q25,75 50,80 T100,80" stroke="currentColor" fill="none" stroke-width="0.3" />
          </pattern>
          <rect x="0" y="0" width="100" height="100" fill="url(#nav-wood-grain)" />
        </svg>
      </div>

      {{-- Brand Section --}}
      <a href="{{ route('home') }}" class="flex items-center gap-3 group relative">
        {{-- Decorative corner elements --}}
        <div class="absolute -top-2 -left-2 w-4 h-4 opacity-10">
          <svg viewBox="0 0 100 100" class="w-full h-full">
            <path d="M0,0 L100,0 L0,100" stroke="currentColor" fill="none" stroke-width="2" />
            <path d="M20,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
          </svg>
        </div>
        <div class="absolute -bottom-2 -right-2 w-4 h-4 opacity-10">
          <svg viewBox="0 0 100 100" class="w-full h-full">
            <path d="M0,0 L100,0 L0,100" stroke="currentColor" fill="none" stroke-width="2" />
            <path d="M20,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
          </svg>
        </div>
        <img src="{{ asset('image/logo2.svg') }}" alt="WoodCraft Logo"
          class="w-12 transition-transform duration-300 group-hover:scale-105">
        <span class="text-2xl font-light text-[#2C3E50]">WoodCraft</span>
      </a>

      {{-- Primary Navigation Links --}}
      <div class="flex items-center space-x-10">
        <a href="{{ route('home') }}"
          class="text-[#2C3E50] hover:text-[#E67E22] transition-colors duration-300 font-light relative group {{ request()->routeIs('home') ? 'text-[#E67E22]' : '' }}">
          Home
          <span
            class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#E67E22] transition-all duration-300 group-hover:w-full"></span>
        </a>
        <a href="{{ route('shops.index') }}"
          class="text-[#2C3E50] hover:text-[#E67E22] transition-colors duration-300 font-light relative group {{ request()->routeIs('shops.*') ? 'text-[#E67E22]' : '' }}">
          Shops
          <span
            class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#E67E22] transition-all duration-300 group-hover:w-full"></span>
        </a>
        <a href="{{ route('artisan') }}"
          class="text-[#2C3E50] hover:text-[#E67E22] transition-colors duration-300 font-light relative group {{ request()->routeIs('artisan') ? 'text-[#E67E22]' : '' }}">
          Artisan
          <span
            class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#E67E22] transition-all duration-300 group-hover:w-full"></span>
        </a>
        <a href="{{ route('about') }}"
          class="text-[#2C3E50] hover:text-[#E67E22] transition-colors duration-300 font-light relative group {{ request()->routeIs('about') ? 'text-[#E67E22]' : '' }}">
          About
          <span
            class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#E67E22] transition-all duration-300 group-hover:w-full"></span>
        </a>
        <a href="{{ route('contact') }}"
          class="text-[#2C3E50] hover:text-[#E67E22] transition-colors duration-300 font-light relative group {{ request()->routeIs('contact') ? 'text-[#E67E22]' : '' }}">
          Contact
          <span
            class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#E67E22] transition-all duration-300 group-hover:w-full"></span>
        </a>
      </div>

      {{-- Utility Icons Section --}}
      <div class="flex items-center space-x-8">

        {{-- Shopping Cart --}}
        <a href="{{ route('cart.index') }}"
          class="text-[#2C3E50] hover:text-[#E67E22] transition-colors duration-300 relative group"
          title="Shopping Cart">
          <i class="fas fa-shopping-cart text-lg"></i>
          @if($cartCount > 0)
        <span
        class="absolute -top-2 -right-2 bg-[#E67E22] text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-light">
        {{ $cartCount }}
        </span>
      @endif
          {{-- Hand-drawn underline --}}
          <span
            class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#E67E22] transition-all duration-300 group-hover:w-full"></span>
        </a>

        {{-- User Profile Dropdown --}}
        @auth
        <div x-data="{ open: false }" class="relative">
          <button @click="open = !open"
          class="text-[#2C3E50] hover:text-[#E67E22] transition-colors duration-300 flex items-center space-x-2 group"
          title="Account">
          <i class="fas fa-user text-lg"></i>
          <span class="font-light">{{ Auth::user()->name }}</span>
          <i class="fas fa-chevron-down text-xs"></i>
          {{-- Hand-drawn underline --}}
          <span
            class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#E67E22] transition-all duration-300 group-hover:w-full"></span>
          </button>

          {{-- Dropdown Menu --}}
          <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
          x-transition:enter-start="opacity-0 transform scale-95"
          x-transition:enter-end="opacity-100 transform scale-100"
          x-transition:leave="transition ease-in duration-150"
          x-transition:leave-start="opacity-100 transform scale-100"
          x-transition:leave-end="opacity-0 transform scale-95"
          class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg py-1 z-50 border border-gray-100">
          {{-- Decorative corner elements --}}
          <div class="absolute -top-2 -left-2 w-4 h-4 opacity-10">
            <svg viewBox="0 0 100 100" class="w-full h-full">
            <path d="M0,0 L100,0 L0,100" stroke="currentColor" fill="none" stroke-width="2" />
            <path d="M20,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
            </svg>
          </div>
          <div class="absolute -bottom-2 -right-2 w-4 h-4 opacity-10">
            <svg viewBox="0 0 100 100" class="w-full h-full">
            <path d="M0,0 L100,0 L0,100" stroke="currentColor" fill="none" stroke-width="2" />
            <path d="M20,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
            </svg>
          </div>

          {{-- Profile Links --}}
          <a href="{{ route('profile') }}"
            class="block px-4 py-2 text-sm text-[#2C3E50] hover:bg-gray-50 transition-colors duration-300 font-light">
            <i class="fas fa-user-circle mr-2"></i> Profile
          </a>
          @if (Auth::user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}"
          class="block px-4 py-2 text-sm text-[#2C3E50] hover:bg-gray-50 transition-colors duration-300 font-light">
          <i class="fas fa-user-circle mr-2"></i> Dashboard
        </a>
        @endif
          <a href="{{ route('orders.index') }}"
            class="block px-4 py-2 text-sm text-[#2C3E50] hover:bg-gray-50 transition-colors duration-300 font-light">
            <i class="fas fa-shopping-bag mr-2"></i> Orders
          </a>
          {{-- Removed Notifications Link --}}

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

{{-- Spacer to prevent content from being hidden under the fixed navigation --}}
<div class="h-20"></div>