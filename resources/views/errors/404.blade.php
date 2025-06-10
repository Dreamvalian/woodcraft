@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
    <div class="min-h-[60vh] flex items-center justify-center px-4 py-12">
        <div class="max-w-lg w-full text-center">
            {{-- 404 Illustration --}}
            <div class="mb-8">
                <svg class="mx-auto h-48 w-48 text-wood" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            {{-- Error Message --}}
            <h1 class="text-6xl font-bold text-gray-900 mb-4">404</h1>
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Page Not Found</h2>
            <p class="text-gray-600 mb-8">
                The page you're looking for doesn't exist or has been moved.
            </p>

            {{-- Action Buttons --}}
            <div class="space-y-4 sm:space-y-0 sm:space-x-4">
                <x-button href="{{ url()->previous() }}">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Go Back
                </x-button>
                <x-button href="{{ route('home') }}">
                    <i class="fas fa-home mr-2"></i>
                    Go Home
                </x-button>
            </div>

            {{-- Search Box --}}
            <div class="mt-12">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Looking for something specific?</h3>
                <form action="{{ route('search') }}" method="GET" class="max-w-md mx-auto">
                    <div class="flex">
                        <input type="text" name="q" placeholder="Search our shops..."
                            class="flex-1 min-w-0 block w-full px-4 py-2 rounded-l-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-wood focus:border-transparent">
                        <x-button type="submit" class="rounded-l-none">
                            <i class="fas fa-search"></i>
                        </x-button>
                    </div>
                </form>
            </div>

            {{-- Popular Shops --}}
            <div class="mt-12">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Popular Shops</h3>
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                    @foreach(['Furniture', 'Decor', 'Kitchen', 'Outdoor', 'Bathroom', 'Lighting'] as $shop)
                        <x-button href="{{ route('shops.index', ['material' => strtolower($shop)]) }}" class="text-sm">
                            {{ $shop }}
                        </x-button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection