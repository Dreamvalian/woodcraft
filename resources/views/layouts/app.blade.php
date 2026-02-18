<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Woodcraft - Handcrafted Wooden Products')</title>
    <meta name="description" content="@yield('meta_description', 'Discover our collection of handcrafted wooden products made with love and precision.')">
    <meta name="keywords" content="@yield('meta_keywords', 'woodcraft, wooden products, handmade, furniture, crafts')">
    <meta name="author" content="Woodcraft">
    
    <meta property="og:title" content="@yield('og_title', 'Woodcraft - Handcrafted Wooden Products')">
    <meta property="og:description" content="@yield('og_description', 'Discover our collection of handcrafted wooden products made with love and precision.')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @stack('styles')
</head>
<body class="h-full font-sans antialiased text-gray-900 bg-gray-50">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:px-4 focus:py-2 focus:bg-white focus:text-gray-900 focus:rounded-md focus:shadow-soft">
        Skip to main content
    </a>
    <div x-data="{ loading: false }" 
         x-on:loading.window="loading = true"
         x-on:loaded.window="loading = false"
         x-show="loading"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-cloak
         class="fixed inset-0 bg-white/80 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="flex flex-col items-center space-y-4">
            <div class="animate-spin rounded-full h-12 w-12 border-3 border-wood-500 border-t-transparent"></div>
            <p class="text-wood-700 font-medium">Loading...</p>
        </div>
    </div>

    <div x-data="{ 
        toasts: [],
        addToast(message, type = 'success') {
            const id = Date.now();
            this.toasts.push({ id, message, type });
            setTimeout(() => this.removeToast(id), 5000);
        },
        removeToast(id) {
            this.toasts = this.toasts.filter(toast => toast.id !== id);
        }
    }" 
    x-on:notify.window="addToast($event.detail.message, $event.detail.type)"
    class="fixed bottom-4 right-4 z-50 space-y-4">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="true"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform translate-y-2"
                 :class="{
                    'bg-green-50 text-green-800 border-green-100': toast.type === 'success',
                    'bg-red-50 text-red-800 border-red-100': toast.type === 'error',
                    'bg-blue-50 text-blue-800 border-blue-100': toast.type === 'info',
                    'bg-yellow-50 text-yellow-800 border-yellow-100': toast.type === 'warning'
                 }"
                 class="px-6 py-3 rounded-lg shadow-soft border flex items-center space-x-3">
                <template x-if="toast.type === 'success'">
                    <i class="fas fa-check-circle text-green-500"></i>
                </template>
                <template x-if="toast.type === 'error'">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </template>
                <template x-if="toast.type === 'info'">
                    <i class="fas fa-info-circle text-blue-500"></i>
                </template>
                <template x-if="toast.type === 'warning'">
                    <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                </template>
                <span x-text="toast.message"></span>
                <button @click="removeToast(toast.id)" class="ml-auto text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </template>
    </div>

    @include('layouts.navigation')
    
    <main id="main-content" class="flex-grow">
        @if(session('success'))
            <div x-data="{ show: true }"
                 x-init="window.dispatchEvent(new CustomEvent('notify', { 
                     detail: { message: '{{ session('success') }}', type: 'success' }
                 }))"
                 x-show="false">
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }"
                 x-init="window.dispatchEvent(new CustomEvent('notify', { 
                     detail: { message: '{{ session('error') }}', type: 'error' }
                 }))"
                 x-show="false">
            </div>
        @endif

        @yield('content')
    </main>
    
    @include('layouts.footer')
    
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.dispatchEvent(new Event('loaded'));
        });

        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', () => {
                window.dispatchEvent(new Event('loading'));
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
