@extends('layouts.app')

@section('title', 'Unsubscribe')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-semibold mb-8">Manage Email Preferences</h1>

        <div class="bg-white rounded-lg shadow p-6">
            @if(isset($email))
                <div class="mb-6">
                    <p class="text-gray-600">Managing preferences for: <span class="font-medium">{{ $email }}</span></p>
                </div>

                <form action="{{ route('unsubscribe.update') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="preferences[newsletter]" 
                                   id="newsletter"
                                   {{ $preferences['newsletter'] ?? true ? 'checked' : '' }}
                                   class="h-4 w-4 text-wood focus:ring-wood border-gray-300">
                            <label for="newsletter" class="ml-3 block text-sm font-medium text-gray-700">
                                Newsletter & Updates
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="preferences[promotions]" 
                                   id="promotions"
                                   {{ $preferences['promotions'] ?? true ? 'checked' : '' }}
                                   class="h-4 w-4 text-wood focus:ring-wood border-gray-300">
                            <label for="promotions" class="ml-3 block text-sm font-medium text-gray-700">
                                Promotions & Special Offers
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="preferences[order_updates]" 
                                   id="order_updates"
                                   {{ $preferences['order_updates'] ?? true ? 'checked' : '' }}
                                   class="h-4 w-4 text-wood focus:ring-wood border-gray-300">
                            <label for="order_updates" class="ml-3 block text-sm font-medium text-gray-700">
                                Order Updates & Shipping Notifications
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="preferences[product_updates]" 
                                   id="product_updates"
                                   {{ $preferences['product_updates'] ?? true ? 'checked' : '' }}
                                   class="h-4 w-4 text-wood focus:ring-wood border-gray-300">
                            <label for="product_updates" class="ml-3 block text-sm font-medium text-gray-700">
                                New Product Announcements
                            </label>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" 
                                class="w-full bg-wood text-white px-6 py-3 rounded-md hover:bg-wood-dark transition">
                            Update Preferences
                        </button>
                    </div>
                </form>

                <div class="mt-6 pt-6 border-t">
                    <form action="{{ route('unsubscribe.all') }}" method="POST">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        <input type="hidden" name="token" value="{{ $token }}">
                        <button type="submit" 
                                class="w-full text-red-600 hover:text-red-700 font-medium">
                            Unsubscribe from All Emails
                        </button>
                    </form>
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-600 mb-4">Enter your email address to manage your preferences:</p>
                    
                    <form action="{{ route('unsubscribe') }}" method="GET" class="max-w-md mx-auto">
                        <div class="flex gap-2">
                            <input type="email" 
                                   name="email" 
                                   required
                                   class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-wood focus:ring-wood"
                                   placeholder="Enter your email">
                            <button type="submit" 
                                    class="bg-wood text-white px-4 py-2 rounded-md hover:bg-wood-dark transition">
                                Continue
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>

        <div class="mt-8 text-center text-sm text-gray-500">
            <p>Need help? Contact our support team at <a href="mailto:support@woodcraft.com" class="text-wood hover:text-wood-dark">support@woodcraft.com</a></p>
        </div>
    </div>
</div>
@endsection 