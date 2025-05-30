<header x-data="{ mobileMenuOpen: false, searchOpen: false }" class="bg-white shadow-md">
    {{-- Top Bar --}}
    <div class="bg-wood-dark text-white py-2">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <div class="text-sm">
                    <span>Free shipping, 30-day return or refund guarantee.</span>
                </div>
                <div class="flex items-center space-x-4 text-sm">
                    @guest
                        <a href="{{ route('login') }}" class="hover:text-wood-light transition">Sign in</a>
                        <a href="{{ route('register') }}" class="hover:text-wood-light transition">Register</a>
                    @else
                        <a href="{{ route('profile') }}" class="hover:text-wood-light transition">My Account</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="hover:text-wood-light transition">Logout</button>
                        </form>
                    @endguest
                    <a href="{{ route('faq') }}" class="hover:text-wood-light transition">FAQs</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Navigation --}}
    <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex-shrink-0">
                <img src="{{ asset('img/logo.png') }}" alt="Woodcraft" class="h-12">
            </a>

            {{-- Desktop Navigation --}}
            <nav class="hidden md:flex space-x-8">
                <a href="{{ url('/') }}" class="text-gray-700 hover:text-wood transition {{ request()->is('/') ? 'text-wood font-medium' : '' }}">
                    Home
                </a>
                <a href="{{ url('/shop') }}" class="text-gray-700 hover:text-wood transition {{ request()->is('shop*') ? 'text-wood font-medium' : '' }}">
                    Shop
                </a>
                <a href="{{ url('/blog') }}" class="text-gray-700 hover:text-wood transition {{ request()->is('blog*') ? 'text-wood font-medium' : '' }}">
                    Blog
                </a>
                <a href="{{ url('/about') }}" class="text-gray-700 hover:text-wood transition {{ request()->is('about') ? 'text-wood font-medium' : '' }}">
                    About Us
                </a>
                <a href="{{ url('/contact') }}" class="text-gray-700 hover:text-wood transition {{ request()->is('contact') ? 'text-wood font-medium' : '' }}">
                    Contact
                </a>
            </nav>

            {{-- Right Icons --}}
            <div class="flex items-center space-x-6">
                {{-- Search --}}
                <button @click="searchOpen = !searchOpen" class="text-gray-700 hover:text-wood transition">
                    <i class="fas fa-search"></i>
                </button>

                {{-- User Account --}}
                <a href="{{ url('/account') }}" class="text-gray-700 hover:text-wood transition">
                    <i class="fas fa-user"></i>
                </a>

                {{-- Cart --}}
                <a href="{{ url('/shopping-cart') }}" class="text-gray-700 hover:text-wood transition relative">
                    <i class="fas fa-shopping-cart"></i>
                    @if(session('quantity', 0) > 0)
                        <span class="absolute -top-2 -right-2 bg-wood text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            {{ session('quantity', 0) }}
                        </span>
                    @endif
                </a>

                {{-- Mobile Menu Button --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-700 hover:text-wood transition">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Search Overlay --}}
    <div x-show="searchOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50 z-50"
         @click.self="searchOpen = false">
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-xl p-6">
                <form action="{{ route('search') }}" method="GET" class="flex items-center">
                    <input type="text" 
                           name="q" 
                           placeholder="Search products..." 
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-wood focus:border-transparent">
                    <button type="submit" class="bg-wood text-white px-6 py-2 rounded-r-lg hover:bg-wood-dark transition">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="md:hidden fixed inset-0 bg-white z-50"
         x-cloak>
        <div class="container mx-auto px-4 py-8">
            <div class="flex justify-between items-center mb-8">
                <img src="{{ asset('img/logo.png') }}" alt="Woodcraft" class="h-10">
                <button @click="mobileMenuOpen = false" class="text-gray-700 hover:text-wood transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="flex flex-col space-y-4">
                <a href="{{ url('/') }}" class="text-gray-700 hover:text-wood transition py-2 {{ request()->is('/') ? 'text-wood font-medium' : '' }}">
                    Home
                </a>
                <a href="{{ url('/shop') }}" class="text-gray-700 hover:text-wood transition py-2 {{ request()->is('shop*') ? 'text-wood font-medium' : '' }}">
                    Shop
                </a>
                <a href="{{ url('/blog') }}" class="text-gray-700 hover:text-wood transition py-2 {{ request()->is('blog*') ? 'text-wood font-medium' : '' }}">
                    Blog
                </a>
                <a href="{{ url('/about') }}" class="text-gray-700 hover:text-wood transition py-2 {{ request()->is('about') ? 'text-wood font-medium' : '' }}">
                    About Us
                </a>
                <a href="{{ url('/contact') }}" class="text-gray-700 hover:text-wood transition py-2 {{ request()->is('contact') ? 'text-wood font-medium' : '' }}">
                    Contact
                </a>
            </nav>
        </div>
    </div>
</header>
