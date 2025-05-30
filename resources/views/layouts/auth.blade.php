<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        wood: {
                            light: '#d4a373',
                            DEFAULT: '#4B2E1F',
                            dark: '#3b2417',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.13.3/dist/cdn.min.js" defer></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    @stack('styles')
</head>
<body class="font-sans antialiased">
    {{-- Main content --}}
    <main>
        @yield('content')
    </main>
    
    @stack('scripts')
</body>
</html> 