<header class="bg-white border-b border-gray-100 sticky top-0 z-40">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo and Brand -->
            <a href="/" class="flex items-center gap-3 group">
                <img src="{{ asset('image/logo2.svg') }}" alt="WoodCraft Logo" class="w-8 h-8 transition-transform duration-300 group-hover:scale-105">
                <span class="font-display text-xl font-semibold text-primary-800">WoodCraft</span>
            </a>

            <!-- Main Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="/" class="text-gray-600 hover:text-primary-600 transition-colors duration-200 font-medium">Home</a>
                <a href="/products" class="text-gray-600 hover:text-primary-600 transition-colors duration-200 font-medium">Products</a>
                <a href="/about" class="text-gray-600 hover:text-primary-600 transition-colors duration-200 font-medium">About Us</a>
                <a href="/contact" class="text-gray-600 hover:text-primary-600 transition-colors duration-200 font-medium">Contact</a>
                
                <!-- Divider -->
                <span class="border-r h-6 border-gray-200"></span>

                @auth
                    <!-- Admin Link -->
                    @if(auth()->user()->is_admin)
                        <a href="/admin" class="inline-flex items-center gap-2 px-3 py-1.5 bg-primary-50 text-primary-700 rounded-lg hover:bg-primary-100 transition-colors duration-200">
                            <i class="fas fa-user-shield text-sm"></i>
                            <span class="text-sm font-medium">Admin</span>
                        </a>
                    @endif

                    <!-- User Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 text-gray-600 hover:text-primary-600 transition-colors duration-200">
                            <div class="w-8 h-8 rounded-full bg-primary-50 flex items-center justify-center text-primary-700">
                                <i class="fas fa-user text-sm"></i>
                            </div>
                            <span class="font-medium">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             @click.away="open = false" 
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-soft py-1 z-50 border border-gray-100">
                            <a href="/profile" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 transition-colors duration-200">
                                <i class="fas fa-user-circle w-5"></i>
                                <span>Profile</span>
                            </a>
                            <a href="/orders" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 transition-colors duration-200">
                                <i class="fas fa-shopping-bag w-5"></i>
                                <span>My Orders</span>
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 transition-colors duration-200">
                                    <i class="fas fa-sign-out-alt w-5"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Cart -->
                    <a href="/cart" class="relative group">
                        <div class="w-8 h-8 rounded-full bg-primary-50 flex items-center justify-center text-primary-700 group-hover:bg-primary-100 transition-colors duration-200">
                            <i class="fas fa-shopping-cart text-sm"></i>
                        </div>
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-primary-500 text-white text-xs rounded-full flex items-center justify-center">
                            0
                        </span>
                    </a>
                @else
                    <!-- Guest Navigation -->
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-primary-600 transition-colors duration-200 font-medium">Login</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200 font-medium">Register</a>
                        <a href="/cart" class="relative group">
                            <div class="w-8 h-8 rounded-full bg-primary-50 flex items-center justify-center text-primary-700 group-hover:bg-primary-100 transition-colors duration-200">
                                <i class="fas fa-shopping-cart text-sm"></i>
                            </div>
                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-primary-500 text-white text-xs rounded-full flex items-center justify-center">
                                0
                            </span>
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden" x-data="{ open: false }">
                <button @click="open = !open" class="text-gray-600 hover:text-primary-600 transition-colors duration-200">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Mobile menu -->
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     @click.away="open = false"
                     class="absolute top-16 left-0 right-0 bg-white border-b border-gray-100 shadow-soft">
                    <div class="px-4 py-3 space-y-3">
                        <a href="/" class="block text-gray-600 hover:text-primary-600 transition-colors duration-200 font-medium">Home</a>
                        <a href="/products" class="block text-gray-600 hover:text-primary-600 transition-colors duration-200 font-medium">Products</a>
                        <a href="/about" class="block text-gray-600 hover:text-primary-600 transition-colors duration-200 font-medium">About Us</a>
                        <a href="/contact" class="block text-gray-600 hover:text-primary-600 transition-colors duration-200 font-medium">Contact</a>
                        
                        @auth
                            @if(auth()->user()->is_admin)
                                <a href="/admin" class="block px-4 py-2 bg-primary-50 text-primary-700 rounded-lg hover:bg-primary-100 transition-colors duration-200 font-medium">
                                    <i class="fas fa-user-shield mr-2"></i>Admin
                                </a>
                            @endif
                            <a href="/profile" class="block text-gray-600 hover:text-primary-600 transition-colors duration-200 font-medium">Profile</a>
                            <a href="/orders" class="block text-gray-600 hover:text-primary-600 transition-colors duration-200 font-medium">My Orders</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left text-gray-600 hover:text-primary-600 transition-colors duration-200 font-medium">
                                    Logout
                                </button>
                            </form>
                        @else
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('login') }}" class="block text-gray-600 hover:text-primary-600 transition-colors duration-200 font-medium">Login</a>
                                <a href="{{ route('register') }}" class="block px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200 font-medium text-center">Register</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
