<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>@yield('title')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="{{ asset('image/logo2.svg') }}" type="image/svg+xml">

  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  @stack('styles')
</head>

<body class="font-sans antialiased bg-gray-50">
  <a href="#auth-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:px-4 focus:py-2 focus:bg-white focus:text-gray-900 focus:rounded-md focus:shadow-soft">
    Skip to main content
  </a>
  <main id="auth-content">
    @yield('content')
  </main>

  <script src="{{ mix('js/app.js') }}" defer></script>
  @stack('scripts')
</body>

</html>
