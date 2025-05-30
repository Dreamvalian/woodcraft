@extends('layouts.app')

@section('title', 'Server Error')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-4 py-12">
    <div class="max-w-lg w-full text-center">
        {{-- 500 Illustration --}}
        <div class="mb-8">
            <svg class="mx-auto h-48 w-48 text-wood" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>

        {{-- Error Message --}}
        <h1 class="text-6xl font-bold text-gray-900 mb-4">500</h1>
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Server Error</h2>
        <p class="text-gray-600 mb-8">
            Oops! Something went wrong on our end. We're working to fix the issue.
        </p>

        {{-- Action Buttons --}}
        <div class="space-y-4 sm:space-y-0 sm:space-x-4">
            <a 
                href="{{ route('home') }}"
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-wood hover:bg-wood-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-wood"
            >
                <i class="fas fa-home mr-2"></i>
                Go Home
            </a>
            <button 
                onclick="window.location.reload()"
                class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-wood"
            >
                <i class="fas fa-sync-alt mr-2"></i>
                Try Again
            </button>
        </div>

        {{-- Contact Support --}}
        <div class="mt-12">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Need Help?</h3>
            <p class="text-gray-600 mb-4">
                If the problem persists, please contact our support team.
            </p>
            <div class="space-y-4">
                <a 
                    href="mailto:support@woodcraft.com"
                    class="inline-flex items-center text-wood hover:text-wood-dark"
                >
                    <i class="fas fa-envelope mr-2"></i>
                    support@woodcraft.com
                </a>
                <div class="text-gray-600">
                    <i class="fas fa-phone mr-2"></i>
                    +1 (555) 123-4567
                </div>
            </div>
        </div>

        {{-- Status Updates --}}
        <div class="mt-12">
            <h3 class="text-lg font-medium text-gray-900 mb-4">System Status</h3>
            <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800">
                <i class="fas fa-circle text-green-500 mr-2"></i>
                All Systems Operational
            </div>
            <p class="mt-2 text-sm text-gray-600">
                Last checked: {{ now()->format('M d, Y H:i:s') }}
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-refresh status check
    setInterval(() => {
        fetch('/api/status')
            .then(response => response.json())
            .then(data => {
                const statusElement = document.querySelector('.status-indicator');
                if (data.status === 'operational') {
                    statusElement.classList.remove('bg-red-100', 'text-red-800');
                    statusElement.classList.add('bg-green-100', 'text-green-800');
                    statusElement.innerHTML = '<i class="fas fa-circle text-green-500 mr-2"></i> All Systems Operational';
                } else {
                    statusElement.classList.remove('bg-green-100', 'text-green-800');
                    statusElement.classList.add('bg-red-100', 'text-red-800');
                    statusElement.innerHTML = '<i class="fas fa-circle text-red-500 mr-2"></i> System Issues Detected';
                }
            })
            .catch(() => {
                const statusElement = document.querySelector('.status-indicator');
                statusElement.classList.remove('bg-green-100', 'text-green-800');
                statusElement.classList.add('bg-yellow-100', 'text-yellow-800');
                statusElement.innerHTML = '<i class="fas fa-circle text-yellow-500 mr-2"></i> Checking Status...';
            });
    }, 30000); // Check every 30 seconds
</script>
@endpush 