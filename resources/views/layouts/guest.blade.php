<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body class="bg-gray-50">
  <a href="#guest-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:px-4 focus:py-2 focus:bg-white focus:text-gray-900 focus:rounded-md focus:shadow-soft">
    Skip to main content
  </a>
  <div id="guest-content" class="font-sans text-gray-900 antialiased">
    {{ $slot }}
  </div>
  <script src="{{ mix('js/app.js') }}" defer></script>
</body>

</html>
