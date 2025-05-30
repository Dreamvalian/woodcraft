<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- SEO Meta Tags --}}
    <title>@yield('title', 'Woodcraft - Handcrafted Wooden Products')</title>
    <meta name="description" content="@yield('meta_description', 'Discover our collection of handcrafted wooden products made with love and precision.')">
    <meta name="keywords" content="@yield('meta_keywords', 'woodcraft, wooden products, handmade, furniture, crafts')">
    <meta name="author" content="Woodcraft">
    
    {{-- Open Graph / Social Media Meta Tags --}}
    <meta property="og:title" content="@yield('og_title', 'Woodcraft - Handcrafted Wooden Products')">
    <meta property="og:description" content="@yield('og_description', 'Discover our collection of handcrafted wooden products made with love and precision.')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    
    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.13.3/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    {{-- Custom Styles --}}
    <style>
        [x-cloak] { display: none !important; }
        .loading { @apply opacity-50 pointer-events-none; }
        .fade-enter-active, .fade-leave-active { @apply transition-opacity duration-300; }
        .fade-enter-from, .fade-leave-to { @apply opacity-0; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: theme('colors.gray.100');
        }
        ::-webkit-scrollbar-thumb {
            background: theme('colors.primary.300');
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: theme('colors.primary.400');
        }
    </style>
    
    @stack('styles')
</head>
<body class="h-full font-sans antialiased text-gray-900 bg-gray-50">
    {{-- Loading Overlay --}}
    <div x-data="{ loading: false }" 
         x-on:loading.window="loading = true"
         x-on:loaded.window="loading = false"
         x-show="loading"
         x-cloak
         class="fixed inset-0 bg-white/80 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="animate-spin rounded-full h-12 w-12 border-2 border-primary-500 border-t-transparent"></div>
    </div>

    @include('layouts.header')
    
    {{-- Main content --}}
    <main class="flex-grow">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div x-data="{ show: true }"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform translate-y-2"
                 x-init="setTimeout(() => show = false, 3000)"
                 class="fixed top-4 right-4 bg-green-50 text-green-800 px-6 py-3 rounded-lg shadow-soft z-50 border border-green-100">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform translate-y-2"
                 x-init="setTimeout(() => show = false, 3000)"
                 class="fixed top-4 right-4 bg-red-50 text-red-800 px-6 py-3 rounded-lg shadow-soft z-50 border border-red-100">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>
    
    @include('layouts.footer')
    
    {{-- Global Scripts --}}
    <script>
        // Handle loading states
        document.addEventListener('DOMContentLoaded', () => {
            window.dispatchEvent(new Event('loaded'));
        });

        // Handle form submissions
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', () => {
                window.dispatchEvent(new Event('loading'));
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
